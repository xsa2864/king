<?php
class output_ext
{
	public static function tag($name,$type,$id=0,$left=0)
	{
		return '<div style="position: relative; z-index:9999; left:'.$left.'px">
				<a class="kingLabel" href="'.input::site('admin/tag/showTag/'.$name.'_'.$type.'_'.$id).'"></a>
			</div>';
	}
	
	public static function getCoverImg($pic,$type='60x60')
	{
		$pics	= unserialize($pic);
		$thumb	= '';
		if (is_array($pics) && count($pics)>0)
		{
			foreach ($pics as $key=>$value)
			{
				if (!isset($img))
				{
					$img	= $key;
				}
				if ($value ==1)
				{
					$p	= $key;
					break;
				}
			}
			if (!$p)
			{
				$p	= $img;
			}
			$thumb	= output_ext::getThumb($p,$type);
		}
      //  return $p;
		return $thumb;
	}
	
	public static function getThumb($name,$size)
	{
		$names    = explode('.',$name);
		return $names[0].'_'.$size.'.'.$names[1];
	}
    /*
    public static function loadLeft($viewName){
        $view = new View($viewName);
        return $view->render();
    }*/
	
	public static function getIndexHtml()
	{
		$content    = file_get_contents(input::site('admin/home/index'));
		$content	= preg_replace('/<div style="position: relative; z-index:9999; left:(\d+)px">(.*?)<\/div>/is','',$content);
		$content    = preg_replace('/<div class="sup_btn">(.*?)<\/script>/is','',$content);
		$content    = preg_replace('/<!--导航---><style type="text\/css">(.*?)<\/style>/is','',$content);
		return $content;
	}
	
	public static function jsHref($msg,$url)
	{
		echo '<script type="text/javascript" charset="utf-8">
			alert(\''.$msg.'\');
		</script>';
		input::redirect($url,'refresh');
	}
	
	public static function delImg($img,$size='200x50')
	{
        if(!is_file($img)){
            return false;
        }
		$thumb   = self::getThumb($img,$size);
		if (is_file($thumb))
		{
			unlink($thumb);
		}
		return @unlink($img);
	}		
	/**
     * 导出数据为excel表格
     * @param $data    一个二维数组,结构如同从数据库查出来的数组
     * @param $title   excel的第一行标题,一个数组,如果为空则没有标题
     * @param $filename  下载的文件名
     *@examlpe 
     $stu = M ('User');
     $arr = $stu -> select();
     exportexcel($arr,array('id','账户','密码','昵称'),'文件名!');
    */
    public static function exportexcel($data=array(),$title=array(),$filename='report'){
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Content-type:application/vnd.ms-excel");  
        header("Content-Disposition:attachment;filename=".$filename.".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        //导出xls 开始
        if (!empty($title)){
            foreach ($title as $k => $v) {
                $title[$k]=iconv("UTF-8", "GB2312",$v);
            }
            $title= implode("\t", $title);
            echo "$title\n";
        }
        if (!empty($data)){
            $rule = '/^14[0-9]{8}$/';
            foreach($data as $key=>$val){
                foreach ($val as $ck => $cv) {
                	if($ck == 'nickname'){
                		$data[$key][$ck] = iconv("UTF-8","GB2312//IGNORE", json_decode($cv));
                	}else{                		
	                	if(preg_match($rule,$cv)){
	                		$cv = date('Y-m-d H:i:s',$cv);
	                	}                		
	                    $data[$key][$ck]=iconv("UTF-8", "GB2312", $cv);
                	}
                }
                $data[$key]=implode("\t", $data[$key]);
            }
            echo implode("\n",$data);
        }
    }
	/**
     * 导出数据为csv表格
     * @param $data   	csv的第一行标题,一个数组,如果为空则没有标题
     * @param $filename  下载的文件名
     *@examlpe 
     $str = "姓名,性别,年龄\n";   
	 $str = iconv('utf-8','gb2312',$str);  
     while($row) {   
    	$name = iconv('utf-8','gb2312',$row['name']); //中文转码   
    	$sex = iconv('utf-8','gb2312',$row['sex']);   
    	$str .= $name.",".$sex.",".$row['age']."\n"; //用引文逗号分开   
	 }
    */
    public static function export_csv($filename,$data)   
	{   
	    header("Content-type:text/csv");   
	    header("Content-Disposition:attachment;filename=".$filename);   
	    header('Cache-Control:must-revalidate,post-check=0,pre-check=0');   
	    header('Expires:0');   
	    header('Pragma:public');   
	    echo $data;   
	}  
	/*
	 * fgetcsv有BUG 用这个替代
	 *
	 */
	public static function _fgetcsv(& $handle, $length = null, $d = ',', $e = '"') {
     	$d = preg_quote($d);
     	$e = preg_quote($e);
     	$_line = "";
     	$eof=false;
     	while ($eof != true) {
     	    $_line .= (empty ($length) ? fgets($handle) : fgets($handle, $length));
     	    $itemcnt = preg_match_all('/' . $e . '/', $_line, $dummy);
     	    if ($itemcnt % 2 == 0)
     	        $eof = true;
     	}
     	$_csv_line = preg_replace('/(?: |[ ])?$/', $d, trim($_line));
     	$_csv_pattern = '/(' . $e . '[^' . $e . ']*(?:' . $e . $e . '[^' . $e . ']*)*' . $e . '|[^' . $d . ']*)' . $d . '/';
     	preg_match_all($_csv_pattern, $_csv_line, $_csv_matches);
     	$_csv_data = $_csv_matches[1];
     	for ($_csv_i = 0; $_csv_i < count($_csv_data); $_csv_i++) {
     	    $_csv_data[$_csv_i] = preg_replace('/^' . $e . '(.*)' . $e . '$/s', '$1' , $_csv_data[$_csv_i]);
     	    $_csv_data[$_csv_i] = str_replace($e . $e, $e, $_csv_data[$_csv_i]);
     	}
     	return empty ($_line) ? false : $_csv_data;
	} 
}