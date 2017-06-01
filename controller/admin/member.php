<?php defined('KING_PATH') or die('访问被拒绝.');
class Member_Controller extends Template_Controller{
    private $mod;
    private $id;
    private $regTime;
    private $purchaseAmount;
    
    public function __construct()
    {
        parent::__construct();
        comm_ext::validUser();         
        $this->mod				 = M('member');
        $this->account_id = accountInfo_ext::accountId(); 
    }
    // 会员展示列表页
    public function index()
    {
        $index = S(4);

        if($index == 1){
          $h_arr['m.levelId'] = 1;
        }else if($index == 2){
          $h_arr['m.levelId'] = '0';
        }else{
          $index = 99;
        }

        $where = '';
        // 条件搜索
        $h_arr['m.nickname like'] = G('nickname','');
        $h_arr['stime']['m.regTime >='] = G('startTime','');
        $h_arr['etime']['m.regTime <='] = G('endTime','');
        $h_arr['minPrice']['m.amount >='] = G('minPrice','');
        $h_arr['maxPrice']['m.amount <='] = G('maxPrice','');
        $where = file_ext::get_where($h_arr);       

        $hql = "SELECT count(*) total FROM tf_member m ";
        $hql .= $where != ""?"where $where":"";
        $rs_count	= M()->query($hql);
        $total = $rs_count[0]->total;

        $data['pagination'] = pagination::getClass(array(
            'total'		=> $total,
            'perPage'		=> 20,
            'segment'		=> 'page',
            ));
        $start		= ($data['pagination']->currentPage-1)*20;
        // 条件排序
        $select_arr = array('m.regTime','m.golds','m.points','m.levelId','m.amount','m.member_num','m.commission');  
        if(in_array($puiSelect ,$select_arr)){
          $where .= " order by $puiSelect desc";
        }

        $limit .= "order by m.regTime desc limit $start,20";
        $sql = "SELECT * FROM tf_member m ";
        $sql .= $where != ""?"where $where $limit":"$limit";
        $rs	= M()->query($sql);

        $data['members']= $rs;

        // url 
        $unset = array("levelId");
        $query_url = file_ext::get_url(G(),$unset);
        // where 
        $unset = array("m.levelId");
        $where = file_ext::get_where($h_arr,$unset);       
        $data['total'] = M('member m')->getAllCount($where);

        $wh = $where!="" ?$where." and m.levelId=0":"m.levelId=0";
        $data['levelId0'] = M('member m')->getAllCount($wh);

        $wh = $where!="" ?$where." and m.levelId=1":"m.levelId=1";
        $data['levelId1'] = M('member m')->getAllCount($wh);

        $data['url'] = '?'.($query_url !='' ? $query_url:'');

        $data['tab_class'] = $index;  
        $this->template->content    = new View('admin/member/index_view',$data);
        $this->template->render();
    }
    // 下级会员列表
    public function next_member(){
        $pid = G('pid',-1);
        $levelId = G("levelId","99");
        $where = "";
        if($pid){
          if($where != ""){
            $where .= " and ";
          }
          $where .= "pid=$pid";
        }
        if($levelId != 99){
          $total = M("member")->getAllCount($where);
          if($where != ""){
            $where .= " and ";
          }
          $where .= "levelId=$levelId";
        }else{
          $total = M("member")->getAllCount($where);
        }

        $result = M("member")->getOneData("id=$pid");
        $data['p_member'] = $result;        
        $perPage = 20;
        $data['pagination'] = pagination::getClass(array(
            'total'   => $total,
            'perPage'   => $perPage,
            'segment'   => 'page',
            ));
        $start    = ($data['pagination']->currentPage-1)*$perPage;

        $limit .= "order by m.regTime desc limit $start,$perPage";

        $sql = "SELECT * FROM tf_member m ";
        $sql .= $where != ""?"where $where $limit":"$limit";

        $rs = M()->query($sql);
        $data['members']= $rs;

        $data['lv_url'] = "?pid=$pid";
        $data['total'] = $total;
        $data['lv0_url'] = "?pid=$pid&levelId=0";
        $data['levelId0'] = M('member')->getAllCount("pid=$pid and levelId=0");
        $data['lv1_url'] = "?pid=$pid&levelId=1";
        $data['levelId1'] = M('member')->getAllCount("pid=$pid and levelId=1");
        $data['levelId'] = $levelId;
        $this->template->content    = new View('admin/member/nextmember_view',$data);
        $this->template->render();
    }
    // 编辑详情页面
    public function show_edit(){
      $id = G('id','');      
      if($id == ''){
        input::redirect('admin/member/index');
      }
      $data['member'] = M('member')->getOneData("id=$id");
      $this->template->content    = new View('admin/member/edit_view',$data);
      $this->template->render();

    }
    // 查看详情页面
    public function show_see(){
      $id = G('id','');
      if($id == ''){
        input::redirect('admin/member/index');
      }
      $data['member'] = M('member')->getOneData("id=$id");
      $this->template->content    = new View('admin/member/see_view',$data);
      $this->template->render();

    }
    // 保存编辑后信息
    public function save(){
      $re_msg['success'] = 0;
      $re_msg['msg'] = "保存失败";


      $id = P('member_id','');
      $data['realName'] = P('realName','');
      $data['sex'] = P('sex','');
      $data['nickname'] = json_encode(P('nickname',''));
      $data['mobile'] = P('mobile','');
      $data['address'] = P('address','');
      $data['amount'] = P('amount','');
      $data['commission'] = P('commission','');
      $data['member_num'] = P('member_num','');
      $data['freeze_money'] = P('freeze_money','');
      $data['pid'] = P('pid','');

      if($id!=''){        
        $rs = M('member')->update($data,"id=$id");
        if($rs){
            $re_msg['success'] = 0;
            $re_msg['msg'] = "保存成功";
        }
      }
      echo json_encode($re_msg);
    }

    public function group()
    {
        $rs			= M('member_group')->execute();
        foreach($rs as $item)
        {
            $item->num = M('member')->getAllCount(array('groupId'=>$item->id));
        }
        $data['memberGroups']=$rs;
        $this->template->content    = new View('admin/member/group_view',$data);
        $this->template->tipBoxContent1 = new View('admin/member/addGroup_view');
        $this->template->tipBoxContent2 = new View('admin/member/ceareAbout_view');
        $this->template->tipBoxContent3 = new View('admin/member/editGroup_view');
        $this->template->render();
    }
    
    public function groupMembers()
    {
        $id = S('groupMembers');
        $total		= M('member')->getAllCount(array('groupId'=>$id));
        $data['pagination'] = pagination::getClass(array(
            'segment'     => 5,
            'total'		=> $total,
            'perPage'		=> 10
            ));
        $start		= ($data['pagination']->currentPage-1)*10;
        $data['groupName'] = M('member_group')->getFieldData('name',array('id'=>$id));
        $data['groupId'] = $id;
        $data['members'] = M('member')->where(array('groupId'=>$id))->limit($start,10)->execute();
        $this->template->content    = new View('admin/member/groupMembers_view',$data);
        $this->template->render();
    }
    
    public function addGroupMembers()
    {
        $id = S('addGroupMembers');
        $data['groupId'] = $id;
        $total		= M('member')->getAllCount(array('groupId !='=>$id));
        $data['pagination'] = pagination::getClass(array(
            'segment'     => 5,
            'total'		=> $total,
            'perPage'		=> 10
            ));
        $start		= ($data['pagination']->currentPage-1)*10;
        $data['members'] = M('member')->where(array('groupId !='=>$id))->limit($start,10)->execute();
        foreach($data['members'] as $item)
        {
            $item->levelname = M('member_level')->getFieldData('name',array('id'=>$item->levelId));
            $item->pname = M('provincial')->getFieldData('name',array('id'=>$item->provincial));
            $item->cname = M('city')->getFieldData('name',array('id'=>$item->city));
        }
        $this->template->content    = new View('admin/member/addGroupMembers_view',$data);
        $this->template->render();
    }
          
          public function level()
          {
              $rs			= M('member_level')->orderby(array('amount'=>'asc'))->execute();
              foreach($rs as $item)
              {
                  $item->num = M('member')->getAllCount(array('levelId'=>$item->id));
              }
              $data['levelList']=$rs;
              $this->template->content    = new View('admin/member/level_view',$data);
              $this->template->tipBoxContent1 = new View('admin/member/addLevel_view');
              $this->template->tipBoxContent2 = new View('admin/member/editLevel_view');
              $this->template->render();
          }
          
          public function output()
          {
              $this->template->content    = new View('admin/member/output_view',$data);
              $this->template->render();
          }
          /*
           * 执行导出
           */
          public function outputSave(){
              //积分
              $startpoints = P('startpoints');
              $endpoints = P('endpoints');
              //注册时间
              $startRegTime = P('startRegTime');
              $endRegTime = P('endRegTime');
              //最后订单时间
              $startlastOrder = P('startlastOrder');
              $endlastOrder = P('endlastOrder');

              //累计消费
              $starttotalPay = P('starttotalPay');
              $endtotalPay = P('endtotalPay');

              $where = '1=1';
              if(intval($startpoints) > 0){
                    if(intval($endpoints) > 0){
                        $where .= ' and (points between '.intval($startpoints).' and '.intval($endpoints).')';
                    }else{
                        $where .= ' and points >= '.intval($startpoints).'';
                    }
              }
              if($startRegTime != ''){
                  if($endRegTime !=''){
                      $where .= ' and (regTime between "'.$startRegTime.'" and "'.$endRegTime.'")';
                  }else{
                      $where .= ' and regTime >= "'.$startRegTime.'"';
                  }
              }
              if($startlastOrder != ''){
                  if($endlastOrder != ''){
                      $where .= ' and (lastOrder between '.strtotime($startlastOrder).' and '.strtotime($endlastOrder).')';
                  }else{
                      $where .= ' and lastOrder >= '.strtotime($startlastOrder).'';
                  }
              }
              if(intval($starttotalPay) > 0){
                  if(intval($endtotalPay) > 0){
                      $where .= ' and (totalPay between '.intval($starttotalPay).' and '.intval($endtotalPay).')';
                  }else{
                      $where .= ' and totalPay >= '.intval($starttotalPay).'';
                  }
              }
              $result = M('member')->where($where)->execute();
             // var_dump($result);exit;
              $title = "手机号码,用户名,昵称,性别,注册时间,积分,最后消费\n";
              $title = iconv('utf-8','gb2312',$title);
              foreach($result as $res){
                  $res->sex == 0 ? $sex = '男' : '女';
                  $title = $title.$res->mobile.','.iconv('utf-8','gb2312',$res->realName).','.iconv('utf-8','gb2312',$res->nickname).','.iconv('utf-8','gb2312',$sex).','.$res->regTime.','.$res->points.','.strtotime('Y-m-d H:i:s',$res->lastOrder)."\n";
              }
              $filename = date('Ymd').'.csv';
              header("Content-type:text/csv");
              header("Content-Disposition:attachment;filename=".$filename);
              header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
              header('Expires:0');
              header('Pragma:public');
              echo $title;
          }
          
          public function search()
          {
              $mobile	= $this->input->get('mobile');
              $wh			= array();
              if ($mobile)
              {	
                  $wh		= array('mobile'=>$mobile);
              }
              return $wh;
          }
          
          public function order()
          {
              $id						= $this->input->get('id');
              $regTime				= $this->input->get('regTime');
              $purchaseAmount         = $this->input->get('purchaseAmount');

              $order		= array();
              if(isset($purchaseAmount)&&$purchaseAmount!='default')
              {
                  $order['purchaseAmount']	= $purchaseAmount;
                  $this->purchaseAmount = $purchaseAmount;
              }
              if(isset($regTime)&&$regTime!='default')
              {
                  $order['regTime']			= $regTime;
                  $this->regTime = $regTime;
              }
              if(isset($id))
              {
                  $order['id']				= $id;
                  $this->id = $id;
              }
              
              return $order;
          }

          public function show()
          {
              $edit	= S('show');
              $madd   = M('member_address')->getOneData(array('uid'=>$edit, 'isDefault'=>1));
              if(!$madd)
              {
                  $madd   = M('member_address')->getOneData(array('uid'=>$edit, 'isDefault'=>0));
                  if(!$madd)
                  {
                      $data['add']='无';
                  }
              }
              if($madd)
              {
                  $p = M('provincial')->getFieldData('name',array('id'=>$madd->provincial));
                  $c = M('city')->getFieldData('name',array('id'=>$madd->city));
                  $data['add'] = $p.$c.$madd->address.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$madd->consignee.'('.$madd->phone.')';
              }
              $data['row']   = M('member')->getOneData(array('id'=>$edit));
              $beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));
              $data['orderCount'] = M('order_info')->getAllCount(array('uid'=>$edit, 'orderStatus'=>4));
              $data['goodsTotal'] = M('order_info')->getFieldData('sum(amount)',array('uid'=>$edit, 'orderStatus'=>4));
              $data['orderCountThismonth'] = M('order_info')->getAllCount(array('uid'=>$edit, 'orderStatus'=>4, 'ctime >'=>$beginThismonth));
              $data['goodsTotalThismonth'] = M('order_info')->getFieldData('sum(amount)',array('uid'=>$edit, 'orderStatus'=>4, 'ctime >'=>$beginThismonth));
              if(!$data['goodsTotal'])
              {
                  $data['goodsTotal']='0.00';
              }
              if(!$data['goodsTotalThismonth'])
              {
                  $data['goodsTotalThismonth']='0.00';
              }
              $data['orderList'] = M('order_info')->where(array('uid'=>$edit,'orderStatus'=>4))->orderby(array('ctime'=>'desc'))->limit(0,30)->execute();
              $this->template->content    = new View('admin/member/show_view',$data);
              $this->template->render();
          }
          
          public function resetPwd()
          {			
              list($id)	= $this->input->getArgs();
              if ($id)
              {
                  $upd		= array(
                      'passwd'		=> md5($GLOBALS['config']['md5Key'].$GLOBALS['config']['defaultPwd'])
                      );
                  $wh			= array('id'=>$id);
                  $return		= $this->mod->update($upd,$wh);
                  if ($return >0)
                  {
                      echo json_encode(array('msg'=>'密码已重置'));
                  }
                  else
                      echo json_encode(array('msg'=>'重置密码失败'));
              }
              else
                  echo json_encode(array('msg'=>'参数错误'));
          }
          
          public function changePoint()
          {			
              $id	= P('id');
              if ($id)
              {
                  $upd		= array(
                      'points'		=> P('points')
                      );
                  $wh			= array('id'=>$id);
                  $return		= $this->mod->update($upd,$wh);
                  if ($return >0)
                  {
                      echo json_encode(array('success'=>1));
                  }
                  else
                      echo json_encode(array('success'=>0, 'msg'=>'保存失败'));
              }
              else
                  echo json_encode(array('success'=>0, 'msg'=>'参数错误'));
          }
          
          public function addGroup()
          {			
              $name = P('name');
              if ($name)
              {
                  $upd		= array(
                      'name'		=> $name
                      );
                  $return		= M('member_group')->save($upd);
                  if ($return >0)
                  {
                      echo json_encode(array('success'=>1));
                  }
                  else
                      echo json_encode(array('success'=>0, 'msg'=>'保存失败'));
              }
              else
                  echo json_encode(array('success'=>0, 'msg'=>'参数错误'));
          }
          
          public function editGroup()
          {			
              $id = P('id');
              $name = P('name');
              if ($id&&$name)
              {
                  $upd		= array(
                      'name'		=> $name
                      );
                  $wh = array('id'=>$id);
                  $return		= M('member_group')->update($upd,$wh);
                  if ($return >0)
                  {
                      echo json_encode(array('success'=>1));
                  }
                  else
                      echo json_encode(array('success'=>0, 'msg'=>'保存失败'));
              }
              else
                  echo json_encode(array('success'=>0, 'msg'=>'参数错误'));
          }
          
          public function deleteGroup()
          {
              $id = S('deleteGroup');
              if ($id)
              {
                  $wh = array('id'=>$id);
                  $return		= M('member_group')->delete($wh);
              }
              input::redirect('admin/member/group');
          }
          
  public function addLevel(){			
      $power = P('power','');
      $name = P('name','');
      $amount = P('amount','');
      $discount = P('discount','');
      $status = P('status','');
      $months = P('months','');
      $m_amount = P('m_amount','');
              
      if ($amount!='' && $name!=''){
          $upd = array(
            'account_id'=>  $this->account_id,
            'power'     =>  $power,
            'name'      =>  $name,
            'amount'    =>  $amount,
            'discount'  =>  $discount,
            'status'    =>  $status,
            'months'    =>  $months,
            'm_amount'  =>  $m_amount,
            'addtime'   =>  time()
          );
          $return		= M('member_level')->save($upd);
          if ($return >0){
            echo json_encode(array('success'=>1));
          }else{
            echo json_encode(array('success'=>0, 'msg'=>'保存失败'));
          }
      }else{
        echo json_encode(array('success'=>0, 'msg'=>'参数错误'));
      }
  }
  // 编辑会员等级信息
  public function editLevel(){
      $power = P('power','');
      $name = P('name','');
      $amount = P('amount','');
      $discount = P('discount','');
      $status = P('status','');
      $months = P('months','');
      $m_amount = P('m_amount','');
      $id = P('id','');
      if ($amount!='' && $name!=''){
          $upd = array(
            'power'     =>  $power,
            'name'      =>  $name,
            'amount'    =>  $amount,
            'discount'  =>  $discount,
            'status'    =>  $status,
            'months'    =>  $months,
            'm_amount'  =>  $m_amount,
          );
          $wh = array('id'=>$id,'account_id'=>$this->account_id);
          $rs  = M('member_level')->update($upd,$wh);
          if($rs){
            echo json_encode(array('success'=>1));
          }else{
            echo json_encode(array('success'=>0, 'msg'=>'保存失败'));
          }
      }else{
        echo json_encode(array('success'=>0, 'msg'=>'参数错误'));
      }   
  }
    // 获取会员等级信息
    public function getInfo(){
      $re_msg['success'] = 0;
      $re_msg['msg'] = "获取失败";
      $id = P('id');
      $result = M('member_level')->getOneData("id=$id and account_id=".$this->account_id);
      if($result){
        $re_msg['success'] = 1;
        $re_msg['msg'] = "获取成功";
        $re_msg['info'] = $result;
      }
      echo json_encode($re_msg);
    } 
    // 删除会员等级信息
    public function deleteLevel()
    {
        $id = S('deleteLevel');
        if ($id)
        {
            $wh = array('id'=>$id,'account_id'=>$this->account_id);
            $return		= M('member_level')->delete($wh);
        }
        input::redirect('admin/member/level');
    }
    // 删除会员
    public function delete_member(){
        $id = P("id","");
        $re_msg['success'] = 0;
        $re_msg['msg'] = "删除失败";
        $rs = M('member')->delete("id=$id");
        if($rs){
          $re_msg['success'] = 1;
          $re_msg['msg'] = "删除成功";
        }
        echo json_encode($re_msg);
    }
    // 批量删除会员
    public function delete_allmember(){
        $id = P("id","");
        $re_msg['success'] = 0;
        $re_msg['msg'] = "删除失败";
        $rs = M('member')->delete("id in ($id)");
        if($rs){
          $re_msg['success'] = 1;
          $re_msg['msg'] = "删除成功";
        }
        echo json_encode($re_msg);
    }
    // 导出会员信息
    public function member_excel(){
      $levelId = G('levelId','');

      $where = $levelId!='' ? "levelId=$levelId" : '';
      $result = M("member")->select("realName,regTime,nickname,mobile,sex,address,points,share_points,golds,amount,commission,member_num,freeze_money")->where($where)->execute();
      $data = json_decode(json_encode($result),true);
      $title = array('真实姓名','注册时间','昵称','手机号','性别','地址','积分','分享积分','金币','消费金额','佣金','推荐会员数量','冻结金额');
      $name = "member";
      output_ext::exportexcel($data,$title,$name);
    }
}
?>