<?php defined('KING_PATH') or die('访问被拒绝.');
      class Main_Controller extends Wechatbase_Controller
      {
          public function __construct(){              
              parent::__construct();
          }

          // 首页列表
          public function index(){
            
              $data['goodsList'] = M('tk_item')->where("status=1 and stock>0 and ((starttime<=".time()." and endtime>=".time().") or timetype=0)")->orderby(array('id'=>'asc'))->execute();

              $data['listCount'] = count($data['goodsList']);
              $higher = $this->getUser($this->user->pid);
              $length = strlen($higher->nickname);
              if($length>=19){
                $nickname = mb_substr($higher->nickname,0,6,"utf-8").'...';
              }else{
                $nickname = $higher->nickname;
              }
              if($higher)
              {
                  $data['higher'] = '我的客户代表<img src="'.$higher->head_img.'" /><font>'.$nickname.'</font>';
              }
              else
              {
                  $data['higher'] = '&nbsp;';
              }

              $data['message'] = ""; 
              $data['message'] = $this->get_now_msg();
              if($data['message']==""){
                $data['message'] = $this->get_msg();
              }


              $this->template->content = new View('wechat/main/index_view',$data);
              $this->template->render();
          }

          // 消息数据
          public function msgInfo(){
              $re_msg['success'] = 0;
              $re_msg['msg'] = "";

              $message =  ""; 
              $message = $this->get_now_msg();
              if($message == ""){
                $message = $this->get_msg();
              }

              $re_msg['success'] = $message == "" ? 0:1;
              $re_msg['msg'] = $message == "" ? "" : $message;
              echo json_encode($re_msg);
          }
          // 获取当前用户的信息
          public function get_now_msg(){
              $message =  ''; 
              $result = M("tk_message")->select()->where("to_member_id='".$this->member_id."' and is_all=0")->orderby(array('addtime'=>'desc'))->limit(0,1)->execute();
              $rs = $result[0];     

              if($rs){   
                $obj = M("tk_message")->select("coupon_id")->orderby(array('addtime'=>'desc'))->limit(0,1)->execute();
                if($rs->coupon_id == $obj[0]->coupon_id){                  
                  if($rs->is_read==0){
                    M("tk_message")->update(array('is_read'=>1),"id=".$rs->id);
                  }         
                  $msgUser = $this->getUser($rs->member_id);
                  $timestr = timeformat_ext::format($rs->addtime);                                   
                  $message = '<span style="margin-right:0.1rem"><img src="'.$msgUser->head_img.'" />'.$msgUser->nickname.'  '.$timestr.$rs->message.'</span>';                  
                }
              }
              return $message;
          }
          // 获取全部面向全部会员信息
          public function get_msg(){
              $message = '';
              $timestamp = strtotime(date('Y-m-d',time()-259200)); //获取三天前零点的时间戳
              $msg = M('tk_message')->where(array('is_all'=>1,'addtime >'=>$timestamp))->orderby(array('addtime'=>'desc'))->limit(0,1)->  execute();
              $msg = $msg[0];

              if($msg)
              {
                // 获取购买用户的三级会员id
                $array = tuoke_ext::get_up_member($msg->member_id);
                $has = array('');
                if($array['success']==1){
                  $has = $array['info'];
                }     
                $flag = true;
                if($msg->coupon_id==0){
                  $flag = true;
                }else{  
                  $show = M("tk_coupon")->getOneData("id='".$msg->coupon_id."'","mem_num1,mem_num2,mem_num3");
                  if($this->member_id == $has[1] && $show->mem_num1>0){
                    $flag = false;
                  }else if($this->member_id == $has[2] && $show->mem_num2>0){
                    $flag = false;
                  }else if($this->member_id == $has[3] && $show->mem_num3>0){
                    $flag = false;
                  }

                }
                if($flag){
                  $msgUser = $this->getUser($msg->member_id);
                  if($msgUser->pid!=$this->member_id && $msg->member_id != $this->member_id && $msg->member_id!=$this->user->pid)
                  {
                      $msgUser->nickname = mb_substr($msgUser->nickname,0,1,'utf-8').'**';
                  }
                  $timestr = timeformat_ext::format($msg->addtime);
                  $message = '<span style="margin-right:0.1rem"><img src="'.$msgUser->head_img.'" />'.$msgUser->nickname.'  '.$timestr.$msg->message.'</span>';
                }
              }
              return $message;
          }
      }

