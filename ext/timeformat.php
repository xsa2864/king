<?php
/**
 * Created by hwz@qq.com
 * Date: 2016-04-07
 * 时间格式化
 */
class timeformat_ext{
    /**
     * 将时间戳按格式化输出
     * @param mixed $int 时间戳
     * @param mixed $type 格式化类型
     * 默认:显示今天、昨天、前天
     * 1:年-月-日 时:分:秒
     * 2:年-月-日 时:分
     * 3:只显示年-月-日
     * @param mixed $diy 自定义时间格式
     * @return string 格式化后的时间
     */
    public static function format($int,$type=0,$diy=''){
        $type = !empty($type)?intval($type):0;
        if(!empty($diy)){
            //自定义时间样式 $diy参数必须为正确的date参数
            $res = date($diy,$int);
        }else{
            switch($type){
                case 1:
                    //年-月-日 时:分:秒
                    $res = date('Y-m-d H:i:s',$int);
                    break;
                case 2:
                    //年-月-日 时:分
                    $res = date('Y-m-d H:i',$int);
                    break;
                case 3:
                    //只显示年-月-日
                    $res = date('Y-m-d',$int);
                    break;
                default:
                    //默认时间规则（月、日无前导0 时、分、秒有前导0）
                    $today_timestamp = strtotime(date('Y-m-d')); //获取当天零点的时间戳
                    if($int<$today_timestamp){
                        if($today_timestamp-$int<86400){
                            //昨天
                            $res = '昨天 '.date('H:i',$int);
                        }elseif($today_timestamp-$int<172800){
                            //前天
                            $res = '前天 '.date('H:i',$int);
                        }else{
                            if(date('Y')<>date('Y',$int)){
                                //年份不等的，把年份也显示出来
                                $res = date('y-n-j H:i',$int);
                            }else{
                                $res = date('n-j H:i',$int);
                            }
                        }
                    }elseif($int<$today_timestamp+86400){
                        //今天
                        $mins = floor((time()-$int)/60);
                        if($mins>=60)
                        {
                            $res = floor(($mins)/60).'小时前';
                        }
                        else if($mins>=1)
                        {
                            $res = $mins.'分钟前';
                        }
                        else
                        {
                            $res = '刚刚';
                        }
                    }else{
                        //明天之后的
                        $res = date('y-n-j H:i',$int);
                    }
            }
        }
        return $res;
    }

    /**
     * 带自定义显示内容的，将时间戳按格式化输出
     * @param mixed $int 时间戳
     * @param mixed $dstr 自定义默认显示内容
     * @return mixed
     */
    public static function defaultFormat($int,$dstr='--'){
    if(!empty($int)){
        $datetime = self::format($int);
    }else{
        $datetime = $dstr;
    }
    return $datetime;
}
}
