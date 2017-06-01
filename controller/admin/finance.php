<?php
defined('KING_PATH') or die('访问被拒绝.');

class Finance_controller extends Template_Controller {

    public function __construct() {
        parent::__construct();
        comm_ext::validUser();      
        $this->account_id = accountInfo_ext::accountId();  
    }
    // 配置首页
    public function index() {
        // auto_ext::money_member();
        $rs = M('set_finance')->getOneData("id=1");
        $this->template->content    = new View('admin/finance/index_view',json_decode(json_encode($rs),true));
        $this->template->render();
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
            $rs = M('a_config')->update($data,"id=$id and account_id=".$this->account_id);
        }else{
            $data['account_id']   = $this->account_id;
            $data['addtime']      = time();
            $rs = M('a_config')->insert($data);
        }

        if($rs){
            $re_msg['msg'] = '执行成功!';
        }
        echo json_encode($re_msg);
    }
    // 批量删除记录
    public function del_more(){
        $id = P('id','');
        $re_msg['success'] = 0;
        $re_msg['msg'] = "删除失败";
        $rs = M('tk_log_consume')->delete("id in ($id)");
        if($rs){
          $re_msg['success'] = 1;
          $re_msg['msg'] = "删除成功";
        }
        echo json_encode($re_msg);
    }
     // 退款日志页面
    public function show_return(){     
        // 条件搜索
        $h_arr['lr.code'] = G('order_sn','');
      
        $where = "";
        $where = file_ext::get_where($h_arr);
        $wh = $where!=""?$where." group by lr.code":" 1 group by lr.code";
        $total = M('tk_log_return lr')->getAllCount($wh);
        $data['pagination'] = pagination::getClass(array(
            'total'         => $total,
            'perPage'       => 20,
            'segment' => 'page'
            ));
        $start      = ($data['pagination']->currentPage-1)*20;

        $data['List'] = M('tk_log_return lr')->join("member m","m.id=lr.member_id")->join("tk_coupon tc","tc.id=lr.coupon_id")->select("lr.*,m.nickname,m.head_img,tc.title,tc.price,tc.returntime,count(lr.type) as type_status")->where($where)->groupby("lr.code")->orderby("lr.addtime desc")->limit($start,20)->execute();
        $data['order_sn'] = $h_arr['lr.order_sn'];
        $this->template->content    = new View('admin/finance/return_view',$data);
        $this->template->render();
    }
    // 获取退款订单详情
    public function get_more_info(){
        $code = P('code','');
        $type = P('type','');
        $rs = M('tk_log_return lr')->join("member m","m.id=lr.member_id")->join("tk_coupon tc","tc.id=lr.coupon_id")->select("lr.*,m.nickname,m.head_img,tc.title,tc.price,tc.returntime,tc.paytime")->where("lr.code=$code and lr.type=$type")->execute();
        $result = json_decode(json_encode($rs[0]),true);
        $str = "";
        if($result){
            $str .='<label>头像：</label><label><img src='.$result['head_img'].' width=50></label><br>';
            $str .='<label>昵称：</label><label>'.json_decode($result['nickname']).'</label><br>';
            $str .='<label>会员ID：</label><label>'.$result['member_id'].'</label><br>';
            // $str .='<label>原订单号：</label><label>'.$result['code'].'</label><br>';
            $str .='<label>退款订单号：</label><label>'.$result['code'].'</label><br>';
            $str .='<label>状态：</label><label>'.($result['type']==1?"申请退款":"退款完成").'</label><br>';
            $str .='<label>商品名称：</label><label>'.$result['title'].'</label><br>';
            $str .='<label>商品价格：</label><label>'.$result['price'].'</label><br>';
            $str .='<label>退款价格：</label><label>'.$result['re_price'].'</label><br>';
            $str .='<label>创建时间：</label><label>'.($result['addtime']>0?date('Y-m-d H:i:s',$result['addtime']):'').'</label><br>';
            $str .='<label>付款时间：</label><label>'.($result['paytime']>0?date('Y-m-d H:i:s',$result['paytime']):'').'</label><br>';
            $str .='<label>申请退款时间：</label><label>'.($result['returntime']>0?date('Y-m-d H:i:s',$result['returntime']):'').'</label><br>';
            $str .='<label>完成时间：</label><label>'.($result['addtime']>0?date('Y-m-d H:i:s',$result['addtime']):'').'</label><br>';
        }
        echo $str;
    }
    // 获取退款接口详情
    public function get_detail(){
        $code = P('code','');
        $type = P('type','');
        $rs = M("tk_log_return")->getOneData("code=$code and type=$type","content");
        $arr = json_decode($rs->content,true);
        $str = '';
        foreach ($arr as $key => $value) {
            $str .='<label>'.$key.'：</label><label>'.$value.'</label><br>';
        }        
        echo $str;
    }
    // 提现日志页面
    public function show_cash(){        
        $order_sn = G('order_sn','');
        $where = '';
        if($order_sn!=''){
            $where = "order_sn = $order_sn";
        }
        $total = M('tk_log_cash')->getAllCount($where);
        $data['pagination'] = pagination::getClass(array(
            'total'         => $total,
            'perPage'       => 20,
            'segment' => 'page'
            ));
        $start      = ($data['pagination']->currentPage-1)*20;
        $data['List'] = M('tk_log_cash')->select()->where($where)->limit($start,20)->execute();
        $data['order_sn'] = $order_sn;
        $this->template->content    = new View('admin/finance/cash_view',$data);
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
            $rs = M('set_points')->update($data,"id=$id and account_id=".$this->account_id);
        }else{
            $data['account_id']      = $this->account_id;
            $rs = M('set_points')->insert($data);
        }
        if($rs){
            $re_msg['msg'] = '执行成功!';
        }
        echo json_encode($re_msg);
    }
  
    // 更新退款配置
    public function saveFinance(){
        $id           = P("id");
        $data['poundage']  = P('poundage',0);
        $data['tax']  = P('tax',0);
        $data['type']  = P('type',0);
        $data['percent']  = P('percent',0);
        $data['member_time']  = P('member_time',0);
        $data['business_time']  = P('business_time',0);

        $re_msg['msg'] = '执行失败!';
        if($id>0){
            $rs = M('set_finance')->update($data,"id=$id");
        }else{
            $rs = M('set_finance')->insert($data);
        }
        if($rs){
            $re_msg['msg'] = '执行成功!';
        }
        echo json_encode($re_msg);
    }
    // 消费日志
    public function show_consume(){
        $h_arr['lc.order_sn'] = G('order_sn','');
        $h_arr['lc.tkb_name like'] = G('tkb_name','');
        $where = '';
        $where = file_ext::get_where($h_arr);

        $total = M('tk_log_consume lc')->getAllCount($where);
        $data['pagination'] = pagination::getClass(array(
            'total'         => $total,
            'perPage'       => 20,
            'segment' => 'page'
            ));
        $start      = ($data['pagination']->currentPage-1)*$data['pagination']->perPage;

        $data['list'] = M("tk_log_consume lc")->select()->where($where)->orderby("lc.status asc,lc.addtime desc")->limit($start,$data['pagination']->perPage)->execute();

        $result = M("set_finance")->getOneData("id=1",'business_time');
        $data['delay'] = $result->business_time;
        
        $data['order_sn'] = G('order_sn','');
        $data['tkb_name'] = G('tkb_name','');
        $this->template->content = new View('admin/finance/consume_view',$data);
        $this->template->render();
    }
}
