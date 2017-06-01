<?php defined('KING_PATH') or die('访问被拒绝.');
	class Hello_controller extends Place_Controller
	{
		public function __construct()
		{
			parent::__construct();
		}
		
		public function index()
		{
            $data['test'] = 'hello word';
			$view = new View('hello/index_view', $data);
			$view->render();
		}
	}