<?php defined('KING_PATH') or die('访问被拒绝.');
      class Index_Controller extends Mobilebase_Controller
      {
          public function __construct(){	
              // 检查是否登录 
              // $userinfo = mobile_ext::validUser();
              // if($userinfo['success'] == 0){          
              //   echo json_encode($userinfo);
              //   exit;
              // }else{
              //   $this->member_id = $userinfo['id'];
              //   $this->account_id = $userinfo['account_id'];
              // }
          }

          // 首页列表
          public function index(){
            $username = G('username');
            $password = G('password');
            $data['success'] = 0;
            $data['msg'] = '登录失败!';
            if($username == 'admin' && $password == '123456'){
              $data['success'] = 1;
              $data['msg'] = '登录成功!';
            }
            echo json_encode($data);
            exit;
              $data['goodsList'] = array();
              // $data['test'] = 'huangbin';
              // $data['goodsList'] = M('item')->select("id,title,mainPic")->where("account_id=".$this->account_id." and status=1")->execute();
              $view = new View('mobile/index/index_view',$data);
              $view->render();
          }

          public function goodsDetail(){
              $id = G('id');
              $data['goodsDetail'] = M('item i')->select()->join('item_attr ia','ia.item_id=i.id')->where("ia.item_id=$id and i.account_id=".$this->account_id)->execute();
              print_r($data);
          }
      }
