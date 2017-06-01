<?php
defined('KING_PATH') or die('访问被拒绝.');

class Config_controller extends Template_Controller {

    public function __construct() {
        parent::__construct();
        comm_ext::validUser();      
        $this->account_id = accountInfo_ext::accountId();  
    }
    // 配置首页
    public function index() {
        auto_ext::cancel_order();
        // $result = M('set_config')->getOneData("id=1"); 
        $cache = cache::getClass();
        $data['config'] = $cache->hGetAll("config");
        $this->template->content    = new View('admin/config/index_view',$data);
        $this->template->render();
    }
    // 保存商城配置信息
    public function saveConfig(){
        $str = P('str','');
        $array = json_decode($str,true);
        $cache = cache::getClass();

        foreach ($array[0] as $key => $value) {
            if($key != ''){
                $rs = $cache->hSet('config',"$key","$value");
            }            
        }
        echo 1;
    }
    // 删除商城配置
    public function delConfig(){
        $name = P('name','');
        $cache = cache::getClass();
        $rs = $cache->hDel('config',$name);
        echo $rs;
    }
    // 更新或者添加配置信息
    public function save(){
        $id = P('id');
        $data['name']         = P('name');
        $data['phone']      = P('phone');
        $data['share_description'] = P('share_description');
        $data['warning_stock']   = P('warning_stock');
        $data['sell_num']        = P('sell_num');

        $re_msg['msg'] = '执行失败!';
        if($id>0){
            $rs = M('set_config')->update($data,"id=$id");
        }else{
            $data['addtime']      = time();
            $rs = M('set_config')->insert($data);
        }

        if($rs){
            $re_msg['msg'] = '执行成功!';
        }
        echo json_encode($re_msg);
    }
     // 积分配置页面
    public function show_points(){        
        $result = M('set_points')->getOneData("id=1"); 
        $this->template->content    = new View('admin/config/points_view',json_decode(json_encode($result),true));
        $this->template->render();
    }
   
     // 更新积分配置
    public function savePoints(){
        $id                   = P("id");
        $data['give_type']    = P("give_type",'');
        $data['fission_type'] = P("fission_type",'');
        $data['fission_rate'] = P("fission_rate",'');
        $data['fission_number'] = P("fission_number",'');
        $data['cash_clear'] = P("cash_clear",'');
        $data['cash_to']    = P("cash_to",'');
        $data['valid_time'] = P("valid_time",'');        

        $re_msg['msg'] = '执行失败!';
        if($id>0){
            $rs = M('set_points')->update($data,"id=$id");
        }else{
            $data['account_id']      = $this->account_id;
            $rs = M('set_points')->insert($data);
        }
        if($rs){
            $re_msg['msg'] = '执行成功!';
        }
        echo json_encode($re_msg);
    }
    // 金币配置页面
    public function show_golds(){
        $result = M('set_golds')->getOneData("id=1"); 
        $this->template->content    = new View('admin/config/golds_view',json_decode(json_encode($result),true));
        $this->template->render();
    }
    // 更新金币配置
    public function saveGolds(){
        $id                         = P("id");
        $data['give_type']          = P("give_type");
        $data['valid_time']         = P("valid_time");
        $data['mask_points']        = P("mask_points");
        $data['mask_type']          = P("mask_type");
        $data['continuity_points']  = P("continuity_points");
        $data['continuity_day']     = P("continuity_day");
        $data['money']              = P("money");
        $data['order_discount']     = P("order_discount");
        $data['points_cash']        = P("points_cash");
        
        $re_msg['msg'] = '执行失败!';
        if($id>0){
            $rs = M('set_golds')->update($data,"id=$id");
        }else{
            $data['account_id']      = $this->account_id;
            $rs = M('set_golds')->insert($data);
        }
        if($rs){
            $re_msg['msg'] = '执行成功!';
        }
        echo json_encode($re_msg);
    }
     // 佣金配置页面
    public function show_commission(){        
        $result = M('set_commission')->getOneData("id=1"); 
        $this->template->content    = new View('admin/config/commission_view',json_decode(json_encode($result),true));
        $this->template->render();
    }
    // 更新佣金配置
    public function saveCommission(){
        $id                     =   P("id");
        $data['give_type']      =   P('give_type','');
        $data['fission_type']   =   P('fission_type','');
        $data['one_price']      =   P('one_price','');
        $data['two_price']      =   P('two_price','');
        $data['three_price']    =   P('three_price','');
        $data['max_commission'] =   P('max_commission','');
        $data['freeze_day']      = P('freeze_day',0);
        $data['fee']             = P('fee',0);
        $data['fission_time']    = P('fission_time',0);
        $data['price_type']    = P('price_type',0);

        $re_msg['msg'] = '执行失败!';
        if($id>0){
            $rs = M('set_commission')->update($data,"id=$id");
        }else{
            $rs = M('set_commission')->insert($data);
        }
        if($rs){
            $re_msg['msg'] = '执行成功!';
        }
        echo json_encode($re_msg);
    }
    // 退款配置页面
    public function show_return(){
        $result = M('set_return')->getOneData("id=1"); 
        $this->template->content    = new View('admin/config/return_view',json_decode(json_encode($result),true));
        $this->template->render();
    }
    // 更新退款配置
    public function saveReturn(){
        $id           = P("id");
        $data['return_day']  = P('return_day',0);  
        $data['percent']  = P('percent',0);

        $re_msg['msg'] = '执行失败!';
        if($id>0){
            $rs = M('set_return')->update($data,"id=$id");
        }else{
            $rs = M('set_return')->insert($data);
        }
        if($rs){
            $re_msg['msg'] = '执行成功!';
        }
        echo json_encode($re_msg);
    }
    
    // 微信配置信息
    public function show_weixin(){

        $cache = cache::getClass();
        $data['config'] = $cache->hGetAll("wechat");
        $this->template->content    = new View('admin/config/weixin_view',$data);
        $this->template->render();
    }   
    // 保存微信配置信息
    public function saveWeixin(){
        $str = P('str','');
        $array = json_decode($str,true);
        $cache = cache::getClass();

        foreach ($array[0] as $key => $value) {
            if($key != ''){
                $rs = $cache->hSet('wechat',"$key","$value");
            }            
        }
        echo 1;
    }
    // 删除微信配置
    public function delWeixin(){
        $name = P('name','');
        $cache = cache::getClass();
        $rs = $cache->hDel('wechat',$name);
        echo $rs;
    }
    // 修改登录密码页面
    public function password(){
        $this->template->content = new View('admin/config/password_view');
        $this->template->render();
    }

    // 修改登录密码
    public function save_pwd(){
        $oldpwd = md5($GLOBALS['config']['md5Key'].P('oldpwd'));
        $password = P('password');
        $rpassword = P('rpassword');

        $re_msg['success'] = 0;
        $re_msg['msg'] = "修改失败";

        if($password != $rpassword){
            $re_msg['msg'] = "两次输入密码不一致!";
            echo json_encode($re_msg);
            exit;
        }
        if($oldpwd == $password){
            $re_msg['msg'] = "新密码和旧密码不能一样的!";
            echo json_encode($re_msg);
            exit;
        }

        $result = M("account")->getOneData("passwd='".$oldpwd."' and id=".$this->account_id);
        if($result){            
            $data['passwd'] = md5($GLOBALS['config']['md5Key'].$password);
            $rs = M("account")->update($data,"id=".$this->account_id);
            if($rs){
                $re_msg['success'] = 1;
                $re_msg['msg'] = "修改成功";
            }
        }else{
            $re_msg['msg'] = "旧密码错误";
        }

        echo json_encode($re_msg);
    }
}
