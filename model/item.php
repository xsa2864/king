<?php defined('KING_PATH') or die('访问被拒绝.');

	class Item_Model extends Model
	{
		public function __construct($dbSet)
		{
			$table		= $this->setTable();
			parent::__construct($table,$dbSet);
		}
		
		private function setTable()
		{
			return 'category';
		}
		
		public function getCateById($id)
		{
			$key	= 'cate_name_'.$id;
			$cache	= cache::getClass();
			$data	= $cache->get($key);
			if ($data === false)
			{
				$data	= $this->getOneData(array('id'=>$id));
				$cache->set($key,$data,864000);//存储10天
			}
			return $data;
		}
		
		public function getItemById($id)
		{
			$key	= 'item_'.$id;
			$cache	= cache::getClass();
            //$cache->delete($key);
			$data	= $cache->get($key);
			if ($data === false)
			{
				$data	= $this->getOneData(array('id'=>$id,'down'=>1),'','item');
                if(isset($data)) {
                    $cache->set($key, $data, 864000);//存储10天
                }
			}
			return $data;
		}
		
		public function updateCate($key)
		{
			//$key	= 'cate_name_'.$id;   //类别
			$cache	= cache::getClass();
			$cache->delete($key);
        }
	}
	