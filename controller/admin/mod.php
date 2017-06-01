<?php defined('KING_PATH') or die('访问被拒绝.');
      class Mod_Controller extends Template_Controller 
      {
          private $mod;
          public function __construct()
          {
              parent::__construct();
              comm_ext::validUser();
              $this->mod	= M('mod');	
          }
          
          /**
           * 展示模块
           */
          public function index()
          {
              $data['tree']               = $this->getAllMod();
              $this->template->content	= new View('admin/mod/list_view', $data);
              $this->template->render();
          }	
          
          /**
           * 
           *添加模块
           */
          public function add()
          {
            //  $data['tree']               = $this->getAllMod();
              $data['tree'] = $this->mod->where(array('bid'=>0,'visible'=>1))->execute();
              $this->template->content = new View('admin/mod/add_view',  $data);
              $this->template->render();
          }

          /*
           * 获得二级菜单
           */
          public function getSecondary(){
              list($pid) = $this->input->getArgs();
              $data = $this->mod->where(array('bid'=>$pid,'visible'=>1))->execute();
              echo json_encode((array)$data);
          }
          
          /**
           * 删除模块
           */
          public function del()
          {
              $id		= $this->input->segment("del");		
              $count	= $this->mod->getAllCount(array('bid'=>$id));
              if ($count >0)
              {
                  echo json_encode(array('msg'=>'请先删除子模块','success'=>0));
              }
              else 
              {
                  $return		= $this->mod->delete("id='$id'");
                  if ($return)
                  {
                      echo json_encode(array('msg'=>'','success'=>1));
                  }
                  else
                      echo json_encode(array('msg'=>'删除失败','success'=>0));
              }
          }

          public function getAllMod()
          {
              $rs			= $this->mod->where(array('bid'=>0))->execute();
              $array	= array();
              foreach ($rs as $row)
              {
                  $rs2	= $this->mod->where(array('bid'=>$row->id))->execute();
                  if($row->visible==1)
                      $row->visible='显示';
                  else
                      $row->visible='隐藏';
                  $array2	= array();
                  foreach ($rs2 as $row2)
                  {
                      if($row2->visible==1)
                          $row2->visible='显示';
                      else
                          $row2->visible='隐藏';
                      $array2[]	= array('id'=>$row2->id,'text'=>$row2->modName,'visible'=>$row2->visible,'orderNum'=>$row2->orderNum);
                  }
                  $array[]		= array('id'=>$row->id,'text'=>$row->modName,'visible'=>$row->visible,'orderNum'=>$row->orderNum, 'children'=>$array2);
              }
              return $array;
          }
          
          public function getMod()
          {
              $gid		= $this->input->get('id');
              $modPower	= $this->mod->getFieldData('modPower',array('id'=>$gid),'group');
              $rs			= $this->mod->where(array('bid'=>0))->execute();
              foreach ($rs as $row)
              {
                  $checked		= $this->getChecked($row->id,$modPower);
                  $array[]		= array('id'=>$row->id,'name'=>$row->modName,'pId'=>0,'open'=>true,'checked'=>$checked);//'visible'=>$row->visible,'orderNum'=>$row->orderNum, 'children'=>$array2,'checked'=>$checked);
                  $rs2	= $this->mod->where(array('bid'=>$row->id))->execute();
                  foreach ($rs2 as $row2)
                  {
                      $checked		= $this->getChecked($row2->id,$modPower);
                      $array[]	= array('id'=>$row2->id,'name'=>$row2->modName,'pId'=>$row->id,'checked'=>$checked);//'children'=>$array3,'visible'=>$row->visible,'orderNum'=>$row->orderNum,'checked'=>$checked,'state'=>$state);//三级树默认闭合
                      $rs3		= $this->mod->where(array('bid'=>$row2->id))->execute();
                      foreach ($rs3 as $row3)
                      {
                          $checked		= $this->getChecked($row3->id,$modPower);
                          $array[]	= array('id'=>$row3->id,'name'=>$row3->modName,'pId'=>$row2->id,'checked'=>$checked);//'visible'=>$row->visible,'orderNum'=>$row->orderNum,'checked'=>$checked);
                      }
                  }
              }
              echo json_encode($array);			
          }

          /**
           * 取得App列表
           *
           */
          public function getApp()
          {
              echo json_encode($GLOBALS['config']['apps']);
          }
          
          private function getChecked($id,$ids)
          {
              if ($ids=='')
                  return false;
              $ids	= explode(',',$ids);
              if (in_array($id,$ids))
                  return true;
              else
                  return false;
          }

          /**
           * 
           * 保存模块
           */
          public function save()
          {
              $post		= $this->input->post();
              $url	= '';
              if ($post['modName'])
              {
                  if ($post['class'] && $post['function'])
                  {
                      $url	= $post['class'].'/'.$post['function'];
                  }
                  
                  if ($post['width'] && $post['height'])
                  {
                      $size		= serialize(array('width'=>$post['width'],'height'=>$post['height']));
                  }
                  else 
                      $size		= '';
                  $parent = $post['bid'];
                  $second = $post['secondSelect'];
                  $parent > 0 ? $bid = $second : $bid = $parent;
                  //二级栏目不能有地址
                  $parent >0 ? $url = '' : $url = $url;
                  $data		= array(
                      'url'		=> $url,
                      'modName'	=> $post['modName'],				
                      'bid'		=> $bid,
                      'visible'	=> $post['visible'],
                      'app'		=> $post['app'],
                      'size'		=> $size,	
                      'icon'		=> $post['icon'],	
                      'orderNum'	=> $post['orderNum']
                  );
                  $return		= $this->mod->save($data);
              }
              input::redirect('admin/mod/');
          }
          
          /**
           * 更新模块
           */
          public function edit()
          {
              $id				= $this->input->segment('edit');
              $data['row']	= $this->mod->getOneData("id='$id'");
              $data['tree']   = $this->getAllMod();
              $this->template->content = new View('admin/mod/add_view',$data);
              $this->template->render();
          }
          
          /**
           * 保存更新的模块
           */
          public function update()
          {
              $id			= $this->input->segment('update');
              $post		= $this->input->post();
              $url		= '';
              if ($this->input->post('class') && $this->input->post('function'))
              {
                  $url	= $this->input->post('class').'/'.$this->input->post('function');
              }
              
              if ($post['width'] && $post['height'])
              {
                  $size		= serialize(array('width'=>$post['width'],'height'=>$post['height']));
              }
              else 
                  $size		= '';
              $upd		= array(
                  'modName'	=> $post['modName'],
                  'url'		=> $url,
                  'bid'		=> $post['bid'],
                  'visible'	=> $post['visible'],
                  'app'		=> $post['app'],
                  'size'		=> $size,
                  'icon'		=> $post['icon'],
                  'orderNum'	=> $post['orderNum']
              );
              $return		= $this->mod->update($upd,array('id'=>$id));
              if ($return)
              {
                  comm_ext::saveToLog(2, '更新了id为'.$id.'的模块');
                  input::redirect('admin/mod/');
              }	
          }
      }
      
