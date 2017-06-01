<?php
/**
 * Date: 2016-08-18
 * 商品扩展模块
 */
class item_ext{
    public static function get_sell_num($item_id=''){
        $num = 0;
        if(!empty($item_id)){
            $rs = M('item_attr')->select("sell_num")->where(array('item_id'=>$item_id))->execute();
            foreach ($rs as $key => $value) {
                $num = $num + $value->sell_num;
            }
        }
        return $num;
    }

    // 判断是否关注公众号
    public static function subscribe($openid){
        $subscribe = 0;         

        $access_token = jsapi_ext::get_access_token();
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";

        $json = file_get_contents($url);
        $array = json_decode($json,true);

        if(!empty($array)){
          $subscribe = $array['subscribe'];
        }   

        return $subscribe;
    }
    
}