<?php
/**
 * 自动循环执行
 */
class auto_ext
{
    /**
     * 循环重复执行方法，无需调用。
     * 执行时间间隔为60秒一次。
     */
    public static function autorun()
    {
        //实现功能
        self::up_item();
        self::down_item();
        
        // $cache = cache::getClass();
        // $a = $cache->hGet("config",'是否欠费');
        // if(!$a){
        self::money_business();
        self::money_member();
        // }
        // 定时取消订单
        self::cancel_order();
        // file_put_contents('upload/pay/'.date('Y-m-d',time()).'.txt',date('H:i:s',time()).'=>3'."\t\n",FILE_APPEND);
    }

    /**
     * 开启自动
     */
    public static function start()
    {
        $cache = cache::getClass();
        $cache->hset('config','自动状态',1);
        $info = parse_url(input::site('autoOrder'));
        $fp = fsockopen($info['host'], 80, $errno, $errstr, 3);
        if (!$fp) 
        {
            return;
        }
        else
        {
            $out = "GET /autoOrder   HTTP/1.1\r\n";
            $out .= "Host: ".$info['host']."\r\n";
            $out .= "Connection: Close\r\n\r\n";
            
            fwrite($fp, $out);
            fclose($fp);
        }
    }

    /**
     * 关闭自动
     */
    public static function stop()
    {
        $cache = cache::getClass();
        $cache->hset('config','自动状态',0);
    }

    // 自动更新上架商品
    public static function up_item(){
        $stime = time()-10;
        $etime = time()+10;
        $sql = "SELECT * FROM tf_tk_item ti WHERE ti.status=0 and ti.timetype=1 AND ti.starttime>=$stime AND ti.starttime<=$etime";
        // file_put_contents('upload/pay/'.date('Y-m-d',time()).'.txt',date('H:i:s',time()).'=>'.$sql."\t\n",FILE_APPEND);
        $result = M()->query($sql);
        foreach ($result as $key => $value) {
            M("tk_item")->update(array('status'=>1),"id=".$value->id);
        }
    }
    // 自动更新下架商品
    public static function down_item(){
        $stime = time()-10;
        $etime = time()+10;
        $sql = "SELECT * FROM tf_tk_item ti WHERE ti.status=1 and ((ti.timetype=1 AND ti.endtime>=$stime AND ti.endtime<=$etime) or ti.stock<=0 )";
        $result = M()->query($sql);
        foreach ($result as $key => $value) {
            M("tk_item")->update(array('status'=>0),"id=".$value->id);
        }
    }
    // 自动向企业补发放红包
    public static function money_business(){
        // 获取延迟时间
        $re_data = M("set_finance")->getOnedata("id=1","business_time");
        if($re_data){
            $delay_time = time()-$re_data->business_time*24*3600;
        }else{
            $delay_time = time();
        }

        $day = date('Y-m-d',time());
        $result = M("tk_log_consume lc")->select("lc.id,lc.order_sn,lc.get_price,tb.openId")->join("tk_business tb","tb.id=lc.tkb_id")->where("lc.status=0 and lc.lasttime!='".$day."' and lc.addtime<$delay_time")->execute();

        $lasttime = date('Y-m-d',time());
        foreach ($result as $key => $value) {
            $send = str_ext::wxWithdrawCash($value->order_sn,$value->openId,$value->get_price*100);
            if($send['result_code']=='SUCCESS'){
                M("tk_log_consume")->update(array('lasttime'=>$lasttime,'status'=>1,'note'=>"发放成功"),"id=".$value->id);
            }else{
                if(is_array($send['return_msg'])){
                    $return_msg = "发放失败";
                }else{
                    $return_msg = $send['return_msg'];
                }
                M("tk_log_consume")->update(array('lasttime'=>$lasttime,'note'=>$return_msg),"id=".$value->id);
            }
        }
    }
    // 根据消费记录向店家补发放红包
    public static function again_money_business($id=''){
        $reg_msg = 0;
        $result = M("tk_log_consume lc")->select("lc.id,lc.order_sn,lc.get_price,tb.openId")->join("tk_business tb","tb.id=lc.tkb_id")->where("lc.status=0 and lc.id=".$id)->limit(0,1)->execute();

        $rs = $result[0];
        $lasttime = date('Y-m-d',time());
        $send = str_ext::wxWithdrawCash($rs->order_sn,$rs->openId,$rs->get_price*100);
        if($send['result_code']=='SUCCESS'){
            M("tk_log_consume")->update(array('lasttime'=>$lasttime,'status'=>1,'note'=>"发放成功"),"id=".$rs->id);
            $reg_msg = 1;
        }else{
            if(is_array($send['return_msg'])){
                $return_msg = "发放失败";
            }else{
                $return_msg = $send['return_msg'];
            }
            M("tk_log_consume")->update(array('lasttime'=>$lasttime,'note'=>$return_msg),"id=".$rs->id);
        }     
        return $reg_msg;
    }
    // 根据消费记录批量向店家补发放红包
    public static function again_all_business($id=''){
        $reg_msg = 0;
        $result = M("tk_log_consume lc")->select("lc.id,lc.order_sn,lc.get_price,tb.openId")->join("tk_business tb","tb.id=lc.tkb_id")->where("lc.status=0 and lc.id in (".$id.")")->execute();
        foreach ($result as $key => $value) {
            $lasttime = date('Y-m-d',time());
            $send = str_ext::wxWithdrawCash($value->order_sn,$value->openId,$value->get_price*100);
            if($send['result_code']=='SUCCESS'){
                M("tk_log_consume")->update(array('lasttime'=>$lasttime,'status'=>1,'note'=>"发放成功"),"id=".$value->id);
                $reg_msg = 1;
            }else{
                if(is_array($send['return_msg'])){
                    $return_msg = "发放失败";
                }else{
                    $return_msg = $send['return_msg'];
                }
                M("tk_log_consume")->update(array('lasttime'=>$lasttime,'note'=>$return_msg),"id=".$value->id);
            }     
        }       
        return $reg_msg;
    }

    // 自动向会员补发放红包
    public static function money_member(){
        // 获取延迟时间
        $re_data = M("set_finance")->getOnedata("id=1","member_time");
        if($re_data){
            $delay_time = time()-$re_data->member_time*24*3600;
        }else{
            $delay_time = time();
        }

        $day = date('Y-m-d',time());
        $result = M("tk_log_commission lc")->select("lc.id,lc.price,m.openId")->join("member m","m.id=lc.to_member_id")->where("lc.status=0 and lc.lasttime!='".$day."' and lc.addtime<$delay_time")->execute();

        $lasttime = date('Y-m-d',time());
        foreach ($result as $key => $value) {            
            $send = return_ext::send_money($value->openId,$value->price);  
            if($send['result_code']=='SUCCESS'){
               $rs = M("tk_log_commission")->update(array('lasttime'=>$lasttime,'status'=>1,'content'=>"发放成功"),"id=".$value->id);
            }else{
                if(is_array($send['return_msg'])){
                    $return_msg = "发放失败";
                }else{
                    $return_msg = $send['return_msg'];
                }
                $rs = M("tk_log_commission")->update(array('lasttime'=>$lasttime,'content'=>$return_msg),"id=".$value->id);
            }
        }
    }
    // 根据佣金记录向会员补发放红包
    public static function again_money_member($id=''){
        $reg_msg = 0;
        $result = M("tk_log_commission lc")->select("lc.id,lc.price,m.openId")->join("member m","m.id=lc.to_member_id")->where("lc.status=0 and lc.id=".$id)->limit(0,1)->execute();
        $rs = $result[0];
        $lasttime = date('Y-m-d',time());
        // file_put_contents('upload/pay/'.date('Y-m-d',time()).'.txt',date('H:i:s',time()).'=>'.json_encode($rs)."\t\n",FILE_APPEND);
        $send = return_ext::send_money($rs->openId,$rs->price);  
        if($send['result_code']=='SUCCESS'){
            $crs = M("tk_log_commission")->update(array('lasttime'=>$lasttime,'status'=>1,'content'=>"发放成功"),"id=".$rs->id);
            $reg_msg = 1;
        }else{
            if(is_array($send['return_msg'])){
                $return_msg = "发放失败";
            }else{
                $return_msg = $send['return_msg'];
            }
            $crs = M("tk_log_commission")->update(array('lasttime'=>$lasttime,'content'=>$return_msg),"id=".$rs->id);
        }        
        return $reg_msg;
    }
    // 根据佣金记录批量向会员补发放红包
    public static function again_all_member($id=''){
        $reg_msg = 0;
        $result = M("tk_log_commission lc")->select("lc.id,lc.price,m.openId")->join("member m","m.id=lc.to_member_id")->where("lc.status=0 and lc.id in (".$id.")")->execute();
        foreach ($result as $key => $value) {
            $lasttime = date('Y-m-d',time());
            $send = return_ext::send_money($value->openId,$value->price);  
            if($send['result_code']=='SUCCESS'){
                $crs = M("tk_log_commission")->update(array('lasttime'=>$lasttime,'status'=>1,'content'=>"发放成功"),"id=".$value->id);
                $reg_msg = 1;
            }else{
                if(is_array($send['return_msg'])){
                    $return_msg = "发放失败";
                }else{
                    $return_msg = $send['return_msg'];
                }
                $crs = M("tk_log_commission")->update(array('lasttime'=>$lasttime,'content'=>$return_msg),"id=".$value->id);
            }      
        }
        return $reg_msg;
    }
    // X天后待付款的订单自动取消 
    public static function cancel_order(){
        $cache = cache::getClass();
        $num = (int)$cache->hGet('config','X天后待付款的订单自动取消');
        if($num>0){
            $time = time()-$num*24*3600;
            $result = M("tk_coupon")->select("id")->where("paystatus=0 and addtime<$time")->execute();
            if($result){
                foreach ($result as $key => $value) {
                    $data['paystatus'] = -1;
                    $data['closetime'] = time();
                    M("tk_coupon")->update($data,"id=".$value->id);
                }
            }
        }
    }
}