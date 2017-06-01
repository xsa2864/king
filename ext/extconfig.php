<?php
/**
 * Created by hwz@qq.com
 * Date: 2016-04-07
 * 获取网站的扩展属性
 */
class extconfig_ext{
    //获取商城高级配置
    public static function getSiteMore($keyname=''){
        $res = myfunc_ext::cacheGet('siteExtconfig');
        if(!empty($res) && is_array($res)){
            //从缓存中读取
            if(!empty($keyname)){
                $data = $res[$keyname];
            }else{
                $data = $res;
            }
        }else{
            //无缓存的重新写入
                $rs = M('tk_extconfig')->where('1=1')->execute();
                if(!empty($rs)){
                    foreach($rs as $val){
                        $arr[$val->keyname] = $val->keyval;
                        myfunc_ext::cachePut('siteExtconfig',$val->keyname,$val->keyval);
                    }
                    if(!empty($keyname)){
                        $data = $arr[$keyname];
                    }else{
                        $data = $arr;
                    }
                }
        }
        return $data;
    }
}