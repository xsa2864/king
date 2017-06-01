<?php
 defined('KING_PATH') or die('访问被拒绝.'); 
 class Logout_Controller extends Template_Controller {
    public function __construct() 
    {
        parent::__construct();
    }
	public function index(){
        session_start();
        session_unset();
        session_destroy();
		input::redirect('admin/login');
	}
}