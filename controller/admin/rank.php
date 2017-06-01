<?php
defined('KING_PATH') or die('访问被拒绝.');

class Rank_controller extends Template_Controller {

    public function __construct() {
        parent::__construct();
        comm_ext::validUser();      
        $this->account_id = accountInfo_ext::accountId();  
    }
    // 配置首页
    public function index() {
        $rank['list'] = M('member_rank')->select()->where("account_id=".$this->account_id)->execute(); 
        $this->template->content    = new View('admin/rank/rank_view',$rank);
        $this->template->render();
    }
    // 更新或者添加配置信息
    public function save(){
        $id = P('id');
        $data['commission']      = P('commission');
        $data['refunds']         = P('refunds');
        $data['sell_num']        = P('sell_num');
        $data['qr_code']         = P('qr_code');
        $data['points']          = P('points');
        $data['golds']           = P('golds');
        $data['warning_stock']   = P('warning_stock');
        $data['share_description'] = P('share_description');

        $re_msg['msg'] = '执行失败!';
        if($id>0){
            $rs = M('a_config')->update($data,"id=$id and account_id=".$this->account_id);
        }else{
            $data['account_id']      = $this->account_id;
            $rs = M('a_config')->insert($data);
        }

        if($rs){
            $re_msg['msg'] = '执行成功!';
        }
        echo json_encode($re_msg);
    }
}
