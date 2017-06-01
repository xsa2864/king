<?php
/**
 * 数组扩展函数库
 * @author xilin
 *
 */
	class array_ext
	{
		/**
		 *删除数据键值 
		 * @param string $key
		 * @param array $array
		 */
		public static function remove($key, & $array)
		{
			if ( ! array_key_exists($key, $array))
				return NULL;
			$val = $array[$key];
			unset($array[$key]);
			return $val;
		}
		
		/**
		 * 数组转换对象
		 * @param array $array
		 * @param string $class
		 */
		public static function toObject(array $array, $class = 'stdClass')
		{
			$object = new $class;
		
			foreach ($array as $key=>$value)
			{
				if (is_array($value))
				{
					$value = array_ext::toObject($value, $class);
				}
				$object->{$key} = $value;
			}
			return $object;
		}
		
		/**
		 * 数组转为对象
		 * @param object $object
		 * @return Ambigous <array, unknown>
		 */
		public static function toArray($object)
		{
			$array	= (array)$object;
			foreach($array as $key=>$value)
			{
				if (is_object($value))
				{
					$value	= array_ext::toArray($value);
				}
				$array[$key]	= $value;	
			}
			return $array;
		}
		

		/*
		 *获取数组指定的键值，php5.5有内置函数
		 */
		public static function array_column($input, $columnKey, $indexKey=null){
			$columnKeyIsNumber      = (is_numeric($columnKey)) ? true : false;
			$indexKeyIsNull         = (is_null($indexKey)) ? true : false;
			$indexKeyIsNumber       = (is_numeric($indexKey)) ? true : false;
			$result                 = array();
			foreach((array)$input as $key=>$row){
				if($columnKeyIsNumber){
					$tmp            = array_slice($row, $columnKey, 1);
					$tmp            = (is_array($tmp) && !empty($tmp)) ? current($tmp) : null;
				}else{
					$tmp            = isset($row[$columnKey]) ? $row[$columnKey] : null;
				}
				if(!$indexKeyIsNull){
					if($indexKeyIsNumber){
						$key        = array_slice($row, $indexKey, 1);
						$key        = (is_array($key) && !empty($key)) ? current($key) : null;
						$key        = is_null($key) ? 0 : $key;
					}else{
						$key        = isset($row[$indexKey]) ? $row[$indexKey] : 0;
					}
				}
				$result[$key]       = $tmp;
			}
			return $result;
		}		
	}