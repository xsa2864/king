<?php 
if (isset($_SERVER['TESTENV'])) //用于测试环境，apache SETENV TESTENV; nginx fastcgi_param TESTENV;
{
	return array(
		'default'	=> array(
				'user'			=> 'battery',
				'passwd'		=> '123456',
				'hosts'			=> '192.168.1.101',
				'dbname'		=> 'battery',
				'prefix'		=> 'tf_',
				'charset'		=> 'utf8'
		),
		//主从时定义： 	'defaultSlave'	=> array(array(
		// 				'user'			=> 'root',
		// 				'passwd'		=> 'xiling',
		// 				'hosts'			=> 'localhost',
		// 				'dbname'		=> 'tt2',
		// 				'prefix'		=> 't_',
		// 				'charset'		=> 'utf8'
		// 			)
		// 	),
		'king'	=> array(
				'user'			=> 'root',
				'passwd'		=> '123456',
				'hosts'			=> 'localhost',
				'dbname'		=> 'king',
				'prefix'		=> '',
				'charset'		=> 'utf8'
		)
	);
}
else 
{
	return array(
			'default'	=> array(
					'user'			=> 'mysql_mall',
					'passwd'		=> 'bpDACbD',
					'hosts'			=> 'localhost',
					'dbname'		=> 'mall',
					'prefix'		=> 'tf_',
					'charset'		=> 'utf8'
			),
			'king'	=> array(
					'user'			=> 'root',
					'passwd'		=> '123456',
					'hosts'			=> 'localhost',
					'dbname'		=> 'king',
					'prefix'		=> '',
					'charset'		=> 'utf8'
			)
	);	
}