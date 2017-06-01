<?php defined('KING_PATH') or die('访问被拒绝.');
class Business_Controller extends Template_Controller
{
	private $mod;
	public function __construct()
	{
		parent::__construct();
		comm_ext::validUser();
		$this->account_id = accountInfo_ext::accountId(); 
	}
	
	/**
	 * 拓客商家列表
	 */
	public function index()
	{
		 // 条件搜索
        $h_arr['mobile'] = G('mobile','');
        $h_arr['name like'] = G('name','');
        $h_arr['realname like'] = G('realname','');
        $h_arr['city like'] = G('city','');
        $h_arr['stime']['addtime >='] = G('startTime','');
        $h_arr['etime']['addtime <='] = G('endTime','');
        $where = "";
        $where = file_ext::get_where($h_arr);

		$arr = $this->input->getArgs();
    	$tab_class = $arr[0];

    	if($tab_class == 100){
    		$where = "status=1";
    	}
    	if($tab_class == 101){
    		$where = "status=0";
    	}
    	if($tab_class == 102){
    		$where = "status=2";
    	}

    	$page_size = 20;
    	if(!empty($tab_class)){
    		$total	   = M('tk_business')->getAllCount();
    	}else{
    		$total	   = M('tk_business')->getAllCount($where);
    	}
    	
		$data['pagination'] = pagination::getClass(array(
			'total'		    => $total,
			'perPage'		=> $page_size,
    	    'segment'		=> 'page',
		));
		$start	= ($data['pagination']->currentPage-1)*$page_size;

		$rs	= M('tk_business')->where($where)->select()->orderby(" addtime desc")->limit($start,$page_size)->execute();
		$data['list']	= $rs;

		$where1 = $where." and status=1";
		$data['run'] = M('tk_business')->getAllCount(array('status'=>1));	
		$where0 = $where." and status=0";
		$data['over'] = M('tk_business')->getAllCount(array('status'=>0));
		$where2 = $where." and status=2";
		$data['apply'] = M('tk_business')->getAllCount(array('status'=>2));

		$data['total'] = $total;
		$data['tab_class'] = $tab_class;
		$data['name']	= $name;
		$data['startTime']	= $startTime;
		$data['endTime']	= $endTime;
		$data['realname'] = $realname;
		$data['mobile'] = $mobile;
		$data['city'] = $city;
		$this->template->content = new View('admin/business/index_view',$data);
		$this->template->render();
	}
	// 获取店铺状态信息
	public function get_status(){
		$id = P('id');
		$rs = M("tk_business")->getOneData("id=$id","status,note");
		echo json_encode($rs);
	}
	// 审核店铺状态
	public function apply_status(){
		$re_msg['success'] = 0;
		$re_msg['msg'] = "操作失败";

		$id = P('id');
		$data['status'] = P('status');
		$data['suretime'] = time();
		$data['note'] = P('note','');
		$rs = M("tk_business")->update($data,"id=$id");
		if($rs){
			$re_msg['success'] = 1;
			$re_msg['msg'] = "操作成功";
		}
		echo json_encode($re_msg);
	}
	/**
	 * 添加拓客商品
	 */
	public function add(){				
		$id = G('id','');
		if($id != ''){
			$result = M('tk_business')->getOneData("id=$id");
			$data['list'] = $result;
		}
		$data['clist'] = M('tk_category')->select()->execute();
		$this->template->content	= new View('admin/business/add_view',$data);
		$pic = D('picture')->GetData();
        $this->template->tipBoxContent3 = new View('admin/picture/useImg_view', $pic);

		$this->template->render();
	}
	/*
	 * 批量删除店铺
	 */
	public function del_more(){
		$id = P('id','');
        $re_msg['success'] = 0;
        $re_msg['msg'] = "删除失败";
        $rs = M('tk_business')->delete("id in ($id)");
        if($rs){
          $re_msg['success'] = 1;
          $re_msg['msg'] = "删除成功";
        }
        echo json_encode($re_msg);
	}

	/**
	 * 拓客商家保存
	 */
	public function save(){
		$id    = P('id','');
		$data['name'] =	P('name','');
 		$data['realname'] 	= P('realname','');
 		$data['status'] 	= P('status','');
 		$data['mobile'] 	= P('mobile','');
 		$data['zh_name']	= P('zh_name','');
 		$data['address'] 	= P('address','');
 		$data['full_address'] 	= P('full_address','');
 		$data['content'] 	= P('content','');
 		$data['openId']		= P('openid','');
 		$data['city'] 	= P('city',''); 		
 		$picskey 			= P('picskey','');

 		if(P('lat') && P('lng')){
 			$data['lat']		= P('lat');
			$data['lng']		= P('lng');
 		}
		$re_msg['success'] = 0;
		$re_msg['msg'] = "操作失败";		
		
		$data['pic'] 		= empty($picskey) ? '':$picskey[0];
		if(empty($data['mobile']) || empty($data['openId'])){
			$re_msg['msg'] = "手机号和openid不能为空";
			echo json_encode($re_msg);
			exit;
		}
		if($id!=''){
			if(P('suretime','') == '' && $data['status'] == 1){
				$data['suretime'] = time();
			}
			$rs = M('tk_business')->update($data,"id=$id");
			if($rs){
				$re_msg['success'] = 1;
				$re_msg['msg'] = "编辑成功";
			}
		}else{
			$is_rs = M("tk_business")->getOneData("mobile='".$data['mobile']."' or openId='".$data['openId']."'");
			if($is_rs){
				$re_msg['msg'] = "手机号或者openid已经存在，不要重复添加!";
			}else{				
				if($data['status'] == 1){
					$data['suretime'] = time();
				}
				$data['addtime'] 	= time();
				$rs = M('tk_business')->save($data);
				if($rs){
					// 生成二维码图片.
					$this->mk_qrcode($rs);		
					$re_msg['success'] = 1;
					$re_msg['msg'] = "新增成功";				
				}
			}
		}
   	 	
		echo json_encode($re_msg);
	}
	
	/*
	 * 生成店铺二维码
	 */
	public function shop_code(){
		$id = P('id','');
		if($id!=''){
			// 生成二维码图片.
			$rs = $this->mk_qrcode($id);		
		}
		echo $rs;
	}
	public function mk_qrcode($id=0){		
		// 生成二维码图片
		$url = "http://tok.uszhzh.com/wechat/business/detail/".$id;		
    	$filename = 'upload/qrcode/shop_'.$id.'.png';    			
    	$qrcode = qrcode::getClass();

		$qrcode->png($url,$filename);

		$code['qrCode'] = $filename;
		$rs = M('tk_business')->update($code,"id=$id");
		return $rs;
	}
	/**
	 * 查询详情
	 */
	public function show_detail()
	{
		$id	= P('id','1');
		
		$re_msg['success'] = 0;
		$re_msg['msg'] = "查询失败";

		$result = M('tk_business')->getOneData("id=$id");
		if($result){
			$re_msg['success'] = 1;
			$re_msg['msg'] = "查询成功";
			$re_msg['info'] = $result;
		}
		echo json_encode($re_msg);
	}		
	// 删除活动
	public function del_business(){
		$id = P('id','');
		$re_msg['success'] = 0;
		$re_msg['msg'] = "查询失败";
		$rs = M('tk_business')->delete("id=$id");
		if($rs){
			$re_msg['success'] = 1;
			$re_msg['msg'] = "查询成功";
		}
		echo json_encode($re_msg);
	}

	// 导出商家信息
	public function business_excel(){
		$name = G('name','');
		$startTime = G('startTime','');
		$endTime = G('endTime','');
		$tab_class = G('tab_class','');

    	$where = '1 ';
    	if($tab_class == 100){
    		$where .= " and status=1";
    	}
    	if($tab_class == 101){
    		$where .= " and status=0";
    	}
    	if($name != ''){
    		$where .= " and name like '%$name%'";
    	}

    	if(!empty($startTime)){
    		$stime = strtotime($startTime);
    		if(!empty($endTime)){
    			$etime = strtotime($endTime);
    			$where .= " and addtime>=$stime and addtime<=$etime";
    		}else{
    			$where .= " and addtime>=$stime";
    		}
    	}
    	$sql = "SELECT name,realname, mobile,address,
                CASE status 
                WHEN 0 THEN '关闭' 
                WHEN 1 THEN '正常' 
                END AS status,
                addtime FROM tf_tk_business where $where";
        $rs = M()->query($sql);
        $data = json_decode(json_encode($rs),true);
        $title = array('店名','真实姓名','手机号','地址','店铺状态','添加时间');
        $name = "business";
        output_ext::exportexcel($data,$title,$name);
	}
}
