<?php defined('KING_PATH') or die('访问被拒绝.');
      class Mobilebase_Controller extends Controller
      {
          public $template;
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
                  $this->openid = 'otJYNs5HA8Yc2oVhb7B24IX39bmo';
                  $this->userInfo->nickname = '怪叔叔';
                  $this->userInfo->headimgurl = 'http://wx.qlogo.cn/mmopen/WmwqjsSBsZImAlsItQTwv57osIYHvuSo2lriavG2wjE3cwdI24YyMz1SRCewicVDwseuibicm3EJibzfWEd1Uk8iafDw/0';
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
                  $this->user = M('member')->getOneData(array('openId'=>$this->openid));
                  if(!$this->user)
                  {
                      //新用户注册
                      $this->user = $this->addNewUser();
                  }
                  else
                  {
                      M('member')->update(array('loginTime'=>time()),array('id'=>$this->user->id));
                  }
                  $this->member_id = $this->user->id;
                  $this->account_id = $this->user->account_id;
              }
              $this->template = new View('mobile_view');
          }

          public function addNewUser()
          {
              $this->userInfo = json_decode(cookie::get('userInfo'));
              $data['mobile'] = '12345678910';
              $data['passwd'] = md5('123456');
              $data['nickname'] = $this->userInfo->nickname;
              $data['head_img'] = $this->userInfo->headimgurl;
              $data['openId'] = $this->openid;
              $data['regTime'] = time();
              $data['loginTime'] = time();
              M('member')->insert($data);
              return M('member')->getOneData(array('openId'=>$this->openid));
          }
      }