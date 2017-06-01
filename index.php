<?php	
	require dirname(__FILE__).'/../king.php';
	$config		= require(dirname(__FILE__).'/config/config.php');
	error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE);
	King::init($config,error_reporting());
