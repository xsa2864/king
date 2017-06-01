<?php defined('KING_PATH') or die('访问被拒绝.');
      class Share_Controller extends Wechatbase_Controller
      {
          public function __construct(){              
              parent::__construct();
          }
          // 判断是否关注公众号
          public function subscribe(){

              $subscribe = 0;            
              $openid = $this->openid;
              $access_token = jsapi_ext::get_access_token();
              $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";

              $json = file_get_contents($url);
              $array = json_decode($json,true);

              if(!empty($array)){
                $subscribe = $array['subscribe'];
              }   

              return $subscribe;
          }

          // 分享首页
          public function main(){
              $userId = S('main');
              $shareUser = $this->getUser($userId);

              // $subscribe = $this->subscribe();
              // if($subscribe == 1){                
              //   $item_url = input::site("wechat/main/index");
              //   header('Location:'.$item_url);
              // }

              $data['goodsList'] = M('tk_item')->where(array('status'=>1))->orderby(array('id'=>'asc'))->execute();
              $higher = $this->getUser($shareUser->pid);
              if($higher)
              {
                  $data['higher'] = '我的客户代表<img src="'.$higher->head_img.'" /><font>'.$higher->nickname.'</font>';
              }
              else
              {
                  $data['higher'] = '&nbsp;';
              }
              $timestamp = strtotime(date('Y-m-d',time()-259200)); //获取三天前零点的时间戳
              $msg = M('tk_message')->where(array('addtime >'=>$timestamp))->orderby(array('addtime'=>'desc'))->limit(0,1)->execute();
              $msg = $msg[0];
              if($msg)
              {
                  $msgUser = $this->getUser($msg->member_id);
                  if($msg->is_all==1)
                  {
                      if($msgUser->pid!=$userId)
                      {
                          $msgUser->nickname = mb_substr($msgUser->nickname,0,1,'utf-8').'**';
                      }
                      $timestr = timeformat_ext::format($msg->addtime);
                      $data['message'] = '<span style="margin-right:0.1rem"><img src="'.$msgUser->head_img.'" />'.$msgUser->nickname.'  '.$timestr.$msg->message.'</span>';
                  }
                  else
                  {
                      $data['message'] =  '&nbsp;<br />&nbsp;';
                      if($msgUser->pid==$userId)
                      {
                          $timestr = timeformat_ext::format($msg->addtime);
                          $data['message'] = '<span style="margin-right:0.1rem"><img src="'.$msgUser->head_img.'" />'.$msgUser->nickname.'  '.$timestr.$msg->message.'</span>';
                      }
                  }
              }
              else
              {
                  $data['message'] =  '&nbsp;<br />&nbsp;';
              }
              $this->template->bgcss = 'pad_none2';
              $this->template->content = new View('wechat/share/shareMain_view',$data);
              $this->template->render();
          }

          // 分享订单
          public function order(){
              $id = S('order');
              $sign = S($id);
              $cache = cache::getClass();
              $reSign = $cache->get('shareOrder:'.$id);
              if($sign===$reSign){
                  $coupon = M('tk_coupon')->getOneData(array('id'=>$id));
                  $data['itemId'] = $coupon->item_id;
                  if($coupon)
                  {
                      if($coupon->paystatus==0)
                      {
                          $coupon->orderStatus='待付款';
                          $coupon->orderpng = input::imgUrl('orderStatus_01.png','wechat');
                      }
                      else if($coupon->paystatus==1 && $coupon->is_use==1){
                          $coupon->orderStatus='交易完成';
                          $coupon->orderpng = input::imgUrl('orderStatus_04.png','wechat');
                          if($coupon->tkb_id){
                              $coupon->tkb_name = M('tk_business')->getFieldData('name',array('id'=>$coupon->tkb_id));
                              $coupon->business_id = $coupon->tkb_id;
                          }
                      }
                      else if($coupon->paystatus==1 && $coupon->is_use==0 && $coupon->endtime>time())
                      {
                          $coupon->orderStatus='待使用';
                          $coupon->orderpng = input::imgUrl('orderStatus_02.png','wechat');
                      }
                      else if($coupon->is_use==-1)
                      {
                          $coupon->orderStatus='退款中';
                          $coupon->orderpng = input::imgUrl('orderStatus_03.png','wechat');
                      }
                      else
                      {
                          if($coupon->is_use!=1)
                          {
                              $coupon->orderStatus='交易关闭';
                              $coupon->orderpng = input::imgUrl('orderStatus_05.png','wechat');
                          }
                          if($coupon->tkb_id){
                              $coupon->tkb_name = M('tk_business')->getFieldData('name',array('id'=>$coupon->tkb_id));
                              $coupon->business_id = $coupon->tkb_id;
                          }
                      }
                      $data['user'] = $this->getUser($coupon->member_id);
                      $data['item'] = $coupon;
                      if(!$data['item']->business_id)
                      {
                          $data['item']->business_id = M('tk_item')->getFieldData('business_id',array('id'=>$data['item']->item_id));
                      }

                      $data['business']=array();
                      if($data['item']->business_id){
                          $data['total'] = count(explode(',', $data['item']->business_id));
                          $cache = cache::getClass();
                          $userpos = $cache->get('userPosition:'.$this->user->id);
                          $array = json_decode($userpos,true);

                          $result = M('tk_business')->where('id in('.$data['item']->business_id.') and `status`=1')->execute(); 
                          $arr = json_decode(json_encode($result),true);
                          foreach ($arr as $key => $value) {                    
                            $lat = abs($value['lat']-$array['lat']);
                            $lng = abs($value['lng']-$array['lng']);
                            $powNum = pow($lat,2)+pow($lng,2);
                            array_unshift($value,$powNum);
                            $new[] = $value;
                          }
                          asort($new);
                          $data['business'] = array_slice($new,0,10);
                      }
                                           
                      $data['item']->validity = $data['item']->endtime;                      
                      $data['qrcodeUrl'] = comm_ext::getQrcodeUrl($id);
                      
                      $this->template->bgcss = 'pad_none2';
                      $this->template->content = new View('wechat/share/shareOrder_view',$data);
                      $this->template->render();
                  }
              }
          }

          // 分享商品
          public function item(){
              $itemId = S('item');
              $data['itemId'] = $itemId;

              $subscribe = $this->subscribe();
              if($subscribe == 1){                
                $item_url = input::site("wechat/goods/index").'/'.$itemId;
                header('Location:'.$item_url);
              }

              $data['item'] = M('tk_item')->getOneData(array('id'=>$itemId));
              $data['item']->pics = json_decode($data['item']->pics);
              if(!$data['item']->pics)
              {
                  $data['item']->pics = array();
              }

              $data['business']=array();
              if($data['item']->business_id)
              {
                  $data['total'] = count(explode(',', $data['item']->business_id));
                  $cache = cache::getClass();
                  $userpos = $cache->get('userPosition:'.$this->user->id);
                  $array = json_decode($userpos,true);

                  $result = M('tk_business')->where('id in('.$data['item']->business_id.') and `status`=1')->execute(); 
                  $arr = json_decode(json_encode($result),true);
                  foreach ($arr as $key => $value) {                    
                    $lat = abs($value['lat']-$array['lat']);
                    $lng = abs($value['lng']-$array['lng']);
                    $powNum = pow($lat,2)+pow($lng,2);
                    array_unshift($value,$powNum);
                    $new[] = $value;
                  }
                  asort($new);
                  $data['business'] = array_slice($new,0,10);
              }
              
              if($data['item']->timetype==0)
              {
                  $data['item']->validity = $data['item']->validtime+time();
              }
              else
              {
                  $data['item']->validity = $data['item']->endtime;
              }
              $this->template->bgcss = 'pad_none2';
              $this->template->content = new View('wechat/share/shareItem_view',$data);
              $this->template->render();
          }
      }
