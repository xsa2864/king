<?php
/**
 * Created by hwz@qq.com
 * Date: 2016-11-11
 * 分红扩展类
 */
class dividend_ext{
    //用户支付订单后处理 $member_id=用户ID $share_id=用户级别级别（1=区代 2=市代 3=省代） $num=商品数量 $userpath=用户路径  (此方法必须在用户累计销售量增加完毕，并更新用户等级后执行)
    public static function putOrder($member_id,$num=1,$userpath=''){
        $num = intval($num);
        if(empty($num)) $num = 1;   //默认1件商品
        self::addSaleNum($num); //增加当月商品总销量
        $userpath = trim($userpath,'-');
        if(!empty($userpath)){
            $mypath = $member_id.'-'.$userpath;
        }else{
            $mypath = $member_id;
        }
        if(strstr($mypath,'-')){
            $ch_num = $num;
            //循环遍历上线所有用户
            $arr = explode('-',$mypath);
            foreach($arr as $val){
                $share_id = self::getMemShareId($val);
                $data = self::addGoodsNum($val,$share_id,$ch_num);
                //更新上级filter_num
                $ch_num = $data['ch_num'];
            }
        }else{
            //本线只有自己的
            $share_id = self::getMemShareId($mypath);
            $data = self::addGoodsNum($mypath,$share_id,$num);
        }
        $res = self::getMemsWeight($mypath);    //重新计算权重
        return 1;
    }
    //用户加商品数(此方法必须在用户累计销售量增加完毕，并更新用户等级后执行)
    public static function addGoodsNum($member_id,$share_id,$num){
        $ptime = time();
        $day_num = date('Ym',$ptime);  //当前月份
        $rs = M('area_dividend')->getOneData(array('member_id'=>$member_id,'day_num'=>$day_num),'id,filter_num,prov_status,city_status');
        if(!empty($rs)){
            //更新记录
            $new_fnum = $rs->filter_num+$num;
            $data = self::isDivExpt($share_id,$new_fnum);  //加上商品数后，省/市代是否达标
            $data['filter_num'] = $new_fnum;
            $data['prov_o_status'] = $rs->prov_status;  //返回旧状态
            $data['city_o_status'] = $rs->city_status;
            switch($share_id){
                case '3':
                    //省代
                    if(!empty($data['prov_status'])){
                        //省代达标
                        $data['ch_num'] = 0;
                        if(empty($data['prov_o_status']))  $data['ch_num'] = 0-$rs->filter_num; //省代不达标->达标的，上级filter_num扣除
                    }else{
                        //省代不达标
                        $data['ch_num'] = $num;
                        if(!empty($data['prov_o_status'])) $data['ch_num'] = $new_fnum; //省代达标->不达标的，上级filter_num增加
                    }
                    break;
                case '2':
                    //市代
                    if(!empty($data['city_status'])){
                        //市代达标
                        $data['ch_num'] = 0;
                        if(empty($data['city_o_status']))  $data['ch_num'] = 0-$rs->filter_num; //市代不达标->达标的，上级filter_num扣除
                    }else{
                        //市代不达标
                        $data['ch_num'] = $num;
                        if(!empty($data['city_o_status'])) $data['ch_num'] = $new_fnum; //市代达标->不达标的，上级filter_num增加
                    }
                    break;
                default:
                    //非省/市代的，上级filter_num始终累加
                    $data['ch_num'] = $num;
            }
            //计算完成度
            M('area_dividend')->update(array('filter_num'=>$new_fnum,'prov_status'=>$data['prov_status'],'city_status'=>$data['city_status'],'share_id'=>$share_id,'diff_num'=>$data['diff_num'],'complete'=>$data['complete'],'ptime'=>$ptime),array('id'=>$rs->id));
        }else{
            //新增记录
            $data = self::isDivExpt($share_id,$num);
            $data['filter_num'] = $num;
            $data['prov_o_status'] = 0;  //返回旧状态
            $data['city_o_status'] = 0;
            $data['ch_num'] = $num; //累计到上级的filter_num
            switch($share_id){
                case '3':
                    //省代达标 不累计到上级filter_num
                    if(!empty($data['prov_status'])) $data['ch_num'] = 0;
                    break;
                case '2':
                    //市代达标，不累计到上级filter_num
                    if(!empty($data['city_status'])) $data['ch_num'] = 0;
                    break;
            }
            M('area_dividend')->save(array('member_id'=>$member_id,'filter_num'=>$num,'prov_status'=>$data['prov_status'],'city_status'=>$data['city_status'],'share_id'=>$share_id,'diff_num'=>$data['diff_num'],'complete'=>$data['complete'],'day_num'=>$day_num,'ptime'=>$ptime));
        }
        return $data;       //返回$data包含 filter_num，city_status，prov_status，city_o_status，prov_o_status ch_num字段
    }
    //是否达到省代/市代分红台数
    public static function isDivExpt($share_id,$filter_num){
        $data['prov_status'] = 0;
        $data['city_status'] = 0;
        $data['diff_num'] = 0;  //剩余台数
        $data['complete'] = '';

        $garr = self::getComNum();
        $pnum = $garr['pnum'];
        $cnum = $garr['cnum'];
        if($share_id == '2'){
            //市代判断状态
            if($filter_num>=$cnum){
                $data['city_status'] =1;
                $data['complete'] = '100%';
            }else{
                $data['diff_num'] = $cnum - $filter_num;
                $data['complete'] = round(100*($filter_num/$cnum),2).'%';
            }
        }elseif($share_id == '3'){
            //省代判断状态
            if($filter_num>=$cnum) $data['city_status'] =1;
            if($filter_num>=$pnum){
                $data['prov_status'] =1;
                $data['complete'] = '100%';
            }else{
                $data['diff_num'] = $pnum - $filter_num;
                $data['complete'] = round(100*($filter_num/$pnum),2).'%';
            }
        }
        return $data;
    }
    //获取用户销售完成度百分比
    public static function getMemberDe($member_id,$day_num=''){
        $ptime = time();
        if(empty($day_num)) $day_num = date('Ym',$ptime);  //默认取当前月份
        $data = array();
        $rs = M('area_dividend')->getOneData(array('member_id'=>$member_id,'day_num'=>$day_num),'member_id,filter_num,prov_status,city_status,diff_num,complete');
        if(!empty($rs)){
            $data = array_ext::toArray($rs);
        }
        return $data;
    }
    //取分红条件
    public static function getComNum($share_id=0){
        $pnum = 0;
        $cnum = 0;
        $data = extconfig_ext::getSiteMore();
        if(!empty($data)){
            $pnum = $data['provEnfLevel'];
            $cnum = $data['cityEnfLevel'];
        }
        if(empty($share_id)){
            return array('cnum'=>$cnum,'pnum'=>$pnum);
        }else{
            if($share_id == '3'){
                return $pnum;
            }elseif($share_id == '2'){
                return $cnum;
            }else{
                return 0;
            }
        }
    }
    public static function getMemShareId($member_id){
        $share_id = M('member')->getFieldData('shareId',array('id'=>$member_id));
        return $share_id?intval($share_id):0;
    }
    //重新计算权重
    public static function getMemsWeight($mypath){
        $ptime = time();
        $day_num = date('Ym',$ptime);  //当前月份
        if(strstr($mypath,'-')){
            //循环遍历上线所有用户
            $arr = explode('-',$mypath);
            foreach($arr as $vastr){
                $rs = M('member a')->select('a.id as member_id,b.id as div_id,a.shareId,b.filter_num,b.prov_status,b.city_status')->join('area_dividend b','a.id=b.member_id')->where('a.id=\''.$vastr.'\' and b.day_num=\''.$day_num.'\' and a.shareId>\'1\'')->execute();
                if(!empty($rs)){
                    foreach($rs as $val){
                        $weight = self::getMyWeight($val->member_id,$val->shareId,$val->prov_status,$val->city_status,$val->filter_num,$day_num);
                        M('area_dividend')->update(array('weight'=>$weight),array('id'=>$val->div_id));
                    }
                }
            }
        }else{
            //本线只有一个用户的
           $rs = M('member a')->select('a.id as member_id,b.id as div_id,a.shareId,b.filter_num,b.prov_status,b.city_status')->join('area_dividend b','a.id=b.member_id')->where('a.id=\''.$mypath.'\' and b.day_num=\''.$day_num.'\' and a.shareId>\'1\'')->execute();
            if(!empty($rs)){
                foreach($rs as $val){
                    $weight = self::getMyWeight($val->member_id,$val->shareId,$val->prov_status,$val->city_status,$val->filter_num,$day_num);
                    M('area_dividend')->update(array('weight'=>$weight),array('id'=>$val->div_id));
                }
            }
        }
        return 1;
    }
    //单用户计算权重
    public static function getMyWeight($member_id,$share_id,$prov_status,$city_status,$filter_num,$day_num,$level=0){
        $level = !empty($level)?intval($level):0;
        $res = 0;
        $isok = 0;
        switch($share_id){
            case '3':
                //省代
                if(!empty($prov_status))  $isok = 1;
                break;
            case '2':
                //市代
                if(!empty($city_status))  $isok = 1;
                break;
        }
        if(!empty($isok)){
            $weight = $filter_num*pow(0.5,$level); //满足分红条件，计算权重
            $rs = M('member a')->select('a.id as member_id,a.shareId,b.filter_num,b.prov_status,b.city_status')->join('area_dividend b','a.id=b.member_id')->where('a.pid=\''.$member_id.'\' and b.day_num=\''.$day_num.'\' and a.shareId>\'1\'')->execute();
            if(!empty($rs)){
                $level += 1;    //级别+1
                foreach($rs as $val){
                    $res += self::getMyWeight($val->member_id,$val->shareId,$val->prov_status,$val->city_status,$val->filter_num,$day_num,$level);
                }
            }
            return round($weight+$res,2);
        }else{
            return 0;
        }
    }
    //增加当月总销量
    public static function addSaleNum($num,$day_num=''){
        $pv = self::getItemPv();    //商品PV值，此值须从商品配置中读取
        $ptime = time();
        $day_num = !empty($day_num)?intval($day_num):0;
        if(empty($day_num)) $day_num = date('Ym',$ptime);  //默认取当前月份
        $rs = M('month_goods')->getOneData(array('day_num'=>$day_num));
        if(!empty($rs)){
            $data['sale_num'] = $rs->sale_num+$num;
            $data['jijin'] = $pv*$data['sale_num'];
            M('month_goods')->update($data,array('id'=>$rs->id));
        }else{
            $data['sale_num'] = $num;
            $data['jijin'] = $pv*$num;
            $data['day_num'] = $day_num;
            M('month_goods')->save($data);
        }
    }
    //计算上月分红
    public static function countFenhong($day_num=''){
        $plv = 0;
        $clv = 0;
        $data = extconfig_ext::getSiteMore();
        if(!empty($data)){
            $plv = $data['provFhBit'];
            $clv = $data['cityFhBit'];
        }
        $ptime = time();
        $cday_num = date('Ym',$ptime);  //默认取当前月份
        $cday_num = $cday_num - 1;  //只能计算上个月之前的分红
        $day_num = !empty($day_num)?intval($day_num):0;
        if(empty($day_num)) $day_num = $cday_num;
        if($day_num>$cday_num)  $day_num = $cday_num;
        //可用于分红的资金
        $jijin = M('month_goods')->getFieldData('jijin',array('day_num'=>$day_num));
        if(!empty($jijin) && $jijin>0){
            //分红基金>0的，进入分红的计算
            $all_weight = M('area_dividend')->getFieldData('SUM(weight)',array('day_num'=>$day_num));   //当月总权重
            $rs = M('area_dividend')->select('id,filter_num,prov_status,city_status,share_id,weight')->where('day_num=\''.$day_num.'\' and share_id>\'1\' and (prov_status>\'0\' or city_status>\'0\')')->execute();
            //取全部满足分红条件的用户
            if(!empty($rs) && $all_weight>0){
                foreach($rs as $val){
                    switch($val->share_id){
                        case '3':
                            //省代
                            if(!empty($val->prov_status) && $val->weight>0){
                                $fenhong = round($jijin*$plv*($val->weight)/$all_weight,2); //计算分红
                                M('area_dividend')->update(array('fenhong'=>$fenhong),array('id'=>$val->id));
                            }
                            break;
                        case '2':
                            //市代
                            if(!empty($val->city_status) && $val->weight>0){
                                $fenhong = round($jijin*$clv*($val->weight)/$all_weight,2); //计算分红
                                M('area_dividend')->update(array('fenhong'=>$fenhong),array('id'=>$val->id));
                            }
                            break;
                    }
                }
            }
        }
        return 1;
    }
    //获取商品的PV
    public static function getItemPv($item_id=1){
        $pv = M('tk_item')->getFieldData('pv',array('id'=>$item_id));
        return !empty($pv)?round($pv,2):0;
    }
}