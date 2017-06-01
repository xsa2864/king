<?php defined('KING_PATH') or die('访问被拒绝.');
	class Index_Controller extends Template_Controller
	{
		public function __construct()
		{
			parent::__construct();
		}
		
		public function index()
		{
		    $lite     = lite::getClass(array('lifeTime'=>null));
		    $key      = 'tf.index';
		    if ($data     = $lite->get($key))
		    {
		        echo $data;
		    }
		    else 
		    {
		      	echo '缓存不存在';   
		    }
		}

		public function test()
		{
            $res = dividend_ext::countFenhong(201610);
            echo $res;
		}
	}
			