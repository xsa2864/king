<?php defined('KING_PATH') or die('访问被拒绝.');
class BusinessApply_Controller extends Wechatbase_Controller
{
    public function __construct(){              
        parent::__construct();       
    }   
    // 申请店铺
    public function apply_save(){
        $re_msg['success'] = 0;
        $re_msg['msg'] = "申请失败";

        $zh_name = P('zh_name','');
        $mobile = P('mobile','');
        $realname = P('realname','');
        $name =  P('name','');
        $address = P('address','');

        $data['type'] = 2;
        $data['zh_name'] = $zh_name;
        $data['mobile'] = $mobile;
        $data['realname'] = $realname;
        $data['name'] = $name;
        $data['address'] = $address;
        $data['openId'] = $this->openid;
        $data['addtime'] = time();
        $type = P('type','');   //判断是否再次申请的


        if($type=='again'){
            $flag = false;
            $rs_ag = M('tk_business')->getOneData("openId='".$this->openid."' and mobile=$mobile");
            if($rs_ag){
                $flag = true;
            }else{
                $rs_again = M('tk_business')->getOneData("mobile=$mobile");
                if(!$rs_again){
                    $flag = true;
                }
            }
            if($flag){                
                unset($data['openId']);
                $data['status'] = 2;
                $trs = M('tk_business')->update($data,"openId='".$this->openid."'");
                if($trs){
                    $re_msg['success'] = 1;
                    $re_msg['msg'] = "等待审核";
                }
            }else{
                $re_msg['msg'] = "手机号已经使用，请更换试试";
            }
            echo json_encode($re_msg);        
            exit;
        }

        $b_rs = M("tk_business")->getOneData("mobile='".$mobile."'");
        if(!$b_rs){
            $rs = M("tk_business")->save($data);
            if($rs){
                $url = "http://tok.uszhzh.com/wechat/business/detail/".$rs;
                $filename = 'upload/qrcode/shop_'.$rs.'.png';               
                $qrcode = qrcode::getClass();
                $qrcode->png($url,$filename);
        
                $code['qrCode'] = $filename;
                $result = M('tk_business')->update($code,"id=$rs");

                $re_msg['success'] = 1;
                $re_msg['msg'] = "等待审核";
            }
        }else{
            $re_msg['msg'] = "您的手机号已经提交申请或已入驻，不能重复使用哦。";
        }
        echo json_encode($re_msg);
    }  

   // 查看条款的
    public function show_clause(){
        $this->template->content = new View('wechat/businessManage/clause_view');
        $this->template->render();
    }

    // 绑定店铺
    public function bind_business(){
        
        $this->template->content = new View('wechat/businessManage/bind_view');
        $this->template->render();
    }
    // 进行绑定
    public function apply_bind(){
        $re_msg['success'] = 0;
        $re_msg['msg'] = "绑定失败";

        $mobile = P('mobile');
        $result = M('tk_business')->getOneData("mobile='".$mobile."'","id,openId");
        if($result){ 
            $data['openId'] = $this->openid;
            $rs = M('tk_business')->update($data,"mobile='".$mobile."'");
            if($rs){
                $re_msg['success'] = 1;
                $re_msg['msg'] = "绑定成功";
            }            
        }else{
            $re_msg['msg'] = "没有查询到店铺";
        }
  
        echo json_encode($re_msg);
    }
}