<?php 
return array(
	'_default'		=> 'mobile/goods/index', 
	'admin'         => 'admin/login',
	'head'         => 'headquarters/login',
	'login'			=> 'mobile/login/login',	
	'index-(\w+)'		=> 'mobile/index/$1',
	'goods-(\d+)'		=> 'hello/groupGoods/$1',
	'detail-(\d+)'		=> 'www/goods/detailed/$1',
	'fav-index'			=> 'www/favorite/index',
	'fav-(.*?)'			=> 'www/favorite/index/$1',
	'user-(\w+)'		=> 'www/user/$1',
	'order-(.*?)'		=> 'www/order/$1',
	'cart-(\w+)'		=> 'www/cart/$1',
	'login-(\w+)'		=> 'mobile/login/$1',	
	'address-(\w+)'		=> 'www/address/$1',
	'help-(\w+)'		=> 'www/help/index/$1',
	'integral-(\w+)'	=> 'www/integral/$1',
	'pay/(\w+)'			=> 'www/pay/$1',
	'list-c(.*?)-q(.*?)-d(.*?)-o(\d+)-k(.*?)-p(\d+)'	=> 'www/goods/goodsList/$1/$2/$3/$4/$5/$6',
    'wechat'            => 'wechat/main',
    'mobile'            => 'mobile/goods/index'
);