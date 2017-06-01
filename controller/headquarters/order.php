<?php defined('KING_PATH') or die('访问被拒绝.');
	class Order_Controller extends Template_Controller
	{
		private $mod;
		public function __construct()
		{
			parent::__construct();
			hcomm_ext::validUser();
			$this->mod	= M('order_info',"");
		}
		
		public function index()
		{
            list($tab_class) = $this->input->getArgs();
            if($tab_class == 0 || !isset($tab_class)) {
                $wh = '1=1';
            }
            if($tab_class == 100){
                $wh = 'orderStatus = 0';
            }
            if($tab_class == 1){
                $wh = 'orderStatus = 1';
            }
            if($tab_class == 2){
                $wh = 'orderStatus = 2';
            }
            if($tab_class == 4){
                $wh = 'orderStatus = 4';
            }
            if($tab_class == 99){
                $wh = 'orderStatus = 99';
            }
            $searchName = G('searchName');
            $startTime = G('startTime');
            $endTime = G('endTime');
            $data['searchName'] = $searchName;
            $data['startTime'] = $startTime;
            $data['endTime'] = $endTime;
            if(isset($searchName)){
                $wh .= ' and (mobile like "%'.$searchName.'%" or address like "%'.$searchName.'%" or consignee like "%'.$searchName.'%" or sn like "%'.$searchName.'%")';
               // $wh .= ' and consignee like "%'.$searchName.'%"';
            }
            if($startTime != ''){
                if($endTime != ''){
                    $wh .= ' and (ctime between '.strtotime($startTime).' and '.strtotime($endTime).')';
                }else{
                    $wh .= ' and (ctime >= '.strtotime($startTime).')';
                }
            }

            //echo $wh;

            $page_size = 10;
            $total		    = $this->mod->getAllCount($wh);
           // echo $wh;
            //根据订单状态做统计
            $all_total = $this->mod->getAllCount();
            $all_noPay = $this->mod->getAllCount(array('orderStatus'=>0));
            $all_Pay = $this->mod->getAllCount(array('orderStatus'=>1));
            $all_send = $this->mod->getAllCount(array('orderStatus'=>2));
            $all_ok = $this->mod->getAllCount(array('orderStatus'=>4));
            $all_close = $this->mod->getAllCount(array('orderStatus'=>99));
            $data['all_total'] = $all_total;
            $data['all_noPay'] = $all_noPay;
            $data['all_Pay'] = $all_Pay;
            $data['all_send'] = $all_send;
            $data['all_ok'] = $all_ok;
            $data['all_close'] = $all_close;

			$data['pagination'] = pagination::getClass(array(
				'total'		=> $total,
				'perPage'		=> $page_size,
             //   'style'         =>  'pagmall',
                'segment'		=> 'page',
			));
			$start		= ($data['pagination']->currentPage-1)*$page_size;
            $rs			= $this->mod->where($wh)->orderby('id desc')->limit($start,$page_size)->execute();
            $order_result = array();
            foreach ($rs as $row)
            {
                /*
                $row->field		= '';
                $row->add_time  = date("Y-m-d H:i:s", $row->add_time);*/
                //查询订单下的第一个物品，作为展示用
                $order_goods = M('order_goods')->getOneData(array('orderId'=>$row->id));
                $goods_info = M('item')->getOneData(array('id'=>$order_goods->itemId));
                $order_result[] = array(
                    'order_id'  =>  $row->id,
                    'order_sn'  =>  $row->sn,
                    'order_status'  =>  $row->orderStatus,
                    'user_id'   =>  $row->uid,
                    'pay_status'    =>  $row->payStatus,
                    'goods_total'   =>  $row->amount,
                    'shipping_total'    =>  $row->freight,//运费
                    'consignee'     =>  $row->consignee,//收货人
                    'user_note' =>  $row->note,//留言
                    'consignee_tel' =>  $row->mobile,
                    'add_time'  =>  $row->ctime,
                    //物品信息
                    'goods_id'  =>  $goods_info->id,
                    'goods_title'   =>  $goods_info->title,
                    'pics'  =>  output_ext::getCoverImg($goods_info->pics,'88x88'),
                    'goods_count'   =>  $order_goods->num
                );
            }
			$data['orders'] = $order_result;
            $data['tab_class'] = $tab_class;
            $this->template->content	= new View('admin/order/index_view', $data);
            $this->template->render();
		}

        //ajax get order info
        public function ajaxGetInfo(){
            $id = $this->input->post('id');
           // echo json_encode($id);exit;
            $detailed = $this->mod->getOneData(array('id'=>$id));
            if(count($detailed) < 0){echo json_encode(array('status'=>false,'msg'=>'订单不存在'));exit;}
            //查询订单物品详情
            $order_goods = M('order_goods')->where(array('orderId'=>$detailed->id))->execute();
            if(!isset($order_goods)){echo json_encode(array('status'=>false,'msg'=>'订单不存在'));exit;}
            //$data['order'] = (array)$detailed;
            $data['order'] = array(
                'order_id'  =>  $detailed->id,
                'order_sn'  =>  $detailed->sn,
                'order_status'  =>  comm_ext::getOrderStatus($detailed->orderStatus),
                'shipping_name' =>  $detailed->expressName,
                'consignee' =>  $detailed->consignee,
                'consignee_book'    =>  $detailed->address,
                'consignee_tel' =>  $detailed->mobile,
                'user_note' =>  $detailed->note,
                'goods_total'   =>  $detailed->amount,
                'shipping_total'    =>  $detailed->freight,
                'expressId'   =>  $detailed->expressId,
                'add_time'  =>  $detailed->ctime,
            );
            foreach($order_goods as $og){
                //查询物品信息
                $goods_info = M('item')->getOneData(array('id'=>$og->itemId));
                if(!isset($goods_info)){continue;};
                $data['goods'][] = array(
                    'id'    =>  $goods_info->id,
                    'title' =>  $goods_info->title,
                    'img'   =>  $this->input->site().output_ext::getCoverImg($goods_info->pics,'88x88'),
                    'count' =>  $og->num,
                    'price' =>  $goods_info->price,
                    'total_price'   =>  $og->itemPrice*$og->num,
                 //   'goods_discount'    =>  $og->goods_discount,
                    'goods_attr_id' =>  $og->goods_attr_id,
                    'goods_sn'  =>  $og->goods_sn,
                );
            }
            echo json_encode(array('status'=>true,'msg'=>$data));
        }

        /*
         * 修改未支付的订单信息，主要是金额修改
         */
        public function updateOrderMoney(){
            $id = $this->input->post('id');
            if($id <= 0){echo json_encode(array('status'=>false,'msg'=>'信息错误'));exit;}
            $order_info = M('order_info')->getOneData(array('id'=>$id));
            if(count($order_info) <= 0){echo json_encode(array('status'=>false,'msg'=>'订单不存在'));exit;}
            $data = array(
                'order_sn'  =>  $order_info->sn,
                'goods_total'   =>  $order_info->amount,
                'address'    =>  $order_info->address,
                'shipping_total'    =>  $order_info->freight,
                'order_id'  =>  $order_info->id,
            );
            echo json_encode(array('status'=>true,'msg'=>$data));exit;
        }
        //修改订单金额
        public function editOrderMoney(){
            $id = $this->input->post('update_order_id');
            $freight = $this->input->post('freight'); //是否包邮
            $update_order_address = $this->input->post('update_order_address'); //修改地址
            $freight_input = $this->input->post('freight_input'); //修改邮费
            $update_order_price = $this->input->post('update_order_price'); //修改订单价格
            //验证订单
            $check_order = M('order_info')->getOneData(array('id'=>$id,'orderStatus'=>0));
            if(count($check_order) <= 0){echo json_encode(array('status'=>false,'msg'=>'订单不存在'));exit;}
            $update_data['address'] = $update_order_address;
            $update_data['amount'] = $update_order_price;
            $rs = M('order_info')->update($update_data,array('id'=>$id));
            if($rs) {
                echo json_encode(array('status' => true, 'msg' => '修改成功'));
            }else{
                echo json_encode(array('status' => false, 'msg' => '修改失败'));
            }
        }
		//发货
        public function send(){
            $id = $this->input->post('id');
            //验证订单
            $check_order = M('order_info')->getOneData(array('id'=>$id,'orderStatus'=>1));
            if(count($check_order) <= 0){echo json_encode(array('status'=>false,'msg'=>'订单不存在'));exit;}
            //查询物流公司
            $shipping = M('express')->where(array('enabled'=>1))->execute();
            $data['orderNumber'] = $check_order->sn;
            $data['orderAddress'] = $check_order->address;
            foreach($shipping as $sh){
                $data['shipping'][] = array('id'=>$sh->id,'name'=>$sh->brief);
            }
            //返回订单
            echo json_encode(array('status'=>true,'msg'=>$data));
            /*
            $shipping_name = $this->input->post('shipping_name');
            $shipping_id = $this->input->post('shipping_id');
            $update_data['shipping_name'] = $shipping_name;
            $update_data['shipping_id'] = $shipping_id;
            $update_data['shipping_status'] = 1;
            $update_data['shipping_time'] = date('Y-m-d H:i:s');
            $rs = M('order_info')->update($update_data,array('order_id'=>$id));
            if($rs) {
                echo json_encode(array('status' => true, 'msg' => '发货成功'));
            }else{
                echo json_encode(array('status' => false, 'msg' => '发货失败'));
            }*/
        }
        /*
         * 保存发货
         */
        public function saveSend(){
            $shipping_order_sn_hidden = P('shipping_order_sn_hidden');
            $shipping_id = P('shipping_id');
            $shipping_number = P('shipping_number');
            //验证订单
            $check_order = M('order_info')->getOneData(array('sn'=>$shipping_order_sn_hidden,'orderStatus'=>1));
            if(count($check_order) <= 0){echo json_encode(array('status'=>false,'msg'=>'订单不存在'));exit;}
            $shipping = M('express')->getOneData(array('id'=>$shipping_id));
            if(count($shipping) <= 0){echo json_encode(array('status'=>false,'msg'=>'物流公司不存在'));exit;}

            $update_data['expressName'] = $shipping->brief;
            $update_data['expressId'] = $shipping_number;
            //$update_data['shipping_status'] = 1;
            $update_data['expressTime'] = date('Y-m-d H:i:s');
            $update_data['orderStatus'] = 2;
            $rs = M('order_info')->update($update_data,array('id'=>$check_order->id));
            if($rs) {
                echo json_encode(array('status' => true, 'msg' => '发货成功'));
            }else{
                echo json_encode(array('status' => false, 'msg' => '发货失败'));
            }
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
			$data['button'] = $this->getButton($data['row']->orderStatus);
			$data['row']->orderStatus    = $this->orderStatus($data['row']->orderStatus);
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
		private function orderStatus($status){
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
		public function otp(){
			$ids			= $this->input->post("checkboxes");
			$data           = $this->getSelect($ids);
	
            $this->template->content = new View('admin/order/otp', $data);
            $this->template->render();	
		}
        public function save()
        {
            $post			= $this->input->post();
            if ($post['field'])
            {
                $count		= $this->mod->getAllCount(array('field'=>$post['field']));
                if ($count >0)
                {
                    echo json_encode(array('msg'=>'该订单已存在','success'=>0));
                }
                else
                {
                    $insert		= array(
                    );
                    $return		= $this->mod->save($insert);
                    if ($return >0)
                    {
                        echo json_encode(array('msg'=>'','success'=>1));
                    }
                    else
                   	{
                        echo json_encode(array('msg'=>'保存订单失败','success'=>0));
                    }
                }
            }
            else
            {
                echo json_encode(array('msg'=>'参数错误','success'=>0));
            }
        }
        
        public function update()
        {
            $id		= $this->input->segment('update');
            if ($id>0)
            {
                $post			= $this->input->post();
				$upd	        = array();
				$time           = time();
				if (isset($post['op'])){
                   switch($post['op']){
                      case "pay":
						  $upd  = array(
                              "orderStatus"=>1,
                              "payStatus"=>1,
						      "payWay"=>"后台修改",
						      "payTime"=>$time,
						      "mtime"=>$time
						  );
					      $return = $this->mod->update($upd,array('id'=>$id));
						  break;
					  case "send":
						  // 发货,修改状态及配送
					      if (!empty($post["expressName"])){
							  $upd  = array(
								  "orderStatus"=>2,
								  "expressName"=>$post["shipping_name"],
								  "expressId"=>$post["shipping_id"],
								  "freight"=>$post["shipping_total"],
								  "expressTime"=>$time,
								  "mtime"=>$time
							  );
							  $return = $this->mod->update($upd,array('id'=>$id));
						  }
						  break;
					  case "return":
						  $upd  = array(
                              "orderStatus"=>3,
						      "mtime"=>$time
						  );
					      $return = $this->mod->update($upd,array('id'=>$id));
						  break;
					  case "finish":
						  if (!empty($post["expressName"])){
							  $upd  = array(
								  "orderStatus"=>4,
								  "expressName"=>$post["shipping_name"],
								  "expressId"=>$post["shipping_id"],
								  "freight"=>$post["shipping_total"],
								  "expressTime"=>$time,
								  "mtime"=>$time
							  );
							  $return = $this->mod->update($upd,array('id'=>$id));
					      }
						  break;
					  default:
						  break;
				   }
                   
				}
            }
			input::redirect('admin/order/edit/'.$id);
        }
        private function get_order_sn(){
		/**
		 * 得到新订单号
		 * @return  string
		 */
        /* 选择一个随机的方案 */
               mt_srand((double) microtime() * 1000000);
               return date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
		}
        public function delete()
        {
			$id		=$this->input->segment('delete');
			if ($id>0)
			{
				$result = $this->mod->delete(array('id'=>$id, 'orderStatus'=>0));
				if ($result){
                     M('order_goods')->delete(array('orderId'=>$id));
				}
			}
			input::redirect('admin/order/');
        }                  
	}
?>