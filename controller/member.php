<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/7/17
 * Time: 16:49
 */

class Member_Controller extends Place_Controller {
    public $member_folder;
    public function __construct(){
        parent::__construct();
        if(is_null($_SESSION['userinfo']) or empty($_SESSION['userinfo'])){
           // echo '<script>alert("请先登录");</script>';
            input::redirect('login-index.html');
        }
        $this->data['left'] = new View($this->folder.'/comm/member_left_view');
      //  $this->data['folder'] = $this->folder;
        $this->member_folder = $this->folder.'/member/';
    }
}