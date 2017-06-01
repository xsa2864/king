<?php defined('KING_PATH') or die('访问被拒绝.');
      class Member_Controller extends Template_Controller
      {
          private $mod;
          private $id;
          private $regTime;
          private $purchaseAmount;
          
          public function __construct()
          {
              parent::__construct();
              $this->mod				 = M('member');
          }
          // 会员展示列表页
          public function index()
          {
              $where = '1';
              $mobilename = G('mobilename');
              $startTime = G('startTime');
              $puiSelect = G('puiSelect');
              // 昵称/ID条件
              if($mobilename != ''){
                if(preg_match('/1\d{10}/',$mobilename)){
                  $where .= ' and m.mobile = \''.$mobilename.'\'';                
                }else{
                  $where .= ' and m.nickname like \'%'.$mobilename.'%\'';
                }
              }
              // 时间条件
              if($startTime != ''){
                  if($endTime != ''){
                      $where .= ' and m.regTime between unix_timestamp(\''.$startTime.'\') and unix_timestamp(\''.$endTime.'\')';
                  }else{
                      $where .= ' and m.regTime >= unix_timestamp(\''.$startTime.'\')';
                  }
              }

              $hql = "SELECT count(*) total FROM tf_member m LEFT JOIN tf_member_attr ma ON ma.member_id=m.id where ";
              $hql .= $where;
              $rs_count	= M()->query($hql);
              $total = $rs_count[0]->total;

              $data['pagination'] = pagination::getClass(array(
                  'total'		=> $total,
                  'perPage'		=> 10,
                  'segment'		=> 'page',
                  ));
              $start		= ($data['pagination']->currentPage-1)*20;
              // 条件排序
              $select_arr = array('m.regTime','ma.golds','ma.points','m.levelId','ma.amount','ma.member_num','ma.commission');  
              if(in_array($puiSelect ,$select_arr)){
                $where .= " order by $puiSelect desc";
              }

              $where .= " limit $start,20";
              $sql = "SELECT * FROM tf_member m LEFT JOIN tf_member_attr ma ON ma.member_id=m.id where ";
              $sql .= $where;        
              $rs	= M()->query($sql);

              // 会员消费信息，如果没有，则初始化
              foreach ($rs as $key => $value) {
                if(empty($value->member_id)){
                  if($value->id){
                    $data_m['member_id'] = $value->id;
                    M('member_attr')->insert($data_m);                  
                  }
                }
              }
              
              $data['total']  = $total;
              $data['members']= $rs;
              $this->template->content    = new View('admin/member/index_view',$data);
              $this->template->tipBoxContent1 = new View('admin/member/changePoints_view');
              $this->template->render();
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
              $rs			= M('member_level')->orderby(array('orderNum'=>'asc'))->execute();
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
          
          public function addLevel()
          {			
              $point = P('point');
              $name = P('name');
              $order = P('order');
              $min = P('min');
              $max = P('max');
              if ($point&&$name&&$min&&$max)
              {
                  $upd		= array(
                      'name'		=> $name,
                      'minExpense'		=> $min,
                      'maxExpense'		=> $max,
                      'point'		=> $point,
                      'orderNum'		=> $order
                      );
                  $return		= M('member_level')->save($upd);
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
          
          public function editLevel()
          {
              $id = P('id');
              $point = P('point');
              $name = P('name');
              $order = P('order');
            //  $min = P('min');
            //  $max = P('max');
              P('min') == 0 ? $min = 1 : $min = P('min');
              P('max') == 0 ? $max = 1 : $max = P('max');
              if ($id&&$point&&$name&&$min&&$max)
              {
                  $upd		= array(
                      'name'		=> $name,
                      'minExpense'		=> $min,
                      'maxExpense'		=> $max,
                      'point'		=> $point,
                      'orderNum'		=> $order
                      );
                  $wh = array('id'=>$id);
                  $return		= M('member_level')->update($upd,$wh);
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
          
          public function deleteLevel()
          {
              $id = S('deleteLevel');
              if ($id)
              {
                  $wh = array('id'=>$id);
                  $return		= M('member_level')->delete($wh);
              }
              input::redirect('admin/member/level');
          }


      }
?>