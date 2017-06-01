<?php defined('KING_PATH') or die('访问被拒绝.');
//http://120.25.231.14:9999/sms.aspx?action=send&userid=592&account=hzzh&password=hzzh888&mobile=18305968892&content=123&sendTime=&extno=
    class Sms_Controller extends Template_Controller
    {
        private $mod;
        public function __construct()
        {
            parent::__construct();
           // $this->mod  = D('sms',"");
        }
        
        public function index()
        {
			$data['row']             = C('smsConfig');
			$this->template->content = new View("admin/sms/add_view", $data);
			$this->template->render();
        }
		 public function save()
        {
            $post            = $this->input->post();
            if ($post['account'])
            {
                $insert        = array(
                        'account'          => $post['account'],
                        'password'          => $post['password'],
                        'userid'            => $post['userid']        
                );
                $return        = file_ext::saveConfig($insert,'smsConfig');
            }
            else
                input::redirect('admin/sms');
        }
		public function testSend(){
			$post            = $this->input->post();
			if (!empty($post['mobile'])){
				$valid		= valid::getClass();
				$valid->mobile($post['mobile']);
				$array = array(
					  "content" => "【酒泉网】您的验证码为，10分钟内有效。如非本人操作请忽略本短信。",
					  "mobile" => $post["mobile"],
					  "sendTime" => ""
					);
				$result = sms_ext::send($post["mobile"],"【酒泉网】您的验证码为，10分钟内有效。如非本人操作请忽略本短信。");
				if ($result == 1){
                    echo '发送成功';
				}else{
                    echo '发送失败';
				}
			}else{
                echo '请填写手机号码';
			}
		}
	}