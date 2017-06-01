<?php defined('KING_PATH') or die('访问被拒绝.');

	class Attr_Model extends Model
	{
		private $cache;
		public function __construct($dbSet)
		{
			$table		= $this->setTable();
			parent::__construct($table,$dbSet);
			$this->cache	= cache::getClass();
		}
		
		public function setTable()
		{
			return 'attribute';
		}
		
		/**
		 * 取得分类所有属性
		 */
		public function getAttr($id)
		{
			$wh		= array('cateId'=>$id,'pid'=>0);
			$key	= 'categoryId_attr_'.$id;
			$rs	= $this->cache->get($key);
			if ($rs === false)
			{
				$rs		= $this->where($wh)->orderby(array('orderNum'=>'asc'))->execute();
				$this->cache->set($key,$rs,864000);//存储10天
			}
			return $rs;
		}
		
		/**
		 * 保存属性
		 * @param int $itemId
		 * @param array $dicts 字典id集合
		 * @param array $options 字典项id集合
		 */
		public function saveAttr($itemId,$dicts,$options)
		{
			foreach ($dicts as $key=>$value)
			{
				$params		= array(
					'itemId'	=> $itemId,
					'attributeId'	=> $value,
					'optionId'		=> $dids[$key]
				);
				$return 	= $this->insert($params,'item_attribute');
			}
			
			if ($return)
			{
				echo json_encode(array('success'=>1));
			}
			else 
			{
				echo json_encode(array('success'=>0));
			}
		}
		
		/**
		 * 取得属性项
		 */
		public function getDictOption($dictId)
		{
			$key	= 'attribute_'.$dictId;
			$rs	= $this->cache->get($key);
			if ($rs === false)
			{
				$rs		= $this->where(array('pid'=>$dictId))->orderby(array('orderNum'=>'asc'))->execute();
				$this->cache->set($key,$rs,86400);
			}
			return $rs;
		}
		
		/**
		 * 更新属性项
		 */
		public function updateDictOption($dictId)
		{
			$key	= 'attribute_'.$dictId;
			$this->cache->delete($key);
        }
		
		/**
         * 更新属性
         */
		public function updateAttr($dictId)
		{
			$key	= 'categoryId_attr_'.$dictId;
			$this->cache->delete($key);
        }
		
		/**
         * 获取首页分类
         */
		public function getCategory()
		{
			$key	= 'mainCategory';
            //$this->cache->delete($key);
			$rs	= $this->cache->get($key);
			if ($rs === false)
			{
                $rs = array();
                $rows = M('category')->where(array('visible'=>1))->orderby(array('orderNum'=>'asc'))->execute();
                foreach($rows as $row)
                {
                    $count = M('category')->getAllCount(array('pid'=>$row->id));
                    if($count <= 0)
                    {
                        if($row->pid==0)
                        {
                            $row->lv=1;
                        }
                        else
                        {
                            $pid = M('category')->getFieldData('pid', array('id'=>$row->pid));
                            if($pid==0)
                            {
                                $row->lv=2;
                            }
                            else
                            {
                                $row->lv=3;
                            }
                        }
                        $rs[] = $row;
                    }
                }
            }
            return $rs;
        }
		
		/**
         * 更新首页分类
         */
		public function updateCategory()
		{
			$key	= 'mainCategory';
			$this->cache->delete($key);
        }
	}
	