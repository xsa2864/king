<?php
/**
 * 短信相关函数
 * @author xilin
 *
 */
	class sms_ext
	{
		//发送手机短信
		
		public static function send($mobile,$content,$sendTime="")
        {
            if(isset($_SERVER['TESTENV']))
            {
                return 1;
            }
            $val = valid::getClass();
            $val->mobile($mobile,$lab);
            $lab = $val->getError();
            if($lab)
            {
                return $lab;
            }
            $config    = C('smsConfig');
            $account   = $config['account'];
            $password  = $config['password'];
            $url="http://www.jianzhou.sh.cn/JianzhouSMSWSServer/http/sendBatchMessage";
            $post_data = array();
            $post_data['account'] = $account;
            $post_data['destmobile'] = $mobile;									
            $post_data['msgText'] =  $content;
            $post_data['password'] = $password;
            $req = request::getClass($url, 'POST');
            $req->setBody($post_data);
            $req->sendRequest();
            $msg = rawurldecode($req->getResponseBody());
            if($msg>0)
            {
                $ret=1;			//发送成功
            }
            else
            {
                $ret='发送失败（'.$msg.')';
            }
            return $ret;
		}
		
		public static function sockOpenUrl($url,$method='GET',$postValue='',$Referer='Y'){
			if($Referer=='Y'){
				$Referer=$url;
			}
			$method = strtoupper($method);
			if(!$url){
				return '';
			}elseif(strstr("://",$url)){
				$url="http://$url";
			}
			$urldb=parse_url($url);
			$port=$urldb[port]?$urldb[port]:80;
			$host=$urldb[host];
			$query='?'.$urldb[query];
			$path=$urldb[path]?$urldb[path]:'/';
			$method=$method=='GET'?"GET":'POST';
			if(function_exists('fsockopen')){
				$fp = fsockopen($host, $port, $errno, $errstr, 30);
			}elseif(function_exists('pfsockopen')){
				$fp = pfsockopen($host, $port, $errno, $errstr, 30);
			}elseif(function_exists('stream_socket_client')){
				$fp = stream_socket_client($host.':'.$port, $errno, $errstr, 30);
			}else{
				die("服务器不支持以下函数:fsockopen,pfsockopen,stream_socket_client操作失败!");
			}
			if(!$fp)
			{
				echo "$errstr ($errno)<br />\n";
			}
			else
			{
				$out = "$method $path$query HTTP/1.1\r\n";
				$out .= "Host: $host\r\n";
				$out .= "Cookie: c=1;c2=2\r\n";
				$out .= "Referer: $Referer\r\n";
				$out .= "Accept: */*\r\n";
				$out .= "Connection: Close\r\n";
				if ( $method == "POST" ) {
					$out .= "Content-Type: application/x-www-form-urlencoded\r\n";
					$length = strlen($postValue);
					$out .= "Content-Length: $length\r\n";
					$out .= "\r\n";
					$out .= $postValue;
				}else{
					$out .= "\r\n";
				}
				fwrite($fp, $out);
				while (!feof($fp)) {
					$file.= fgets($fp, 256);
				}
				fclose($fp);
				if(!$file){
					return '';
				}
				$ck=0;
				$string='';
				$detail=explode("\r\n",$file);
				foreach( $detail AS $key=>$value){
					if($value==''){
						$ck++;
						if($ck==1){
							continue;
						}
					}
					if($ck){
						$stringdb[]=$value;
					}
				}
				$string=implode("\r\n",$stringdb);
				//$string=preg_replace("/([\d]+)(.*)0/is","\\2",$string);
				return $string;
			}
		}
		

		/**
		 * 邮件发送
		 *
		 * @param: $name[string]        接收人姓名
		 * @param: $email[string]       接收人邮件地址
		 * @param: $subject[string]     邮件标题
		 * @param: $content[string]     邮件内容
		 * @param: $type[int]           0 普通邮件， 1 HTML邮件
		 * @param: $notification[bool]  true 要求回执， false 不用回执
		 *
		 * @return boolean
		 */
		public static function send_mail($array, $type=0, $notification=false)
		{
			//[smtphost] => smtp.163.com
			//[smtpport] => 25
			//[smtpuser] => leeinsoo@163.com
			//[smtppass] => love03liuye
			//[replyemail] => leeinsoo@163.com
			//[testmailaddress] =>
			//[mailservice] => 0
		
		
			/**
			 * 使用mail函数发送邮件
			 */
			$email     = trim($array["test_mail_address"]);
			$charset   = "UTF8";
			$content   = "abC";
			$name      = "";
			$shop_name = "酒泉网";
			$subject   = "subject";
			if ($array['mailservice'] == 0 && function_exists('mail'))
			{
				/* 邮件的头部信息 */
				$content_type = ($type == 0) ? 'Content-Type: text/plain; charset=UTF8' : 'Content-Type: text/html; charset=UTF8';
				$headers = array();
				$headers[] = 'From: "' . '=?' . $charset . '?B?' . base64_encode("酒泉网") . '?='.'" <' . $array['reply_email'] . '>';
				$headers[] = $content_type . '; format=flowed';
				if ($notification)
				{
					$headers[] = 'Disposition-Notification-To: ' . '=?' . $charset . '?B?' . base64_encode("酒泉网") . '?='.'" <' . $array['reply_email'] . '>';
				}
				echo implode("\r\n", $headers);
				$res = @mail($email, '=?' . $charset . '?B?' . base64_encode("subject") . '?=', $content, implode("\r\n", $headers));
		
				if (!$res)
				{
		
					return false;
				}
				else
				{
					return true;
				}
			}
			/**
			 * 使用smtp服务发送邮件
			 */
			else
			{
		
				/* 邮件的头部信息 */
				$content_type = ($type == 0) ?
				'Content-Type: text/plain; charset=' . $charset : 'Content-Type: text/html; charset=' . $charset;
				$content   =  base64_encode($content);
		
				$headers = array();
				$headers[] = 'Date: ' . gmdate('D, j M Y H:i:s') . ' +0000';
				$headers[] = 'To: "' . '=?' . $charset . '?B?' . base64_encode($name) . '?=' . '" <' . $email. '>';
				$headers[] = 'From: "' . '=?' . $charset . '?B?' . base64_encode($shop_name) . '?='.'" <' . $array['reply_email'] . '>';
				$headers[] = 'Subject: ' . '=?' . $charset . '?B?' . base64_encode($subject) . '?=';
				$headers[] = $content_type . '; format=flowed';
				$headers[] = 'Content-Transfer-Encoding: base64';
				$headers[] = 'Content-Disposition: inline';
				if ($notification)
				{
					$headers[] = 'Disposition-Notification-To: ' . '=?' . $charset . '?B?' . base64_encode("酒泉网") . '?='.'" <' . $array['reply_email'] . '>';
				}
		
				/* 获得邮件服务器的参数设置 */
				$params['host'] = $array['smtphost'];
				$params['port'] = $array['smtpport'];
				$params['user'] = $array['smtpuser'];
				$params['pass'] = $array['smtppass'];
		
				if (empty($params['host']) || empty($params['port']))
				{
					return false;
				}
				else
				{
					// 发送邮件
					if (!function_exists('fsockopen'))
					{
						//如果fsockopen被禁用，直接返回
						return false;
					}
		
					include_once(ROOT_PATH . 'includes/cls_smtp.php');
					static $smtp;
		
					$send_params['recipients'] = $email;
					$send_params['headers']    = $headers;
					$send_params['from']       = $array['smtpmail'];
					$send_params['body']       = $content;
		
					if (!isset($smtp))
					{
						$smtp = new smtp($params);
					}
		
					if ($smtp->connect() && $smtp->send($send_params))
					{
						return true;
					}
					else
					{
						$err_msg = $smtp->error_msg();
						if (empty($err_msg))
						{
							$GLOBALS['err']->add('Unknown Error');
						}
						else
						{
							if (strpos($err_msg, 'Failed to connect to server') !== false)
							{
								$GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['smtp_connect_failure'], $params['host'] . ':' . $params['port']));
							}
							else if (strpos($err_msg, 'AUTH command failed') !== false)
							{
								$GLOBALS['err']->add($GLOBALS['_LANG']['smtp_login_failure']);
							}
							elseif (strpos($err_msg, 'bad sequence of commands') !== false)
							{
								$GLOBALS['err']->add($GLOBALS['_LANG']['smtp_refuse']);
							}
							else
							{
								$GLOBALS['err']->add($err_msg);
							}
						}
		
						return false;
					}
				}
			}
		}		
	}
?>