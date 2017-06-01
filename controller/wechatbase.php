<?php defined('KING_PATH') or die('访问被拒绝.');
      class Wechatbase_Controller extends Controller
      {
          public $template;
          public $openid;
          public function __construct()
          { 
              parent::__construct();
              if (!isset($_SERVER['TESTENV']) && strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') < 1) {
                  header("Content-type:text/html;charset=utf-8");
                  exit('<script type="text/javascript">alert("请在微信中打开此页面");</script>');
              }
              $cache = cache::getClass();
              $this->openid = cookie::get('openid');
              if(isset($_SERVER['TESTENV']))
              {
                  $this->openid = 'otJYNs5HA8Yc2oVhb7B24IX37bmo';
                  $this->userInfo->nickname = '怪叔叔';
                  $this->userInfo->headimgurl = 'http://wx.qlogo.cn/mmopen/ajNVdqHZLLAGZicmvHGNUqChH5gOrWDLrF9Rw1PHALI6c5Rg4KbsLKGT3Wb4CYgApfUibYMykLEx12TWNYNdusCA/0';
              }

              if(!$this->openid)
              {
                  $appid = $cache->hGet('wechat','appId');
                  $redirect_uri = input::site('api/getur');
                  $url = implode('/',Route::$segUri);
                  cookie::set('memoryurl',$url,3600*1,'/api',$GLOBALS['config']['domain']);
                  $state = substr(md5(rand()), 0, 6);
                  cookie::set('state', $state,3600*1,'/api',$GLOBALS['config']['domain']);
                  input::redirect('https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.$redirect_uri.'&response_type=code&scope=snsapi_userinfo&state='.$state.'#wechat_redirect','refresh');
              }              
              else
              {
                  $this->user = $this->getUserByOpenId($this->openid);
                  if(!$this->user)
                  {
                      $shareUser = S('shareUser');
                      //新用户注册
                      $this->user = $this->addNewUser($shareUser);                      
                  }
                  else
                  {
                      M('member')->update(array('loginTime'=>time()),array('id'=>$this->user->id));
                  }
                  $this->member_id = $this->user->id;
                  $this->account_id = $this->user->account_id;
              }
              $this->template = new View('wechat_view');
              // 获取微信参数
              $url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
              $array = jsapi_ext::get_signature($url);
              $this->template->appId = $array['appId'];
              $this->template->noncestr = $array['noncestr'];
              $this->template->timestamp = $array['timestamp'];
              $this->template->signature = $array['signature'];
              $this->template->shareParam = '"","'.input::site('wechat/share/main/shareUser/'.$this->member_id).'"';

          }

          public function addNewUser($shareUser=0)
          {
              $request_url = $_SERVER['REQUEST_URI'];
              if($shareUser>0){
                  $rs = M("member")->getOneData("id=$shareUser","userpath");  
                  if(!empty($rs->userpath)){
                    $userpath = $shareUser.'-'.$rs->userpath;
                  }else{
                    $userpath = $shareUser;
                  }                       
              }

              $this->userInfo = json_decode(cookie::get('userInfo'));
              if(isset($_SERVER['TESTENV']))
              {
                  $this->userInfo->nickname = '😂哈哈';
                  $this->userInfo->headimgurl = 'http://wx.qlogo.cn/mmopen/ajNVdqHZLLAGZicmvHGNUqChH5gOrWDLrF9Rw1PHALI6c5Rg4KbsLKGT3Wb4CYgApfUibYMykLEx12TWNYNdusCA/0';
              }
              //emoji表情转换
              $tmpStr = json_encode($this->userInfo->nickname); //暴露出unicode
              $tmpStr = preg_replace("#(\\\ue[0-9a-f]{3})#ie","addslashes('\\1')",$tmpStr); //将emoji的unicode留下，其他不动
              $this->userInfo->nickname = $tmpStr;              
              
              $data['userpath'] = $userpath;
              $data['mobile'] = '';
              $data['passwd'] = md5('123456');
              $data['nickname'] = $this->userInfo->nickname;
              $data['head_img'] = $this->userInfo->headimgurl;
              $data['openId'] = $this->openid;
              $data['regTime'] = time();
              $data['loginTime'] = time();
              $data['pid'] = $shareUser;

              M('member')->save($data);
              return $this->getUserByOpenId($this->openid);
          }

          public function getUser($userId)
          {
              $user = M('member')->getOneData(array('id'=>$userId));
              if($user)
              {
                  $user->nickname = json_decode($user->nickname);
              }
              return $user;
          }

          public function getUserByOpenId($openId)
          {
              $user = M('member')->getOneData(array('openId'=>$openId));
              if($user)
              {
                  $user->nickname = json_decode($user->nickname);
              }
              return $user;
          }
      }