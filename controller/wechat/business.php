<?php defined('KING_PATH') or die('访问被拒绝.');
      class Business_Controller extends Wechatbase_Controller
      {
          public function __construct(){              
              parent::__construct();
          }

          /**
           * 商家列表
           */
          public function index(){
              $itemId = S('index');
              if(!$itemId)
              {
                  exit;
              }
              $item = M('tk_item')->getOneData(array('id'=>$itemId));
              if(!$item)
              {
                  exit;
              }
              $data['total'] = 0;
              $data['business']=array();
              if($item->business_id){
                  $data['total'] = count(explode(',', $item->business_id));
                  $cache = cache::getClass();
                  $userpos = $cache->get('userPosition:'.$this->user->id);
                  $array = json_decode($userpos,true);

                  $result = M('tk_business')->where('id in('.$item->business_id.') and `status`=1')->execute(); 
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
              $data['itemId'] = $itemId;
              $this->template->content = new View('wechat/business/list_view',$data);
              $this->template->render();
          }
          /*
           * 获取更多的商家
           */
          public function get_more(){
              $id = P("id");
              $page = P('page');

              $item = M("tk_item")->getOneData("id=$id","business_id");
         
              $str = '';
              if($item->business_id){
                  $total = count(explode(',', $item->business_id));

                  $cache = cache::getClass();
                  $userpos = $cache->get('userPosition:'.$this->user->id);
                  $array = json_decode($userpos,true);

                  $result = M('tk_business')->select()->where('id in('.$item->business_id.') and `status`=1')->execute(); 
                  $arr = json_decode(json_encode($result),true);
                  foreach ($arr as $key => $value) {                    
                    $lat = abs($value['lat']-$array['lat']);
                    $lng = abs($value['lng']-$array['lng']);
                    $powNum = pow($lat,2)+pow($lng,2);
                    array_unshift($value,$powNum);
                    $new[] = $value;
                  }
                  asort($new);
                  $sNum = $page*10;
                  // $eNum = $sNum+10;
                  if($total>$sNum){
                      $show_arr = array_slice($new,$sNum,10);
                      foreach ($show_arr as $key => $value) {
      $str .= '<dl class="edit_list" busId="'.$value['id'].'" onclick="location.href=\''.input::site('wechat/business/detail/'.$value['id']).'\'">  ';
      $str .= '    <dt>  ';
      $str .= '        <img src="'.($value['pic']?input::site($value['pic']):input::imgUrl('default_bheader.png','wechat')).'" /></dt>  ';
      $str .= '    <dd>  ';
      $str .= '        <h2>'.$value['name'].'</h2>  ';
      $str .= '        <h1 class="tb">  ';
      $str .= '            <span class="flex_1 distancs" id="'.$value['id'].'" loc="'.$value['lat'].','.$value['lng'].'">  ';
      $str .= '                <img style="width: 18px;" src="'.input::imgUrl('wait.gif','wechat').'">  ';
      $str .= '            </span>  ';
      $str .= '            <font><a class="tel" butitle="'.$value['name'].'" butel="'.$value['mobile'].'">电话咨询</a></font>  ';
      $str .= '        </h1>  ';
      $str .= '        <p>定位地址：'.$value['address'].'</p>  ';
      $str .= '        <p>详细地址：'.$value['full_address'].'</p>  ';
      $str .= '    </dd>  ';
      $str .= '</dl>        ';
                      }
                  }
              }
              echo $str;
          }
          /**
           * 商家距离
           */
          public function getPosition()
          {
              $ids = P('busids');
              $lat = P('lat');
              $lng = P('lng');
              $business = M('tk_business')->where('id in('.$ids.') and `status`=1')->execute();
              $buspos = '';
              $busposls = array();
              foreach($business as $item)
              {
                  $st = $item->lat.','.$item->lng.';';
                  $busposls[] = $item->id;
                  if($item->lat && $item->lng)
                  {
                      $toStr .= $st;
                  }
              }
              if($toStr)
              {
                  $toStr = mb_substr($toStr,0,strlen($toStr)-1);
                  $baseString = '/ws/distance/v1/?mode=driving&from='.$lat.','.$lng.'&to='.$toStr.'&key=QMOBZ-QBT3K-WNMJV-ATIUM-3W5CH-GOFZL';
                  $sn = $this->caculateAKSN($baseString);
                  $request = request::getClass('http://apis.map.qq.com/ws/distance/v1/?mode=driving&from='.$lat.','.$lng.'&to='.$toStr.'&key=QMOBZ-QBT3K-WNMJV-ATIUM-3W5CH-GOFZL&sn='.$sn);
                  $request->sendRequest();
                  $rs = json_decode($request->getResponseBody());
                  if($rs->status)
                  {
                      echo json_encode(array('success'=>0,'msg'=>$rs));exit;
                  }
                  foreach($rs->result->elements as $key=>$element)
                  {
                      $buspos[$busposls[$key]] = $element->distance;
                  }
                  echo json_encode(array('success'=>1,'info'=>$buspos));exit;
              }
              else
              {
                  echo json_encode(array('success'=>0,'msg'=>'1'));exit;
              }              
          }

          /**
           * 商家详情
           */
          public function detail()
          {
              $id = S('detail');
              $data['bus'] = M('tk_business')->getOneData(array('id'=>$id));
              $data['gpsUrl'] = 'http://apis.map.qq.com/tools/routeplan/eword='.$data['bus']->name.'&epointx='.$data['bus']->lng.'&epointy='.$data['bus']->lat.'?referer=myapp&key=QLPBZ-3WU3R-SCEWE-WHR3D-OC3YZ-RLFM2';
              $this->template->content = new View('wechat/business/detail_view',$data);
              $this->template->render();              
          }
      }
