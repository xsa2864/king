<?php
class str_ext
{
    /**
     * 取得字符串拼音
     * @param string $value
     * @param number $first 是否取得拼音首字母，1为是
     */
    public static function getPinyin($value,$first=1)
    {
        $value		= iconv("utf-8","gbk",$value);
        $convert 	= array ('a' => '-20319', 'ai' => '-20317', 'an' => '-20304', 'ang' => '-20295', 'ao' => '-20292', 'ba' => '-20283', 'bai' => '-20265', 'ban' => '-20257', 'bang' => '-20242', 'bao' => '-20230', 'bei' => '-20051', 'ben' => '-20036', 'beng' => '-20032', 'bi' => '-20026', 'bian' => '-20002', 'biao' => '-19990', 'bie' => '-19986', 'bin' => '-19982', 'bing' => '-19976', 'bo' => '-19805', 'bu' => '-19784', 'ca' => '-19775', 'cai' => '-19774', 'can' => '-19763', 'cang' => '-19756', 'cao' => '-19751', 'ce' => '-19746', 'ceng' => '-19741', 'cha' => '-19739', 'chai' => '-19728', 'chan' => '-19725', 'chang' => '-19715', 'chao' => '-19540', 'che' => '-19531', 'chen' => '-19525', 'cheng' => '-19515', 'chi' => '-19500', 'chong' => '-19484', 'chou' => '-19479', 'chu' => '-19467', 'chuai' => '-19289', 'chuan' => '-19288', 'chuang' => '-19281', 'chui' => '-19275', 'chun' => '-19270', 'chuo' => '-19263', 'ci' => '-19261', 'cong' => '-19249', 'cou' => '-19243', 'cu' => '-19242', 'cuan' => '-19238', 'cui' => '-19235', 'cun' => '-19227', 'cuo' => '-19224', 'da' => '-19218', 'dai' => '-19212', 'dan' => '-19038', 'dang' => '-19023', 'dao' => '-19018', 'de' => '-19006', 'deng' => '-19003', 'di' => '-18996', 'dian' => '-18977', 'diao' => '-18961', 'die' => '-18952', 'ding' => '-18783', 'diu' => '-18774', 'dong' => '-18773', 'dou' => '-18763', 'du' => '-18756', 'duan' => '-18741', 'dui' => '-18735', 'dun' => '-18731', 'duo' => '-18722', 'e' => '-18710', 'en' => '-18697', 'er' => '-18696', 'fa' => '-18526', 'fan' => '-18518', 'fang' => '-18501', 'fei' => '-18490', 'fen' => '-18478', 'feng' => '-18463', 'fo' => '-18448', 'fou' => '-18447', 'fu' => '-18446', 'ga' => '-18239', 'gai' => '-18237', 'gan' => '-18231', 'gang' => '-18220', 'gao' => '-18211', 'ge' => '-18201', 'gei' => '-18184', 'gen' => '-18183', 'geng' => '-18181', 'gong' => '-18012', 'gou' => '-17997', 'gu' => '-17988', 'gua' => '-17970', 'guai' => '-17964', 'guan' => '-17961', 'guang' => '-17950', 'gui' => '-17947', 'gun' => '-17931', 'guo' => '-17928', 'ha' => '-17922', 'hai' => '-17759', 'han' => '-17752', 'hang' => '-17733', 'hao' => '-17730', 'he' => '-17721', 'hei' => '-17703', 'hen' => '-17701', 'heng' => '-17697', 'hong' => '-17692', 'hou' => '-17683', 'hu' => '-17676', 'hua' => '-17496', 'huai' => '-17487', 'huan' => '-17482', 'huang' => '-17468', 'hui' => '-17454', 'hun' => '-17433', 'huo' => '-17427', 'ji' => '-17417', 'jia' => '-17202', 'jian' => '-17185', 'jiang' => '-16983', 'jiao' => '-16970', 'jie' => '-16942', 'jin' => '-16915', 'jing' => '-16733', 'jiong' => '-16708', 'jiu' => '-16706', 'ju' => '-16689', 'juan' => '-16664', 'jue' => '-16657', 'jun' => '-16647', 'ka' => '-16474', 'kai' => '-16470', 'kan' => '-16465', 'kang' => '-16459', 'kao' => '-16452', 'ke' => '-16448', 'ken' => '-16433', 'keng' => '-16429', 'kong' => '-16427', 'kou' => '-16423', 'ku' => '-16419', 'kua' => '-16412', 'kuai' => '-16407', 'kuan' => '-16403', 'kuang' => '-16401', 'kui' => '-16393', 'kun' => '-16220', 'kuo' => '-16216', 'la' => '-16212', 'lai' => '-16205', 'lan' => '-16202', 'lang' => '-16187', 'lao' => '-16180', 'le' => '-16171', 'lei' => '-16169', 'leng' => '-16158', 'li' => '-16155', 'lia' => '-15959', 'lian' => '-15958', 'liang' => '-15944', 'liao' => '-15933', 'lie' => '-15920', 'lin' => '-15915', 'ling' => '-15903', 'liu' => '-15889', 'long' => '-15878', 'lou' => '-15707', 'lu' => '-15701', 'lv' => '-15681', 'luan' => '-15667', 'lue' => '-15661', 'lun' => '-15659', 'luo' => '-15652', 'ma' => '-15640', 'mai' => '-15631', 'man' => '-15625', 'mang' => '-15454', 'mao' => '-15448', 'me' => '-15436', 'mei' => '-15435', 'men' => '-15419', 'meng' => '-15416', 'mi' => '-15408', 'mian' => '-15394', 'miao' => '-15385', 'mie' => '-15377', 'min' => '-15375', 'ming' => '-15369', 'miu' => '-15363', 'mo' => '-15362', 'mou' => '-15183', 'mu' => '-15180', 'na' => '-15165', 'nai' => '-15158', 'nan' => '-15153', 'nang' => '-15150', 'nao' => '-15149', 'ne' => '-15144', 'nei' => '-15143', 'nen' => '-15141', 'neng' => '-15140', 'ni' => '-15139', 'nian' => '-15128', 'niang' => '-15121', 'niao' => '-15119', 'nie' => '-15117', 'nin' => '-15110', 'ning' => '-15109', 'niu' => '-14941', 'nong' => '-14937', 'nu' => '-14933', 'nv' => '-14930', 'nuan' => '-14929', 'nue' => '-14928', 'nuo' => '-14926', 'o' => '-14922', 'ou' => '-14921', 'pa' => '-14914', 'pai' => '-14908', 'pan' => '-14902', 'pang' => '-14894', 'pao' => '-14889', 'pei' => '-14882', 'pen' => '-14873', 'peng' => '-14871', 'pi' => '-14857', 'pian' => '-14678', 'piao' => '-14674', 'pie' => '-14670', 'pin' => '-14668', 'ping' => '-14663', 'po' => '-14654', 'pu' => '-14645', 'qi' => '-14630', 'qia' => '-14594', 'qian' => '-14429', 'qiang' => '-14407', 'qiao' => '-14399', 'qie' => '-14384', 'qin' => '-14379', 'qing' => '-14368', 'qiong' => '-14355', 'qiu' => '-14353', 'qu' => '-14345', 'quan' => '-14170', 'que' => '-14159', 'qun' => '-14151', 'ran' => '-14149', 'rang' => '-14145', 'rao' => '-14140', 're' => '-14137', 'ren' => '-14135', 'reng' => '-14125', 'ri' => '-14123', 'rong' => '-14122', 'rou' => '-14112', 'ru' => '-14109', 'ruan' => '-14099', 'rui' => '-14097', 'run' => '-14094', 'ruo' => '-14092', 'sa' => '-14090', 'sai' => '-14087', 'san' => '-14083', 'sang' => '-13917', 'sao' => '-13914', 'se' => '-13910', 'sen' => '-13907', 'seng' => '-13906', 'sha' => '-13905', 'shai' => '-13896', 'shan' => '-13894', 'shang' => '-13878', 'shao' => '-13870', 'she' => '-13859', 'shen' => '-13847', 'sheng' => '-13831', 'shi' => '-13658', 'shou' => '-13611', 'shu' => '-13601', 'shua' => '-13406', 'shuai' => '-13404', 'shuan' => '-13400', 'shuang' => '-13398', 'shui' => '-13395', 'shun' => '-13391', 'shuo' => '-13387', 'si' => '-13383', 'song' => '-13367', 'sou' => '-13359', 'su' => '-13356', 'suan' => '-13343', 'sui' => '-13340', 'sun' => '-13329', 'suo' => '-13326', 'ta' => '-13318', 'tai' => '-13147', 'tan' => '-13138', 'tang' => '-13120', 'tao' => '-13107', 'te' => '-13096', 'teng' => '-13095', 'ti' => '-13091', 'tian' => '-13076', 'tiao' => '-13068', 'tie' => '-13063', 'ting' => '-13060', 'tong' => '-12888', 'tou' => '-12875', 'tu' => '-12871', 'tuan' => '-12860', 'tui' => '-12858', 'tun' => '-12852', 'tuo' => '-12849', 'wa' => '-12838', 'wai' => '-12831', 'wan' => '-12829', 'wang' => '-12812', 'wei' => '-12802', 'wen' => '-12607', 'weng' => '-12597', 'wo' => '-12594', 'wu' => '-12585', 'xi' => '-12556', 'xia' => '-12359', 'xian' => '-12346', 'xiang' => '-12320', 'xiao' => '-12300', 'xie' => '-12120', 'xin' => '-12099', 'xing' => '-12089', 'xiong' => '-12074', 'xiu' => '-12067', 'xu' => '-12058', 'xuan' => '-12039', 'xue' => '-11867', 'xun' => '-11861', 'ya' => '-11847', 'yan' => '-11831', 'yang' => '-11798', 'yao' => '-11781', 'ye' => '-11604', 'yi' => '-11589', 'yin' => '-11536', 'ying' => '-11358', 'yo' => '-11340', 'yong' => '-11339', 'you' => '-11324', 'yu' => '-11303', 'yuan' => '-11097', 'yue' => '-11077', 'yun' => '-11067', 'za' => '-11055', 'zai' => '-11052', 'zan' => '-11045', 'zang' => '-11041', 'zao' => '-11038', 'ze' => '-11024', 'zei' => '-11020', 'zen' => '-11019', 'zeng' => '-11018', 'zha' => '-11014', 'zhai' => '-10838', 'zhan' => '-10832', 'zhang' => '-10815', 'zhao' => '-10800', 'zhe' => '-10790', 'zhen' => '-10780', 'zheng' => '-10764', 'zhi' => '-10587', 'zhong' => '-10544', 'zhou' => '-10533', 'zhu' => '-10519', 'zhua' => '-10331', 'zhuai' => '-10329', 'zhuan' => '-10328', 'zhuang' => '-10322', 'zhui' => '-10315', 'zhun' => '-10309', 'zhuo' => '-10307', 'zi' => '-10296', 'zong' => '-10281', 'zou' => '-10274', 'zu' => '-10270', 'zuan' => '-10262', 'zui' => '-10260', 'zun' => '-10256', 'zuo' => '-10254' );
        $ret		= '';
        for($i=0;$i<strlen($value);$i++)
        {
            $sp	= substr($value,$i,2);
            $p	= ord(substr($value,$i,1));
            if ($p>160)
            {
                $q	= ord(substr($value,++$i,1));
                $p	= $p*256+$q-65536;
            }
            if ($p >0 && $p<160)
                $m 	= chr($p);
            elseif($p<-20319||$p>-10247)
            {
                $m	= '';
            }
            else
            {
                krsort($convert);
                foreach ($convert as $k=>$v)
                {
                    if ($v <= $p)
                    {
                        $m	= $k;
                        break;
                    }
                }
            }
            if ($first)
                $m	= substr($m,0,1);
            $ret	.= $m;
        } 		
        return $ret;
    }

    /**
     * utf-8格式的字符串截取
     * @param string $str
     * @param int $start
     * @param int $length
     */
    public static function msubstr($str, $start, $length=NULL)
    {
        preg_match_all("/./u", $str, $ar);
        if(func_num_args() >= 3) {
            $end = func_get_arg(2);
            return join("",array_slice($ar[0],$start,$end));
        } 
        else 
            return join("",array_slice($ar[0],$start));
    }	
    
    /**
     * 取得随机字符串
     * @param number $length 随机字符串长度
     * @param string $type 随机的类型
    
     */
    public static function random($length = 8,$type = 'alnum')
    {
        $utf8 = FALSE;
		
        switch ($type)
        {
            case 'alnum':
                $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            case 'alpha':
                $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            case 'hexdec':
                $pool = '0123456789abcdef';
                break;
            case 'numeric':
                $pool = '0123456789';
                break;
            case 'nozero':
                $pool = '123456789';
                break;
            case 'distinct':
                $pool = '2345679ACDEFHJKLMNPRSTUVWXYZ';
                break;
            default:
                $pool = (string) $type;
                $utf8 = ! text::is_ascii($pool);
                break;
        }
		
        $pool = ($utf8 === TRUE) ? utf8::str_split($pool, 1) : str_split($pool, 1);
		
        $max = count($pool) - 1;
		
        $str = '';
        for ($i = 0; $i < $length; $i++)
        {
            $str .= $pool[mt_rand(0, $max)];
        }
		
        if ($type === 'alnum' AND $length > 1)
        {
            if (ctype_alpha($str))
            {
                $str[mt_rand(0, $length - 1)] = chr(mt_rand(48, 57));
            }
            elseif (ctype_digit($str))
            {
                $str[mt_rand(0, $length - 1)] = chr(mt_rand(65, 90));
            }
        }
		
        return $str;
    }
    
    /**
     * 密码强度判断
     * @param string $passwd
     * @return number
     */
    public static function passwdStrength($passwd){
        $score = 0;
        if(preg_match("/[0-9]+/",$passwd))
        {
            $score ++;
        }
        if(preg_match("/[0-9]{3,}/",$passwd))
        {
            $score ++;
        }
        if(preg_match("/[a-z]+/",$passwd))
        {
            $score ++;
        }
        if(preg_match("/[a-z]{3,}/",$passwd))
        {
            $score ++;
        }
        if(preg_match("/[A-Z]+/",$passwd))
        {
            $score ++;
        }
        if(preg_match("/[A-Z]{3,}/",$passwd))
        {
            $score ++;
        }
        if(preg_match("/[_|\-|+|=|*|!|@|#|$|%|^|&|(|)]+/",$passwd))
        {
            $score += 2;
        }
        if(preg_match("/[_|\-|+|=|*|!|@|#|$|%|^|&|(|)]{3,}/",$passwd))
        {
            $score ++ ;
        }
        if(strlen($passwd) >= 10)
        {
            $score ++;
        }
        return $score;
    }

    /**
     * 分类列表
     * @return array[]
     */
    public static function getTree()
    {
        $account_id = accountInfo_ext::accountId(); 
        $rs			= M('category')->where(array('pid'=>0,'account_id'=>$account_id))->execute();
        $mods	= array('');
        foreach ($rs as $row)
        {
            $rs2	= M('category')->where(array('pid'=>$row->id))->execute();
            $array2	= array();
            foreach ($rs2 as $row2)
            {
                $array3		= array();
                $rs3		= M('category')->where(array('pid'=>$row2->id))->execute();
                foreach ($rs3 as $row3)
                {
                    $array3[]	= array('id'=>$row3->id, 'pid'=>$row3->pid, 'text'=>$row3->name,'visible'=>$row3->visible,'orderNum'=>$row3->orderNum, 'createTime'=>$row3->createTime);
                }                
                $array2[]	= array('id'=>$row2->id,'text'=>$row2->name,'pid'=>$row2->pid,'visible'=>$row2->visible,'orderNum'=>$row2->orderNum,'children'=>$array3,'createTime'=>$row2->createTime);//三级树默认闭合
            }
            $array[]		= array('id'=>$row->id,'text'=>$row->name,'pid'=>$row->pid,'children'=>$array2, 'visible'=>$row->visible, 'orderNum'=>$row->orderNum, 'createTime'=>$row->createTime);
        }   
        return $array;
    }

    //随机订单号
    public static function getOrdersn(){
        $str = self::random(6,'numeric');
        $str = time().$str;
        return $str;
    }    

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

    /**
     * 微信企业付款提现
     * @param mixed $sn 自定义订单号
     * @param mixed $openid 用户微信ID
     * @param mixed $total 单位：分
     * @return mixed
     */
    public static function wxWithdrawCash($sn,$openid,$total)
    {        
        $cache = cache::getClass();
        $appid = $cache->hGet('wechat','appId');
        $mchid = $cache->hGet('wechat','mchid');
        $values = array();
        $values['mch_appid'] = $appid;
        $values['mchid'] = $mchid;
        $values['openid'] = $openid;
        $values['check_name'] = 'NO_CHECK';
        $values['nonce_str'] = self::getNonceStr();
        $values['partner_trade_no'] = $sn;
        $values['amount'] = $total;
        $values['desc'] = '钱包提现';
        $values['spbill_create_ip'] = '117.27.143.242';
        $values['sign'] = self::MakeSign($values);

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_TIMEOUT,30);
	    curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_URL,'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers');
	    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,true);
	    curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);

        curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLCERT,$GLOBALS['config']['pemurl'].'/apiclient_cert.pem');
        curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLKEY,$GLOBALS['config']['pemurl'].'/apiclient_key.pem');

        curl_setopt($ch,CURLOPT_POST, 1);
	    curl_setopt($ch,CURLOPT_POSTFIELDS,self::ToXml($values));

        $data = curl_exec($ch);
        if($data){
            curl_close($ch);
        }
        else { 
            $error = curl_errno($ch);
            curl_close($ch);
            return $error;            
        }        
        // file_put_contents('upload/return/'.date('Y-m-d',time()).'.txt',date('H:i:s',time()).':企业红包=>'.$data."\t\n",FILE_APPEND);
        $data = self::FromXml($data);
        return $data;
    }
    
}