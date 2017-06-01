<?php
class tuoke_ext
{
/*--------------------生成券-----------------------*/
	/**
	 * 判断是否买过
	 * member_id会员id   type券的类型
	 */
	public static function is_coupon($member_id='',$type=''){
		$re_msg['success'] = 0;
		$re_msg['msg'] = "已经买过!";
		$result = M('tk_coupon')->getOneData(array('member_id'=>$member_id, 'type'=>$type));
		if($result){
			$re_msg['msg'] = "您已经购买过了!";
		}else{
			$re_msg['success'] = 1;
			$re_msg['msg'] = "还没购买过!";				
		}
		return $re_msg;	
	}	
	/**
	 * 判断是否超限制购买
	 * member_id会员id   id商品id
	 * return 0不能再次购买 (1可以购买 number是还可以购买的数量)
	 */
	public static function is_limit($member_id='',$id=''){
		$number = 0;
		$result = M('tk_item')->getOneData(array('id'=>$id),"limit_num,stock");

		if($result->stock <= 0){
			return 0;
			exit;
		}
		$cache = cache::getClass();
        if($cache->hExists('limit:limit_'.$member_id,$id)){
          	$num = $cache->hGet('limit:limit_'.$member_id,$id);          
			if($num < $result->limit_num){
				$number = $result->limit_num - $num;
			}
			$number = $number>$result->stock ? $result->stock : $number;
        }else{        	
        	$number = $result->limit_num>$result->stock ? $result->stock : $result->limit_num;
        }		
        // file_put_contents('upload/pay/'.date('Y-m-d',time()).'.txt',date('H:i:s',time()).'=>'.$num.'::'.$member_id.'--'.$number."\t\n",FILE_APPEND);

		return $number;	
	}

	/**
	 * 生成订单
	 * @param object $item 商品商品信息
	 */
	public static function make_coupon($member_id='',$item='',$array){
		$data['item_id'] 	= $item->id;
		$data['pic'] 		= $item->img;
		$data['title'] 		= $item->title;
		$data['price'] 		= $array['number']*$item->price;
		$data['number']		= $array['number'];
		$data['pv']			= $array['number']*$item->pv;
		$data['realname'] 	= $array['realname'];
		$data['address'] 	= $array['address'];
		$data['mobile'] 	= $array['mobile'];

		$data['bus_num'] 	= $item->bus_num;
		$data['mem_num1'] 	= $item->mem_num1;
		$data['mem_num2'] 	= $item->mem_num2;
		$data['mem_num3'] 	= $item->mem_num3;
		// $data['business_id']= $item->business_id;
		$data['code'] 		= substr(time(),2,10).mt_rand(1000,9999);
		$data['addtime'] 	= time();
		$data['member_id'] 	= $member_id;
		$rs = M('tk_coupon')->save($data);	
		// 更新会员订单数量
		$result = M("member")->getOneData("id=$member_id","id,order_num");
		$m_data['order_num'] = $result->order_num+1;
		$m_rs = M("member")->update($m_data,"id=".$result->id);

		return $rs;	
	}	
/*------------------佣金结算-------------------------*/
	/**
	 * 记录佣金裂变 和 佣金结算
	 * @param string $member_id
	 */
	public static function log_commission($result=''){
		$re_msg['success'] = 0;
		$re_msg['msg'] = "记录失败!";

		$data['member_id'] = $result->member_id;
		$data['addtime'] = time();
		// 获取上级会员
		$arr = self::get_up_member($result->member_id);
		// file_put_contents('upload/pay/'.date('Y-m-d',time()).'.txt',date('H:i:s',time()).'=>'.json_encode($arr)."\t\n",FILE_APPEND);
		M('tk_message')->insert(array('coupon_id'=>$result->id,'member_id'=>$data['member_id'],'message'=>'付款了。','is_all'=>1,'addtime'=>time()));
		if($arr['success']==1){
			$three_m = $arr['info'];		//上级用户的id		
			$openid = $arr['openid'];		//上级用户的id		
			foreach ($three_m as $key => $value) {
				$re_price = 0;
				$data['to_member_id'] = $value;
				$price = $result->pv;		//订单pv值
				if($result->mem_type == 0){	
					if($key == 1){
						$re_price = $result->mem_num1;
					}elseif($key == 2){
						$re_price = $result->mem_num2;
					}elseif($key == 3){
						$re_price = $result->mem_num3;
					}		
				}else{
					if($key == 1 && $result->mem_num1>0){
						$re_price = $price*$result->mem_num1/100;
					}
					elseif($key == 2 && $result->mem_num2>0){
						$re_price = $price*$result->mem_num2/100;
					}
					elseif($key == 3 && $result->mem_num3>0){
						$re_price = $price*$result->mem_num3/100;
					}									
				}
				$data['price'] = $re_price;	
				$data['note'] = '佣金抽成';		
				$data['coupon_id'] = $result->id;

				if($re_price>0){
					// 发放红包 return array
					$data['content'] = "等待自动发红包";
					$rs = M('tk_log_commission')->save($data);	

					$m_data['coupon_id'] = $result->id;
					$m_data['member_id'] = $data['member_id'];
					$m_data['to_member_id'] = $data['to_member_id'];
					$m_data['message'] = '付款了，您获得佣金￥'.$re_price;
					$m_data['is_all'] = 0;
					$m_data['addtime'] = time();
					M('tk_message')->insert($m_data);
				}							
				// 上级会员结算
				$add_rs = self::add_commission($value,$re_price);
			}
			if($rs){
				$re_msg['success'] = 1;
				$re_msg['msg'] = "记录成功!";				
			}			
		}else{
			$re_msg['msg'] = $arr['msg'];				
		}
		return $re_msg;	
	}


	/**
	 * 结算佣金给上级会员
	 * @return array
	 */
	public static function add_commission($member_id='',$price=0){
		$re_msg['success'] = 0;
		$re_msg['msg'] = "结算失败!";
		
		$result = M('member')->getOneData("id=$member_id","asset,commission");
		if($result){
			$data['asset'] = $result->asset+$price;
			$data['commission'] = $result->commission+$price;
			$rs = M('member')->update($data,"id=$member_id");			
		}
		if($rs){
			$re_msg['success'] = 1;
			$re_msg['msg'] = "结算成功!";					
		}	
		return $re_msg;	
	}

	/**
	 * 获取会员三级用户id
	 * @return array
	 */
	public static function get_up_member($member_id=''){
		$re_msg['success'] = 0;
		$re_msg['msg'] = "获取上级会员失败!";
		
		$result = M('member')->getOneData("id=$member_id","id,pid,levelId,openId");

		if($result->pid > 0){
			// 第一级用户
			$rs = M('member')->getOneData("id=".$result->pid,"id,pid,levelId,openId");

			if($rs->levelId==1){
				$next_m['1'] = $result->pid;
				$openid[$result->pid] = $rs->openId;
			}
			if($rs->pid > 0){
				// 第二级用户
				$rs_n = M('member')->getOneData("id=".$rs->pid,"id,pid,levelId,openId");
				if($rs_n->levelId==1){
					$next_m['2'] = $rs->pid;
					$openid[$rs->pid] = $rs_n->openId;
				}	
				if($rs_n->pid > 0){
					// 第三极用户
					$rs_3 = M('member')->getOneData("id=".$rs_n->pid,"id,levelId,openId");
					if($rs_3->levelId==1){
						$next_m['3'] = $rs_n->pid;
						$openid[$rs_n->pid] = $rs_3->openId;
					}
				}		
			}
		}
		if(isset($next_m)){
			$re_msg['success'] = 1;
			$re_msg['msg'] = "获取上级会员成功!";
			$re_msg['info'] = $next_m;		
			$re_msg['openid'] = $openid;							
		}	
		return $re_msg;	
	}
/*---------------冻结资金-----------------*/

	/**
	 * 冻结资金
	 * $member_id 会员id $coupon_id 优惠券id $price 佣金金额
	 */
	public static function freeze($member_id='',$coupon_id='',$price=0,$day=0){
		$cache = cache::getClass();
		$rs['hSet'] = $cache->hSet('commission:m_'.$member_id,$coupon_id,$price);		
		$rs['setex'] = $cache->setex("freeze:".$coupon_id,$day*24*3600,$price);	
		return $rs;	
	}    
	/**
	 * 获取冻结资金金额
	 * 返回冻结金额
	 */
	public static function get_freeze_money($member_id=''){
		$cache = cache::getClass();
		self::unset_freeze($member_id);
		$arr_price = $cache->hVals('commission:m_'.$member_id);	
		$price = empty($arr_price) ? 0.00:array_sum($arr_price);
		return $price;	
	}  
	// 解除冻结资金
	public static function unset_freeze($member_id='',$coupon_id=''){
		$rs = 0;
		$cache = cache::getClass();
		if($coupon_id != ''){
			$rs = $cache->hDel('commission:m_'.$member_id, $coupon_id);
		}else{			
			$arr_key = $cache->hKeys('commission:m_'.$member_id);
			foreach ($arr_key as $key => $coupon_id) {
				if(!$cache->exists('freeze:'.$coupon_id)){
					$rs = $cache->hDel('commission:m_'.$member_id, $coupon_id);
				}
			}
		}
		return $rs;
	}
/*----------------------退款------------------------*/
	/*
	 * 佣金回滚
	 * $member_id 会员id  $coupon_id 订单id
	 */
	public static function return_commission($member_id='',$coupon_id=''){
		$re_msg['success'] = 0;
		$re_msg['msg'] = "佣金回滚失败!";

		$hql = "SELECT COUNT(*) num FROM tf_tk_log_commission lc WHERE lc.member_id=$member_id AND lc.coupon_id=$coupon_id GROUP BY lc.`type`";
		$hs = M()->query($hql);
		if(count($hs) == 1){			
			// 获取佣金记录结算退款时的佣金
			$rs = M('tk_log_commission')->select()->where("member_id=$member_id and coupon_id=$coupon_id and type=1")->execute();
			foreach ($rs as $key => $value) {
				$fs = self::unset_freeze($value->to_member_id,$coupon_id);
				$cs = self::add_commission($value->to_member_id,'-'.$value->price);	
				$re_data['member_id'] = $value->member_id;
				$re_data['addtime'] = time();
				$re_data['to_member_id'] = $value->to_member_id;
				$re_data['type'] = 0;
				$re_data['price'] = '-'.$value->price;	
				$re_data['note'] = '退款扣减佣金';		
				$re_data['coupon_id'] = $value->coupon_id;
				$re_rs = M('tk_log_commission')->save($re_data);		
			}
		}
		$order = M("tk_coupon")->getOneData("id=$coupon_id and member_id=$member_id","item_id,member_id,code,price,number");	
		if($order){	
		     // 升级会员
			self::get_member($order->member_id,'-'.$order->price);		
		     // 库存更新
			self::update_stock($order->item_id,'-'.$order->number);
			$re_msg['success'] = 1;
			$re_msg['msg'] = "佣金回滚成功!";
		}
		return $re_msg;	
	}

	/**
	 * 生成优惠券
	 * @param string $member_id
	 */
	public static function mk_coupon($member_id=''){
		$re_msg['success'] = 0;
		$re_msg['msg'] = "获取失败!";
		$result = M('tk_coupon')->getOneData(array('member_id'=>$member_id, 'is_give'=>0));
		if($result){
			$re_msg['msg'] = "已经获取过了,不能重复获取!";
		}else{
			$data['code'] = substr(time(),2,10).mt_rand(1000, 9999);
			$data['addtime'] = time();
			$data['member_id'] = $member_id;
			$rs = M('tk_coupon')->save($data);
			if($rs){
				$re_msg['success'] = 1;
				$re_msg['msg'] = "获取成功!";				
			}
		}
		return $re_msg;	
	}	
	/*
	 * 赠送优惠券
	 */
	public static function give_coupon($member_id='',$to_member_id=''){
		$re_msg['success'] = 0;
		$re_msg['msg'] = "赠送失败!";
		$result = M('tk_coupon')->getOneData(array('member_id'=>$member_id, 'is_use'=>0,'is_give'=>0));
		if($result){
			$data['to_member_id'] = $to_member_id;
			$data['is_give'] = 1;
			$data['givetime'] = time();
			$rs = M('tk_coupon')->update($data,"member_id=$member_id and is_give=0");
		}
		if($rs){
			$re_msg['success'] = 1;
			$re_msg['msg'] = "赠送成功!";				
		}
		return $re_msg;	
	}
	/*
	 * 使用优惠券 和 记录佣金裂变详情
	 */
	public static function use_coupon($code='',$tkb_id='',$type=''){
		$re_msg['success'] = 0;
		$re_msg['msg'] = "该券券码为无效码!";

		$result = M('tk_coupon')->getOneData("code='$code' and is_use=0 and paystatus=1");
		if($result){
			if($result->endtime<time()){
				$re_msg['msg'] = "该券券码已经过期!";
				return $re_msg;
			}
			$shop_rs = M("tk_item")->getOneData("id=".$result->item_id);
			$shop_arr = explode(',',$shop_rs->business_id);
			if(in_array($tkb_id, $shop_arr)){
				$data['tkb_id'] = $tkb_id;
				$data['is_use'] = 1;
				$data['usetime'] = time();
				$rs = M('tk_coupon')->update($data,"id=".$result->id);
				if($rs){	
					// 更新商家销售量和消费总金额
					$b_rs = M("tk_business")->getOneData("id=$tkb_id","name,sell_num,amount,openId");
					if($result->bus_type == 0){
						$amount = $result->bus_num;
					}else{
						$amount = ($result->price*$result->bus_num)/100;
					}
					$b_data['sell_num'] = $b_rs->sell_num+1;
					$b_data['amount'] = $b_rs->amount+$amount;
					M("tk_business")->update($b_data,"id=$tkb_id");

					// 给商户发放现金 return array
					// $send = str_ext::wxWithdrawCash($result->code,$b_rs->openId,$amount*100);
					// if(!empty($send)){
					// 	$log['status'] = $send['result_code'] == 'FAIL'?0:1;
					// 	$log['note'] = is_array($send['return_msg'])?'':$send['return_msg'];
					// 	if($send['result_code'] == 'SUCCESS' && empty($log['note'])){
					// 		$log['note'] = "发放成功";
					// 	}
					// }	

					// 记录消费商家日志
					$log['tkb_name']	= $b_rs->name;
					$log['coupon_id']	= $result->id;	
					$log['order_sn']	= $result->code;
					$log['price']		= $result->price;
					$log['get_price'] 	= $amount;
					$log['tkb_id']	  	= $tkb_id;
					$log['member_id']	= $result->member_id;
					$log['addtime']   	= time();
					$log['note']		= "等待自动发红包";
					$log_rs = M('tk_log_consume')->save($log);
					file_put_contents('upload/return/'.date('Y-m-d',time()).'.txt',date('H:i:s',time()).':红包日志>'.$log_rs.'==>'.json_encode($log)."\t\n",FILE_APPEND);

					$cache = cache::getClass();
					$cache->hSet('lastUse:shop_'.$tkb_id,$result->member_id,time());		

					$re_msg['success'] = 1;
					$re_msg['msg'] = "扫描成功，该订单在本店完成消费。";
				}				
			}else{
				$re_msg['msg'] = "该订单不能在该店消费。";
			}
		}
		
		return $re_msg;	
	}

	/*
	 * 优惠券订单付款确认
	 * 回调 $code 优惠券编码==订单号  $paytype支付类型 $serial_number 支付流水号
	 */
	public static function pay_coupon($code='',$paytype=1,$serial_number=''){
		$re_msg['success'] = 0;
		$re_msg['msg'] = "确认付款失败!";

		$result = M('tk_coupon')->getOneData("code=$code");	
		if($result){	
			if($result->paystatus == 0){				
				$data['paytype'] = $paytype;
				$data['serial_number'] = $serial_number;
				$data['paystatus'] = 1;
				
				$data['paytime'] = time();			
				$rs = M('tk_coupon')->update($data,"id=".$result->id);			
				if($rs){
					$cache = cache::getClass();
					if($cache->hExists('limit:limit_'.$result->member_id,$result->item_id)){
						$num = $cache->hGet('limit:limit_'.$result->member_id,$result->item_id);
						$sum = $num + $result->number;
						$cache->hSet('limit:limit_'.$result->member_id,$result->item_id,$sum);	
					}else{
						$cache->hSet('limit:limit_'.$result->member_id,$result->item_id,$result->number);		
					}				

					// 佣金结算
					self::log_commission($result);	
					// 升级会员
					self::update_goods_num($result->member_id,$result->number,$result->price);
					// 库存更新
					$stock_rs = self::update_stock($result->item_id,$result->number);
					$re_msg['success'] = 1;
					$re_msg['msg'] = "确认付款成功!";				
				}
			}
		}
		return $re_msg;	
	}	

	// 库存更新
	public static function update_stock($item_id,$number){
		$result = M("tk_item")->getOneData("id=$item_id","stock,sell_num");
		if($number>0){
			$data['sell_num'] = $result->sell_num + 1;
		}else{
			$data['sell_num'] = $result->sell_num - 1;
		}		
		$data['stock'] = $result->stock - $number;
		$rs = M("tk_item")->update($data,"id=$item_id");
		return $rs;
	}
	// 拓客购买活动会员资格更新消费金额
	public static function get_member($member_id=0,$price=0){
		$rs = 0;
		$result = M("member")->getOneData("id=$member_id","id,amount");
		if($result){
			$sum = $result->amount+$price;
			$data['levelId'] = 1;
			$data['amount'] = $sum;
			$rs = M("member")->update($data,"id=".$result->id);
		}		
		return $rs;
	}
	// 更新上级会员的团队购买数量
	public static function update_goods_num($member_id=0,$number=0,$price=0){

		$result = M("member")->getOneData("id=$member_id","id,levelId,order_num,amount,goods_num,userpath");
		if($result){
			$mydata['goods_num'] = $result->goods_num+$number;			
			if($result->levelId==0){
				$mydata['levelId'] = self::get_level($member_id);
			}else{
				$shareId = self::get_share($mydata['goods_num']);			
				if($result->shareId < $shareId){	
					$data['shareId'] = $shareId;				
				}				
			}
			$mydata['amount'] = $result->amount+$price;
			M("member")->update($mydata,"id=".$result->id);

			if(!empty($result->userpath)){				
				$path = explode('-', $result->userpath);
				$str = implode(',', $path);
				$rs = M("member")->select("id,goods_num")->where("id in ($str)")->execute();
				if($rs){				
					foreach ($rs as $key => $value) {
						unset($data['shareId']);
						$data['goods_num'] = $value->goods_num+$number;
						$shareId = self::get_share($data->goods_num);
						if($result->shareId < $shareId){	
							$data['shareId'] = $shareId;				
						}
						M("member")->update($data,"id=".$value->id);
					}
				}
			}
			// 计算团队完成情况
			dividend_ext::putOrder($member_id,$number,$result->userpath);
		}		
		
	}
	// 判断是否能成为代理商
	public static function get_level($member_id){
		$dailiLevel = extconfig_ext::getSiteMore('dailiLevel');
        $rs = M("tk_coupon")->select("SUM(number) AS number")->where("member_id=".$member_id)->execute();
        $levelId = 0;
        if($rs[0]->number >= $dailiLevel){
			$levelId = 1;
		}
		return $levelId;
	}
	// 判断等级
	public static function get_share($number=0){
        $array = extconfig_ext::getSiteMore();
        $shareId = 0;
        if($number>$array['provLevel']){
			$shareId = 3;
		}else if($number>$array['cityLevel']){
			$shareId = 2;
		}else if($number>$array['distrLevel']){
			$shareId = 1;
		}
		return $shareId;
	}
	/*
	 * 优惠券申请退款
	 * $member_id 会员id  $code 优惠券编码
	 */
	public static function return_coupon($member_id='',$code=''){
		$re_msg['success'] = 0;
		$re_msg['msg'] = "申请退款失败!";

		$result = M('tk_coupon')->getOneData(array('member_id'=>$member_id,'code'=>$code, 'is_use'=>0));
		if($result){
			$data['is_use'] = -1;
			$data['returntime'] = time();			
			$rs = M('tk_coupon')->update($data,"id=".$result->id);			
			if($rs){		
				// 更新商铺信息
				self::update_shop($result->tkb_id,$result->price);
				$re_msg['success'] = 1;
				$re_msg['msg'] = "申请退款成功!";				
			}
		}	
		return $re_msg;	
	}
	
	/*
	 * 更新商店的数据
	 * $tkb_id  商家id
	 */
	public static function update_shop($tkb_id=0,$price=0){
		$rs = 0;
		$result = M("tk_business")->getOneData("id=".$tkb_id);
		if($result){
			$data['sell_num'] = $result->sell_num+1;
			$data['amount'] = $result->amount+$price;
			$rs = M("tk_business")->update($data,"id=".$tkb_id);
		}
		return $rs;
	}
	/*
	 * 优惠券确认退款
	 * 回调 $code 优惠券编码 $member_id 会员id $coupon_id 订单id
	 */
	// public static function return_complete($code='',$member_id='',$coupon_id=''){
	// 	$re_msg['success'] = 0;
	// 	$re_msg['msg'] = "确认退款失败!";

	// 	$data['is_use'] = -2;
	// 	$data['overtime'] = time();			
	// 	$rs = M('tk_coupon')->update($data,"code=$code and is_use='-1'");			
	// 	if($rs){			
	// 		// 佣金回滚
	// 		self::return_commission($member_id,$coupon_id);			

	// 		$re_msg['success'] = 1;	
	// 		$re_msg['msg'] = "操作成功!";
	// 	}
				
	// 	return $re_msg;	
	// }

	// 统计当店会员消费情况
	public static function get_ms_info($member_id='',$tkb_id=''){
		$result = 0;
		$hql = "SELECT code,price,bus_type,bus_num FROM tf_tk_coupon WHERE tkb_id=$tkb_id AND member_id=$member_id";
        $result = M()->query($hql);

        $amount = 0;
        $sum = 0;
        foreach ($result as $key => $value) {        	
        	$sum = $sum + $value->price;
        	if($value->bus_type == 0){
        		$amount += $value->bus_num;
        	}else{
        		$amount += $value->price*$value->bus_num/100;
        	}        	
        }
        $data['sum'] = $sum;
        $data['amount'] = $amount;
        $data['total'] = count($result);
        return $data;
	}

	// 获取用户最后使用时间
	public static function lasttime($tkb_id='',$member_id=''){
		$cache = cache::getClass();
		$lasttime = $cache->hGet('lastUse:shop_'.$tkb_id,$member_id);
		return $lasttime;
	}
}