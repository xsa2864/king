<?php

defined('KING_PATH') or die('访问被拒绝.');

class Register_controller extends Controller {

    public function __construct() {
        parent::__construct();
        $this->mod = M('account');
    }

    public function index() {
        $userName = $this->input->post('userName');
        $passwd = md5($GLOBALS['config']['md5Key'] . $this->input->post('passwd'));
        if ($userName && $passwd) {
            
        } else {
            $data['test'] = '测试';
            $view = new View('admin/login_view', $data);
            $view->render();

        }
    }

}
