<?php
/**
 * Created by hwz@qq.com
 * Date: 2016-11-17
 * 级差佣金扩展类
 */
class yongjin_ext{
    //计算(级差)佣金
    public static function getYongjin($coupon_id,$item_id,$num,$member_id,$userpath=''){
        $pv = self::getItemPv($item_id);
        if(!empty($pv) && $pv>0){
            //PV值大于0的，开始计算佣金
            $p_yongjinlv = 0;
            $c_yongjinlv = 0;
            $d_yongjinlv = 0;
            $data = extconfig_ext::getSiteMore();
            if(!empty($data)){
                $p_yongjinlv = $data['provYjBit'];
                $c_yongjinlv = $data['cityYjBit'];
                $d_yongjinlv = $data['distrYjBit'];
            }

        }
        return 1;
    }
    //构造佣金分配路径
    public static function getYpath($userpath,$inme=0){
        $uparr = array();
            $i = 0;
            if(!empty($inme)){
                //购买用户自己也能获得佣金
                $uparr[$i] = self::getMemberYinfo($member_id,$yconfig);
                $i++;
            }
            if(!empty($userpath)){
                $userpath = trim($userpath,'-');
                if(strstr($userpath,'-')){
                    //多级客户代表的情况
                    $arr = explode('-',$userpath);
                    foreach($arr as $val){
                        if(!empty($val) && $val<>$member_id){
                            $uparr[$i] = self::getMemberYinfo($val,$yconfig);
                            $i++;
                        }
                        if($i>=3) break;
                    }
                }else{
                    //单级客户代表
                    if($userpath<>$member_id){
                        $uparr[$i] =  self::getMemberYinfo($userpath,$yconfig);
                        $i++;
                    }
                }
            }
        return $uparr;
    }
}