<?php
/*
 * 请确保您的libcurl版本是否支持双向认证，版本高于7.20.1
 * 退款接口
 */
class return_ext
{
	function curl_post_ssl($url, $vars, $second=30,$aHeader=array()){
		$ch = curl_init();
		//超时时间
		curl_setopt($ch,CURLOPT_TIMEOUT,$second);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
		//这里设置代理，如果有的话
		//curl_setopt($ch,CURLOPT_PROXY, '10.206.30.98');
		//curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
		
		//以下两种方式需选择一种
		
		//第一种方法，cert 与 key 分别属于两个.pem文件
		//默认格式为PEM，可以注释
		curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
		// curl_setopt($ch,CURLOPT_SSLCERT,$arr['path_cert']);
		curl_setopt($ch,CURLOPT_SSLCERT,$GLOBALS['config']['pemurl'].'/apiclient_cert.pem');
		//默认格式为PEM，可以注释
		curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
		// curl_setopt($ch,CURLOPT_SSLKEY,$arr['path_key']);
		 curl_setopt($ch,CURLOPT_SSLKEY,$GLOBALS['config']['pemurl'].'/apiclient_key.pem');
		
		//第二种方式，两个文件合成一个.pem文件
		// curl_setopt($ch,CURLOPT_SSLCERT,getcwd().'/all.pem');
	 
		if( count($aHeader) >= 1 ){
			curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
		}
	 
		curl_setopt($ch,CURLOPT_POST, 1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$vars);
		$data = curl_exec($ch);
		if($data){
			curl_close($ch);
			return $data;
		}else { 
			$error = curl_errno($ch);
			echo "call faild, errorCode:$error\n"; 
			curl_close($ch);
			return false;
		}
	}


	public static function returnPay($order_sn='',$price=0,$return_price=0)
	{
		$cache = cache::getClass();
        $arr = $cache->hGetAll("wechat");
       
		$appid	= $arr['appId'];		//公众账号ID
		$mch_id	= $arr['mchid'];		//商户号
		$nonce_str = mt_rand(1,999999); //随机字符串
		$op_user_id	= $arr['mchid'];	//操作员
		$out_refund_no	= $order_sn; 			//商户退款单号
		$out_trade_no	= $order_sn;			//商户订单号
		$refund_fee	= $return_price*100;		//退款金额
		$total_fee	= $price*100;				//订单金额

		$data['appid'] = $appid;
		$data['mch_id'] = $mch_id;
		$data['nonce_str'] = $nonce_str;
		$data['out_trade_no'] = $out_trade_no;
		$data['out_refund_no'] = $out_refund_no;
		$data['total_fee'] = $total_fee;
		$data['refund_fee'] = $refund_fee;
		$data['op_user_id'] = $op_user_id;
		$data['sign'] = str_ext::MakeSign($data);

		$url = 'https://api.mch.weixin.qq.com/secapi/pay/refund';	//申请退款请求地址
		$xml = str_ext::ToXml($data); //把array格式转换成xml格式

		$result = self::curl_post_ssl($url, $xml);
		$array = str_ext::FromXml($result);
		return $array;
		
	}	

	/*
	 * xml格式转换成array
	 * $xml   $type 0  函数把 XML 字符串载入对象中。  1 函数把 XML 文档载入对象中。
	 */
	public static function xmltoarray($xml='',$type=0){
		if($type == 0){
			$object = simplexml_load_string($xml);
		}else{
			$object = simplexml_load_file($xml);
		}
		$array = json_decode(json_encode($object),true);
		return $array;
	}

	// array转化成xml
	public static function arrayToXml($arr,$dom=0,$item=0){
    	if (!$dom){
    	    $dom = new DOMDocument("1.0");
    	}
    	if(!$item){
    	    $item = $dom->createElement("root"); 
    	    $dom->appendChild($item);
    	}
    	foreach ($arr as $key=>$val){
    	    $itemx = $dom->createElement(is_string($key)?$key:"item");
    	    $item->appendChild($itemx);
    	    if (!is_array($val)){
    	        $text = $dom->createTextNode($val);
    	        $itemx->appendChild($text);
    	        
    	    }else {
    	        arrtoxml($val,$dom,$itemx);
    	    }
    	}
    	return $dom->saveXML();
	}

	/*
     * 微信红包
     * 赠送的会员openid  价格price
     */
    public static function send_money($openid='',$price=0){
    	$cache = cache::getClass();
        $arr = $cache->hGetAll("wechat");
		$mch_id	= $arr['mchid'];		//商户号

		$data['nonce_str'] 	= str_ext::getNonceStr(30);
    	$data['mch_billno'] = $mch_id.date('Ymd',time()).substr(time(),5).mt_rand(10000,99999);    	
		$data['mch_id'] 	= $mch_id;
		$data['wxappid']	= $arr['appId'];
		$data['send_name'] 	= $arr['send_name'];
		$data['re_openid'] 	= $openid;
		$data['total_amount'] = $price*100;
		$data['total_num'] = 1;
		$data['wishing'] = $arr['wishing'];
		$data['client_ip'] = $_SERVER["REMOTE_ADDR"];
		$data['act_name'] = $arr['act_name'];
		$data['remark'] = $arr['remark'];
		$data['sign'] = str_ext::MakeSign($data);	

		$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';	//申请退款请求地址
		$xml = str_ext::ToXml($data); //把array格式转换成xml格式

		$result = self::curl_post_ssl($url, $xml);
		// file_put_contents('upload/return/'.date('Y-m-d',time()).'.txt',date('H:i:s',time()).':红包=1>'.$result."\t\n",FILE_APPEND);
		$array = str_ext::FromXml($result);
		return $array;
    }
}