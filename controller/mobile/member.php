<?php
defined('KING_PATH') or die('访问被拒绝.');
class Member_Controller extends Mobilebase_Controller
{    
    public function __construct()
    {
        parent::__construct();
        $this->template->currentCount = 4;
    }
    // 个人中心页面
    public function member_center(){
        $this->template->content = new View('mobile/member/member_center_view');
        $this->template->render();
    }

    // 获取个人信息
    public function get_center_info(){
        $re_msg['success'] = 0;
        $re_msg['msg'] = "获取失败";
        $result = M('member')->getOneData(array('id'=>$this->member_id));
        
        if(strstr($result->golds,'.'))
        {
            $ca = array_filter(explode(".",$result->golds));
            if($ca[1]==0)
            {
                if($ca[0])
                {
                    $result->golds = $ca[0];
                }
                else
                {
                    $result->golds = '0';
                }
            }
            else if($ca[1][1]==0)
            {
                $result->golds = $ca[0].'.'.$ca[1][0];
            }
        }
        if(strstr($result->points,'.'))
        {
            $ca = array_filter(explode(".",$result->points));
            if($ca[1]==0)
            {
                if($ca[0])
                {
                    $result->points = $ca[0];
                }
                else
                {
                    $result->points = '0';
                }
            }
            else if($ca[1][1]==0)
            {
                $result->points = $ca[0].'.'.$ca[1][0];
            }
        }
        if(!$result->levelName)
        {
            $result->levelName = '初级会员';
        }
        $result->note= M('system_msg')->getAllCount(array('member_id'=>$this->member_id,'is_read'=>'0'));
        if($result){
            $re_msg['success'] = 1;
            $re_msg['msg'] = "获取成功";
            $re_msg['info'] = $result;
        }
        echo json_encode($re_msg);
    }
    
    // 金币页面
    public function showGold(){
        $this->template->hideFooter = true;
        $this->template->content = new View('mobile/member/gold_view');
        $this->template->render();
    }
    
    /**
     * 积分页面
     */
    public function showPoints(){
        $this->template->hideFooter = true;
        $this->template->content = new View('mobile/member/points_view');
        $this->template->render();
    }
    
    /**
     * 积分页面数据
     */
    public function getPoints(){
        $member = M('member')->getOneData(array('id'=>$this->member_id));
        
        if(strstr($member->points,'.'))
        {
            $ca = array_filter(explode(".",$member->points));
            if($ca[1]==0)
            {
                if($ca[0])
                {
                    $member->points = $ca[0];
                }
                else
                {
                    $member->points = '0';
                }
            }
            else if($ca[1][1]==0)
            {
                $member->points = $ca[0].'.'.$ca[1][0];
            }
        }
        $member->fenhonglv = 2;
        $member->forsee = sprintf("%.2f",(floor($member->amount*$member->fenhonglv)/100));
        echo json_encode(array('success'=>1,'info'=>$member));
    }
    
    /**
     * 积分页面数据
     */
    public function getPointsLog(){
        $ty = P('ty');
        if($ty==0)
        {
            $logs = M('log_points')->where(array('status'=>1,'number >'=>0))->execute();
        }
        else
        {
            $logs = M('log_points')->where(array('status'=>1,'number >'=>0,'type'=>$ty))->execute();
        }
        $info->amount = 0;
        $info->str = '';
        $info->mamount = 0;
        foreach($logs as $item)
        {
            $info->amount = $info->amount+$item->number;
            if(date('Ym',time())==date('Ym',$item->addtime))
            {
                $info->mamount = $info->mamount+$item->number;
            }
            $info->str .= '<dl>
                        <dd>
                            <h4><em></em>
                                <p><font>'.$item->note.'，您获赠+ <i></i> '.$item->number.'。</font></p>
                            </h4>
                            <span>'.date('Y-m-d',$item->addtime).'</span>
                        </dd>
                    </dl>';
        }
        $info->str = '<h2 class=" bor_bott">共计'.$info->amount.'，其中本月获得'.$info->mamount.'</h2>'.$info->str;

        echo json_encode(array('success'=>1,'info'=>$info));
    }
    
    /**
     * 积分说明页面
     */
    public function showPointsInstruction(){
        $this->template->hideFooter = true;
        $this->template->content = new View('mobile/member/points_instruction_view');
        $this->template->render();
    }

    // 签到
    public function member_mask(){
        $re_msg['success'] = 0;
        $re_msg['msg'] = "签到失败";
        $number = 10;
        $s_time = strtotime(date('Y-m-d',time()));
        $e_time = strtotime(date('Y-m-d',strtotime("+1 day")));
        $num = M('log_points')->getAllCount("member_id=".$this->member_id." and addtime>=$s_time and addtime<$e_time");        
        if($num<=0){
            $arr = mobile_ext::add_number($this->member_id,'golds',$number);
            if($arr['success'] == 1){
                $points['member_id'] = $this->member_id;
                $points['number']   = $number;
                $points['note']     = "金币签到";
                $points['addtime']  = time();
                M('log_points')->insert($points);
                $re_msg['success'] = 1;
                $re_msg['msg'] = "签到成功";
            }
        }else{
            $re_msg['success'] = 1;
            $re_msg['msg'] = "已签到";
        }
        echo json_encode($re_msg);
    }
    // 地址列表页面
    public function index(){
        $view = new View('mobile/member/address_view');
        $view->render();
    }
    // 添加地址页面
    public function add(){
        $view = new View('mobile/member/opaddress_view');
        $view->render();
    }

    // 获取用户的送货地址列表
    public function getaddress(){
        $re_msg['success'] = 0;
        $re_msg['msg'] = "获取失败";
        $re_msg['info'] = "";

        $where['member_id'] = $this->member_id;
        $rs = M('member_address')->select()->where($where)->orderby('addtime desc')->execute();
        if(!empty($rs)){
            foreach($rs as $key=>$val){
                $rdata[$key]['id']          = $val->id;
                $rdata[$key]['local']        = $val->local;
                $rdata[$key]['address']     = $val->address;
                $rdata[$key]['zipcode']     = $val->zipcode;
                $rdata[$key]['mobile']      = $val->mobile;
                $rdata[$key]['consignee']   = $val->consignee;
                $rdata[$key]['isdefault']   = $val->isdefault;
            }  
            $re_msg['success'] = 1;
            $re_msg['msg'] = "获取成功";
            $re_msg['info'] = $rdata;         
        }
        die(json_encode($re_msg));
    }
    //获取用户的默认送货地址
    public function default_address(){        
        $re_msg['success'] = 0;
        $re_msg['msg'] = "获取失败";
        $re_msg['info'] = "";

        $where['member_id'] = $this->member_id;
        $rs = M('member_address')->orderby('isdefault desc,id desc')->getOneData("member_id=".$this->member_id);
        if(!empty($rs)){
            $rdata['id']         = $rs->id;
            $rdata['provincial'] = $rs->provincial;
            $rdata['city']       = $rs->city;
            $rdata['address']    = $rs->address;
            $rdata['zipcode']    = $rs->zipcode;
            $rdata['mobile']     = $rs->mobile;
            $rdata['consignee']  = $rs->consignee;
            $rdata['isdefault']  = $rs->isdefault;

            $re_msg['success'] = 1;
            $re_msg['msg'] = "获取成功";
            $re_msg['info'] = $rdata;
        }
        die(json_encode($re_msg));
    }
    //添加地址
    public function addaddress(){
        $provid     = P('provid',0);
        $cityid     = P('cityid',0);
        $veraddress = P('veraddress','');
        $vermobile  = P('vermobile','');
        $vername    = P('vername','');
        $zipcode    = P('zipcode','');
        if(empty($provid)){
            die(json_encode(array('success'=>0,'msg'=>'必须选择省份！')));
        }
        if(empty($cityid)){
            die(json_encode(array('success'=>0,'msg'=>'必须选择市区！')));
        }
        if(empty($veraddress)){
            die(json_encode(array('success'=>0,'msg'=>'必须填写详细地址！')));
        }
        if(empty($vermobile)){
            die(json_encode(array('success'=>0,'msg'=>'必须填写联系电话！')));
        }
        if(empty($vername)){
            die(json_encode(array('success'=>0,'msg'=>'必须填写真实姓名！')));
        }
        $data['member_id']  = $this->member_id;
        $data['prov_id']    = $provid;
        $data['city_id']    = $cityid;
        $data['address']    = $veraddress;
        $data['zipcode']    = $zipcode;
        $data['mobile']     = $vermobile;
        $data['realname']   = $vername;
        $data['isdefault']  = 0;
        $data['status']     = 1;
        $data['addtime']    = time();
        $res = M('member_address')->save($data);
        if($res){
            die(json_encode(array('success'=>1,'msg'=>'添加成功')));
        }else{
            die(json_encode(array('success'=>0,'msg'=>'添加失败')));
        }
    }
    //修改地址
    public function editaddress(){
        $id         = P('id',0);
        $provid     = P('provid',0);
        $cityid     = P('cityid',0);
        $veraddress = P('veraddress','');
        $vermobile  = P('vermobile','');
        $vername    = P('vername','');
        $zipcode    = P('zipcode','');
        if(empty($id)){
            die(json_encode(array('success'=>0,'msg'=>'无效的地址ID！')));
        }
        if(empty($provid)){
            die(json_encode(array('success'=>0,'msg'=>'必须选择省份！')));
        }
        if(empty($cityid)){
            die(json_encode(array('success'=>0,'msg'=>'必须选择市区！')));
        }
        if(empty($veraddress)){
            die(json_encode(array('success'=>0,'msg'=>'必须填写详细地址！')));
        }
        if(empty($vermobile)){
            die(json_encode(array('success'=>0,'msg'=>'必须填写联系电话！')));
        }
        if(empty($vername)){
            die(json_encode(array('success'=>0,'msg'=>'必须填写真实姓名！')));
        }
        $data['prov_id'] = $provid;
        $data['city_id'] = $cityid;
        $data['address'] = $veraddress;
        $data['zipcode'] = $zipcode;
        $data['mobile'] = $vermobile;
        $data['realname'] = $vername;
        $data['ptime'] = time();
        $res = M('member_address')->update($data,array('id'=>$id,'member_id'=>$this->member_id));
        if($res){
            die(json_encode(array('success'=>1,'msg'=>'编辑成功')));
        }else{
            die(json_encode(array('success'=>0,'msg'=>'编辑失败')));
        }
    }
    public function deladdress(){
        $id = P('id',0);
        if(empty($id)){
            die(json_encode(array('success'=>0,'msg'=>'无效的地址ID！')));
        }
        $rs = M('member_address')->delete(array('id'=>$id,'member_id'=>$this->userid));
        // M('member_address')->update(array('status'=>0),array('id'=>$id,'member_id'=>$this->userid));
        if($rs){
            die(json_encode(array('success'=>1,'msg'=>'删除成功')));
        }else{
            die(json_encode(array('success'=>0,'msg'=>'删除失败')));
        }
    }
    //设置默认送货地址
    public function defaultAddress(){
        $id = P('id',0);
        if(empty($id)){
            die(json_encode(array('success'=>0,'msg'=>'无效的地址ID！')));
        }
        $rs = M('member_address')->update(array('isdefault'=>0),array('member_id'=>$this->member_id));
        $rss = M('member_address')->update(array('isdefault'=>1),array('id'=>$id,'member_id'=>$this->member_id));
        if($rs && $rss){
            die(json_encode(array('success'=>1,'msg'=>'设置成功')));
        }else{
            die(json_encode(array('success'=>0,'msg'=>'设置失败')));
        }
    }
    public function selcitys(){
        $data = extconfig_ext::getPcitys();
        die(json_encode(array('errorno'=>0,'msg'=>'success','data'=>$data)));
    }
    public function mypush(){
        $res['errorno'] = 0;
        $res['msg'] = 'success';
        $data = push_ext::get_list($this->member_id,0);
        $res['data'] = $data;
        return $res;
    }
    public function pushcont(){
        $id = P('id',0);
        if(!empty($id)){
            $res = push_ext::get_cont($this->userid,$id);
            die(json_encode($res));
        }else{
            die(json_encode(array('success'=>0,'msg'=>'无效的消息ID')));
        }
    }
}
