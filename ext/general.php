<?php

   class general_ext{
	   function  redirect($url,$error="",$time=0) {
			global $logger;
			while (strstr($url, '&&')) $url = str_replace('&&', '&', $url);
			while (strstr($url, '&amp;&amp;')) $url = str_replace('&amp;&amp;', '&amp;', $url);
			while (strstr($url, '&amp;')) $url = str_replace('&amp;', '&', $url);
			session_write_close();
			if ($error != ""){
			    echo '<script language="JavaScript">alert("'.$error.'");</script>';
			}
			echo "<meta http-equiv='Refresh' content='".$time.";URL=".$url."'>"; 
		    exit;
	  }
   }

function refreshto($url,$msg,$time=1){
    global $webdb;
	if($time==0){
		header("location:$url");
	}else{
		require(ROOT_PATH."template/default/refreshto.htm");
		$content=ob_get_contents();
		ob_end_clean();
		ob_start();
		if($webdb[www_url]=='/.'){
			$content=str_replace('/./','/',$content);
		}
		echo $content;
	}
	exit;
}