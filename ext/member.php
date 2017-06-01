<?php
/**
 * Created by hwz@qq.com
 * Date: 2016-04-11
 * 会员扩展模块
 */
class member_ext{
    public static function get_myinfo($token,$mobile=''){
        if(!empty($mobile)){
            $memberinfo = M('member')->getOneData(array('token'=>$token,'mobile'=>$mobile,'status'=>1));
        }else{
            $memberinfo = M('member')->getOneData(array('token'=>$token,'status'=>1));
        }
        $arr = !empty($memberinfo)?array_ext::toArray($memberinfo):array();
        return $arr;
    }
    //用户浏览记录
    public static function visited_log($member_id,$v_type,$v_id){
        M('visit_log')->delete(array('member_id'=>$member_id,'v_type'=>$v_type,'v_id'=>$v_id));
        //删除旧记录
        M('visit_log')->save(array('member_id'=>$member_id,'v_type'=>$v_type,'v_id'=>$v_id,'ptime'=>time()));   //增加记录
        $rs = M('visit_log')->select('id')->where(array('member_id'=>$member_id))->orderby('id desc')->limit(0,20)->execute();
        foreach($rs as $key=>$val){
            if($key=='20'){
                //只保留最新的20条记录
                M('visit_log')->delete(' member_id=\''.$member_id.'\' and id<=\''.$val->id.'\'');
            }
        }
    }
    public static function memberdetail($member_id){
        $memberinfo = M('member')->getOneData(array('id'=>$member_id,'status'=>1));
        $arr = !empty($memberinfo)?array_ext::toArray($memberinfo):array();
        return $arr;
    }

    //用户收藏$type_id  1=商品 2=店铺 3=会员 4=会议 5=学习 6=资讯
    //验证是否收藏过
    public static function chkfav($member_id,$fav_id,$type_id){
        $fav_id = M('member_fav')->getFieldData('id',array('member_id'=>$member_id,'fav_id'=>$fav_id,'type_id'=>$type_id));
        return !empty($fav_id)?1:0;
    }
    //添加收藏
    public static function addfav($member_id,$fav_id,$type_id){
        $isfav = self::chkfav($member_id,$fav_id,$type_id);
        if(!$isfav){
            //未收藏
            M('member_fav')->save(array('member_id'=>$member_id,'fav_id'=>$fav_id,'type_id'=>$type_id,'ptime'=>time()));
        }
        return true;
    }
    //删除收藏
    public static function delfav($member_id,$fav_id,$type_id){
        M('member_fav')->delete(array('member_id'=>$member_id,'fav_id'=>$fav_id,'type_id'=>$type_id));
        return true;
    }
    public static function myfavlist($type_id,$page=1,$pagesize=10){
        $where['type_id'] = $type_id;
        $tnum = M('member_fav')->getAllCount($where);   //总记录数
        if(!empty($tnum)){
            $page = intval($page);
            $maxpage = ceil($tnum/$pagesize);
            if($page>$maxpage) $page = $maxpage;
            if($page<1) $page = 1;
            $fnum = ($page-1)*$pagesize;
            $rs = M('member_fav')->select('id,fav_id,type_id,ptime')->where($where)->limit($fnum,$pagesize)->execute();
            return $rs;
        }else{
            return false;
        }
    }
    public static function member_money($member_id){
        $data = array();
        $data['points'] = M('member')->getFieldData('points',array('id'=>$member_id));
        $data['points'] = round($data['points'],2);
        $account = M('member_info')->getOneData(array('member_id'=>$member_id),'jifen,yongjin,fenhong,gongxiang');
        if(!empty($account)){
            $data['jifen'] = round($account->jifen,2);
            $data['yongjin'] = round($account->yongjin,2);
            $data['fenhong'] = round($account->fenhong,2);
            $data['gongxiang'] = round($account->gongxiang,2);
            $data['yue'] = $account->jifen+$account->yongjin+$account->fenhong+$account->gongxiang;
            $data['yue'] = round($data['yue'],2);
        }else{
            $data['jifen'] = 0.00;
            $data['yongjin'] = 0.00;
            $data['fenhong'] = 0.00;
            $data['gongxiang'] = 0.00;
            $data['yue'] = 0.00;
        }
        return $data;
    }
    public static function chk_money($member_id,$pm=array()){
        $mymoney = self::member_money($member_id);   //钱包余额
        if(!empty($pm)){
            //hwz:循环遍历钱包抵扣金额，检验余额是否足够
            $karr = array('jifen','yongjin','fenhong','gongxiang');
            foreach($karr as $key){
                if(!empty($pm[$key])){
                    if($pm[$key]>0){
                        //有抵扣的判断余额
                        if(!empty($mymoney[$key])){
                            if($mymoney[$key]<$pm[$key]){
                                return false;
                            }
                        }else{
                            //余额为0
                            return false;
                        }
                    }
                }
            }
            return true;
        }else{
            return true;
        }
    }
    public static function get_realname($member_id){
        $realname = M('member')->getFieldData('realname',array('id'=>$member_id));
        return !empty($realname)?$realname:'';
    }
    public static function get_pcomid($member_id){
        //返回上级经销商ID
        $pcomid = M('member')->getFieldData('pcomid',array('id'=>$member_id));
        return !empty($pcomid)?intval($pcomid):0;
    }
    // 判断会员等级名称
    public static function get_level($amount=''){
        $re_msg['success'] = 0;
        $re_msg['msg'] = "获取失败";
        $re_msg['info'] = "";
        $account_id = accountInfo_ext::accountId(); 
        // 会员等级
        $rs_level = M('member_level')->select("name,amount")->where("account_id=".$account_id)->orderby("amount desc")->execute();

        $flag = true;
        if($amount!='' && $rs_level){
            foreach ($rs_level as $key => $value) {
                if($value->amount <= $amount && $flag){            
                    $re_msg['success'] =1;
                    $re_msg['msg'] = "获取成功";
                    $re_msg['info'] = $value->name;
                    $flag = false;
                }
            }
        }

        if($flag){
            $re_msg['success'] =1;
            $re_msg['msg'] = "获取成功";
            $re_msg['info'] = $rs_level[(count($rs_level)-1)]->name;
        }
        return $re_msg['info'];
    }
    // 统计下级会员数量
    public function count_member($id=''){
        if($id != ''){
            $num = M('member')->getAllCount(array('pid'=>$id));
        }else{
            $num = 0;
        }
        return $num;
    }

    // 获取上级会员昵称
    public static function get_nickname($pid=0){
        $nickname = '';
        if($pid>0){
            $result = M("member")->getOneData("id=$pid","nickname");
            $nickname = json_decode($result->nickname);
        }
        return $nickname;
    }
    /*
     * 查找上级会员的会员id
     * 没有 return 0
     */
    public static function get_pid($member_id=0){
        $id = 0;
        $result = M("member")->getOneData("id=$member_id","id,levelId,pid");
        if($result){
            if($result->levelId == 1){
                $id = $member_id;
            }else{
                $id = self::get_pid($result->pid);
            }
        }
        return $id;
    }
}