<?php 
return array(
	'directory'				=> 'upload',
	'allowTypes'			=> array('jpg','jpeg','gif','bmp','png','doc','docx','xls','xlsx','ppt','pptx','pdf','txt'),
	'allowImgType'			=> array('jpg','jpeg','gif','png'),
	'maxSize'				=> '2M',//允许上传的附件大小，K,M要用大写
    'tempPath'                      => dirname(__FILE__).'/../temp/'    //temp目录的绝对路径
);
