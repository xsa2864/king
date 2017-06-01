<?php
class mobile_ext
{
    /*
     * 判断是否登录
     * @return  array 
     */
    public static function validUser(){
        $re_msg['success'] = -1;
        $re_msg['msg'] = '检测到，未登录'; 
        if (isset($_COOKIE['login_info'])){
            $login_info = $_COOKIE['login_info'];
            $arr = explode(':', $login_info);
            $id   = $arr[0];
            $time = $arr[1];
            $str  = $arr[2];
            if($time <= time()){
                $re_msg['msg'] = '时间超时,请登录';
            }else{
                $userinfo = M('member')->getOneData("id='$id'",'passwd,account_id');
                if($str === md5("$id:$userinfo->passwd:$time")){
                    $re_msg['success'] = 1;
                    $re_msg['msg'] = '已经登录'; 
                    $re_msg['id'] = $id; 
                    $re_msg['account_id'] = $userinfo->account_id; 
                }
            }
        }
        
        return $re_msg;
    }

    /*
     * 记录会员查询的关键词
     * @return  array 
     */
    public static function note_keyword($member_id='',$keyword=''){
        $re_msg['success'] = 0;
        $re_msg['msg'] = '记录失败'; 
        $total_num = 6;                 //保存的记录数量
        $num = M('search_keyword')->getAllCount("member_id='$member_id' and keyword='$keyword'");
        if (!empty($keyword) && $num == 0){
            $number = M('search_keyword')->getAllCount("member_id='$member_id'");
            if($number>=$total_num){
                $sql = "DELETE FROM tf_search_keyword WHERE member_id='$member_id' AND id = (SELECT a.id FROM (SELECT MIN(id) AS id FROM tf_search_keyword) a)";
                $rs = M()->query($sql);
            }
            $params['member_id']    = $member_id;
            $params['keyword']      = $keyword;
            $params['addtime']      = time();
            $rs = M('search_keyword')->insert($params);
            if($rs){
                $re_msg['success'] = 1;
                $re_msg['msg'] = '记录成功'; 
            }
        }
        return $re_msg;
    }
   
    /*
     * 增加积分，金币，消费金额，佣金等
     * @return bool
     * member_id 会员id name 字段名  number 数值
     */
    public static function add_number($member_id='',$name='',$number=0){
        $re_msg['success'] = 0;
        $re_msg['msg'] = '操作失败'; 
        if($member_id != ''){
            $rs = M('member')->getOneData("id=".$member_id,$name);
            $data[$name]        = $number+$rs->$name;
            if($rs){
                $result = M('member')->update($data,"id=".$member_id);
            }            
        }
        if($result){            
            $re_msg['success'] = 1;
            $re_msg['msg'] = '操作成功'; 
        }
        return $re_msg;
    }
}