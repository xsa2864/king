<?php
defined('KING_PATH') or die('访问被拒绝.');
class Member_Controller extends Wechatbase_Controller
{    
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * 保存定位信息
     */
    public function index()
    {
        $data['user'] = $this->user;
        $data['commission'] = $this->user->commission;
        $data['freeze'] = tuoke_ext::get_freeze_money($this->user->id);
        $data['orderNum'] = M('tk_coupon')->getAllCount('member_id='.$this->user->id.' and isDel= 0');
        $this->template->content = new View('wechat/member/index_view',$data);
        $this->template->render();
    }
    
    /**
     * 保存定位信息
     */
    public function wallet()
    {
        $data['asset'] = $this->user->asset;
        $data['commission'] = $this->user->commission;
        $month = date('Ym' ,time());
        // 本月分红信息
        $my_rs = M("area_dividend")->getOneData("member_id=".$this->user->id." and day_num='$month'");

        if(!$my_rs){
            $my_rs->complete = 0;
            $my_rs->filter_num = 0;
            $my_rs->diff_num = dividend_ext::getComNum($this->user->shareId);
        }

        $data['dividend'] = $my_rs;
        //上个月分红    
        $month = date('Ym' ,strtotime("-1 month"));
        $rs=M("tk_log_commission")->getOneData("to_member_id=".$this->user->id." and day_num='$month'","price");
        $data['beforem'] = $rs->price;

        // 佣金日志
        $data['detail'] = M("tk_log_commission c")->select("m.nickname,c.addtime,c.price")->join('member m','m.id=c.member_id')->where("c.to_member_id=".$this->user->id." and c.type<2")->orderby("c.addtime desc")->limit(0,15)->execute();
        $total = M("tk_log_commission")->getAllCount("to_member_id=".$this->user->id." and type<2");
        $data['is_more'] = $total>15 ? 1 : 0;
        $this->template->content = new View('wechat/member/wallet_view',$data);
        $this->template->render();
    }


    // 获取更多的收入明细
    public function more_wallet(){
        $page = P('page');
        $pageNum = $page*15;

        $re_msg['success'] = 0;
        
        //收入
        $srlog = M("tk_log_commission c")->select("m.nickname,c.addtime,c.price")->join('member m','m.id=c.member_id')->where("c.to_member_id=".$this->user->id." and c.type<2")->orderby("c.addtime desc")->limit($pageNum,15)->execute();

        $number = M('tk_log_commission')->getAllCount("to_member_id=".$this->user->id." and type<2");

        $re_msg['more'] = $number>($pageNum+15)?1:0;

        $srlogStr='';
        if(!empty($srlog)){
            $re_msg['success'] = 1;          
            foreach($srlog as $item)
            {
                $item->price = sprintf('%.2f',$item->price);
                if($item->price==0){
                    continue;
                }
                if($item->type<=1)
                {
                    $srlogStr.='<li>￥'.$item->price.' ，来自'.json_decode($item->nickname).'的下单。<span class="content_list_right">'.date('m-d',$item->addtime).'</span></li>';
                }
            }
        }
        $re_msg['info'] = $srlogStr;
        echo json_encode($re_msg);
    }
    
    /**
     * 提现界面
     */
    public function drawMoney()
    {
        $this->template->bgcss = 'back2';
        $data['commission'] = $this->user->commission;
        $data['freeze'] = tuoke_ext::get_freeze_money($this->user->id);
        $this->template->content = new View('wechat/member/drawMoney_view',$data);
        $this->template->render();
    }
    
    /**
     * 提现验证
     */
    public function gotoCheck()
    {
        $money = mb_substr(P('money'),1,strlen(P('money')),'utf-8');
        if($money>0)
        {
            $commission = $this->user->commission;
            $freeze = tuoke_ext::get_freeze_money($this->user->id);
            if($commission-$freeze>=$money)
            {
                $cache = cache::getClass();
                $cache->set('userGetMoney:'.$this->user->id,$money);
                exit;
            }
            echo '可提现金额不足';exit;
        }
        echo '请输入正确金额';exit;
    }
    
    /**
     * 提现手机验证界面
     */
    public function safetyCheck()
    {
        $this->template->content = new View('wechat/member/safetyCheck_view');
        $this->template->render();
    }
    
    /**
     * 提现手机验证界面
     */
    public function checkCode()
    {
        $phone = P('phone');
        $code = P('code');
        $cache = cache::getClass();
        $phoneCode = $cache->get('userMsgCode:'.$phone);
        if($phoneCode)
        {
            $phoneCode = json_decode($phoneCode);
            if($phoneCode->code==$code)
            {
                if($phoneCode->time+300>time() && $phoneCode->used==0)
                {
                    $phoneCode->used=1;
                    $cache->set('userMsgCode:'.$phone,json_encode($phoneCode));
                    //绑定用户与手机关系
                    $cache->hSet('userIdPhome:'.$this->user->id,$phone,1);
                    $cache->hSet('phomeUserId:'.$phone,$this->user->id,1);
                    $money = $cache->Get('userGetMoney:'.$this->user->id);
                    
                    $re = M('tk_log_commission')->save(array('userId'=>$this->auth->id,'userType'=>$this->userType,'createTime'=>time(),'money'=>$this->money,'dir'=>2,'remark'=>'提现'));
                    if($re)
                    {

                    }
                }
                echo '验证码已失效';exit;
            }
        }
        echo '无效验证码';exit;
    }

    /**
     * 保存定位信息
     */
    public function savePosition()
    {
        $pos = P();
        $cache = cache::getClass();
        $cache->set('userPosition:'.$this->user->id,json_encode($pos));
        
    }

    /**
     * 手机验证码获取
     */
    public function getCode()
    {
        $phone = P('phone');
        if(!$phone)
        {
            echo json_encode(array('msg'=>'请输入手机号'));exit;
        }
        $cache = cache::getClass();
        $msgCode = $cache->get('userMsgCode:'.$phone);
        if($msgCode)
        {
            $msgCode = json_decode($msgCode);            
            $sec = time() - $msgCode->time;
            if(60 - $sec > 0)
            {
                if(!$msgCode->used)
                {
                    echo json_encode(array('sec'=>60 - $sec));exit;
                }
            }
        }
        $code = rand(10000,999999);
        if(!isset($_SERVER['TESTENV']))
        {
            sms_ext::send($phone,'您的验证码为'.$code.'，10分钟内有效。如非本人操作请忽略本短信。【拓客共享】');
        }
        $cache->set('userMsgCode:'.$phone,json_encode(array('code'=>$code,'time'=>time(),'used'=>0)));
        echo json_encode(array('sec'=>60));exit;
    }
    // 下级未付款会员列表
    public function nopay_list(){

        $result = array();        

        $result = M("member")->select("id,head_img,nickname")->where("pid='".$this->user->id."' and levelId=0")->execute(); 

        $data['total'] = M("member")->getAllCount("pid='".$this->user->id."' and levelId=0");
        $data['list'] = $result;
        $this->template->content = new View('wechat/member/nopay_view',$data);
        $this->template->render();
    }

    // 下级付过款会员列表
    public function next_list(){
        $id = G('id',0);
        $member_id = $id == 0 ? $this->user->id : $id;
        $result = array();
        $data['level'] = 1;
        $data['nickname'] = '';
        if($id != 0){         
            $leng = 13;   
            $rs = M("member")->getOneData("id=$id and pid=".$this->user->id);
            if($rs){
                $result = M("member")->select("id,head_img,nickname")->where("pid=$member_id and levelId=1")->execute();
                $nickname = json_decode($rs->nickname);  
            }else{
                $th_rs = M("member")->getOneData("id=$member_id");
                $nickname = json_decode($th_rs->nickname);                  
                $result = M("member")->select("id,head_img,nickname")->where("pid=$member_id and levelId=1")->execute();
                $data['level'] = 0;
            }
            if(strlen($nickname) > $leng){                    
                $nickname = mb_substr($nickname,0,$leng,"utf-8").'...';
            }  
            $data['nickname'] = $nickname;
        }else{
            $result = M("member")->select("id,head_img,nickname")->where("pid=$member_id and levelId=1")->execute();
        }

        $data['total'] = M("member")->getAllCount("pid=$member_id and levelId=1");
        $data['list'] = $result;
        $this->template->content = new View('wechat/member/nextlist_view',$data);
        $this->template->render();
    }
    // 团队完成情况
    public function get_target(){
        $day = S(4);
        if($day == 1){           
            // 本月分红信息            
            $month = date('Ym' ,time());
            $sql = "SELECT ad.complete,ad.filter_num,ad.diff_num,m.nickname FROM tf_area_dividend ad
                    RIGHT JOIN tf_member m ON m.id=ad.member_id WHERE m.pid='".$this->user->id."' and m.shareId>=2 and ad.day_num='$month'";
            $rs = M()->query($sql);          
            $data['list'] = $rs;
            $data['day'] = '本月';
            $my_rs = M("area_dividend")->getOneData("member_id=".$this->user->id." and day_num='$month'","complete");
            $data['rate'] = $my_rs->complete;
        }else{
            // 上月分红信息            
            $month = date('Ym' ,strtotime('-1 month'));
            $sql = "SELECT ad.complete,ad.filter_num,ad.diff_num,m.nickname FROM tf_area_dividend ad
                    RIGHT JOIN tf_member m ON m.id=ad.member_id WHERE m.pid='".$this->user->id."' and m.shareId>=2 and ad.day_num='$month'";
            $rs = M()->query($sql);
            $data['list'] = $rs;
            $data['day'] = '上月';
            $my_rs = M("area_dividend")->getOneData("member_id=".$this->user->id." and day_num='$month'","complete");
            $data['rate'] = $my_rs->complete;
        }
        
        $this->template->content = new View('wechat/member/target_view',$data);
        $this->template->render();
    }
    // 手机号绑定账号
    public function get_bind(){
        $data['id'] = S(4);
        $this->template->content = new View('wechat/member/bind_view',$data);
        $this->template->render();
    }
        // 获取验证码
    public function get_code(){
        $mobile = P('mobile');
        $array = yysms_ext::postRcodeSms($mobile);
        echo json_encode($array);
    }

    // 获取验证码
    public function chkRcode(){
        $mobile = P('mobile','');
        $codestr = P('codestr');
       
        $json = yysms_ext::chkRcode($mobile,$codestr);
        $arr = json_decode($json,true);
        $rs = 0;

        if($arr['errorno'] == 0){           
            $result = M("member")->getOneData("mobile=$mobile");
            $data['first'] = 0; 
            if($result){
                $data['openId'] = $this->user->openId;
                $data['nickname'] = $this->user->nickname;
                $rs = M("member")->update($data,"id=".$result->id);
                if($rs){
                    M("member")->delete("id=".$this->user->id);
                }
            }else{
                $data['mobile'] = $mobile;                
                $rs = M("member")->update($data,"id=".$this->user->id." and first=1");
            }     
        }
        echo $rs;
    }

    // 获取市区数据
    public function get_city(){
        $id = P("id");
        $result = M("region")->select()->where("parent_id=$id")->execute();        
        echo json_encode($result);
    }
}
