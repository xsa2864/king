<?php defined('KING_PATH') or die('访问被拒绝.');
      class Account_Controller extends Template_Controller
      {
          private $did;
          private $mod;
          public function __construct()
          {
              parent::__construct();
              hcomm_ext::validUser();
              $this->mod	= M('account');
              $this->did	= 10;//部门的字典id
              $this->account_id = accountInfo_ext::accountId(); 
          }
          
          public function index()
          {
              $rs			= $this->mod->where(array('gid>'=>0,'pid'=>$this->account_id))->orderby(array('id'=>'asc'))->execute();
              $rs2		= array();
              foreach ($rs as $row)
              {
                  $row->groupName		= $this->mod->getFieldData('groupName',"id='{$row->gid}'",'group');
                  $rs2[]				= $row;
              }
              $data['tree']=$rs2;
              $this->template->content = new View('admin/account/list_view',$data);
              $gdata['groupList'] = M('group')->select('id,groupName')->execute();
              $this->template->tipBoxContent1 = new View('admin/account/add_view',$gdata);
              $this->template->tipBoxContent2 = new View('admin/account/edit_view',$gdata);
              $this->template->render();
          }
          
          public function add()
          {
              $data['groupList']			= $this->mod->select('id,groupName')->from('group')->execute();
              $this->template->content	= new View('admin/account/add_view',$data);
              $this->template->render();
          }
          
          public function edit()
          {
              list($edit)	= $this->input->getArgs();			
              $data['row']				= $this->mod->getOneData("id='$edit'");
              $data['groupList']			= $this->mod->select('id,groupName')->from('group')->execute();
              $this->template->content = new View('admin/account/edit_view',$data);
              $this->template->render();
          }
          
          /**
           * 修改密码
           */
          public function alterPwd()
          {
              $this->template->content 	= new View('admin/account/alter_view');
              $this->template->render();
          }
          
          /**
           * 修改用户常规资料
           */
          public function alterProfile()
          {
              $data['row']	= $this->mod->getOneData("id='{$_SESSION['uid']}'");
              $this->template->content = new View('admin/account/profile_view',$data);
              $this->template->render();
          }

          /**
           * 保存用户常规资料
           */
          public function saveProfile()
          {
              $project    = $this->input->get("project");
              $mobile		= $this->input->get("mobile");
              if ($project && $mobile)
              {
                  $upd		= array('project'=>$project,'mobile'=>$mobile);
                  $return		= $this->mod->update($upd,"id='{$_SESSION['uid']}'");
                  if ($return)
                  {
                      echo json_encode(array('msg'=>'资料已保存','suc'=>'0'));
                  }
                  else
                  {
                      echo json_encode(array('msg'=>'资料更新失败','suc'=>'1'));
                  }
              }
              else
                  echo json_encode(array('msg'=>'必须输入所有参数','suc'=>'1'));
          }

          /**
           * 保存新密码
           */
          public function savePwd()
          {
              $oldPassword		= $this->input->post("oldPassword");
              $newPassword		= $this->input->post("newPassword");
              $confirmPassword	= $this->input->post("confirmPassword");
              if ($oldPassword && $newPassword && $confirmPassword)
              {
                  if($newPassword == $confirmPassword)
                  {
                      $oldPasswd		= md5($GLOBALS['config']['md5Key'].$oldPassword);
                      $id				= $this->mod->getFieldData('id',"passwd='$oldPasswd' and username='{$_SESSION['userName']}'");
                      if ($id)
                      {
                          $newPasswd	= md5($GLOBALS['config']['md5Key'].$newPassword);
                          $upd		= array('passwd'=>$newPasswd);
                          $return		= $this->mod->update($upd,array('id'=>$id));
                          if ($return)
                          {
                              echo json_encode(array('msg'=>'新密码已保存','success'=>'0'));
                          }
                          else
                          {
                              echo json_encode(array('msg'=>'密码更新失败','success'=>'1'));
                          }
                      }
                      else
                      {
                          echo json_encode(array('msg'=>'旧密码错误','success'=>'1'));
                      }
                  }
                  else
                  {
                      echo json_encode(array('msg'=>'新密码与确认新密码不同','success'=>'1'));
                  }
              }
              else
              {
                  echo json_encode(array('msg'=>'必须输入所有参数','success'=>'1'));
              }
          }
          
          /**
           * 取得的有账号
           */				
          public function getAccount()
          {
          }

          /**
           * 重置密码
           */
          public function resetPwd()
          {
              list($id)	= $this->input->getArgs();
              if ($id)
              {
                  $upd		= array(
                          'passwd'		=> md5($GLOBALS['config']['md5Key'].$GLOBALS['config']['defaultPwd'])
                  );
                  $wh			= array('id'=>$id);
                  $return		= $this->mod->update($upd,$wh);
                  if ($return >0)
                  {
                      //comm_ext::saveToLog(17, '重置了id为'.$id.'的用户密码');
                      echo "<script>alert('密码已重置')</script>";
                  }
                  else
                      echo "<script>alert('重置失败')</script>";
              }
              else
                  echo "<script>alert('参数错误')</script>";
              echo "<script>location.href='/admin/account/getAccount'</script>";
          }
          

          /**
           * 保存用户所有信息
           */		
          public function save()
          {
              $userName = P('userName');
              $mobile = P('mobile');
              $passwd = P('passwd');
              $gId = P('gId');
              $realName = P('realName');
              if ($userName&&$passwd&&$gId)
              {
                  $count		= $this->mod->getAllCount(array('username'=>$userName));
                  if ($count >0)
                  {
                      echo json_encode(array('msg'=>'该用户名已存在','success'=>'0'));
                      return false;
                  }
                  else 
                  {
                      $insert		= array(
                          'pid'         => $this->account_id,
                          'username'		=> $userName,
                          'passwd'		  => md5($GLOBALS['config']['md5Key'].$passwd),
                          'gid'			    => $gId,
                          'project'		  => $realName,
                          'mobile'		  => $mobile
                      );
                      $return		= $this->mod->save($insert);
                      if ($return >0)
                      {
                          echo json_encode(array('msg'=>'','success'=>'1'));
                          return true;
                      }
                      else
                      {
                          echo json_encode(array('msg'=>'保存失败','success'=>'0'));
                          return false;
                      }
                  }
              }
              else
              {
                  echo json_encode(array('msg'=>'参数错误','success'=>'0'));
                  return false;
              }
          }
          
          public function del()
          {
              $id	= S('del');
              if ($id>1)//admin不允许删除
              {
                  $return 	= $this->mod->delete(array('id'=>$id));
              }
              input::redirect('admin/account/index');
          }
          
          public function update()
          {
              $id = P('id');
              $userName = P('userName');
              $mobile = P('mobile');
              $passwd = P('passwd');
              $gId = P('gId');
              $realName = P('realName');
              if($userName&&$id&&$gId)
              {
                  $count		= $this->mod->getAllCount(array('username'=>$userName, 'id !='=>$id));
                  if($count>0)
                  {
                      echo json_encode(array('msg'=>'该用户名已存在','success'=>0));
                  }
                  else
                  {
                      $upd		= array(
                          'username'		=> $userName,
                          'mobile'		=> $mobile,
                          'project'     => $realName,
                          'gid'			=> $gId
                      );
                      if($passwd)
                      {
                          $upd['passwd'] = md5($GLOBALS['config']['md5Key'].$passwd);
                      }
                      $wh			= array('id'=>$id);
                      $return		= $this->mod->update($upd,$wh);
                      if ($return > 0)
                      {
                          echo json_encode(array('msg'=>'','success'=>1));
                      }
                      else
                      {
                          echo json_encode(array('msg'=>'更新失败','success'=>0));
                      }
                  }
              }
              else
              {
                  echo json_encode(array('msg'=>'参数错误','success'=>0));
              }
          }
      }