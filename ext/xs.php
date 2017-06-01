<?php
/**
 * xs搜索引擎扩展函数库
 * @author xilin
 *
 */
	class xs_ext extends xs
	{
		public $project;
		public function __construct($project)
		{
			$this->project	= $project;
			parent::__construct($project);
		}
		
		public function initData($id='')//加载数据
		{
			if ($id)
				$rs		= M('item')->select('id,title,parent,cateId,childId,mainPic,price,prePrice,store,sales,promotion,ctime,comments')->where(array('id'=>$id))->execute();
			else
				$rs		= M('item')->select('id,title,parent,cateId,childId,mainPic,price,prePrice,store,sales,promotion,ctime,comments')->where(array('down'=>1))->orderby(array('id'=>'desc'))->execute();
			$record	= array();
			foreach ($rs as $row)
			{
				$attr	= array();
				$record	= (array)$row;
				$data	= D('item')->getCateById($row->cateId);
				$record['defaultSearch']	= $row->title.' '.$row->promotion.' '.$data->name;
				$rs2	= M('item_attribute')->where(array('itemId'=>$row->id))->execute();
				foreach ($rs2 as $row2)
				{
					$attr[]	= $row2->attrId.'x'.intval($row2->optionId);
				}
				$record['attrs']	= implode(' ',$attr);
				$this->addDoc($record);
			}
		}
		
		public function timeCollect()//定时收录数据
		{
			$file	= dirname(__FILE__).'/../logs/touch.lock';
			if (file_exists($file))
			{
				echo '另一脚本运行中';
				exit;
			}
			touch($file);
            M('item_record')->delete(array('done'=>1));
			$rs		= M('item_record')->where(array('done'=>0))->execute();
			foreach ($rs as $row)
			{
				if ($row->opt =='add' || $row->opt=='update')
				{
					$rs	= $this->initData($row->itemId);
				}
				elseif($row->opt == 'delete')
				{
					$rs	= $this->delDoc($row->itemId);
				}
				M('item_record')->update(array('done'=>1),array('id'=>$row->id));	
			}
			unlink($file);
		}
		
		/**
		 * 在添加，修改，删除商品时需要保存
		 * @param mixed 商品Id 
		 * @param mixed 操作 增加：add,更新：update,删除：delete  
		 * @return mixed 成功返回大于0的ID，失败返回0
		 */
		public function save($itemId,$opt)
		{
            $check = M('item_record')->getOneData(array('itemId'=>$itemId));
            if($check && $check->done == 0){
                return M('item_record')->update(array('opt'=>$opt),array('itemId'=>$itemId));
            }else {
                return M('item_record')->insert(array('itemId' => $itemId, 'opt' => $opt));
            }
		}
		
		public function query($param,$limit=20)
		{
			$cacheKey	= md5($param.'.'.$limit);
			$cache		= cache::getClass();
          //  $cache->delete($cacheKey);
			$data		= unserialize($cache->get($cacheKey));
			if ($data === false)
			{
				$params		= explode('-',$param);
				$scws		= scws::getClass();
				foreach ($params as $value)
				{
					$sign	= $value{0};
					$signValue	= substr($value,1);
				
					if ($signValue && $signValue !='-')
					{
						if ($sign =='k')//关键词
						{
							$keyword	= urldecode($scws->split($signValue));
							$this->setQuery($keyword);
						}
							
						if ($sign == 'c')//类别
						{
                            if(strstr($signValue, '|'))
                            {
                                $cate = array_filter(explode("|",$signValue));
                                if($cate[0]==1)
                                {
                                    $this->setFilter('parent',$cate[1],$cate[1]);
                                }
                                else if($cate[0]==2)
                                {
                                    $this->setFilter('cateId',$cate[1],$cate[1]);
                                }
                                else if($cate[0]==3)
                                {
                                    $this->setFilter('childId',$cate[1],$cate[1]);
                                }
                            }
                            else
                            {
                                $this->setFilter('cateId',$signValue,$signValue);
                            }
						}
							
						if ($sign == 'o')//排序
						{
							$fields	= array(1=>'store',2=>'price',3=>'comments',4=>'ctime',5=>'sales');
							$orders	= array(1=>'ASC',2=>'DESC');
							$field	= $signValue{0};
							$order	= $signValue{1};
							$this->setOrder(array($fields[$field]=>$orders[$order]));
						}
							
						if ($sign == 'd')//属性
						{
                            //27.156.26.20

							$multiValue	= str_replace('_',' AND ',$signValue);
							$attrValue	= str_replace('|','x',$multiValue);
                            /*
                            if($_SERVER["REMOTE_ADDR"] == '27.156.26.20'){
                                var_dump($attrValue);
                            }*/
							$this->setQuery('attrs:'.$attrValue);
						}
							
						if ($sign == 'q')//自定义价格区间
						{
							$prices	= explode('|',$signValue);
							$minPrice	= $prices[0] ? $prices[0] : NULL;
							$maxPrice	= $prices[1] ? $prices[1] : NULL;
							$this->setFilter('price',$minPrice,$maxPrice);
						}
							
						if ($sign == 'p')
						{
							$start	= $limit*($signValue-1);
							$start	= $start <0 ? 0 : $start;
							$this->setLimit($start,$limit);
						}
					}
				}
				$data		= $this->search();
				$cache->set($cacheKey, serialize($data),600);
			}
			return $data;
		}
	}