<?php defined('KING_PATH') or die('访问被拒绝.');
      class Order_Controller extends Mobilebase_Controller
      {       
          public function __construct(){	
              parent::__construct();              
              $this->template->currentCount = 2;
          }
          // 订单详情
          public function detailOrder(){  
              $re_msg['success'] = 0;
              $re_msg['msg']     = '数据获取失败';

              $rs = M('cart')->where("member_id=".$this->member_id)->select()->execute();
              foreach ($rs as $key => $value) {
                  $total_price = $value->number * $value->item_price;
              }
              print_r($rs);

          }
          // 购物车页面
          public function show_cart(){
              $this->template->content = new View('mobile/cart/cart_view');
              $this->template->render();
          }
          // 生成订单
          public function mkOrder(){  
              $item_attr_id = P('item_attr_id',11810);
              $number       = P('number',0);
              $address_id   = P('address_id',0);

              $re_msg['success'] = 0;
              $re_msg['msg']     = '操作失败';
              $flag              = true;
              if(empty($item_attr_id)){
                  $re_msg['msg'] = '提交商品失败';
                  die(json_encode($re_msg['msg']));
              }
              if(empty($address_id)){
                  $re_msg['msg'] = '请选择地址';
                  die(json_encode($re_msg['msg']));
              }

              $item_rs = M('item i')->select('i.title,i.account_id,i.mainPic,i.limit_num,ia.attr_price,ia.attr_stock')->join('item_attr ia','i.id=ia.item_id')->where("ia.id=$item_attr_id and i.status=1")->execute();

              if(empty($item_rs)){
                  $re_msg['msg'] = '无此商品';
                  die(json_encode($re_msg['msg']));
              }

              echo str_ext::getOrdersn();
              $order['account_id']  = 
              $order['member_id']   =
              $order['order_sn']    = str_ext::getOrdersn();
              $order['number']      =
              $order['consignee']   =  
              $order['address']     =
              $order['mobile']      =    
              $order['amount']      =
              $order['receipt']     =
              $order['receipt_type']=     
              $order['addtime']     = time();


              exit;
              if(empty($num)){
                  die(json_encode(array('errorno'=>1,'msg'=>'商品数量错误！')));
              }
              $grouplist = array();
              if(!empty($item_content)){
                  $grouplist = json_decode($item_content,true);
              }
              $dinfo = array();
              $dinfo['pay_way'] = P('payway',1);
              $dinfo['consignee'] = P('vername','');
              $dinfo['mobile'] = P('vermobile','');
              $dinfo['prov_id'] = P('provid',0);
              $dinfo['city_id'] = P('cityid',0);
              $dinfo['address'] = P('veraddress','');

              //钱包余额抵扣
              $dinfo['pay_jifen'] = P('jifen',0);
              $dinfo['pay_yongjin'] = P('yongjin',0);
              $dinfo['pay_fenhong'] = P('fenhong',0);
              $dinfo['pay_gongxiang'] = P('gongxiang',0);
              $dinfo['coupon_ids'] = P('coupon','');  //优惠券抵扣
              $c_res = array();
              if(!empty($dinfo['coupon_ids'])){
                  $c_res = coupon_ext::coupon_paid($this->userid,$dinfo['coupon_ids']);
                  if($c_res['errorno']=='1') die(json_encode(array('errorno'=>1,'msg'=>'无效的抵用券！')));
              }
              $dinfo['pay_jifen'] = !empty($dinfo['pay_jifen'])?round($dinfo['pay_jifen'],2):0;
              $dinfo['pay_yongjin'] = !empty($dinfo['pay_yongjin'])?round($dinfo['pay_yongjin'],2):0;
              $dinfo['pay_fenhong'] = !empty($dinfo['pay_fenhong'])?round($dinfo['pay_fenhong'],2):0;
              $dinfo['pay_gongxiang'] = !empty($dinfo['pay_gongxiang'])?round($dinfo['pay_gongxiang'],2):0;

              $c_paid = !empty($c_res['data'])?$c_res['data']:0;  //券抵扣金额
              $dinfo['paid'] = $dinfo['pay_jifen']+$dinfo['pay_yongjin']+$dinfo['pay_fenhong']+$dinfo['pay_gongxiang']+$c_paid;

              if(empty($dinfo['pay_way'])) die(json_encode(array('errorno'=>1,'msg'=>'必须提交支付方式！')));
              if(empty($dinfo['consignee'])) die(json_encode(array('errorno'=>1,'msg'=>'必须填写收件人姓名！')));
              if(empty($dinfo['mobile'])) die(json_encode(array('errorno'=>1,'msg'=>'必须填写联系电话！')));

              if(empty($dinfo['prov_id'])) die(json_encode(array('errorno'=>1,'msg'=>'必须选择省份！')));
              if(empty($dinfo['city_id'])) die(json_encode(array('errorno'=>1,'msg'=>'必须选择城市！')));

              if(empty($dinfo['address'])) die(json_encode(array('errorno'=>1,'msg'=>'必须填写收件人地址！')));
              //hwz:判断钱包余额是否足够
              $ischk = member_ext::chk_money($this->userid,array('jifen'=>$dinfo['pay_jifen'],'yongjin'=>$dinfo['pay_yongjin'],'fenhong'=>$dinfo['pay_fenhong'],'gongxiang'=>$dinfo['pay_gongxiang']));
              if(!$ischk) die(json_encode(array('errorno'=>1,'msg'=>'您的钱包余额不足！')));

              $res = orders_ext::check_order($this->userid,$item_id,$attr_id,$num,$dinfo,$grouplist);
              if($res['status']=='0'){
                  //成功
                  orders_ext::reduce_stock($item_id,$attr_id,$num,$grouplist);    //扣除库存
                  $res_info = $res['info'];
                  die(json_encode(array('errorno'=>0,'msg'=>'success','data'=>$res_info)));
              }else{
                  if(!empty($res['msg'])){
                      die(json_encode(array('errorno'=>1,'msg'=>$res['msg'])));
                  }else{
                      die(json_encode(array('errorno'=>1,'msg'=>'false')));
                  }
              }
          }
          //更改购物车数量
          public function changeNum(){
              $re_msg['success'] = 0;
              $re_msg['msg'] = '更改失败';

              $item_attr_id = 11810;// P('item_attr_id',0);
              $number       = 2;// P('number',0);
              $rs = M('cart')->getOneData(array('member_id'=>$this->member_id,'item_attr_id'=>$item_attr_id),'id,number');
              if($rs){
                  $nowNumber = intval($rs->number+$number);
                  $itemRs = M('item i')->select('i.limit_num,ia.attr_stock')->join('item_attr ia','i.id=ia.item_id')->where(" ia.id=$item_attr_id and i.status=1")->execute();
                  $itemRs = $itemRs[0];
                  if($itemRs->attr_stock < $nowNumber){
                      $re_msg['msg'] = "购买总数量超过库存数量";
                  }else if($nowNumber > $itemRs->limit_num){
                      $re_msg['msg'] = "购买总数量超过限购数量";
                  }else{
                      $res = M('cart')->update(array('number'=>$nowNumber),"id = ".$rs->id);
                      if($res){
                          $re_msg['success'] = 1;
                          $re_msg['msg'] = "更改成功!";
                      }
                  }  
              }     
              print_r($re_msg);
              echo json_encode($re_msg);
          }

          //删除购物车单品
          public function deleteAttr(){
              $re_msg['success'] = 0;
              $re_msg['msg'] = '删除失败';

              $item_attr_id =  P('item_attr_id',0);

              $rs = M('cart')->delete("member_id = ".$this->member_id." and item_attr_id = ".$item_attr_id);
              if($rs){     
                  $re_msg['success'] = 1;
                  $re_msg['msg'] = '删除成功';
              }      
              echo json_encode($re_msg);
          }
      }
