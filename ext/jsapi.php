<?php
class jsapi_ext
{
    /*
     * 生成access_token
     * return string   
     */
    public static function get_access_token(){
        $cache = cache::getClass();
        $access_token = '';
        if($cache->exists('access_token')){
            $access_token = $cache->get('access_token');
        }else{
            $appId = $cache->hGet('wechat',"appId");
            $secret = $cache->hGet('wechat',"appsecret");
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appId&secret=$secret";

            $req = request::getClass($url);
            $req->sendRequest();
            $json = $req->getResponseBody();
            $array = json_decode($json,true);
            if(isset($array['access_token'])){
                $access_token = $array['access_token'];
                $cache->setex('access_token',7000,$array['access_token']);  
            }      
        }
        return $access_token;
    }
    /*
     * 生成jsapi_ticket
     * return string   
     */
    public static function get_jsapi_ticket(){
        $cache = cache::getClass();
        $ticket = '';
        if($cache->exists('ticket')){
            $ticket = $cache->get('ticket');
        }else{
            $access_token = self::get_access_token();
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=$access_token&type=jsapi";
            $req = request::getClass($url);
            $req->sendRequest();
            $json = $req->getResponseBody();
            $array = json_decode($json,true);
            if($array['errcode'] == 0){
                $ticket = $array['ticket'];
                $cache->setex('ticket',7000,$array['ticket']);
            }               
        }        
        return $ticket;
    }
    /*
     * 生成签名
     * url（当前网页的URL，不包含#及其后面部分）
     */
    public static function get_signature($url=''){
        $signature = '';
        $cache = cache::getClass();
        $appId = $cache->hGet('wechat',"appId");
        $secret = $cache->hGet('wechat',"appsecret");
        $data['noncestr'] = self::getNonceStr();
        $data["timestamp"] = ''.time().'';
        $data['jsapi_ticket'] = self::get_jsapi_ticket();
        $data['url'] = $url; 
        ksort($data);
        $string1 = self::get_string($data);
        $data['signature'] = sha1($string1);
        $data['appId'] = $appId;
        $data['secret'] = $secret;
        return $data;
    }

    // 拼接字符串
    public static function get_string($array){
        $str = "";
        foreach ($array as $key => $value) {
            if($str != ""){
                $str .= '&';
            }
            $str .= $key.'='.$value;
        }
        return $str;
    }

    /*
     *
     */
    
    /**
     * 
     * 产生随机字符串，不长于32位
     * @param int $length
     * @return string 产生的随机字符串
     */
    public static function getNonceStr($length = 32) 
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";  
        $str ="";
        for ( $i = 0; $i < $length; $i++ )  {  
            $str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);  
        }
        return $str;
    }    

    /**
     * 生成签名
     * @return 签名，本函数不覆盖sign成员变量，如要设置签名需要调用SetSign方法赋值
     */
    public static function MakeSign($values)
    {
        //签名步骤一：按字典序排序参数
        ksort($values);
        $string = str_ext::ToUrlParams($values);
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=uszhzhtuokegongxiangzxaszxsazxa1";
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }

    /**
     * 格式化参数格式化成url参数
     */
    public static function ToUrlParams($values)
    {
        $buff = "";
        foreach ($values as $k => $v)
        {
            if($k != "sign" && $v != "" && !is_array($v)){
                $buff .= $k . "=" . $v . "&";
            }
        }
        
        $buff = trim($buff, "&");
        return $buff;
    }

    /**
     * 输出xml字符
     **/
    public static function ToXml($values)
    {
        if(!is_array($values) 
            || count($values) <= 0)
        {
            //throw new WxPayException("数组数据异常！");
        }
        
        $xml = "<xml>";
        foreach ($values as $key=>$val)
        {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml; 
    }

    /**
     * 将xml转为array
     * @param string $xml
     */
    public static function FromXml($xml)
    {
        if(!$xml){
            //throw new WxPayException("xml数据异常！");
        }
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);		
        return $values;
    }

    /**
     * 
     * 获取jsapi支付的参数
     * @param array $UnifiedOrderResult 统一支付接口返回的数据
     * @return json数据，可直接填入js函数作为参数
     */
    public static function GetJsApiParameters($UnifiedOrderResult)
    {
        if(!array_key_exists("appid", $UnifiedOrderResult)
        || !array_key_exists("prepay_id", $UnifiedOrderResult)
        || $UnifiedOrderResult['prepay_id'] == "")
        {
            //throw new WxPayException("参数错误");
        }
        $values = array();
        $cache = cache::getClass();
        $values['appId'] = $cache->hGet('wechat','appId');
        
        $values['timeStamp'] = ''.time().'';
        $values['nonceStr'] = str_ext::getNonceStr();
        $values['package'] = "prepay_id=" . $UnifiedOrderResult['prepay_id'];
        $values['signType'] = "MD5";
        $values['paySign'] = str_ext::MakeSign($values);

        //$parameters = json_encode($values);
        return $values;
    }
    
    
}