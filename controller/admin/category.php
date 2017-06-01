<?php defined('KING_PATH') or die('访问被拒绝.');
      class Category_Controller extends Template_Controller
      {
          private $mod;
          public function __construct()
          {
              parent::__construct();
              comm_ext::validUser();
              $this->mod    = M('category');
              $this->account_id = accountInfo_ext::accountId(); 
          }
          
          public function index()
          {
              $data['tree']  = str_ext::getTree();
              $this->template->content	= new View('admin/category/index_view', $data);
              $this->template->tipBoxContent1 = new View('admin/category/editCategory_view', $data);
              $this->template->tipBoxContent2 = new View('admin/category/addCategory_view', $data);
              $this->template->render();
          }
          // 2016/7/25 获取分类信息
          // public function getInfo(){
          //   $id = P('id');
            
          //   $rs_msg['success'] = 0;
          //   $rs_msg['info'] = array();
          //   if($id > 0){
          //     $rs = M('category')->getOneData("id=$id","name,visible,orderNum");
          //     if($rs){
          //       $rs_msg['success'] = 1;
          //       $rs_msg['info'] = $rs;
          //     }              
          //   }
          //   echo json_encode($rs_msg);
          // }
          public function add()
          {
              $data['tree']               = str_ext::getTree();
              $this->template->content    = new View('admin/category/add_view', $data);
              $this->template->render();
          }
          
          public function edit()
          {
              $id				= $this->input->segment('edit');
              $data['row']      = $this->mod->getOneData("id='$id'");
              $data['tree']     = str_ext::getTree();
              $this->template->content = new View('admin/category/add_view',$data);
              $this->template->render();            
          }
          
          public function get()
          {
              if ($this->input->get('total'))
              {
                  $rs			= $this->mod->execute();
                  echo json_encode($rs);
              }
              else 
              {
                  $total		= $this->mod->getAllCount();
                  $page		= $this->input->post('page');
                  $size		= $this->input->post('rows');
                  $start		= ($page-1)*$size;
                  $rs			= $this->mod->limit($start,$size)->execute();
                  $rs2		= array();
                  foreach ($rs as $row)
                  {
                      $row->visible		= $row->visible ? '显示':'隐藏';
                      $rs2[]				= $row;
                  }
                  echo json_encode(array('total'=>$total,'rows'=>$rs2));                
              }
          }
          
          public function update()
          {
              $id		= $this->input->segment('update');
              $post			= $this->input->post();
              if ($id>0)
              {
                  if($id == $post['pid'])
                  {
                      echo json_encode(array('msg'=>'该类不能为自身的上级分类','success'=>1));
                  }
                  else
                  {
                      $count		= $this->mod->getAllCount(array('name'=>$post['name'], 'pid'=>$post['pid'], 'id != '=>$id));
                      if ($count >0)
                      {
                          echo json_encode(array('msg'=>'该类别已存在','success'=>0));
                      }
                      else
                      {
                          $upd	= array(
                                  'name'		    => $post['name'],
                                  'pid'		    => $post['pid'],
                                  'orderNum'		=> $post['orderNum']
                          );
                          $return		= $this->mod->update($upd,array('id'=>$id));
                          if ($return)
                          {
                              D('item')->updateCate('cate_name_'.$id);
                              echo json_encode(array('msg'=>'','success'=>1));
                          }
                          else
                              echo json_encode(array('msg'=>'更新失败','success'=>0));
                      }
                  }
              }
              else
                  echo json_encode(array('msg'=>'参数错误','success'=>0));
          }

          private function getChecked($id,$checks)
          {
              if (!is_array($checks))
                  return '';
              else 
              {
                  if (!in_array($id,$checks))
                      return '';
                  else 
                      return 'checked';
              }
          }
          
          public function save()
          {
              $post			= $this->input->post();
              if ($post['name'])
              {
                  $count		= $this->mod->getAllCount(array('name'=>$post['name'], 'pid'=>$post['pid']));
                  if ($count >0)
                  {
                      echo json_encode(array('msg'=>'该类别已存在','success'=>0));
                  }
                  else
                  {
                      $insert		= array(
                              'account_id'    => $this->account_id,
                              'pid'		        => $post['pid'],
                              'name'		      => $post['name'],
                              'visible'		    => $post['visible'],
                              'attr'          => '',
                              'orderNum'		  => $post['orderNum'],
                              'createTime'		=> date('y-m-d h:i:s',time())
                      );
                      $return		= $this->mod->save($insert);
                      if ($return >0)
                      {
                          D('item')->updateCate('cate_name_'.$id);
                          echo json_encode(array('msg'=>'','success'=>1));
                      }
                      else
                          echo json_encode(array('msg'=>'保存失败','success'=>0));
                  }
              }
              else
                  echo json_encode(array('msg'=>'请输入分类名称','success'=>0));
          }
          
          public function advert()
          {
              $data['id']		= $this->input->segment('advert');
              $data['row']	= $this->mod->getOneData(array('id'=>$data['id']));
              $this->template->content	= new View('admin/category/ad_view',$data);
              $this->template->render();
          }
          
          public function saveAd()
          {
              $id     = $this->input->segment('saveAd');
              if ($id && $this->input->post('ad'))
              {
                  $this->mod->update(array('ad'=>$this->input->post('ad')),array('id'=>$id));
                  echo json_encode(array('success' => 1, 'msg' => ''));
              }
              else
              {
                  echo json_encode(array('success' => 0, 'msg' => '参数错误'));
              }
          }
          
          public function deleteParent()
          {
              //$id		= $this->input->post('id');
              $id     = S('deleteParent');
              if ($id>0)
              {   
                  $result =  $this->mod->getOneData(array('pid'=>$id));
                  if (!$result)
                  {
                      $products   = M('item')->getOneData(array('parent'=>$id));
                      if (!$products)
                      {
                          $return 	= M('category')->delete(array('id'=>$id));
                          D('item')->updateCate($id);
                          echo 345;
                      }
                      echo 123;
                  }
                  echo 234;
              }
              input::redirect('admin/category/index');
          }
          
          public function deleteCate()
          {
              //$id		= $this->input->post('id');
              $id     = S('deleteCate');
              if ($id>0)
              {   
                  $result =  $this->mod->getOneData(array('pid'=>$id));
                  if (!$result)
                  {
                      $products   = M('item')->getOneData(array('cateId'=>$id));
                      if (!$products)
                      {
                          $return 	= M('category')->delete(array('id'=>$id));
                          D('item')->updateCate('cate_name_'.$id);
                      }
                  }
              }
              input::redirect('admin/category/index');
          }
          
          public function deleteChild()
          {
              //$id		= $this->input->post('id');
              $id     = S('deleteChild');
              if ($id>0)
              {
                  $products   = M('item')->getOneData(array('childId'=>$id));
                  if (!$products)
                  {
                      $return 	= M('category')->delete(array('id'=>$id));
                      D('item')->updateCate($id);
                  }
              }
              input::redirect('admin/category/index');
          }
          
          public function isChild()
          {
              $id     = $this->input->segment('isChild');
              $count  = $this->mod->getAllCount(array('pid'=>$id));
              if ($count <1)
                  echo json_encode(array('msg'=>'','success'=>1));
              else
                  echo json_encode(array('msg'=>'只有子类别才能添加筛选项','success'=>0));
          }
          
          public function assoc()
          {
              $id     = $this->input->segment('assoc');
              $count  = $this->mod->getAllCount(array('pid'=>$id));
              if ($count <1)
              {
                  $data['id']     = $id;
                  $data['did']          = $this->mod->getFieldData('did',array('id'=>$id));
                  $this->template->content    = new View('admin/category/assoc_view',$data);
                  $this->template->render();                
              }
              else
              {
                  echo json_encode(array('msg'=>'只有子类别才能添加筛选项','success'=>0));
              }
          } 
          
          public function saveAssoc()
          {
              $id     = $this->input->segment('saveAssoc');
              if ($id && $this->input->post('did'))
              {
                  $return		= $this->mod->update(array('did'=>$this->input->post('did')),array('id'=>$id));
                  if ($return >0)
                  {
                      echo json_encode(array('msg'=>'','success'=>1));
                  }
                  else
                      echo json_encode(array('msg'=>'关联属性失败','success'=>0));                
              }
              else
                  echo json_encode(array('msg'=>'参数错误','success'=>0));
              
          }

          public function getCategoryOption()
          {
              $id = P('id',0);
              $cateId = P('cateId',0);
              $rs = M('category')->where(array('pid'=>$id,'visible'=>1))->orderby(array('orderNum'=>'desc'))->execute();
              //echo '<select id="categroy1" class="puiSelect" onchange="javascript:loadCategory(1)">';
              if(sizeof($rs)<=0)
              {
                  echo '<option value="0" selected>（空）</option>';
              }else {
                  echo '<option value="0" selected>全部</option>';
              }
              foreach($rs as $value)
              {
                  echo '<option value="'.$value->id.'"';
                  if($cateId && $cateId==$value->id)
                      echo 'selected="selected"';
                  echo '>'.$value->name.'</option>';
              }
              //echo '</select>';
          }

          public function visible()
          {
              $id     = $this->input->segment('visible');
              if ($id>0)
              {
                  $visible = $this->mod->getFieldData('visible',array('id'=>$id));
                  if($visible== '1')
                  {
                      $visible=0;
                  }
                  else
                  {
                      $visible=1;
                  }
                  $return 	= $this->mod->update(array('visible'=>$visible),array('id'=>$id));
                  D('item')->updateCate('cate_name_'.$id);
              }
              input::redirect('admin/category/index');
          }
          


          public function updateOrder(){
              list($id,$orderNum) = $this->input->getArgs();
              if(!isset($id) || !isset($orderNum)){echo json_encode(array('status'=>0,'msg'=>'保存失败！'));exit;}
              $result = M('category')->update(array('orderNum'=>$orderNum),array('id'=>$id));
              if($result){echo json_encode(array('status'=>0,'msg'=>'保存成功！'));exit;}else{echo json_encode(array('status'=>0,'msg'=>'保存失败！'));exit;}
          }

          
          //         private function getMaxId($id=0)
          //         {
          //             if (!$id)
          //             {
          //                 $wh     = "id<99";
          //                 $min    = 10;
          //             }
          //             else 
          //             {
          //                 $len        = strlen($id);
          //                 if ($len ==2 || $len==4)
          //                 {
          //                     $min    = $id.'01';
          //                     $wh     = 'id <'.$id.'99 and id>='.$min;
          //                 }
          //                 else 
          //                 {
          //                     return false;
          //                 }
          //             }
          //             $id     = $this->mod->getFieldData("MAX(id)",$wh);
          //             $id++;
          //             return ($id>$min)?$id:$min;
          //         }
      }
?>