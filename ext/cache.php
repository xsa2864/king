<?php
/**
 * 缓存扩展函数库
 * @author xilin
 *
 */
class cache_ext
{

	public function getCache($sqlStr,$time=3600)
	{
		$cache	= cache::getClass();
		$key	= md5($sqlStr);
		$data	= $cache->get($key);
		if ($data === false)
		{
			eval('$data ='.$sqlStr.';');
			$cache->set($key,$data,$time);
		}
		return $data;
	}
	
	public function getLiteBySql($sqlStr,$time=NULL)
	{
		$lite		= lite::getClass(array('lifeTime'=>$time));
		$key		= md5($sqlStr);
		$data		= $lite->get($key);
		$data		= $cache->get($key);
		if ($data === false)
		{
			eval('$data ='.$sqlStr.';');
			$lite->set($data);
		}
		return $data;
	}
	
	public function getLiteByContent($url,$time=NULL)
	{
		$lite		= lite::getClass(array('lifeTime'=>$time));
		$key		= md5($url);
		$content	= $lite->get($key);
		if ($content === false)
		{
			$content	= file_get_contents($url);
			$lite->set($content);
		}
		return $content;
	}
	
}