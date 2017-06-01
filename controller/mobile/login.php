<?php defined('KING_PATH') or die('访问被拒绝.');
class Login_Controller extends Mobilebase_Controller
{
    public $template;
    public function __construct(){	

    }

    // 登录页面
    public function login(){
      $userinfo = mobile_ext::validUser();
      if($userinfo['success'] == 1){          
        header('Location:'.input::site("mobile/goods/index"));
        exit;
      }
      $view = new View('mobile/login/login_view');
      $view->render();
    }
    // 注册页面
    public function regist(){

      $view = new View('mobile/login/regist_view');
      $view->render();
    }

    // 登录验证
    public function checkLogin(){
      $mobile = P('mobile');
      $passwd   = md5(P('passwd'));

      $re_msg['success'] = 0;
      $re_msg['msg'] = '用户名密码错误！';

      $userinfo = M('member')->getOneData("mobile='$mobile' and passwd='$passwd'",'id');
      if ($userinfo){
        $expiry = time()+7*24*3600;
        $str = md5("$userinfo->id:$passwd:$expiry");
        $login_info = "$userinfo->id:$expiry:$str";

        setcookie("login_info", $login_info, $expiry,'/');
        $re_msg['success'] = 1;
        $re_msg['msg'] = '登录成功';
      }
      echo json_encode($re_msg) ;
    }



    //注册会员
    public function saveRegist(){
      $re_msg['success'] = 0;
      $re_msg['msg'] = '注册失败';

      $data['mobile'] = P('mobile');
      $data['passwd'] = md5(P('passwd'));
      if(!empty($data['mobile']) && !empty($data['passwd'])){
        $rs = M('member')->insert($data);
        if($rs){
          $re_msg['success'] = 1;
          $re_msg['msg'] = '注册成功';
        }
      }      
      echo json_encode($re_msg);
    }
    // 发送短信验证码
    function sendCode(){
      $re_msg['success'] = 0;
      $re_msg['msg'] = '短信发送失败';

      $mobile = P('mobile','15377907108');
      if(preg_match('/1\d{10}/',$mobile)){
        $time = strtotime(date('Y-m-d',time()));
        $rs = M('sms')->where("mobile=$mobile and addtime>$time")->select('addtime')->orderby('addtime desc')->execute();
        $total = count($rs);
        var_dump(time()<(time()-60));
        print_r($rs);
        if($total >3){
          $re_msg['msg'] = '对不起，一天最多只能获取三次验证码。';
        }else if($rs[0]->addtime<time()+60){      
            $sinfo = C('siteConfig');
            $codestr = str_ext::random(4,'numeric');  //随机数字验证码
            $content = '['.$sinfo['name'].']尊敬的用户，您的验证码:'.$codestr;
            M('sms')->save(array('codestr'=>$codestr,'mobile'=>$mobile,'content'=>$content,'addtime'=>time()));
            // $ok = yysms_ext::postyzcode($mobile,$codestr);
            // if($ok['errorno'] == '0'){
            //     $re_msg['success'] = 1;
            //     $re_msg['msg'] = '验证码发送成功！';
            // }else{
            //     if(empty($ok['msg'])){
            //         $re_msg['msg'] = '短信发送失败！';
            //     }else{
            //         $re_msg['msg'] = $ok['msg'];
            //     }
            // }
        }else{
            //60秒内发送过的，不重复发送
            $re_msg['msg'] = '您的操作太频繁，请稍后再试！';
        }       
      }else{
        $re_msg['msg'] = '请填写正确的手机号';
      }
      print_r($re_msg);
      echo json_encode($re_msg);
    }
    
}
