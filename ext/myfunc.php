<?php
/**
 * Created by hwz@qq.com
 * Date: 2016-07-01
 * 常用扩展函数
 */
class myfunc_ext
{
    public static function curlPost($url,$post=1,$data='',$header='',$refererUrl='',$timeout=30)
    {
        //初始化curl
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        if(!empty($header)){
            curl_setopt ($ch, CURLOPT_HEADER, 1);
        }else{
            curl_setopt ($ch, CURLOPT_HEADER, 0);
        }
        curl_setopt($ch, CURLOPT_POST, $post);
        if($post)  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        $timeout = !empty($timeout)?$timeout:30;    //默认30秒超时
        curl_setopt($ch, CURLOPT_TIMEOUT,$timeout);   //超时
        if($header){
            curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
        }
        if($refererUrl){
            curl_setopt($ch, CURLOPT_REFERER, $refererUrl);
        }
        $result = curl_exec ($ch);
        //连接失败
        if($result == FALSE){
            $result = "Network Error";
        }
        curl_close($ch);
        return $result;
    }
// 循环创建目录
    public static function mkDir($dir, $mode = 0755)
    {
        if (is_dir($dir) || @mkdir($dir,$mode)) return true;
        if (!self::mkDir(dirname($dir),$mode)) return false;
        return @mkdir($dir,$mode);
    }
//缓存文件
    public static function cacheRead($file, $path = '')
    {
        if(!$path) $path = self::tempPath();
        $cachefile = $path.$file;
        if(file_exists($cachefile)){
            return @include $cachefile;
        }else{
            return false;
        }
    }

    public static function cacheWrite($file, $array, $path = '')
    {
        if(!is_array($array)) return false;
        $array = "<?php\n return ".var_export($array, true).";\n?>";
        $cachefile = !empty($path)?$path.$file:self::tempPath().$file;
        $strlen = file_put_contents($cachefile, $array);
        @chmod($cachefile, 0644);
        return $strlen;
    }

    public static function cacheDelete($file, $path = '')
    {
        $cachefile = !empty($path)?$path.$file:self::tempPath().$file;
        return @unlink($cachefile);
    }
    //hwz:获取网站域名
    public static function getSiteurl($end=0){
        $siteurl = !empty($end)?input::site():trim(input::site(),'/');
        return $siteurl;
    }
    //获取temp目录绝对路径
    public static function tempPath(){
        $rs = C('upload');
        return $rs['tempPath'];
    }
    //采集远程URL内容（替代file_get_contents）
    public static function curlGetContents($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_USERAGENT, _USERAGENT_);
        curl_setopt($ch, CURLOPT_REFERER,_REFERER_);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $r = curl_exec($ch);
        curl_close($ch);
        return $r;
    }
    //截取字符串函数
    public static function strCut($string, $length, $dot = '')
    {
        $strlen = strlen($string);
        if($strlen <= $length) return $string;
        $string = str_replace(array('&nbsp;', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), array(' ', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), $string);
        $strcut = '';
            $n = $tn = $noc = 0;
            while($n < $strlen)
            {
                $t = ord($string[$n]);
                if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                    $tn = 1; $n++; $noc++;
                } elseif(194 <= $t && $t <= 223) {
                    $tn = 2; $n += 2; $noc += 2;
                } elseif(224 <= $t && $t < 239) {
                    $tn = 3; $n += 3; $noc += 2;
                } elseif(240 <= $t && $t <= 247) {
                    $tn = 4; $n += 4; $noc += 2;
                } elseif(248 <= $t && $t <= 251) {
                    $tn = 5; $n += 5; $noc += 2;
                } elseif($t == 252 || $t == 253) {
                    $tn = 6; $n += 6; $noc += 2;
                } else {
                    $n++;
                }
                if($noc >= $length) break;
            }
            if($noc > $length) $n -= $tn;
            $strcut = substr($string, 0, $n);

        $strcut = str_replace(array('&', '"', "'", '<', '>'), array('&amp;', '&quot;', '&#039;', '&lt;', '&gt;'), $strcut);
        return $strcut.$dot;
    }
    //获取缓存值 无键名的拉取指定缓存名下的全部数组
    public static function cacheGet($name,$key=''){
        $cache = cache::getClass();
        if(!empty($key)){
            $data = $cache->hGet($name,$key);
        }else{
            $data	=  $cache->hGetAll($name);
        }
        return $data;
    }
    //写入缓存 - 缓存名 键 值
    public static function cachePut($name,$key,$val){
        $cache = cache::getClass();
        $cache->hSet($name,$key,$val);
        return 1;
    }
    //清除缓存
    public static function cacheClear($name){
        $cache = cache::getClass();
        $cache->delete($name);
    }
}