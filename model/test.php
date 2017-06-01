<?php defined('KING_PATH') or die('访问被拒绝.');

	class Test_Model extends Model
	{
		public function __construct($dbSet)
		{
			$table		= $this->setTable();
			parent::__construct($table,$dbSet);
		}
		
		
		private function setTable()
		{
			return 'mod';//返回默认表名，允许为空
		}
		public function getInfo()
		{
			$menuList = array();
        	$where = array('visible'=>1);
        	$order = 'orderNum asc';
        	$fields = 'id,bid,url,app,modName';
        	$menuList = $this->where($where)->orderby($order)->select($fields)->execute();
        	$leftMenu = $this->getTree(json_decode(json_encode($menuList),true));
			
			return $leftMenu;
		}
		// 递归函数
    	public function getTree($arr,$id=0){
    	    $tree = array();
    	    foreach ($arr as $key => $value) {
    	      if($value['bid'] == $id){
    	        $value['child'] = self::getTree($arr,$value['id']);
    	        $tree[] = $value;
    	      }
    	    }
    	    return $tree;
    	}
	}
	