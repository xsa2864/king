<?php defined('KING_PATH') or die('访问被拒绝.');
      class Api_controller extends Controller
      {
          public function __construct()
          {              
          }

          public function getur()
          {
              $state = trim(G('state'));
              if($state == trim(cookie::get('state')))
              {
                  $cache = cache::getClass();
                  $appid = $cache->hGet('wechat','appId');
                  $appsecret = $cache->hGet('wechat','appsecret');
                  $code = trim(G('code'));
                  $req = request::getClass('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$appsecret.'&code='.$code.'&grant_type=authorization_code');
                  $req->sendRequest();
                  $body = json_decode($req->getResponseBody());
                  cookie::set('openid',$body->openid,3600*24*30,'/',$GLOBALS['config']['domain']);
                  $openid = $body->openid;
                  $req = request::getClass('https://api.weixin.qq.com/sns/userinfo?access_token='.$body->access_token.'&openid='.$body->openid.'&lang=zh_CN');
                  $req->sendRequest();
                  $body = $req->getResponseBody();

                  cookie::set('userInfo',$body,3600*24*365,'/',$GLOBALS['config']['domain']);
                  $user = M('member')->getOneData(array('openId'=>$openid));
                  if($user)
                  {
                      $this->userInfo = json_decode($body);
                      //emoji表情转换
                      $tmpStr = json_encode($this->userInfo->nickname); //暴露出unicode
                      $tmpStr = preg_replace("#(\\\ue[0-9a-f]{3})#ie","addslashes('\\1')",$tmpStr); //将emoji的unicode留下，其他不动
                      $this->userInfo->nickname = $tmpStr;
                      M('member')->update(array('nickname'=>$this->userInfo->nickname,'head_img'=>$this->userInfo->headimgurl),array('id'=>$user->id));
                  }
                  $memoryurl = cookie::get('memoryurl');
                  input::redirect(input::site($memoryurl),'refresh');
              }
          }
      }