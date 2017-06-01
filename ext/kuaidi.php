<?php
class kuaidi_ext
{    
    
    public function getKuaidiInfo($express_code,$express_name){        
        $url='http://biz.trace.ickd.cn/'.$express_name.'/'.$express_code.'?&ts=123456&enMailNo=123456789&callback=_jqjsp&_1477981238643=';
        $re=file_get_contents($url);
        preg_match_all("/(?:\()(.*)(?:\))/i",$re, $result);
        $result=$result[1][0];
        $json=json_decode($result);
        return $json;
        
    }
    
}

?>