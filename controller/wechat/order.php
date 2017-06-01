<?php defined('KING_PATH') or die('访问被拒绝.');
      class Order_Controller extends Wechatbase_Controller
      {       
          public function __construct()
          {	
              parent::__construct();
          }

          /**
           * 订单列表
           */
          public function index()
          {
              $wh['member_id'] = $this->user->id;
              $wh['isDel'] = 0;
              $data['allList'] = M('tk_coupon')->where($wh)->orderby(array('id'=>'desc'))->limit(0,10)->execute();
              $data['all'] = M('tk_coupon')->getAllCount($wh);

              $wh['paystatus'] = 0;
              $data['payList'] = M('tk_coupon')->where($wh)->orderby(array('id'=>'desc'))->limit(0,10)->execute();
              $data['pay'] = M('tk_coupon')->getAllCount($wh);
    
              $wh['paystatus'] = 1;
              $wh['is_use <='] = 1;
              $data['useList'] = M('tk_coupon')->where($wh)->orderby(array('id'=>'desc'))->limit(0,10)->execute();
              $data['use'] = M('tk_coupon')->getAllCount($wh);
              unset($wh['is_use <=']);
              $wh['paystatus'] = 1;
              $wh['is_use'] = 2;
              $data['overList'] = M('tk_coupon')->where($wh)->orderby(array('id'=>'desc'))->limit(0,10)->execute();
              $data['over'] = M('tk_coupon')->getAllCount($wh);

              $cache = cache::getClass();
              $data['tel'] = $cache->hGet("config","客服电话");

              $this->template->content = new View('wechat/order/index_view',$data);
              $this->template->render();
          }
          // 确认收货
          public function make_sure(){
              $id = P('id');
              $re_msg['success'] = 0;
              $re_msg['msg'] = '确认失败';

              $data['is_use'] = 2;
              $data['usetime'] = time();
              $rs = M("tk_coupon")->update($data,"id=$id and paystatus=1 and member_id=".$this->user->id);
              if($rs){
                $re_msg['success'] = 1;
                $re_msg['msg'] = '确认成功';
              }
              echo json_encode($re_msg);
          }
          /*
           * 获取更多订单列表
           */
          public function get_more_list(){
              $page = P('page');       
              $str = P('str','');    

              $wh['member_id'] = $this->user->id;
              $wh['isDel'] = 0;

              if($str == 'pay'){
                $wh['paystatus'] = 0;
              }else if($str == 'use'){
                $wh['paystatus'] = 1;
                $wh['is_use <='] = 1;
              }else if($str == 'over'){
                $wh['paystatus'] = 1;
                $wh['is_use'] = 2;
              }

              $cache = cache::getClass();
              $tel = $cache->hGet("config","客服电话");

              $number = $page*10;
              $str = '';
              $result = M('tk_coupon')->where($wh)->orderby(array('id'=>'desc'))->limit(10,10)->execute();

              if(!empty($result)){
                foreach ($result as $key => $value) {                  

                  $str_ext = '';
                  $status = "交易关闭";

                  if($value->paystatus ==0){                    
                    $str_ext .= ' <a href="javascript:tkCancel('.$value->id.')">取消订单</a>    ';
                    $str_ext .= '               <a onclick="pay('.$value->id.');">立即支付</a>   ';
                    $status = "待付款";
                  }else if($value->paystatus == 1 && $value->is_use <= 1){
                    $str_ext .= ' <a href="javascript:goto('.$value->id.')">查看物流</a>    ';
                    $str_ext .= '               <a onclick="make_sure('.$value->id.')">确认收货</a>   ';
                    $status = "待收货";
                  }else if($value->paystatus == 1 && $value->is_use == 2){    
                    $str_ext = '  <a class="" style="color:#000;border-color:#000;"  href="javascript:tel:'.$tel.'">联系客服</a> ';
                    $status = "交易完成";
                  }

                  $str .= '<div class="order_h3">                                                          ';
                  $str .= '    <h5 class="tb">                                                             ';
                  $str .= '        <span class="flex_1">订单编号 '.$value->code.'</span>                    ';
                  $str .= '        <span>'.$status.'</span>                                                   ';
                  $str .= '    </h5>                                                                       ';
                  $str .= '    <div class="order_p1">                                                      ';
                  $str .= '        <div class="commodity_list" orderId="'.$value->id.'">                    ';
                  $str .= '            <dl class="list_dl order_dl tb">                                    ';
                  $str .= '                <dt>                                                            ';
                  $str .= '                    <img src="'.input::site($value->pic).'" /></dt>              ';
                  $str .= '                <dd class="flex_1">                                             ';
                  $str .= '                    <h1>'.$value->title.'</h1>                                   ';
                  $str .= '                    <div class="list_text pad">                                  ';
                  $str .= '                        <h3><font>￥</font>'.$value->price.'</h3>                ';
                  $str .= '                    </div>                                                       ';
                  $str .= '                </dd>                                                            ';
                  $str .= '            </dl>                                                                ';
                  $str .= '            <h4 class="toker_text f28">                                            ';
                  $str .= '            </h4>                                                                ';
                  $str .= '        </div>                                                                   ';
                  $str .= '        <h5 class="order_btn">                                                   ';
                  $str .= $str_ext;
                  $str .= '        </h5>                                                                    ';
                  $str .= '    </div>                                                                       ';
                  $str .= '</div>                                                                           ';
                }
              }
              echo $str;
          }

          /**
           * 订单详情
           */
          public function detail()
          {
              $id = S('detail');              
              $coupon = M('tk_coupon')->getOneData(array('id'=>$id,'member_id'=>$this->user->id));
              if($coupon)
              {
                  $cache = cache::getClass();
                  

                  if($coupon->paystatus==0)
                  {
                      $coupon->orderStatus='待付款';
                      $coupon->orderpng = input::imgUrl('orderStatus_01.png','wechat');
                  }
                  else if($coupon->paystatus==1 && $coupon->is_use==2){
                      $coupon->orderStatus='交易完成';
                      $coupon->orderpng = input::imgUrl('orderStatus_04.png','wechat');
                  }
                  else if($coupon->paystatus==-1)
                  {
                      $coupon->orderStatus='交易关闭';
                      $coupon->orderpng = input::imgUrl('orderStatus_05.png','wechat');                      
                  }
                  else if($coupon->paystatus==1 && $coupon->is_use<=1)
                  {
                      $coupon->orderStatus='待收货';
                      $coupon->orderpng = input::imgUrl('orderStatus_08.png','wechat');
                  }
                  
                  $data['user'] = $this->user;
                  $data['item'] = $coupon;

                  $data['qrcodeUrl'] = comm_ext::getQrcodeUrl($id);
                  $data['kfPhone'] = $cache->hGet('config','客服电话');
                  $data['tkTime'] = 1;
                                    
                  $cache = cache::getClass();
                  $sign = $cache->get('shareOrder:'.$id);
                  if(!$sign)
                  {
                      $sign = md5('3'.$id.time());
                      $cache->set('shareOrder:'.$id,$sign);
                  }                  
                  $this->template->shareParam = '"'.$coupon->title.'","'.input::site('wechat/share/order/'.$id.'/'.$sign.'/shareUser/'.$this->user->id).'","'.input::site($coupon->pic).'","'.$this->user->nickname.'的订单"';

                  $this->template->content = new View('wechat/order/detail_view',$data);
                  $this->template->render();
              }
          }

          /**
           * 确认订单
           */
          public function couponQrcode()
          {
              $id = G('id');
              $sign = G('sign');
              $cache = cache::getClass();
              $signex = $cache->get('orderQrcode:'.$id);
              if($signex == $sign)
              {
                  $coupon = M('tk_coupon')->getOneData(array('id'=>$id));
                  qrcode::png($coupon->code,false,'0',20,1);
              }
          }

          /**
           * 确认订单
           */
          public function makeOrder()
          {
              $data['user'] = $this->user;
              $itemId = S('makeOrder');
              if(tuoke_ext::is_limit($this->user->id,$itemId)<=0)
              {
                  exit;
              }
              $data['item'] = M('tk_item')->getOneData(array('id'=>$itemId));
              
              $result = M("region")->select()->where("parent_id=1")->execute();
              $data['list'] = json_decode(json_encode($result),true);

              $this->template->content = new View('wechat/order/makeOrder_view',$data);
              $this->template->render();
          }

          /**
           * 微信统一下单
           */
          public function wepay()
          {
              if(!P('itemId') && !P('orderId'))
              {
                  echo json_encode(array('success'=>'0','msg'=>'参数错误'));exit;
              }
              if(P('itemId'))
              {
                  $itemId = P('itemId');
                  $p_data['number'] = P('number');
                  $p_data['realname'] = P("realname");
                  $p_data['mobile'] = P("mobile");
                  $p_data['address'] = P("address");
                  $item = M('tk_item')->getOneData(array('id'=>$itemId));
                  if(!$item)
                  {
                      echo json_encode(array('success'=>'0','msg'=>'错误1'));exit;
                  }
                  if($item->status != 1 || $item->stock <= 0)
                  {
                      echo json_encode(array('success'=>'0','msg'=>'该商品已下架'));exit;
                  }

                  if(tuoke_ext::is_limit($this->user->id,$itemId)<=0)
                  {
                      echo json_encode(array('success'=>'0','msg'=>'购买次数达到上限'));exit;
                  }
                  $orderId = tuoke_ext::make_coupon($this->user->id,$item,$p_data);
                  if(!$orderId)
                  {
                      echo json_encode(array('success'=>'0','msg'=>'错误2'));exit;
                  }
                  M('tk_message')->insert(array('member_id'=>$this->user->id,'message'=>'下单了','is_all'=>1,'addtime'=>time()));
                  $order = M('tk_coupon')->getOneData(array('id'=>$orderId));
              }
              else
              {
                  $orderId = P('orderId');
                  $order = M('tk_coupon')->getOneData(array('id'=>$orderId));                  
                  $item = M('tk_item')->getOneData(array('id'=>$order->item_id));
                  if(!$item)
                  {
                      echo json_encode(array('success'=>'0','msg'=>'该商品已下架'));exit;
                  }
                  if($item->status != 1 || $item->stock <= 0)
                  {
                      echo json_encode(array('success'=>'0','msg'=>'该商品已下架'));exit;
                  }
                  if(tuoke_ext::is_limit($this->user->id,$order->item_id)<=0)
                  {
                      echo json_encode(array('success'=>'0','msg'=>'购买次数达到上限'));exit;
                  }
                  
              }
              if(!$order)
              {
                  echo json_encode(array('success'=>'0','msg'=>'错误3'));exit;
              }
              
              //统一下单                    
              $cache = cache::getClass();
              $appid = $cache->hGet('wechat','appId');
              $mchid = $cache->hGet('wechat','mchid');
              $values = array();
              $values['body'] = '拓客共享商城';
              $values['appid'] = $appid;
              $values['mch_id'] = $mchid;
              $values['nonce_str'] = str_ext::getNonceStr();
              $values['detail'] = $order->title;
              $values['out_trade_no'] = $order->id.time();
              $cache->setex('ordersn:'.$values['out_trade_no'],3600*24,$order->id);
              $cache->setex('orderIdsn:'.$order->id,3600*2400,$values['out_trade_no']);
              $values['total_fee'] = $order->price*100;
              if($values['total_fee']<=0 || isset($_SERVER['TESTENV']))
              {
                  //直接结算
                  tuoke_ext::pay_coupon($order->code,2,'0');
                  echo json_encode(array('success'=>'1','orderId'=>$order->id));exit;
              }
              else
              {                  
                  $values['spbill_create_ip'] = '117.27.143.242';
                  $values['notify_url'] = input::site('pay/wpaycallback');
                  $values['trade_type'] = 'JSAPI';
                  $values['openid'] = $this->user->openId;
                  $values['sign'] = str_ext::MakeSign($values);
                  $request = request::getClass('https://api.mch.weixin.qq.com/pay/unifiedorder','post');
                  $request->setBody(str_ext::ToXml($values));
                  $request->sendRequest();
                  $data = $request->getResponseBody();
                  file_put_contents('upload/pay/'.date('Y-m-d',time()).'.txt',date('H:i:s',time()).'=>'.$data."\t\n",FILE_APPEND);
                  $data = str_ext::FromXml($data);
                  //King::log('**************** :'.json_encode($data),'paylog/'.date('Y-m-d').'.log.php');
                  $jsApiParameters = str_ext::GetJsApiParameters($data);
                  echo json_encode(array('success'=>'1','jsApiParameters'=>$jsApiParameters,'msg'=>$data['return_msg'].$data['err_code_des'],'orderId'=>$order->id));
                  exit;
              }
          }
          
          /**
           * 支付成功跳转
           */
          public function paySuccess()
          {
              $id = S('paySuccess');
              if(!$id)
              {
                  exit;
              }
              $data['coupon'] = M('tk_coupon')->getOneData(array('id'=>$id));
              if(!$data['coupon'])
              {
                  exit;
              }
              $this->template->bgcss = 'back2';
              $this->template->content = new View('wechat/order/paySuccess_view',$data);
              $this->template->render();
          }
          
          /**
           * 用户限制检测
           */
          public function checkLimit()
          {
              $itemId = S('checkLimit');
              if(tuoke_ext::is_limit($this->user->id,$itemId)<=0)
              {
                  echo '购买次数达到上限';exit;
              }
              echo '1';exit;
          }
          
          /**
           * 用户申请退款
           */
          public function tkApply()
          {
              $itemId = P('orderId');
              $coupon = M('tk_coupon')->getOneData(array('id'=>$itemId,'isDel'=>0,'member_id'=>$this->user->id));
              if($coupon)
              {
                  $cache = cache::getClass();
                  $tkTime = $cache->hGet('config','退款时间（秒）');
                  if($coupon->paystatus==1 && $coupon->addtime+$tkTime>time() && $coupon->is_use==0)
                  {                      
                      $rs = M('tk_coupon')->update(array('is_use'=>-1,'returntime'=>time()),array('id'=>$itemId));
                      if($rs)
                      {
                          M('tk_log_return')->insert(array('member_id'=>$this->user->id,'coupon_id'=>$itemId,'code'=>$coupon->code,'type'=>1,'addtime'=>time()));
                          $tkday = M('set_return')->getOneData(array('id'=>1));
                          M('tk_message')->insert(array('member_id'=>$this->user->id,'message'=>'您的订单号'.$coupon->code.'发起退款申请，我们将在'.$tkday->return_day.'个工作日内完成审核，届时会将款项原路退','is_all'=>-1,'addtime'=>time()));
                          $upcomm = M('tk_log_commission')->where(array('coupon_id'=>$coupon->id,'type'=>1))->execute();
                          foreach($upcomm as $comm)
                          {
                              M('tk_message')->insert(array('member_id'=>$this->user->id,'message'=>'申请退款，您的佣金￥'.$comm->price.'将被退回','is_all'=>0,'addtime'=>time()));
                              M('tk_log_commission')->insert(array('coupon_id'=>$comm->coupon_id,'member_id'=>$comm->member_id,'type'=>2,'price'=>$comm->price,'to_member_id'=>$comm->to_member_id,'note'=>'申请退款','addtime'=>time()));
                          }
                          echo '1';exit;
                      }
                      echo '退款申请失败';exit;
                  }
                  echo '该订单无法退款';exit;
              }
              echo '无效订单';exit;
          }
          
          /**
           * 用户取消退款
           */
          public function tkCancel()
          {
              $itemId = P('orderId');

              $data['paystatus'] = -1;
              $data['closetime'] = time();
              $rs = M('tk_coupon')->update($data,array('id'=>$itemId,'isDel'=>0,'member_id'=>$this->user->id));
              
              echo $rs;
          }
          
          /**
           * 用户删除订单
           */
          public function delCoupon()
          {
              $itemId = P('orderId');
              $coupon = M('tk_coupon')->getOneData(array('id'=>$itemId,'isDel'=>0,'member_id'=>$this->user->id));
              if($coupon)
              {
                  // if($coupon->is_use==-2 || $coupon->is_use==2 || $coupon->paystatus==0)
                  // {                      
                      $rs = M('tk_coupon')->update(array('isDel'=>1),array('id'=>$itemId));
                      if($rs)
                      {
                          echo '1';exit;
                      }
                      echo '操作失败';exit;
                  // }
                  // echo '该订单无法删除';exit;
              }
              echo '无效订单';exit;
          }
          
          /**
           * 用户取消订单
           */
          public function cancelCoupon()
          {
              $itemId = P('orderId');
              $coupon = M('tk_coupon')->getOneData(array('id'=>$itemId,'paystatus'=>0,'member_id'=>$this->user->id));
              if($coupon)
              {          
                  $rs = M('tk_coupon')->update(array('paystatus'=>-1,'is_use'=>2,'closetime'=>time()),array('id'=>$itemId));
                  if($rs)
                  {
                      echo '1';exit;
                  }
                  echo '操作失败';exit;
              }
              echo '无效订单';exit;
          }
          
    /**
     * 扫一扫使用券
     */
    public function useCoupon()
    {
        $shop_url = P('shopurl');
        $code = P('code');
        $str = "验证失败";

        $codelist = array_filter(explode("/",$shop_url));
        $tkb_id = $codelist[count($codelist)];
        if($tkb_id>0)
        {
            $arr = tuoke_ext::use_coupon($code,$tkb_id);
            if($arr['success']){
              $str = 1;
            }else{
              $str =  $arr['msg'];
            }
        }         
        echo $str;
    }
    // 查看物流信息
    public function express_info(){
        $id = P('id','110');
        $result = M("tk_coupon")->getOneData("id=$id","pic,is_use,number,express,express_name");
        $data['number'] = $result->number;
        $data['pic'] = input::site($result->pic);
        $data['status'] = $result->is_use < '2' ? '待收货':'<span style="color:#ff3434;">已签收</span>';
        $express = kuaidi_ext::getKuaidiInfo($result->express,$result->express_name);
        $data['express'] = json_decode(json_encode($express),true);

        $this->template->content = new View('wechat/order/express_view',$data);
        $this->template->render();
    }

}
