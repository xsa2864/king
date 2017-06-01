<?php
/**
 * 文件及文件夹操作函数库
 * @author xilin
 *
 */
class file_ext
{
	/**
	 * 文件加锁
	 *
	 * @param  $fp
	 * @param string $lock_level
	 */
	public static function lock($fp,$lock_level=LOCK_EX)
	{
		@flock($fp,$lock_level)
		or die('Cannot flock filepointer to '.$lock_level);
	}
	
	/**
	 * 文件解锁
	 *
	 * @param $fp
	 */
	public static function unlock($fp)
	{
		@flock($fp,LOCK_UN)
		or die ('Cannot Release the Lock');
	}
	

	/**
	 * 创建多级目录
	 *
	 * @param string $pre
	 * @param string $path
	 * @param string $mode
	 */
	public static function createDirs($pre,$path,$mode=0644)
	{
		$paths	= explode('/',$path);
		foreach ($paths as $p)
		{
	
			if (!is_dir($pre.$p))
			{
				mkdir($pre.$p,$mode);
			}
			$pre	.=$p.'/';
		}
		return $pre;
	}
	

	/**
	 *
	 * 取得扩展名
	 * @param $name
	 */
	public static function getExt($name)
	{
		$path_parts = pathinfo($name);
		$ext		= strtolower($path_parts['extension']);
		return $ext;
	}
	
	/**
	 * 保存配置文件
	 * @param unknown $array
	 * @param unknown $file
	 */
	public static function saveConfig($array,$file)
	{
		$file = $GLOBALS['config']['basePath'].$file.EXT;
		$str  = '<?php return  ' . var_export($array, true) . ';';
		self::operaFile($file,$str);
		return true;
	}		
	

	/**
	 *
	 * 写入文件的操作
	 * @param str $file
	 * @param str $str
	 * @param str $opera
	 */
	public static function operaFile($file,$str='',$opera='w')
	{
		$fp		= fopen($file,$opera);
		self::lock($fp);
		fwrite($fp,$str);
		self::unlock($fp);
	}
	
	/**
	 * 文件下载
	 * @param string $file 下载的文件名
	 * @param string $filename 新的文件名
	 */
	public static function fileDownload($file, $filename = null)
	{
		$file	= $_SERVER['DOCUMENT_ROOT'].'/'.$file;
		if (is_file($file))
		{
			if (!$filename) $filename = basename($file);
			$filesize = filesize($file);
			$mime = array('application/octet-stream');
			header('Content-Type: '.$mime[0]);
			header('Content-Disposition: attachment; filename="'.$filename.'"');
			header('Content-Transfer-Encoding: binary');
			header('Content-Length: '.sprintf('%d', $filesize));
			// More caching prevention
			header('Expires: 0');
			$ua = $_SERVER["HTTP_USER_AGENT"];
			if (preg_match("/MSIE/", $ua))
			{
				// Send IE headers
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');
			}
			else
			{
				// Send normal headers
				header('Pragma: no-cache');
			}
	
			$handle = fopen($file, 'rb');
			fpassthru($handle);
			fclose($handle);
		}
		else
			echo '找不到该文件';
	}
	/*
     * 拼接url条件字符串
     * array unset 排除掉的字段
     *  return string 
     */
	public static function get_url($array='',$unset=''){
		$str = "";
		if(is_array($array) && !empty($array)){			
			foreach ($array as $key => $value) {
				if($value!='' && !in_array($key, $unset)){					
					if($str != ''){
						$str .= "&";
					}
					$str .= $key.'='.$value;
				}
			}
		}
		return $str;
	}
	
	/*
     * 拼接where条件字符串
     * array unset 排除掉的字段
     *  return string 
     */
	public static function get_total($array='',$unset='',$other=''){
		$str = "";
		if(is_array($array) && !empty($array)){			
			foreach ($array as $key => $value) {
				if($value!='' && !in_array($key, $unset)){					
					if($str != ''){
						$str .= " and ";
					}
					$str .= $key.'='.$value;
				}
			}
			if($other!=''){
				foreach ($other as $keys => $item) {
					if($item!=''){					
						if($str != ''){
							$str .= " and ";
						}
						$str .= $keys.'='.$item;
					}
				}
			}
		}
		return $str;
	}

	/*
     * 拼接where条件语句
     * array
     * return string 
     */
    public static function get_where($array='',$unset=array('')){
        $str = '';
        if(is_array($array) && !empty($array)){
            foreach ($array as $key => $value) {
            	if(!empty($unset)){
            		if(in_array($key, $unset)){
            			continue;
            		}
            	}
            	
                if(is_array($value)){
                    foreach ($value as $keys => $item) {
                        if(!empty($item)){
                        	if($str != ''){
                			    $str .= " and ";
                			}
                        	if(strstr($key,"time")){
                        		$time = strtotime($item);
                            	$str .= $keys." '$time'";
                        	}else{
                        		$str .= $keys." '$item'";
                        	}
                        }                             
                    }
                }                
                if($value!='' && !is_array($value)){                    
                    if($str != ''){
                        $str .= " and ";
                    }
                    if(strstr($key,"like")){
                        if(strstr($key,"nickname")){
                            $tmpStr = json_encode($value); //暴露出unicode
                            $tmpStr = str_replace('"', '', $tmpStr);   
                            $tmpStr = str_replace('\\', '_', $tmpStr); 
                            $str .= $key." '%$tmpStr%'";
                        }else{
                            $str .= $key." '%$value%'";
                        }
                    }else{
                        $str .= $key.'='.$value;
                    }                
                }
            }
        }
        return $str;
    }
}