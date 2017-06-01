<?php 
if (isset($_SERVER['TESTENV'])) //用于测试环境，必须定义TESTENV
{
	return array(
			'domain'	=> 'www.battery.com',//若未设置host，可以定义为localhost/example
			'folder'	=> 'battery',
			'basePath'	=> dirname(__FILE__).DS,
			'md5Key'	=> 'ambush.xilin',
            'basePath'	=> dirname(__FILE__).DS,
			'displayError'	=> true,
			'log'		=> true,
			'suffix'	=> '.html',
            'expireHour'	=> 48,//文件过期小时数
			'apps'		=> array(array('id'=>'solid','app'=>'后台')),
			'fonts'	    => array(array('id'=>0,'text'=>'字体选择'),array('id'=>'bold','text'=>'加粗'),array('id'=>'italic','text'=>'斜体'),array('id'=>'underline','text'=>'下划线')),
			'memcache'	=> array(array('host'=>'192.168.1.101','port'=>11211,'persist'=>false)),
			'redis'		=> array('host'=>'192.168.1.101','port'=>6379,'password'=>'B2qV4Yh','db'=>14),
			'defaultPwd'	=> '123456',
			'defaultGid'	=> 6,
            'pemurl'	=> '/data/pem',
			'article'	=> '文章分类'
	);
}
else 
{
	return array(
			'domain'	=> 'tok.uszhzh.com',//若未设置host，可以定义为localhost/example
			'folder'	=> 'tuoke',
			'basePath'	=> dirname(__FILE__).DS,
			'md5Key'	=> 'ambush.xilin',
			'displayError'	=> false,
			'log'		=> true,
			'defaultPwd'	=> '123456',
			'defaultGid'	=> 6,
			'memcache'	=> array(array('host'=>'127.0.0.1','port'=>11211,'persist'=>false)),
			'redis'		=> array('host'=>'127.0.0.1','port'=>6379,'password'=>'AU37HWKu','db'=>10),
            'pemurl'	=> '/data/pem',
			'suffix'	=> '.html'
	);	
}
