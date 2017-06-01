<?php defined('KING_PATH') or die('访问被拒绝.');
class Log_Controller extends Template_Controller
{
	public function __construct()
	{
		parent::__construct();
		comm_ext::validUser();
		$this->mod		= M('log');	
	}
	
	public function index()
	{
        $list = array();
        $pagesize = 20;
        $total		          = M('log')->getAllCount('1=1');
        $data['pagination']   = pagination::getClass(array(
            'segment'         => 'page',
            'total'           => $total,
            'perPage'		  => $pagesize
        ));
        $fnum = ($data['pagination']->currentPage-1)*$pagesize;
        $rs = M('log')->where('1=1')->orderby('id desc')->limit($fnum,$pagesize)->execute();
        if(!empty($rs)){
            foreach($rs as $key=>$val){
                $list[$key] = array_ext::toArray($val);
            }
        }

        $data['List'] = $list;
		$this->template->content	= new View('admin/log/index_view',$data);
		$this->template->render();			
	}
    // 批量删除记录
    public function del_more(){
        $id = P('id','');
        $re_msg['success'] = 0;
        $re_msg['msg'] = "删除失败";
        $rs = M('tk_log_commission')->delete("id in ($id)");
        if($rs){
          $re_msg['success'] = 1;
          $re_msg['msg'] = "删除成功";
        }
        echo json_encode($re_msg);
    }
    //积分日志
	public function points(){
        $wh = ' 1=1';
        $username = G('username','');
        $type = G('type','');
        $stime = G('startTime','');
        $etime = G('endTime','');
        if(!empty($username)){
            $urs = M('member')->select('id')->where('mobile like \'%'.$username.'%\' or realname like \'%'.$username.'%\'')->limit(0,10)->execute();
            if(!empty($urs)){
                $istr = '';
                foreach($urs as $val){
                    $istr.=$val->id.',';
                }
                $wh.=' and member_id in('.trim($istr,',').')';
            }else{
                $wh.=' and member_id=\'0\'';
            }
        }
        // 日志类型
        if(!empty($type)){
        	$wh.=' and type=\''.$type.'\'';
        } 
        if(!empty($stime)){
            $stime_int = strtotime($stime);
            $wh.=' and ptime>=\''.$stime_int.'\'';
        }
        if(!empty($etime)){
            $etime_int = strtotime($etime);
            if(!empty($stime_int)){
                //如果有起始时间则结束时间不能小于起始时间
                if($etime_int>=$stime_int){
                    $wh.=' and ptime<=\''.$etime_int.'\'';
                }
            }else{
                $wh.=' and ptime<=\''.$etime_int.'\'';
            }
        }
        $list = array();
        $pagesize = 20;
        $total		        = M('jifen_log')->getAllCount($wh);
        $data['pagination'] = pagination::getClass(array(
            'segment'       => 'page',
            'total'         => $total,
            'perPage'		=> $pagesize
        ));
        $fnum = ($data['pagination']->currentPage-1)*$pagesize;
        $rs = M('jifen_log')->where($wh)->orderby('id desc')->limit($fnum,$pagesize)->execute();
        if(!empty($rs)){
            foreach($rs as $key=>$val){
                $list[$key] = array_ext::toArray($val);
                $list[$key]['point'] = ($val->point>=0)?$val->point:'<font color=\'#ff0000\'>'.$val->point.'</font>';
                $list[$key]['uname'] = member_ext::get_realname($val->member_id);
                $list[$key]['lei'] = jifen_ext::get_actstrname($val->actstr);
            }
        }
        $data['List'] = $list;
        $this->template->content	= new View('admin/log/jifen_log_view',$data);
        $this->template->render();
    }
	public function getLog()
	{
		$tid		= $this->input->post('tid');
		if ($tid)
		{
			$wh		= array('tid'=>$tid);
		}
		$total		= $this->mod->getAllCount($wh);
		$page		= $this->input->post('page');
		$size		= $this->input->post('rows');
		$start		= ($page-1)*$size;
		$rs			= $this->mod->where($wh)->orderby(array('id'=>'desc'))->limit($start,$size)->execute();
		$rs2		= array();
		foreach ($rs as $row)
		{
			$row2				= $this->mod->getOneData(array('id'=>$row->uid),'','account');
			$row->user			= $row2->username;
			$row->type			= $this->mod->getFieldData('modName',"id='{$row->tid}'",'mod');
			$row->ctime			= date('Y-m-d H:i:s',$row->ctime);
			$rs2[]				= $row;
		}
		echo json_encode(array('total'=>$total,'rows'=>$rs2));			
	}
    public function clearlog(){
        $vtime = time()-2592000;    //日志保留30天
        M('log')->delete('ctime<\''.$vtime.'\'');
        die(json_encode(array('errorno'=>0,'msg'=>'success')));
    }

    // 访问量统计
    public function hitsList(){
        $where = 'di.did=6';
        $rs = M()->query("SELECT count(*) as total FROM tf_shop_hits sh LEFT JOIN tf_dict_item di ON di.`data`=sh.mall_id WHERE $where");
        $total      = $rs[0]->total;
        $data['pagination'] = pagination::getClass(array(
            'segment'       => 'page',
            'total'         => $total,
            'perPage'       => $pagesize
        ));
        $fnum = ($data['pagination']->currentPage-1)*$pagesize;
        $sql = "SELECT di.name,ms.shop_name,sh.pv,sh.uv,sh.fav,sh.delfav,sh.sales_num,sh.sales_money,sh.`share`,sh.cart_num, FROM_UNIXTIME(sh.pdate) pdate
            FROM tf_shop_hits sh LEFT JOIN tf_member_shop ms ON ms.id=sh.shop_id
            LEFT JOIN tf_dict_item di ON di.`data`=sh.mall_id WHERE $where limit $fnum,15";
        $data['hitsList'] = M()->query($sql);
        $this->template->content    = new View('admin/log/hitsList_view',$data);
        $this->template->render();
    }

    // 佣金日志记录
    public function commission(){
        // 条件搜索
        $h_arr['tc.code'] = G('code','');
        $h_arr['lc.status'] = G('status','');
        $h_arr['m.mobile'] = G('mobile','');
        $h_arr['m.nickname like'] = G('nickname','');
        $h_arr['mr.nickname like'] = G('gnickname','');
        $h_arr['mr.mobile'] = G('gmobile','');
        $h_arr['tc.title like'] = G('title','');
        $h_arr['lc.type <'] = 2;
        $h_arr['lc.price'] = G('price','');
        $h_arr['tc.price'] = G('order_price','');
        $h_arr['stime']['lc.addtime >='] = G('startTime','');
        $h_arr['etime']['lc.addtime <='] = G('endTime','');
        $where = "";
        $where = file_ext::get_where($h_arr);

        if($where!=""){
            $where = " where $where";
        }        
        $hql = "SELECT count(*) as total FROM tf_tk_log_commission lc 
                    LEFT JOIN tf_member m ON m.id=lc.member_id 
                    LEFT JOIN tf_member mr ON mr.id=lc.to_member_id 
                    left join tf_tk_coupon tc on tc.id=lc.coupon_id $where ";
        $rs = M()->query($hql);
        $total      = $rs[0]->total;
        $pagesize = 20;
        $data['pagination'] = pagination::getClass(array(
            'segment'       => 'page',
            'total'         => $total,
            'perPage'       => $pagesize
        ));
        $fnum = ($data['pagination']->currentPage-1)*$pagesize;

        $sql = "SELECT tc.title,tc.code,m.id,m.nickname purchaser,mr.nickname gainer,lc.id as lcid,lc.type,lc.price,lc.note,lc.status,lc.content, lc.addtime
                FROM tf_tk_log_commission lc 
                LEFT JOIN tf_member m ON m.id=lc.member_id 
                LEFT JOIN tf_member mr ON mr.id=lc.to_member_id 
                left join tf_tk_coupon tc on tc.id=lc.coupon_id
                $where order by lc.status asc,lc.addtime desc limit $fnum,$pagesize";

        $result = M()->query($sql);

        $data["List"] = json_decode(json_encode($result),true);

        $result = M("set_finance")->getOneData("id=1",'member_time');
        $data['delay'] = $result->member_time;

        $this->template->content    = new View('admin/log/commission_view',$data);
        $this->template->render();
    }
     // 分红日志记录
    public function share(){
        $this->mk_share();
        // 条件搜索
        $h_arr['lc.status'] = G('status','');
        $h_arr['mr.nickname like'] = G('gnickname','');
        $h_arr['mr.mobile'] = G('gmobile','');
        $h_arr['lc.price'] = G('price','');
        $h_arr['lc.type'] = 3;
        $h_arr['stime']['lc.addtime >='] = G('startTime','');
        $h_arr['etime']['lc.addtime <='] = G('endTime','');
        $where = "";
        $where = file_ext::get_where($h_arr);

        if($where!=""){
            $where = " where $where";
        }        
        $hql = "SELECT count(*) as total FROM tf_tk_log_commission lc 
                    LEFT JOIN tf_member mr ON mr.id=lc.to_member_id 
                    $where ";
        $rs = M()->query($hql);
        $total      = $rs[0]->total;
        $pagesize = 20;
        $data['pagination'] = pagination::getClass(array(
            'segment'       => 'page',
            'total'         => $total,
            'perPage'       => $pagesize
        ));
        $fnum = ($data['pagination']->currentPage-1)*$pagesize;

        $sql = "SELECT mr.nickname gainer,lc.id as lcid,lc.type,lc.day_num,lc.price,lc.note,lc.status,lc.content,lc.addtime
                FROM tf_tk_log_commission lc 
                LEFT JOIN tf_member mr ON mr.id=lc.to_member_id 
                $where order by lc.status asc,lc.addtime desc limit $fnum,$pagesize";

        $result = M()->query($sql);

        $data["List"] = json_decode(json_encode($result),true);

        $result = M("set_finance")->getOneData("id=1",'member_time');
        $data['delay'] = $result->member_time;

        $this->template->content    = new View('admin/log/share_view',$data);
        $this->template->render();
    }
    public function get_pid($array='',$pid=0){

        foreach ($array as $key => $value) {
            if($value->pid == $pid){
                $value->child = $this->get_pid($array,$value->id);
                $new[] = $value;
            }
        }
        return $new;
    }
    // 生成分红记录
    public function mk_share(){
        $drs = dividend_ext::countFenhong();
        if($drs){
            $time = date('Ym',strtotime("-1 month"));
            $log = M("tk_log_commission")->getAllCount("day_num=$time");
            if($log == 0){
                $result = M("area_dividend d")->select("m.id,m.openId,d.fenhong")->join("member m","m.id=d.member_id")->where("day_num=$time")->execute();
                foreach ($result as $key => $value) {
                    $data['to_member_id'] = $value->id;
                    $data['type'] = 3;
                    $data['price'] = $value->fenhong;
                    $data['status'] = 2;
                    $data['addtime'] = time();
                    $data['day_num'] = $time;
                    $data['note'] = '分红记录';
                    M("tk_log_commission")->save($data);
                    // 统计用户总收入
                    tuoke_ext::add_commission($value->id,$value->fenhong);
                }
            }
        }        
    }
    // 商品浏览量展示
    public function item(){
        // $arr = M("member")->select("id,pid,levelId")->where("regTime<1477108800")->execute();
        // $ar = $this->get_pid($arr);
        // print_r($ar);

        $name = G('name','');

        $where = $name!=''? "item_name like '%$name%' ":'';
        $total    = M("tk_item_count")->getAllCount($where);
        $pagesize = 20;
        $data['pagination'] = pagination::getClass(array(
            'segment'       => 'page',
            'total'         => $total,
            'perPage'       => $pagesize
        ));
        $fnum = ($data['pagination']->currentPage-1)*$pagesize;
        $data['List'] = M("tk_item_count")->select()->where($where)->limit($fnum,$pagesize)->execute();
        $data['name'] = $name;
        $this->template->content    = new View('admin/log/item_view',$data);
        $this->template->render();
    }
    // 商家信息展示
    public function show_business(){
        $name = G('name','');

        $where = $name!=''? "item_name like '%$name%' ":'';
        $total    = M("tk_business")->getAllCount($where);
        $pagesize = 20;
        $data['pagination'] = pagination::getClass(array(
            'segment'       => 'page',
            'total'         => $total,
            'perPage'       => $pagesize
        ));
        $fnum = ($data['pagination']->currentPage-1)*$pagesize;
        $data['List'] = '';
        $data['name'] = $name;
        $this->template->content    = new View('admin/log/business_view',$data);
        $this->template->render();
    }

    // 用户红包重新发送
    public function again_money_member(){
        $id = P('id','');
        $rs = 0;
        if($id!=''){
            $rs = auto_ext::again_money_member($id);
        }

        echo $rs;
    }
    // 给用户批量重新发红包
    public function again_all_member(){
        $id = P('str','');
        if($id!=''){
            auto_ext::again_all_member($id);
        }
        echo 1;
    }
    // 店家红包重新发送
    public function again_money_business(){
        $id = P('id','');
        $rs = 0;
        if($id!=''){
            $rs = auto_ext::again_money_business($id);
        }

        echo $rs;
    }
     // 给店家批量重新发红包
    public function again_all_business(){
        $id = P('str','');
        if($id!=''){
            auto_ext::again_all_business($id);
        }
        echo 1;
    }

}