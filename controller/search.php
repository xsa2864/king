<?php defined('KING_PATH') or die('访问被拒绝.');
/**
 * 搜索引擎初始化及定时运行文件
 * @author Administrator
 *
 */
	class Search_controller extends Place_Controller
	{
		public function __construct()
		{
			parent::__construct();
			if (PHP_SAPI != 'cli')
			{
				exit;
			}
		}
		
		public function generate()
		{
			$xs		= new xs_ext('mall');
			$xs->initData();
		}
		
		public function runCollect()
		{
			$xs		= new xs_ext('mall');
			$xs->timeCollect();
		}
		
		public function deleteitem()
		{
            $id = S('deleteitem');
			$xs		= new xs_ext('mall');
			$xs->save($id,'delete');
		}
		
	}
?>