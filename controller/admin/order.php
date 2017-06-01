<?php defined('KING_PATH') or die('访问被拒绝.');
class Order_Controller extends Template_Controller
{
	private $mod;
	public function __construct()
	{
		parent::__construct();
		comm_ext::validUser();
		$this->mod	= M('order_info');
        $this->account_id = accountInfo_ext::accountId(); 
	}
	
	public function index()
	{
        $arr = $this->input->getArgs();
        $tab_class = $arr[0];
        $wh = "status != '-99'";          
        if($tab_class == 100){
            $wh = 'status = 0';
        }
        if($tab_class == 1){
            $wh = 'status = 1';
        }
        if($tab_class == 2){
            $wh = 'status = 2';
        }
        if($tab_class == 4){
            $wh = 'status = 4';
        }
        if($tab_class == 99){
            $wh = 'status = 99';
        }

        $order_sn = G('order_sn');
        $startTime = G('startTime');
        $endTime = G('endTime');
        $data['searchName'] = $searchName;
        $data['startTime'] = $startTime;
        $data['endTime'] = $endTime;
        if(isset($order_sn)){
            $wh .= ' and order_sn='.$order_sn;
        }
        if($startTime != ''){
            if($endTime != ''){
                $wh .= ' and (ctime between '.strtotime($startTime).' and '.strtotime($endTime).')';
            }else{
                $wh .= ' and (ctime >= '.strtotime($startTime).')';
            }
        }
        // 经销商条件
        $wh .= " and account_id=".$this->account_id;

        // echo $wh;
        //根据订单状态做统计
        $all_total = $this->mod->getAllCount(array('status!='=>'-99'));
        $all_noPay = $this->mod->getAllCount(array('status'=>0,'status!='=>'-99'));
        $all_Pay = $this->mod->getAllCount(array('status'=>1,'status!='=>'-99'));
        $all_send = $this->mod->getAllCount(array('status'=>2,'status!='=>'-99'));
        $all_ok = $this->mod->getAllCount(array('status'=>4,'status!='=>'-99'));
        $all_close = $this->mod->getAllCount(array('status'=>99,'status!='=>'-99'));
        $data['all_total'] = $all_total;
        $data['all_noPay'] = $all_noPay;
        $data['all_Pay'] = $all_Pay;
        $data['all_send'] = $all_send;
        $data['all_ok'] = $all_ok;
        $data['all_close'] = $all_close;

        $page_size = 10;
        $total	   = $this->mod->getAllCount($wh);
		$data['pagination'] = pagination::getClass(array(
			'total'		    => $total,
			'perPage'		=> $page_size,
         //   'style'       =>  'pagmall',
            'segment'		=> 'page',
		));
		$start	= ($data['pagination']->currentPage-1)*$page_size;
        
        $rs		= $this->mod->where($wh)->orderby('id desc')->limit($start,$page_size)->execute();

        $order_result = array();
        foreach ($rs as $key => $row){
            $order_result[$key] = array(
                'id'        => $row->id,
                'order_sn'  => $row->order_sn,
                'amount'    => $row->amount,
                'status'    => $row->status,
                'consignee' => $row->consignee,
                'addtime'   => $row->addtime,
            );
            //查询订单下的第一个物品，作为展示用
            $order_goods = M('order_goods')->select()->where('order_id='.$row->id)->execute();
            // // $goods_info = M('item')->getOneData(array('id'=>$order_goods->itemId));
            foreach ($order_goods as $value) {
                $order_result[$key]['child'][] = array(
                'order_id'      =>  $value->id,
                'name'          =>  $value->name,
                'pic'           =>  $value->pic,
                'price'         =>  $value->price,
                'num'           =>  $value->num,                    
                );
            }              
        }
        $data['expressList'] = M('express')->select()->where("account_id=".$this->account_id)->execute();

		$data['orders'] = $order_result;
        $data['tab_class'] = $tab_class;
        $this->template->content	= new View('admin/order/index_view', $data);
        $this->template->render();
	}
    // 获取商品明细
    public function get_goods_info(){
        $id = P('id','');
        $re_msg['success'] = 0;
        $re_msg['msg'] = "获取失败";
        $result = M('order_goods')->select()->where("order_id=$id")->execute();
        if($result){
            $re_msg['success'] = 1;
            $re_msg['msg'] = "获取成功";
            $re_msg['info'] = $result;
        }
        echo json_encode($re_msg);
    }

	public function add()
	{
        $this->template->content = new View('admin/order/add_view');
        $this->template->render();
	}
	
    public function edit()
    {	
        $id				= $this->input->segment('edit');
        $data['row']	= $this->mod->getOneData("id='$id'");
		$ship           = D("express", "");
		$data["shipping"] = $ship->getShipping($data['row']->expressName);
		$data['row']->ctime = date("Y-m-d H:i:s", $data['row']->ctime);
		//$data['row']->shipping_status = $this->shipStatus($data['row']->shipping_status);
		$data['button'] = $this->getButton($data['row']->status);
		$data['row']->status    = $this->status($data['row']->status);
		$data['goods']  = M("order_goods")->where(array('orderId'=>$id))->execute();
        $this->template->content = new View('admin/order/add_view',$data);
        $this->template->render();
    }
	private function shipStatus($status){
        $statue = array ("未发货", "已发货", "已签收");
		if (sizeof($statue) >= $status){
		   return $statue[$status];
		}else{
           return;
		}
	}
	private function status($status){
        $statue = array("未支付", "未发货","已发货", "退货", "完成");
		return $statue[$status];
	}
	private function getButton($status){
        switch ($status){
			case 1:
				$button  = "<button type='submit' name='op' value='send'>发货</button>";
				$button .= "<button type='submit' name='op' value='finish'>完成</button>";
				return $button;
				// 未发货状态，允许发货处理
				break;
			case 2:
				$button  = "<button type='submit' name='op' value='return'>退货</button>";
				$button .= "<button type='submit' name='op' value='finish'>完成</button>";
				return $button;
			    // 发货状态
				break;
			case 3:
			    $button = "<button type='submit' name='op' value='finish'>完成</button>";
				return $button;
				// 退货状态
				break;
			case 4:
			    $button  = "<button type='submit' name='op' value='send'>发货</button>";
			    $button .= "<button type='submit' name='op' value='return'>退货</button>";
				$button .= "<button type='submit' name='op' value='finish'>更新</button>";
				return $button;
				// 完成状态
				break;
            default:
				$button  = "<button type='submit' name='op' value='pay'>未发货</button>";
				return $button;
				// 未支付状态，不允许任何操作
			    break;
		}
	}
	private function get($array = array())
	{
		    $rs2		    = array();
			$wh             = array();
			foreach ($array as $key=>$val){
                if (isset($val) && $val != -1 && $val != ""){
                    $wh[$key] = $val;
				}
			}
			unset($wh['page']);
            $total		    = $this->mod->getAllCount($wh);
            $page		    = $this->input->get('page') ? $this->input->get('page') : 1;
            $size		    = 10;
			$rs2["page"]    = ceil( $total / $size);
			
		    $rs2["nowpage"] = $page;
            $start		= ($page-1)*$size;
            $rs			= $this->mod->where($wh)->limit($start,$size)->execute();
           
            foreach ($rs as $row)
            {
                $row->field		= '';
				$row->ctime  = date("Y-m-d H:i:s", $row->ctime);
                $rs2['orders'][]				= $row;
            }
            return $rs2;   
			
        		
	}
	private function getSelect($oid){
		$rs2        = array();
        if (sizeof($oid) > 0 && is_array($oid)){
			$oid    =  implode(",", $oid);
            $rs     =  $this->mod->where("id in (".$oid.")")->execute();
			$good   =  M('order_goods');
			foreach ($rs as $value){
			   $value->goods = $good->where("orderId = $value->id ")->execute();
               $rs2[] = $value;
			}
		}
		return $rs2;
	}
   
  
    // 订单详情
    public function detail(){
        $id = G('id');
        $sql = "SELECT oi.*,oe.name,oe.code,oe.addtime send_time
                FROM tf_order_info oi LEFT JOIN tf_order_express oe ON oe.order_id=oi.id
                WHERE oi.id='$id' AND oi.account_id=".$this->account_id." limit 1";
        $arr = M()->query($sql);
        $data['orderInfo'] = $arr[0]; 
        $data['orderStatus'] = comm_ext::getOrderStatus($data['orderInfo']->status); 
        if(!empty($data['orderInfo']->id)){
            $data['arrList'] = M('order_goods')->select()->where("order_id=".$data['orderInfo']->id)->execute();
        }
        if(!empty($data['orderInfo']->member_id)){
            $id = $data['orderInfo']->member_id;    
            $member_info = M('member')->getOneData("id=$id","id,realName,mobile");
            $data['member_info'] = $member_info;
            $log_info = M('log_commission')->select()->where("resource_member_id=$id")->execute();
            $data['log_info'] = $log_info;
        }

        $this->template->content = new View('admin/order/detail_view', $data);
        $this->template->render();  
    }
    // 获取订单信息
    public function get_info(){
        $id = P('id');
        $re_msg['success'] = 0;
        $re_msg['msg'] = "获取失败";
        $result = M('order_info')->getOneData("id=$id","address,note");
        if($result){
            $re_msg['success'] = 1;
            $re_msg['msg'] = "获取成功";
            $re_msg['info'] = $result;
        }
        echo json_encode($re_msg);
    }
    // 添加备注
    public function save_new_note(){
        $id = P('id');
        $data['note'] = P('note');

        $re_msg['success'] = 0;
        $re_msg['msg'] = "添加失败";
        if(!empty($data['note'])){
            $rs = M('order_info')->update($data,"id=$id and account_id=".$this->account_id);
            if($rs){
                $re_msg['success'] = 1;
                $re_msg['msg'] = "添加成功";
            }
        }
        echo json_encode($re_msg);
    }
    // 保存新地址
    public function save_new_address(){
        $id = P('id');
        $data['address'] = P('address');

        $re_msg['success'] = 0;
        $re_msg['msg'] = "更新失败";

        if(!empty($data['address'])){
            $rs = M('order_info')->update($data,"id=$id and account_id=".$this->account_id);
            if($rs){
                $re_msg['success'] = 1;
                $re_msg['msg'] = "更新成功";
            }
        }
        echo json_encode($re_msg);
    }
    // 保存物流信息
    public function saveExpress(){
        $id = P("id");
        $data['name'] = P("name");
        $data['code'] = P("code");
        
        $re_msg['success'] = 0;
        $re_msg['msg'] = "操作失败";

        $have = M('order_express')->getOneData("order_id=".$id);
        if(empty($have)){
            $result = M('order_info')->getOneData("id=$id and account_id=".$this->account_id,"order_sn");
            if(!empty($result)){
                $data['order_id'] = $id;
                $data['order_sn'] = $result->order_sn;
                $data['addtime'] = time();
                $rs = M('order_express')->insert($data);               
            }
        }else{
            $rs = M('order_express')->update($data,"order_id=".$id);
        }
        if($rs){
            $order['status'] = 2;
            M('order_info')->update($order,"id=".$id." and account_id=".$this->account_id);
            $re_msg['success'] = 1;
            $re_msg['msg'] = "操作成功";
        }

        echo json_encode($re_msg);
    }
    // 订单关闭
    public function close_order(){
        $id = P('id','');
        $re_msg['success'] = 0;
        $re_msg['msg'] = "关闭失败";
        if($id != ''){
            $data['status'] = '99';
            $rs = M('order_info')->update($data,"id=$id and account_id=".$this->account_id);
            if($rs){
                $re_msg['success'] = 1;
                $re_msg['msg'] = "关闭成功";
            }
        }
        echo json_encode($re_msg);
    }
    // 删除订单
    public function deletes(){
        $id = P('id','');
        $re_msg['success'] = 0;
        $re_msg['msg'] = "删除失败";
        if($id != ''){
            $data['status'] = '-99';
            $rs = M('order_info')->update($data,"id=$id and account_id=".$this->account_id);
            if($rs){
                $re_msg['success'] = 1;
                $re_msg['msg'] = "删除成功";
            }
        }
        echo json_encode($re_msg);
    }
    // 确认收货
    public function make_sure(){
        $id = P('id');
        $re_msg['success'] = 0;
        $re_msg['msg'] = "确认失败";
        if($id>0){
            $data['status']     = '4';
            $data['sendtime']   = time();
            $rs = M('order_info')->update($data,"id=$id and account_id=".$this->account_id);
            if($rs){
                $re_msg['success'] = 1;
                $re_msg['msg'] = "确认成功";
            }
        }
        echo json_encode($re_msg);
    }
    // 确认付款
    public function pay_order(){
        $id = P('id');
        $re_msg['success'] = 0;
        $re_msg['msg'] = "付款失败";
        if($id>0){
            $data['status']     = '1';
            $data['paystatus']  = 1;
            $data['paytime']   = time();
            $rs = M('order_info')->update($data,"id=$id and account_id=".$this->account_id);
            if($rs){
                $re_msg['success'] = 1;
                $re_msg['msg'] = "付款成功";
            }
        }
        echo json_encode($re_msg);
    }

    // 删除日志信息
    public function get_log_info(){
        $order_sn   = G('order_sn','');
        $startTime  = G('startTime','');
        $endTime    = G('endTime','');
        $where = "account_id=".$this->account_id;
        if($order_sn != ''){
            $where .= " and order_sn=$order_sn";
        }
        if($startTime != ''){
            if($endTime != ''){
                $where .= " and addtime>=unix_timestamp('$startTime') and addtime<=unix_timestamp('$endTime')";
            }else{
                $where .= " and addtime>=unix_timestamp('$startTime')";
            }
        }

        $page_size = 20;
        $total     = $this->mod->getAllCount($where);
        $data['pagination'] = pagination::getClass(array(
            'total'         => $total,
            'perPage'       => $page_size,
         //   'style'       =>  'pagmall',
            'segment'       => 'page',
        ));
        $start  = ($data['pagination']->currentPage-1)*$page_size;        
        $data['log'] = M('log_order')->select()->where($where)->limit($start,$page_size)->execute();
        
        $this->template->content   = new View('admin/order/log_view', $data);
        $this->template->render();
    }
    // 恢复日志
    public function recover(){
        $id   = P('id','');
        $re_msg['success'] = 0;
        $re_msg['msg'] = "修改失败";
        if($id>0){
            $data['status']     = '1';           
            $rs = M('log_order')->update($data,"id=$id and account_id=".$this->account_id);
            if($rs){
                $re_msg['success'] = 1;
                $re_msg['msg'] = "修改成功";
            }
        }
        echo json_encode($re_msg);
    }
}
   
?>