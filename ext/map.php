<?php
/**
 * 地图
 */
class map_ext
{
    
    public static function getDistance($lat,$lng,$toStr)
    {
        $baseString = '/ws/distance/v1/?mode=driving&from='.$lat.','.$lng.'&to='.$toStr.'&key=QMOBZ-QBT3K-WNMJV-ATIUM-3W5CH-GOFZL';
        $sn = self::caculateAKSN($baseString);
        $request = request::getClass('http://apis.map.qq.com/ws/distance/v1/?mode=driving&from='.$lat.','.$lng.'&to='.$toStr.'&key=QMOBZ-QBT3K-WNMJV-ATIUM-3W5CH-GOFZL&sn='.$sn);
        $request->sendRequest();
        $rs = json_decode($request->getResponseBody());
        return $rs;
        if($rs->status)
        {
            $a->fault = true;
            $a->message = $rs->message;
            return $a;
        }
        return $rs->result->elements;
    }
    
    public static function getObjDistance($lat,$lng,$toStr)
    {
        $baseString = '/ws/distance/v1/?mode=driving&from='.$lat.','.$lng.'&to='.$toStr.'&key=QMOBZ-QBT3K-WNMJV-ATIUM-3W5CH-GOFZL';
        $sn = self::caculateAKSN($baseString);
        $request = request::getClass('http://apis.map.qq.com/ws/distance/v1/?mode=driving&from='.$lat.','.$lng.'&to='.$toStr.'&key=QMOBZ-QBT3K-WNMJV-ATIUM-3W5CH-GOFZL&sn='.$sn);
        $request->sendRequest();
        $rs = json_decode($request->getResponseBody());        
        return $rs;
    }

    /**
     * 计算SN
     * @param mixed $baseString 指定字符串
     * @return string SN
     */
    public static function caculateAKSN($baseString){
        $sk = 'IXYtGeRjWG1iQQ5pEpUjwIYLBr6zjn4s';
        return md5(urlencode($baseString.$sk));
    }
}