<?php defined('KING_PATH') or die('访问被拒绝.');

	class Member_Model extends Model
	{
		public function __construct($dbSet)
		{
			$table		= $this->setTable();
			parent::__construct($table,$dbSet);
		}
		
		private function setTable()
		{
			return 'member';
		}
		
		public function getMemberById($id)
		{
			$key	= 'member_'.$id;
			$cache	= cache::getClass();
			$data	= $cache->get($key);
			if ($data === false)
			{
				$data	= $this->getOneData(array('id'=>$id));
                if(isset($data)) {
                    $cache->set($key, $data, 864000);//存储10天
                }
			}
			return $data;
		}
		
		public function updateCate($id)
		{
			$key	= 'member_'.$id;
			$cache	= cache::getClass();
			$cache->delete($key);
        }

        public function getProvincial($id)
        {
            $key    = 'provincial_'.$id;
			$cache	= cache::getClass();
			$data	= $cache->get($key);
			if ($data === false)
			{
				$data	= M('provincial')->getOneData(array('id'=>$id));
                if(isset($data)) {
                    $cache->set($key, $data, 864000);//存储10天
                }
			}
			return $data;
        }

        public function getCity($id)
        {
            $key    = 'city_'.$id;
			$cache	= cache::getClass();
			$data	= $cache->get($key);
			if ($data === false)
			{
				$data	= M('city')->getOneData(array('id'=>$id));
                if(isset($data)) {
                    $cache->set($key, $data, 864000);//存储10天
                }
			}
			return $data;
        }
	}
	