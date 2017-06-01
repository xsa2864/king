<?php defined('KING_PATH') or die('访问被拒绝.');
class coupon_Controller extends Template_Controller
{
    public function __construct()
    {
        parent::__construct();
        comm_ext::validUser();       
    }
    
    // 优惠券首页
    public function index()
    {          
        $index = S(4);
        $tab_class = $index;
        $add_where = "";
        if($index == 99 || $index == ''){
            //全部

        }elseif($index == 1){
            //待付款
            $s_arr['tc.paystatus'] = '0';

        }elseif($index == 2){
            //待收货
            $s_arr['tc.is_use'] = 1;
            $s_arr['tc.paystatus'] = 1;

        }elseif($index == 3){
            //已使用
            $s_arr['tc.is_use'] = 2;
        
        }elseif($index == 4){
            // 待发货
            $s_arr['tc.is_use'] = '0';
            $s_arr['tc.paystatus'] = 1;
        }elseif($index == 5){
            // 交易关闭
            $s_arr['tc.paystatus'] = -1;            
        }

        if(G('member_id','')!=''){
            $s_arr['tc.member_id'] = G('member_id','');     
        }

        // 用户昵称 start
        $n_data['nickname like'] = G('nickname','');
        $n_wh = "";
        $n_wh = file_ext::get_where($n_data);
        if($n_wh!=''){
            $list_id = '';
            $nql = "SELECT GROUP_CONCAT(id) list_id FROM tf_member WHERE $n_wh";
            $n_rs = M()->query($nql);
            if($ot_where != ''){
                $ot_where .= " and ";
            }
            $ot_where = $n_rs[0]->list_id==""? "tc.member_id=-1":"tc.member_id in (".$n_rs[0]->list_id.")";
        }
        // 用户昵称 end

        // 条件搜索
        $s_arr['tc.code like'] = G('code','');
        $s_arr['tc.title like'] = G('title','');
        $s_arr['lc.type'] = G('type','');
        $s_arr['minPrice']['tc.price >='] = G('minPrice','');
        $s_arr['maxPrice']['tc.price <='] = G('maxPrice','');
        $s_arr['stime']['tc.addtime >='] = 
        $s_arr['etime']['tc.addtime <='] = G('endTime','');
        $s_where = "";
        $s_where = file_ext::get_where($s_arr);

   
        $where = $ot_where=="" ? $s_where:($s_where==""?$ot_where:$ot_where." and ".$s_where);
        $where = $where=="" ? $add_where:($add_where==""?$where:$where." and ".$add_where);
        $all_where = $where=="" ? "":" WHERE $where";
        $all_sql = "SELECT COUNT(*) num FROM tf_tk_coupon tc 
                LEFT JOIN tf_member b ON tc.member_id=b.id
                LEFT JOIN tf_tk_item ti ON ti.id=tc.item_id
                $all_where";
         
        $all_rs = M()->query($all_sql);
        $total = $all_rs[0]->num;

        $data['pagination'] = pagination::getClass(array(
            'total'			=> $total,
            'perPage'		=> 20,
            'segment' => 'page'
            ));
        $start		= ($data['pagination']->currentPage-1)*20;

        $rs	= M('tk_coupon tc')->join('member b','tc.member_id=b.id')->join('tk_item ti','ti.id=tc.item_id')->select("tc.*,b.nickname,ti.title")->where($where)->orderby(" tc.addtime desc")->limit($start,20)->execute();

        $data['list']	= $rs;
        $data['tab_class'] = $tab_class;
        $data['code'] = G('code','');
        $data['item_title'] = G('item_title','');
        $data['startTime'] = G('startTime','');

        // 统计数量
        $this->mod = M('tk_coupon tc');
        $unset = array("paystatus","is_use");
        // url 
        $query_url = file_ext::get_url(G(),$unset);
        // where 
        $unset = array('tc.is_use','tc.paystatus');
        $where = file_ext::get_where($s_arr,$unset);
        // 全部
        $where = $where!="" ?($ot_where==""?$where:$where.' and '.$ot_where):$ot_where;
        $data['total'] = $this->mod->getAllCount($where);
        $data['total_url'] = '?'.($query_url !='' ? $query_url:'');
        // 待付款
        $wh = $where!="" ?$where." and tc.paystatus=0":"tc.paystatus=0";
        $data['no_pay'] = $this->mod->getAllCount($wh);
        $data['no_pay_url'] = '?'.($query_url !='' ? ($query_url.'&paystatus=0'):'paystatus=0');

        // 交易完成
        $wh = $where!="" ?$where." and tc.is_use=2 and tc.paystatus=1":"tc.is_use=2 and tc.paystatus=1";
        $data['use'] = $this->mod->getAllCount($wh);
        $data['use_url'] = '?'.($query_url !='' ? $query_url.'&is_use=2':'is_use=2');
        // 待发货
        $wh = $where!="" ?$where." and tc.is_use=0 and tc.paystatus=1":"tc.is_use=0 and tc.paystatus=1";
        $data['no_send'] = $this->mod->getAllCount($wh);
        $data['no_send_url'] = '?'.($query_url !='' ? $query_url.'&is_use=0&paystatus=1':'is_use=0&paystatus=1');
        // 待收货
        $wh = $where!="" ?$where." and tc.is_use=1 and tc.paystatus=1":"tc.is_use=1 and tc.paystatus=1";
        $data['no_use'] = $this->mod->getAllCount($wh);
        $data['no_use_url'] = '?'.($query_url !='' ? $query_url.'&is_use=1&paystatus=1':'is_use=1&paystatus=1');
        // 申请退款
        $wh = $where!="" ?$where." and tc.is_use=-1":"tc.is_use=-1";
        $data['return'] = $this->mod->getAllCount($wh);
        $data['return_url'] = '?'.($query_url !='' ? $query_url.'&is_use=-1':'is_use=-1');
        // 退款完成
        // $add_where = " (tc.is_use = 1 or tc.is_use = -2 or tc.is_use = -3 or tc.paystatus = -1)";
        // $wh = $where=="" ? $add_where:($add_where==""?$where:$where." and ".$add_where);
        $wh = $where!="" ?$where." and tc.is_use=-2":"tc.is_use=-2";
        $data['over_return'] = $this->mod->getAllCount($wh);
        $data['over_url'] = '?'.($query_url !='' ? $query_url.'&is_use=-2':'is_use=-2');
        // 交易关闭
        $wh = $where!="" ?$where." and tc.paystatus=-1":"tc.paystatus=-1";
        $data['close'] = $this->mod->getAllCount($wh);
        $data['close_url'] = '?'.($query_url !='' ? $query_url.'&paystatus=-1':'paystatus=-1');
 

        $this->template->content    = new View('admin/coupon/index_view',$data);
        $this->template->render();
    }
    // 优惠券编辑
    public function edit_category(){
        $id = G('id','');
        if($id == ''){
          input::redirect('admin/coupon/category');
        }
        $data['list'] = M('tk_category')->getOneData("id=$id");
        $data['b_list'] = M('tk_business')->select("id,name")->where("status=1")->execute();

        $this->template->content    = new View('admin/coupon/edit_view',$data);
        $this->template->render();
    }
    // 批量删除订单
    public function del_more(){
        $id = P('id','');
        $re_msg['success'] = 0;
        $re_msg['msg'] = "删除失败";
        $rs = M('tk_coupon')->delete("id in ($id)");
        if($rs){
          $re_msg['success'] = 1;
          $re_msg['msg'] = "删除成功";
        }
        echo json_encode($re_msg);
    }
    // 优惠券分类
    public function category(){

        $data['list'] = M('tk_category')->select()->orderby("addtime desc")->execute();
        $this->template->content    = new View('admin/coupon/category_view',$data);
        $this->template->render();
    }
    // 保存分类
    public function save(){        
        $name = P('name','');
        $re_msg['success'] = 0;
        $re_msg['msg'] = '添加失败!';
        $data['name'] = $name;
        $data['addtime'] = time();
        $rs = M('tk_category')->save($data);
        if($rs){
          $re_msg['success'] = 1;
          $re_msg['msg'] = '添加成功!';
        }
        echo json_encode($re_msg);
    }
    public function save_business(){
        $re_msg['success'] = 0;
        $re_msg['msg'] = '更新失败!';
        $id = P('id','');
        $data['name'] = P('name','');
        $data['business_id'] = P('str','');
        $rs = M('tk_category')->update($data,"id=$id");
        if($rs){
          $re_msg['success'] = 1;
          $re_msg['msg'] = '更新成功!';
        }
        echo json_encode($re_msg);
    }
    // 删除分类
    public function del_category(){
        $id = P('id','');

        $re_msg['success'] = 0;
        $re_msg['msg'] = '删除失败!';

        $rs = M('tk_category')->delete("id=$id");
        if($rs){
          $re_msg['success'] = 1;
          $re_msg['msg'] = '删除成功!';
        }
        echo json_encode($re_msg);
    }
    public function edit()
    {
        list($id)	= $this->input->getArgs();
        $data['row']        = $this->mod->getOneData("id='$id'");
        $this->template->content = new View('admin/link/add_view',$data);
        $this->template->render();            
    }   
    // 编辑订单
    public function coupon_edit(){
        $id = G('id','');
        $rs = M("tk_coupon")->getOneData("id=$id");
        if($rs->member_id){
            $mrs = M("member")->getOneData("id=".$rs->member_id);
            $data['member'] = $mrs;
        }
        if($rs->tkb_id){
            $brs = M("tk_business")->getOneData("id=".$rs->tkb_id);
            $data['business'] = $brs;
        }
        $data['coupon'] = $rs;

        $this->template->content = new View('admin/coupon/couponedit_view',$data);
        $this->template->render();    
    }
    // 订单保存
    public function coupon_save(){
        $re_msg['success'] = 0;
        $re_msg['msg'] = '保存失败!';

        $id = P('id','');
        $is_use = "";
        if($id){            
            $paystatus  = P('paystatus','');
            $is_use  = $paystatus=='is_1' ? -1:($paystatus=='is_2' ? -2:"");
            $pay = $is_use!=""?1:$paystatus;
            $data['code']   = P('code','');
            $data['number'] = P('number','');
            $data['price']  = P('price','');
            $data['paystatus']  = $pay;
            $data['paytime']    = strtotime(P('paytime',''));
            $data['is_use']     = $is_use!=""?$is_use:P('is_use','');
            $data['usetime']    = strtotime(P('usetime',''));
            $data['addtime']    = strtotime(P('addtime',''));
            $data['returntime'] = strtotime(P('returntime',''));
            $data['is_give']    = P('is_give','');
            $data['givetime']   = strtotime(P('givetime',''));
            $data['timetype']   = P('timetype',1);
            $data['validtime']  = P('validtime',0);
            $data['starttime']  = strtotime(P('starttime',''));
            $data['endtime']    = strtotime(P('endtime',''));
            $data['note']       = P('note','');
            $data['bus_type']   = P('bus_type',0);
            $data['mem_type']   = P('mem_type',0);
            $data['bus_num']    = P('bus_num',0);
            $data['mem_num1']   = P('mem_num1',0);
            $data['mem_num2']   = P('mem_num2',0);
            $data['mem_num3']   = P('mem_num3',0);

            if(empty($data['closetime']) && $data['paystatus'] == -1){
                $data['closetime'] = time();
            }
            
            if(empty($data['paytime']) && $data['paystatus'] == 1){
                $data['paytime'] = time();
            }elseif(!empty($data['paytime']) && $data['paystatus'] == 0 && $data['is_use'] == 0){
                $data['paytime'] = '';
            }
            if(empty($data['usetime']) && ($data['is_use'] == 1 || $data['is_use'] == -1)){
                $data['usetime'] = time();
            }elseif(!empty($data['usetime']) && $data['is_use'] == 0){
                $data['usetime'] = '';
            }
            if(empty($data['returntime']) && $data['is_use'] == -1){
                $data['returntime'] = time();
            }elseif(!empty($data['returntime']) && $data['is_use'] != -1){
                $data['returntime'] = '';
            }
            if(empty($data['givetime']) && $data['is_give'] == 1){
                $data['givetime'] = time();
            }elseif(!empty($data['givetime']) && $data['is_give'] == 0){
                $data['givetime'] = '';
            }
            if($data['timetype'] == 0){
                $data['starttime'] = 0;
                $data['endtime'] = time()+$data['validtime']*24*3600;
            }

            $rs = M('tk_coupon')->update($data,"id=$id");
            if($rs){
                $re_msg['success'] = 1;
                $re_msg['msg'] = '保存成功!';
            }
        }
        echo json_encode($re_msg);
    }
    // 订单详情
    public function detail(){
        $id = G('id','');
        $code = G('code',"");
        if($id != ''){
            $where = "c.id=$id";
        }else{
            $where = "c.code=$code";
        }
        
        $rs = M('tk_coupon c')->join("tk_item ti","ti.id=c.item_id")->where($where)->select("c.*,ti.title as item_title")->execute();
        $result = $rs[0];
        if($result->is_use == 1){
          $sql = "SELECT lc.price,lc.note,lc.`type`,m.realName FROM tf_tk_log_commission lc
                  LEFT JOIN tf_member m ON m.id=lc.to_member_id 
                  WHERE lc.coupon_id=$result->id AND lc.member_id=$result->member_id";
          $data['commission'] = M()->query($sql);
        }
        if($result->member_id){
            $mrs = M("member")->getOneData("id=".$result->member_id);
            $data['member'] = $mrs;
        }
        if($result->tkb_id){
            $brs = M("tk_business")->getOneData("id=".$result->tkb_id);
            $data['business'] = $brs;
        }
        if($result->member_id){
            $tl_rs = M('tk_log_commission lc')->join("member m","m.id=lc.to_member_id")->select("lc.*,m.nickname")->where("lc.member_id=".$result->member_id." and lc.coupon_id=".$result->id)->orderby(" lc.type desc")->execute();
            $data['commission'] = $tl_rs;
        }
        if($result->member_id){
            $lce_rs = M('tk_log_consume')->getOneData("coupon_id=".$result->id,"get_price,tkb_name,addtime");
            $data['bcommission'] = $lce_rs;
        }
        $data['coupon'] = $result;
        $this->template->content = new View('admin/coupon/detail_view',$data);
        $this->template->render();        
    }
    // 确认退款
    public function mk_sure(){
        $id = P('id','');

        $re_msg['success'] = 0;
        $re_msg['msg'] = '审核失败!';
        
        $type = P('type',0);
        $data['note'] = P('note','');
        if($type == 0){
            $data['is_use'] = 0;
        }else{
            $data['is_use'] = -2;
        }        
        $data['overtime'] = time();  

        $rs = M('tk_coupon')->update($data,"id=$id and is_use='-1'");  
        if($rs){      
            // 是否同意退款
            $result = M("tk_coupon")->getOneData("id=$id","code,price,is_use,member_id");
            if($result->is_use == -2){ 
                // 数据回滚
                $arr = tuoke_ext::return_commission($result->member_id,$id);    
  
                // 调用退款接口
                $cache = cache::getClass();
                $order_sn = $cache->get('orderIdsn:'.$id);
                if(!$order_sn){
                    $order_sn = $result->code;
                }
                 // 计算退款金额
                $re_info = M("set_return")->getOneData("id=1");                
                $return_price = $price*(1-$re_info->percent/100);

                $array = return_ext::returnPay($order_sn,$result->price,$return_price);
                file_put_contents('upload/return/'.date('Y-m-d',time()).'.txt',date('H:i:s',time()).'=1>'.json_encode($array)."\t\n",FILE_APPEND);
                if($array){
                    $log_data['member_id'] = $result->member_id;
                    $log_data['coupon_id'] = $id;
                    $log_data['code'] = $result->code;
                    $log_data['order_sn'] = $order_sn;
                    $log_data['content'] = json_encode($array);
                    $log_data['re_price'] = $return_price;
                    $log_data['addtime'] = time();
                    $log_rs = M("tk_log_return")->save($log_data);
                }
                file_put_contents('upload/return/'.date('Y-m-d',time()).'.txt',date('H:i:s',time()).'=3>'.$log_rs."\t\n",FILE_APPEND);
            }
            $re_msg['success'] = 1;  
            $re_msg['msg'] = "审核成功!";      
        }
        echo json_encode($re_msg);
    }
    // 确认关闭优惠券
    public function close(){
        $id = P('id','');
        $re_msg['success'] = 0;
        $re_msg['msg'] = '关闭失败!';

        $data['paystatus'] = -1;  
        $data['closetime'] = time();
        $rs = M('tk_coupon')->update($data,"id=$id and paystatus=0");     
        if($rs){      
          $re_msg['success'] = 1;
          $re_msg['msg'] = "关闭成功!";       
        }
        echo json_encode($re_msg);
    }
    function _fgetcsv(& $handle, $length = null, $d = ',', $e = '"') {
        $d = preg_quote($d);
        $e = preg_quote($e);
        $_line = "";
        $eof=false;
        while ($eof != true) {
            $_line .= (empty ($length) ? fgets($handle) : fgets($handle, $length));
            $itemcnt = preg_match_all('/' . $e . '/', $_line, $dummy);
            if ($itemcnt % 2 == 0)
                $eof = true;
        }
        $_csv_line = preg_replace('/(?: |[ ])?$/', $d, trim($_line));
        $_csv_pattern = '/(' . $e . '[^' . $e . ']*(?:' . $e . $e . '[^' . $e . ']*)*' . $e . '|[^' . $d . ']*)' . $d . '/';
        preg_match_all($_csv_pattern, $_csv_line, $_csv_matches);
        $_csv_data = $_csv_matches[1];
        for ($_csv_i = 0; $_csv_i < count($_csv_data); $_csv_i++) {
            $_csv_data[$_csv_i] = preg_replace('/^' . $e . '(.*)' . $e . '$/s', '$1' , $_csv_data[$_csv_i]);
            $_csv_data[$_csv_i] = str_replace($e . $e, $e, $_csv_data[$_csv_i]);
        }
        return empty ($_line) ? false : $_csv_data;
    } 
    // 上传csv
    public function uploadcsv(){        
        $re_msg['success'] = 0;
        $re_msg['msg'] = "上传失败";

        // if($_FILES['file']['type'] != 'application/octet-stream'){
        //     $re_msg['msg'] = "上传表格要csv格式";
        //     echo json_encode($re_msg);
        //     exit;
        // }
        $file = file($_FILES["file"]['tmp_name']);
        foreach ($file as $key => $value) {
            $str = iconv('gbk','utf8',$value);
            $data[] = explode(',', $str);
        }
        // 导入模板
 // move_uploaded_file($_FILES["file"]["tmp_name"],"upload/csv/".$_FILES["file"]["name"]);

        if(count($data[0])<=10){
            $re_msg['msg'] = "上传表格内容有误，请下载模板编辑数据再导入";
            echo json_encode($re_msg);
            exit;
        }
        $rep = "";
        $str = "(\"";
        if(!empty($data)){
            foreach ($data as $key => $value) {
                $mobile = trim($value[2]);
                $openid = trim($value[12]);
                $is_rs = M("tk_business")->getOneData("mobile='".$mobile."' or openId='".$openid."'");
                if(!empty($mobile) && !empty($openid) && !$is_rs){                    
                    if($key>0){                    
                        if($str != "(\""){
                            $str .= ",(\"";
                        }
                        foreach ($value as $keys => $item) {
                            $str .= $item;
                            if($keys < count($value)-1 ){
                                $str .= "\",\"";
                            }
                            if($keys == count($value)-1 ){
                                $str .= "\",".time();
                            }
                        }
                        $str .= ")";
                    }
                }else{
                    $rep .= "电话号码:".$mobile." openid:".$openid."\n\t";
                }
            }
        }else{
            $re_msg['msg'] = "上传内容有误";
        }
        if($str != "(\""){
            $rs = M()->query("INSERT INTO tf_tk_business                 
                (name,realname,mobile,zh_name,address,city,content,status,sell_num,amount,lat,lng,openId,addtime) 
                VALUES 
                $str");
            if($rs){
                $re_msg['success'] = 1;
                $re_msg['msg'] = "导入成功";
            }
        }else{
            $re_msg['msg'] = "导入失败";
        }
        $re_msg['info'] = $rep==''?'':$rep;
        echo json_encode($re_msg);        
    }
    // 导出订单
    public function order_excel(){
        $tab_class = G("tab_class");
        $code =  G('code','');
        $startTime = G('startTime','');
        $endTime = G('endTime','');
        $where = ' 1 ';
        if($tab_class == 1){
          $where = " paystatus = 0 ";
        }else if($tab_class == 2){
          $where = " is_use = 1 and paystatus = 1";
        }else if($tab_class == 3){
          $where = " is_use = 2 and paystatus = 1";
        }else if($tab_class == 4){
          $where = " is_use = 0 and paystatus = 1";
        }else if($tab_class == 5){
          $where = " paystatus = -1";
        }

        if($code != ''){
          $where = "code = $code ";
        }
        if($startTime != ''){
          if($endTime != ''){
            $where = "addtime >= unix_timestamp('$startTime') and addtime < unix_timestamp('$endTime') ";            
          }else{
            $where = "addtime >= unix_timestamp('$startTime')";
          }
          $code = '';
        }

        $sql = "SELECT m.nickname,tc.code,tc.express_name,tc.express,tc.title,tc.price, tc.ADDTIME, 
                CASE tc.paystatus 
                WHEN 0 THEN '未付款' 
                WHEN 1 THEN '已付款' 
                WHEN -1 THEN '关闭订单' 
                END AS paystatus,
                tc.paytime, 
                CASE tc.is_use 
                WHEN 0 THEN '未发货' 
                WHEN 1 THEN '已发货' 
                WHEN 2 THEN '确认收货' 
                END AS is_use,
                tc.usetime,
                tc.overtime
                FROM tf_tk_coupon as tc
                left join tf_member as m on m.id=tc.member_id
                where $where";

        $rs = M()->query($sql);
        $data = json_decode(json_encode($rs),true);
        $title = array('昵称','订单号','快递公司','发货单号','商品名称','价格','添加时间','支付情况','付款时间','订单状态','发货时间','完成时间');
        $name = "order";
        output_ext::exportexcel($data,$title,$name);
    }

    // 发货
    function send_sure(){
        $id = P('id');
        $re_msg['success'] = 0;
        $re_msg['msg'] = '发货失败';
        $data['express'] = P("express");
        $data['express_name'] = P("express_name");
        $data['is_use'] = 1;
        $data['usetime'] = time();
        $rs = M('tk_coupon')->update($data,"id=$id");
        if($rs){
            $re_msg['success'] = 1;
            $re_msg['msg'] = '发货成功';
        }
        echo json_encode($re_msg);
    }
}
