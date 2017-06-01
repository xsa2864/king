<?php defined('KING_PATH') or die('访问被拒绝.');
class Tkitem_Controller extends Template_Controller
{
	private $mod;
	public function __construct()
	{
		parent::__construct();
		comm_ext::validUser();
		$this->mod	= M('group');
		$this->account_id = accountInfo_ext::accountId(); 
	}
	
	/**
	 * 拓客商品列表
	 */
	public function index()
	{

		$arr = $this->input->getArgs();
    	$tab_class = $arr[0];

    	$where = '';
    	if($tab_class == 100){
    		$where = "status=1";
    	}
    	if($tab_class == 101){
    		$where = "status=0";
    	}

    	// 标题 start
    	$data['title'] = G('title','');
    	if($data['title'] != ''){
    		if($where != ''){
    			$where .= " and ";
    		}
    		$where .= " title like '%".$data['title']."%'";
    	}
    	// 标题 end

    	// 时间区间 start
		$startTime = G('startTime','');
		$endTime = G('endTime','');
    	if(!empty($startTime)){
    		if($where != ''){
    			$where .= " and ";
    		}
    		$stime = strtotime($startTime);
    		if(!empty($endTime)){
    			$etime = strtotime($endTime);
    			$where .= "starttime>=$stime and endtime<=$etime";
    		}else{
    			$where .= "starttime>=$stime";
    		}
    	}
    	// 时间区间 end


    	$page_size = 20;
    	$total	   = M('tk_item')->getAllCount($where);
		$data['pagination'] = pagination::getClass(array(
			'total'		    => $total,
			'perPage'		=> $page_size,
    	    'segment'		=> 'page',
		));
		$start	= ($data['pagination']->currentPage-1)*$page_size;

		$rs				= M('tk_item')->where($where)->select()->orderby(" addtime desc")->limit($start,$page_size)->execute();
		$data['list']	= $rs;

		$where1 = "status=1";
		$data['run'] = M('tk_item')->getAllCount($where1);
	
		$where0 = "status=0";
		$data['over'] = M('tk_item')->getAllCount($where0);
		$data['total'] = $total;
		$data['tab_class'] = $tab_class;
		$data['startTime']	= $startTime;
		$data['endTime']	= $endTime;
		$this->template->content = new View('admin/tkitem/index_view',$data);
		$this->template->render();
	}
	
	/**
	 * 添加拓客商品
	 */
	public function add(){
		$id = G('id','');
		$type = G('type','');
		if($id != ''){
			$result = M('tk_item')->getOneData("id=$id");
			$data['list'] = $result;
		}
        $rs	= M('tk_category')->orderby(array('id'=>'asc'))->execute();
        $data['tree'] = $rs;

        $data['category'] = M('tk_business')->select("id,name")->where("status=1")->execute();
        $data['type'] = $type;
		$this->template->content	= new View('admin/tkitem/add_view',$data);
		$pic = D('picture')->GetData();
        $this->template->tipBoxContent3 = new View('admin/picture/useImg_view', $pic);

		$this->template->render();
	}
	// 删除批量商品
	public function del_more(){
		$id = P('id','');
        $re_msg['success'] = 0;
        $re_msg['msg'] = "删除失败";
        $rs = M('tk_item')->delete("id in ($id)");
        if($rs){
          $re_msg['success'] = 1;
          $re_msg['msg'] = "删除成功";
        }
        echo json_encode($re_msg);
	}

	/**
	 * 拓客商品详情
	 */
	public function detail(){
		$id = G('id','');
		if($id != ''){
			$result = M('tk_item')->getOneData("id=$id");
			$data['list'] = $result;
		}
        $rs	= M('tk_category')->orderby(array('id'=>'asc'))->execute();
        $data['tree'] = $rs;

        $data['category'] = M('tk_business')->select("id,name")->where("status=1")->execute();
        $data['type'] = $type;
		$this->template->content	= new View('admin/tkitem/detail_view',$data);
		$pic = D('picture')->GetData();
        $this->template->tipBoxContent3 = new View('admin/picture/useImg_view', $pic);

		$this->template->render();
	}
	/**
	 * 拓客商品保存
	 */
	public function save(){
		$id    = P('id','');
		$title = P('title','');
 		$data['type'] 		= P('type','');
 		$data['status'] 	= P('status','');
 		$data['validtime'] 	= P('validtime','');
 		$data['content'] 	= P('content','');
 		$data['business_id']= P('business_id','');
 		$data['price'] 		= P('price',0);
 		$data['pv']			= P('pv',0);
 		$data['stock'] 		= P('stock',0);
 		$data['limit_num'] 	= P('limit_num',0);
 		$data['timetype'] 	= P('timetype',0);
 		$data['sell_num'] 	= P('sell_num',0);
		$data['bus_type'] 	= P('bus_type',0);
		$data['mem_type'] 	= P('mem_type',0);
		$data['bus_num'] 	= P('bus_num',0);
		$data['mem_num1'] 	= P('mem_num1',0);
		$data['mem_num2'] 	= P('mem_num2',0);
		$data['mem_num3'] 	= P('mem_num3',0);
 		$starttime 			= P('starttime','');
 		$endtime 			= P('endtime','');
 		$picskey 			= P('picskey','');
 		$picskeys 			= P('picskeys','');

		$re_msg['success'] = 0;
		$re_msg['msg'] = "操作失败";

		$data['title']      = $title;
		if($data['timetype'] == 0){
			$data['starttime']	= time();
			$data['endtime'] 	= time()+3600*24*$data['validtime'];
		}else{
			$data['starttime']	= $starttime ? strtotime($starttime):'';
			$data['endtime'] 	= $endtime ? strtotime($endtime):'';
		}
		$data['addtime'] 	= time();
		$data['index_img'] 	= $picskeys;
		$data['img'] 		= empty($picskey) ? '':$picskey[0];
		$data['pics']		= empty($picskey) ? '':json_encode($picskey);
		if($title == ''){
			$re_msg['msg'] = "标题不能为空";
			echo json_encode($re_msg);
			exit;
		}
		if(!empty($data['starttime']) && !empty($data['endtime'])){
			if($data['starttime']>$data['endtime']){
				$re_msg['msg'] = "开始时间和结束时间设置有误!";
				echo json_encode($re_msg);
				exit;
			}
		}
		if($id!=''){
			$rs = M('tk_item')->update($data,"id=$id");
		}else{
			$rs = M('tk_item')->save($data);
		}
   	 	
		if($rs){
			$re_msg['success'] = 1;
			$re_msg['msg'] = "操作成功";
		}
		echo json_encode($re_msg);
	}
	
	/**
	 * 查询详情
	 */
	public function show_detail()
	{
		$id	= P('id');
		
		$re_msg['success'] = 0;
		$re_msg['msg'] = "查询失败";
		$sql = "SELECT tc.name,ti.title,ti.content,ti.img,ti.price,ti.`status`,ti.validtime,from_unixtime(ti.starttime) starttime,from_unixtime(ti.endtime) endtime,from_unixtime(ti.addtime) addtime
			FROM tf_tk_item ti LEFT JOIN tf_tk_category tc ON tc.id=ti.category
			where ti.id=$id limit 1";
		$result = M()->query($sql);
		if($result){
			$re_msg['success'] = 1;
			$re_msg['msg'] = "查询成功";
			$re_msg['info'] = $result[0];
		}
		echo json_encode($re_msg);
	}		
	// 删除活动
	public function del_item(){
		$id = P('id','');
		$re_msg['success'] = 0;
		$re_msg['msg'] = "查询失败";
		$rs = M('tk_item')->delete("id=$id");
		if($rs){
			$re_msg['success'] = 1;
			$re_msg['msg'] = "查询成功";
		}
		echo json_encode($re_msg);
	}
	// 商品导出excel
	public function item_excel(){
		
	}
	// 更新状态
	public function change_status(){
		$re_msg['success'] = 0;
		$re_msg['msg'] = "更新失败";

		$id = P('id',''); 
		$data['status'] = P('status',0);
		$rs = M('tk_item')->update($data,"id=$id");
		if($rs){
			$re_msg['success'] = 1;
			$re_msg['msg'] = "更新成功";
		}
		echo json_encode($re_msg);
	}
}
