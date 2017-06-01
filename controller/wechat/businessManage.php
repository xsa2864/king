<?php defined('KING_PATH') or die('访问被拒绝.');
class BusinessManage_Controller extends Wechatbase_Controller
{
    public function __construct(){              
        parent::__construct();
        $type = G('type','');
        $b_rs = M("tk_business")->getOneData("openId='".$this->openid."'");
        $cache = cache::getClass();
        $data['tel'] = $cache->hGet("config","客服电话");        
        if($b_rs){
            $data['reason'] = $b_rs->note;
            if($b_rs->status == 1){
                $this->account = $b_rs->id;
                if($b_rs->is_first == 1){
                    M("tk_business")->update(array('is_first'=>0),"openId='".$this->openid."'");
                    $this->shop_edit();
                    exit;
                }
            }elseif($b_rs->status == 0 && $type == ""){
                $data['type'] = 'close';                
                $this->template->content = new View('wechat/businessManage/wait_view',$data);
                $this->template->render();
                exit;
            }elseif(($b_rs->status == 2 || $b_rs->status == -1) && $type == ""){
                $data['type'] = $b_rs->status==2?'apply':'refuse';
                $this->template->content = new View('wechat/businessManage/wait_view',$data);
                $this->template->render();
                exit;
            }elseif(($b_rs->status == 0 || $b_rs->status == -1) && $type == "again"){
                $data['type'] = 'again';
                $this->template->content = new View('wechat/businessManage/apply_view',$data);
                $this->template->render();
                exit;
            }
        }else{
            $this->template->content = new View('wechat/businessManage/apply_view',$data);
            $this->template->render();
            exit;
        }
    }
        
    public function index()
    {

    }
    // 店铺展示
    public function show_shop(){
        
    	$id = $this->account;

    	$this_month = strtotime(date('Y-m-1',time()));
    	$last_month = strtotime(date('Y-m-1',strtotime("-1 month")));
		$seven_day = strtotime(date('Y-m-d',strtotime("-7 day")));
		// 这个月
    	$sql = "SELECT count(*) `order`,count(distinct(member_id)) member FROM tf_tk_coupon WHERE tkb_id =$id and paytime>$this_month";
    	$rs = M()->query($sql);        
        $data['this_order'] = $rs[0]->order;
        $data['this_member'] = $rs[0]->member;

        $hql = "SELECT SUM(get_price) AS price FROM tf_tk_log_consume WHERE tkb_id=$id and addtime>$this_month";
        $ps = M()->query($hql);    
    	$data['this_price'] = $ps[0]->price;
    	// 上个月
		$sql = "SELECT count(*) `order`,count(distinct(member_id)) member FROM tf_tk_coupon WHERE tkb_id =$id and paytime<$this_month and paytime>$last_month";
    	$rs = M()->query($sql);
        $data['last_order'] = $rs[0]->order;
        $data['last_member'] = $rs[0]->member;
        
        $hql = "SELECT SUM(get_price) AS price FROM tf_tk_log_consume WHERE tkb_id=$id and addtime<$this_month and addtime>$last_month";
        $ps = M()->query($hql);   
    	$data['last_price'] = $ps[0]->price;
    	// 七天
    	$sql = "SELECT count(*) `order`,count(distinct(member_id)) member FROM tf_tk_coupon WHERE tkb_id =$id and paytime>$seven_day";
    	$rs = M()->query($sql);
        $data['seven_order'] = $rs[0]->order;
        $data['seven_member'] = $rs[0]->member;
        
        $hql = "SELECT SUM(get_price) AS price FROM tf_tk_log_consume WHERE tkb_id=$id and addtime>$seven_day";
        $ps = M()->query($hql);  
    	$data['seven_price'] = $ps[0]->price;
    	// 总和
    	$sql = "SELECT count(*) `order`,count(distinct(member_id)) member FROM tf_tk_coupon WHERE tkb_id =$id";
    	$rs = M()->query($sql);
        $data['all_order'] = $rs[0]->order;
        $data['all_member'] = $rs[0]->member;

        $hql = "SELECT SUM(get_price) AS price FROM tf_tk_log_consume WHERE tkb_id=$id";
        $ps = M()->query($hql);  
    	$data['all_price'] = $ps[0]->price;

    	$result = M("tk_business")->getOneData("id=$id");
    	$data['shop'] = $result;

     	// 获取微信参数
    	$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    	$array = jsapi_ext::get_signature($url);

    	$data['appId'] = $array['appId'];
 		$data['jsapi_ticket'] = $array['jsapi_ticket'];
    	$data['noncestr'] = $array['noncestr'];
    	$data['timestamp'] = $array['timestamp'];
    	$data['signature'] = $array['signature'];
        // 客服电话
        $cache = cache::getClass();
        $arr = $cache->hGetAll('config');
        $data['telphone'] = $arr['客服电话'];

    	$this->template->content = new View('wechat/businessManage/shop_view',$data);
        $this->template->render();
    }
    // 验证订单的有效性
    public function valid(){

    	$tkb_id = $this->account;  //商家id
    	$code = P("code");
    	$arr = tuoke_ext::use_coupon($code,$tkb_id);
    	echo json_encode($arr);
    }
    /**
     * 商家详情
     */
    public function shopdetail()
    {
        $data['bus'] = M('tk_business')->getOneData(array('id'=>$this->account));
        $data['gpsUrl'] = 'http://apis.map.qq.com/tools/routeplan/eword='.$data['bus']->name.'&epointx='.$data['bus']->lng.'&epointy='.$data['bus']->lat.'?referer=myapp&key=QLPBZ-3WU3R-SCEWE-WHR3D-OC3YZ-RLFM2';
        $this->template->content = new View('wechat/businessManage/shopdetail_view',$data);
        $this->template->render();              
    }
    // 店铺编辑
    public function shop_edit(){
        $data['latng'] = G('latng','');
        $data['address'] = G('addr','');
    	$id = $this->account;
    	$result = M("tk_business")->getOneData("id=$id");
    	$data['shop'] = $result;
    	$provincial = M("area")->select()->where("pid=0")->orderby("id asc")->execute();
    	$data['provincial'] = $provincial;

    	// 获取微信参数
    	$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    	$array = jsapi_ext::get_signature($url);

    	$data['appId'] = $array['appId'];
 		$data['jsapi_ticket'] = $array['jsapi_ticket'];
    	$data['noncestr'] = $array['noncestr'];
    	$data['timestamp'] = $array['timestamp'];
    	$data['signature'] = $array['signature'];
    	
    	$this->template->content = new View('wechat/businessManage/shopedit_view',$data);
        $this->template->render();
    }
    // 获取城市列表
    public function get_city(){
    	$id = P('id',0);
    	$rs = M("area")->where("pid=$id")->select()->orderby("id asc")->execute();
    	echo json_encode($rs);
    }
    // 保存店铺信息
    public function save_business(){
    	$re_msg['success'] = 0;
    	$re_msg['msg'] = "保存失败";
		$id = P('id');
		$data['pic'] = P('logo_url');
		$data['name'] = P('name');
		$data['realname'] = P('realname');
		$data['mobile'] = P('mobile');
        $data['address'] = P('address');
		$data['full_address'] = P('full_address');
		$data['content'] = P('content');
        $latng = P('latng','');
        // 坐标
        if($latng!=''){
            $loc = explode(',', $latng);
            $data['lng'] = $loc['1'];           //经度
            $data['lat'] = $loc['0'];           //纬度
        }
        $findme   = '市';
        $pos = strpos($data['address'], $findme);
        $data['city'] = substr($data['address'],0,$pos+3);

        // 定位坐标
        if(!empty($data['full_address']) && false){
            $baseString = "/ws/geocoder/v1/?key=QMOBZ-QBT3K-WNMJV-ATIUM-3W5CH-GOFZL&address=".$data['full_address'];
            $sk = 'IXYtGeRjWG1iQQ5pEpUjwIYLBr6zjn4s';
            $sn = md5(urlencode($baseString.$sk));
            $url = "http://apis.map.qq.com/ws/geocoder/v1/?key=QMOBZ-QBT3K-WNMJV-ATIUM-3W5CH-GOFZL&address=".$data['full_address']."&sn=".$sn;
            $json = file_get_contents($url);
            $arr = json_decode($json,true);
            $loc = $arr['result']['location'];
            $data['lng'] = $loc['lng'];
            $data['lat'] = $loc['lat'];
        }

        if(empty($data['mobile'])){
            $re_msg['msg'] = "联系电话不能为空!";
            echo json_encode($re_msg);exit;
        }
		$rs = M("tk_business")->update($data,"id=$id");
		if($rs){
			$re_msg['success'] = 1;
    		$re_msg['msg'] = "保存成功";
		}
		echo json_encode($re_msg);
    }
    
    // 商家的会员列表
    public function show_member(){    	

        $sql = "SELECT id,head_img,nickname,order_num,amount,loginTime FROM tf_member WHERE id IN (SELECT member_id FROM tf_tk_coupon WHERE tkb_id=".$this->account.") order by amount desc limit 0,10";
        $result = M()->query($sql);
        $data['total'] = count($result);
        $data['list'] = $result;
        $data['tkb_id'] = $this->account;

    	// $data['total'] = M("member")->getAllCount("account_id=".$this->account);
    	// $result = M("member")->select("id,head_img,nickname,order_num,amount,loginTime")->where("account_id=".$this->account)->orderby($orderby)->limit(0,10)->execute();
    	// $data['list'] = $result;

    	$this->template->content = new View('wechat/businessManage/memberlist_view',$data);
        $this->template->render();
    }
    // 获取更多的会员列表
    public function more_memberlist(){    	
    	$name = P('name');
    	$key = P('key');
    	$orderby = "";
    	if(!empty($name)){
    		if($key){
    			$orderby = "$name $key";
    		}else{
    			$orderby = "$name desc";
    		}
    	}else{
    		$orderby = "amount desc";
    	}

    	$page = P("page",1);
    	$start = 0;
    	$show_num = 10;
    	$start = $show_num*$page;

        $sql = "SELECT id,head_img,nickname,order_num,amount,loginTime FROM tf_member WHERE id IN (SELECT member_id FROM tf_tk_coupon WHERE tkb_id=".$this->account.") order by $orderby limit $start,$show_num";
        $result = M()->query($sql);

    	$str = '';       
    	foreach ($result as $key => $value) {
            $lasttime = tuoke_ext::lasttime($this->account,$value->id);
            $hs = tuoke_ext::get_ms_info($value->id,$this->account);

    		$str .= '<div class="toker_order member2_box" onclick="member_detail('.$value->id.')">';
            $str .= '<dl class="toker_dl">                                                           ';
            $str .= '    <dt><img src="'.$value->head_img.'" width="100%" height="100%" /></dt>';
            $str .= '    <dd>';
            $str .= '        <span class="f32">'.(empty($value->nickname)?'佚名':json_decode($value->nickname)).'</span>';
            $str .= '        <a href="#" style="display:none;">微信联系</a>';
            $str .= '    </dd>';
            $str .= '</dl>';
            $str .= '<h1>';
            $str .= '    Ta已经在店里消费了'.$hs['total'].'笔订单，';
            $str .= '    共计¥'.$hs['sum'].'，为您带来收益<font>¥'.$hs['amount'].'。</font>';
            $str .= '</h1>';
            $str .= '<h2 class="f28">最近使用时间：'.($lasttime>0?date('Y-m-d H:i:s',$lasttime):'').'</h2>';
            $str .= '</div>';
    	}
    	echo $str;
    }
    // 商家的会员详情
    public function member_detail(){
    	$id = S(4);
    	$rs = M("member")->getOneData("id=$id","id,head_img,nickname,order_num,amount,loginTime");
    	$data['member']  = $rs;
        $hs = tuoke_ext::get_ms_info($rs->id,$this->account);
        $data['hs'] = $hs;
    	$result = M("tk_coupon")->select()->where("member_id=$id and tkb_id=".$this->account)->limit(0,10)->execute();
        $data['total'] = M("tk_coupon")->getAllCount("member_id=$id and tkb_id=".$this->account);
    	$data['list']  = $result;
    	$this->template->content = new View('wechat/businessManage/memberdetail_view',$data);
        $this->template->render();
    }
    // 获取更多商家的会员列表
    public function get_more(){
        $member_id = P('id');
        $page = P("page");
        $pageNum = $page*10;
        $result = M("tk_coupon")->select()->where("member_id=$member_id and tkb_id=".$this->account)->limit($pageNum,10)->execute();
        $str = '';
        foreach ($result as $key => $value) {
            $status = '交易关闭';
            if($value->paystatus==0){
                $status = '待付款';
            }elseif($value->paystatus==1 && $value->is_use==1){
                $status = '交易完成';
            }elseif($value->paystatus==1 && $value->is_use==0 && $value->endtime>time()){
                $status = '待使用';
            }

            $str .= '<div class="toker_details order_h3"  onclick="show_detail('.$value->id.')">        ';
            $str .= '    <h5 class="tb">                                                                ';
            $str .= '        <span class="flex_1">订单编号:'.$value->code.'</span>                      ';
            $str .= '        <span>'.$status.'</span>                                                   ';
            $str .= '    </h5>                                                                          ';
            $str .= '    <dl class="list_dl order_dl tb">                                               ';
            $str .= '        <dt ><img src="'.input::site($value->pic).'"/></dt>                        ';
            $str .= '        <dd class="flex_1">                                                        ';
            $str .= '            <h1>'.$value->title.'</h1>                                             ';
            $str .= '            <div class="list_text pad">                                             ';
            $str .= '                <h3><font>￥</font>'.$value->price.'</h3>                           ';
            $str .= '            </div>                                                                 ';
            $str .= '        </dd>                                                                      ';
            $str .= '    </dl>                                                                                 ';
            $str .= '    <h2 class="f28">最近使用时间：'.($value->usetime?date('Y-m-d H:i:s',$value->usetime):'').'</h2>    ';
            $str .= '</div>                                                                                         ';
        }
        echo $str;
    }

    // 商家订单列表
    public function show_orderlist(){
    	$data['total'] = M("tk_coupon")->getAllCount("tkb_id=".$this->account);
    	$result = M("tk_coupon c")->select("c.id,c.code,c.pic,c.title,c.price,c.paystatus,c.is_use,c.paytime,c.addtime,m.nickname,m.head_img")->join('member m','m.id=c.member_id')->where("c.tkb_id=".$this->account)->orderby('addtime desc')->limit(0,10)->execute();
    	$data['orderlist'] = $result;
    	$this->template->content = new View('wechat/businessManage/orderlist_view',$data);
        $this->template->render();
    }
    // 获取更多订单列表
    public function more_orderlist(){
    	$where = "c.tkb_id=".$this->account;
    	$id = P('id','');
    	if($id != ''){
    		$where .= " and member_id=$id";
    	}
    	$page = P("page",1);
    	$start = 0;
    	$show_num = 10;
    	$start = $show_num*$page;
    	$result = M("tk_coupon c")->select("c.id,c.code,c.pic,c.title,c.price,c.paystatus,c.is_use,c.paytime,c.addtime,m.nickname,m.head_img")->join('member m','m.id=c.member_id')->where($where)->orderby('addtime desc')->limit($start,$show_num)->execute();
    	$str = "";
    	$info = "";
    	foreach ($result as $key => $value) {
    		if($value->paystatus == -1){
                $info = "关闭";
            }else if($value->paystatus == 0){
                $info = "待支付";
            }else{
                if($value->is_use == 0){
                    $info = "待使用";
                }elseif($value->is_use == 1){
                    $info = "交易完成";
                }elseif($value->is_use == -1){
                    $info = "申请退款";
                }elseif($value->is_use == -2){
                    $info = "完成退款";
                }
            }
    		$str .= '<div class="business order_h3 ">                                                         ';
            $str .= '    <h5 class="tb">                                                                      ';
            $str .= '        <span class="flex_1">订单编号:'.$value->code.'</span>                          ';
            $str .= '        <span>'.$info.'</span>                                                         ';
            $str .= '    </h5>                                                                                ';
            $str .= '    <dl class="list_dl order_dl tb" onclick="show_detail('.$value->id.')">             ';
            $str .= '        <dt ><img src="'.input::site($value->pic).'"/></dt>                               ';
            $str .= '        <dd class="flex_1">                                                              ';
            $str .= '            <h1>'.$value->title.'</h1>                                                 ';
            $str .= '            <div class="list_text pad">                                                  ';
            $str .= '                <h3><font>￥</font>'.$value->price.'</h3>                              ';
            $str .= '            </div>                                                                       ';
            $str .= '        </dd>                                                                            ';
            $str .= '    </dl>                                                                                ';
            $str .= '    <div class="toker_order member2_box">                                                ';
            $str .= '        <h2 class="f28">消费时间：'.($value->usetime>0?date('Y-m-d H:i:s',$value->usetime):'').'</h2>    ';
            $str .= '        <dl class="toker_dl pad_20">                                                     ';
            $str .= '            <dt><img src="'.$value->head_img.'" width="100%" height="100%" /></dt>     ';
            $str .= '            <dd>                                                                         ';
            $str .= '                <span class="f32">'.json_decode($value->nickname).'</span>               ';
            $str .= '                <a href="#" style="display:none;">微信联系</a>                             ';
            $str .= '            </dd>                                                                        ';
            $str .= '        </dl>                                                                            ';
            $str .= '    </div>                                                                               ';
            $str .= '</div>                                                                                   ';
    	}
    	echo $str;
    }
    // 订单详情
    public function show_detail(){
    	$id = S(4);
    	// $result = M("tk_coupon")->getOneData("id=$id");
    	$result = M("tk_coupon c")->select("c.code,c.pic,c.title,c.price,c.addtime,c.addtime,c.paytime,c.usetime,c.starttime,c.endtime,c.validtime,m.wxname,m.nickname,m.head_img")->join('member m','m.id=c.member_id')->where("c.id=$id")->execute();
    	// print_r($result);
    	$data['order'] = $result[0];
    	$this->template->content = new View('wechat/businessManage/detail_view',$data);
        $this->template->render();
    }
    // 生成二维码
    public function qr_code(){
    	$re_msg['success'] = 0;
    	$re_msg['msg'] = "生成失败!";
    	$id = P('id',0);

    	$data['code'] = "123456789123";
    	$data['member_id'] = 2;
    	$filename = 'upload/qrcode/qrcode_'.$id.'.png';
    	
    	$qrcode = qrcode::getClass();
		echo $qrcode->png(json_encode($data));

		// if(is_file($filename)){
  //           $re_msg['success'] = 1;
  //   		$re_msg['msg'] = "生成成功!";
  //   		$re_msg['filename'] = $filename;
  //       }

		// echo json_encode($re_msg);
    }

    // 上传图片
    public function get_material(){
		$media_id = P('serverId');
		$access_token = jsapi_ext::get_access_token();
// $media_id = "0VekHwpZNNV-SRKFPD6VN4Dnk2mn14Q-lQfN1jOe-fJwsw-gYsRfFLQUw0Rfx62H";
// $access_token = "Fwo8FVaE_FdjgPMSq1qx6Kp8Y4lq-aAzYFlYv0e6i4rsWmddHc9Maoh7clqYEV9s-W8nGGTOZAc2zgaAntYveqWnL9W_Cc_9bM6A3VaG9YrnEBF7dxiWt2-Ll7jwh3EYYTDjAFAEZJ";
		// $url = "https://api.weixin.qq.com/cgi-bin/media/get?access_token=$access_token&media_id=$media_id";
		$url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=$access_token&media_id=$media_id";

		$ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);    
        curl_setopt($ch, CURLOPT_NOBODY, 0);    //对body进行输出。
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $package = curl_exec($ch);  
        $httpinfo = curl_getinfo($ch);
        curl_close($ch);

 		$media = array_merge(array('mediaBody' => $package), $httpinfo);
        //求出文件格式
        preg_match('/\w\/(\w+)/i', $media["content_type"], $extmatches);
        $fileExt = $extmatches[1];
        $filename = time().rand(100,999).".$fileExt";
        $dirname = 'upload/'.date('Ym/d').'/';
        if(!file_exists($dirname)){
            mkdir($dirname,0777,true);
        }
        file_put_contents($dirname.$filename,$media['mediaBody']);
        file_put_contents($dirname.'upload.txt',date('Y-m-d H:i:s',time()).'=>'.$url."\t\n",FILE_APPEND);
        echo  $dirname.$filename;

    }

}
