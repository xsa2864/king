<?php defined('KING_PATH') or die('访问被拒绝.');
      class Attr_Controller extends Template_Controller
      {
          private $mod;          
          public function __construct()
          {
              parent::__construct();
              hcomm_ext::validUser();
              $this->account_id = accountInfo_ext::accountId(); 
          }
          
          public function index()
          {
              list($id)       = $this->input->getArgs();
              $data['tree']   = M("attribute")->where(array('cateId'=>$id,'pid'=>0))->orderby(array('orderNum'=>desc))->execute();
              foreach($data['tree'] as $item)
              {
                  $item->childs = M("attribute")->where(array('pid'=>$item->id))->execute();
              }
              $data['id']     = $id;
              $data['cName']  = M("category")->getFieldData("name","id=".$id);
              $this->template->content    = new View('admin/attr/index_view',$data);
              $this->template->tipBoxContent1 = new View('admin/attr/addAttrItem_view', $data);
              $this->template->tipBoxContent2 = new View('admin/attr/addAttr_view', $data);
              $this->template->tipBoxContent3 = new View('admin/attr/editAttr_view', $data);
              $this->template->render();
          }
          
          public function add()
          {
              list($id)       = $this->input->getArgs();
              $data['id']     = $id;
              $data['cName']  = M("category")->getFieldData("name","id=".$id);
              $this->template->content    = new View('admin/attr/add_view',$data);
              $this->template->render();        
          }
          
          public function edit()
          {
              list($id)           = $this->input->getArgs();
              $data['row']        = M("attribute")->getOneData("id=".$id);
              $data['id']         = $data['row']->cateId;
              $data['cName']      = M("category")->getFieldData("name","id=".$data['id']);
              $this->template->content = new View('admin/attr/add_view',$data);
              $this->template->render();            
          }

          public function itemList()
          {
              list($id) = $this->input->getArgs();
              $data['tree'] = M("attribute")->where(array('pid'=>$id))->execute();
              $attr = M("attribute")->getOneData(array('id'=>$id));
              $data['cId'] = $attr->cateId;
              $data['id'] = $id;
              $data['attrName'] = $attr->name;
              $data['cName'] = M("category")->getFieldData("name","id=".$data['cId']);
              $this->template->content    = new View('admin/attr/itemList_view',$data);
              $this->template->render();
          }

          public function addItem()
          {
              list($id)       = $this->input->getArgs();
              $attr           = M("attribute")->getOneData('id='.$id);
              $data['cId']    = $attr->cateId;
              $data['id']     = $id;
              $data['attrName'] = $attr->name;
              $data['cName']  = M("category")->getFieldData("name","id=".$data['cId']);
              $this->template->content    = new View('admin/attr/addItem_view',$data);
              $this->template->render();
          }
          
          public function editItem()
          {
              $id         = $this->input->segment('editItem');
              $cId        = $this->input->segment('id');
              $data['row']        = M("attribute")->getOneData("id=".$id);
              $attr             = M("attribute")->getOneData('id='.$cId);
              $data['cId']    = $attr->cateId;
              $data['attrName'] = $attr->name;
              $data['id']       = $data['row']->cateId;
              $data['cName']    = M("category")->getFieldData("name","id=".$attr->cateId);
              $this->template->content = new View('admin/attr/addItem_view',$data);
              $this->template->render();            
          }

          public function changeVisible()
          {
              $changeVisible = S('changeVisible');
              $rs = M("attribute")->getOneData(array('id'=>$changeVisible));
              if($rs->show==0)
              {
                  M("attribute")->update(array('show'=>1), array('id'=>$changeVisible));
              }
              else
              {
                  M("attribute")->update(array('show'=>0), array('id'=>$changeVisible));
              }
              input::redirect('admin/attr/index/'.$rs->cateId);
          }
          
          public function save()
          {
              $post            = $this->input->post();
              if ($post['name'])
              {
                  $count        = M('attribute')->getAllCount(array('name'=>$post['name'],'pid'=>0,'cateId'=>$post['categoryId']));
                  if ($count >0)
                  {
                      echo json_encode(array('msg'=>'该属性已存在','success'=>0));
                  }
                  else
                  {
                      $insert        = array(
                          'name'        => $post['name'],
                          'cateId'      => $post['categoryId'],
                          'orderNum'    => $post['orderNum'],
                          'pid'         => 0
                      );
                      $return        = M('attribute')->save($insert);
                      if ($return >0)
                      {
                          D('attr')->updateAttr($post['categoryId']);
                          echo json_encode(array('msg'=>'','success'=>1));
                      }
                      else
                      {
                          echo json_encode(array('msg'=>'保存链接失败','success'=>0));
                      }
                  }
              }
              else
              {
                  echo json_encode(array('msg'=>'参数错误','success'=>0));
              }
          }
          
          public function saveItem()
          {
              $post            = $this->input->post();
              if ($post['name'])
              {
                  $cid = M('attribute')->getFieldData('cateId',array('id'=>$post['categoryId']));
                  $count        = M('attribute')->getAllCount(array('name'=>$post['name'],'pid'=>$post['categoryId'],'cateId'=>$cid));
                  if ($count >0)
                  {
                      echo json_encode(array('msg'=>'该属性值已存在','success'=>0));
                  }
                  else
                  {
                      $insert        = array(
                          'name'        => $post['name'],
                          'cateId'      => $cid,
                          'orderNum'    => 0,
                          'pid'         => $post['categoryId']
                      );
                      $return        = M('attribute')->save($insert);
                      if ($return >0)
                      {
                          D('attr')->updateDictOption($post['categoryId']);
                          echo json_encode(array('msg'=>'','success'=>1,'cid'=>$cid));
                      }
                      else
                      {
                          echo json_encode(array('msg'=>'保存链接失败','success'=>0));
                      }
                  }
              }
              else
              {
                  echo json_encode(array('msg'=>'参数错误','success'=>0));
              }
          }
          
          public function update()
          {
              list($id)           = $this->input->getArgs();
              $post            = $this->input->post();
              if ($post['name'])
              {
                  $insert        = array(
                      'orderNum'         => $post['order']
                  );
                  $return        = M('attribute')->update($insert,array('id'=>$id));
                  if ($return >0)
                  {
                      D('attr')->updateAttr($post['id']);
                      echo json_encode(array('msg'=>'','success'=>1));
                  }
                  else
                  {
                      echo json_encode(array('msg'=>'保存链接失败','success'=>0));
                  }
              }
              else
              {
                  echo json_encode(array('msg'=>'参数错误','success'=>0));
              }
          }
          
          public function updateItem()
          {
              $post            = $this->input->post();
              $id = $post['id'];
              if ($post['name'])
              {
                  $cid = M('attribute')->getFieldData('cateId',array('id'=>$post['categoryId']));
                  $count        = M('attribute')->getAllCount(array('name'=>$post['name'],'pid'=>$post['categoryId'],'cateId'=>$cid,'id !='=>$id));
                  if ($count >0)
                  {
                      echo json_encode(array('msg'=>'该属性值已存在','success'=>0));
                  }
                  else
                  {
                      $insert        = array(
                          'name'         => $post['name']
                      );
                      $return        = M('attribute')->update($insert,array('id'=>$id));
                      if ($return >0)
                      {
                          D('attr')->updateDictOption($post['id']);
                          echo json_encode(array('msg'=>'','success'=>1,'cid'=>$cid));
                      }
                      else
                      {
                          echo json_encode(array('msg'=>'保存链接失败','success'=>0));
                      }
                  }
              }
              else
              {
                  echo json_encode(array('msg'=>'参数错误','success'=>0));
              }
          }
          
          public function delete()
          {
              $id         = P('id');
              $cId        = P('cid');
              if ($id>0)
              {           
                  $return     = M('attribute')->delete(array('id'=>$id));
                  D('attr')->updateAttr($cId);
                  $return     = M('attribute')->delete(array('pid'=>$id));                  
                  echo json_encode(array('success'=>1));
              }
              else
              {
                  echo json_encode(array('success'=>0));
              }
          }
          
          public function deleteItem()
          {
              $id         = S('deleteItem');
              if ($id>0)
              {
                  $cid = M('attribute')->getFieldData('cateId', array('id'=>$id));
                  $return     = M('attribute')->delete(array('id'=>$id));
                  D('attr')->updateDictOption($cId);
              }
              input::redirect('admin/attr/index/'.$cid);
          }

          public function getItemAttr()
          {              
              $id = P('id',0);
              $itemId = P('itemId',0);
              $rs = M('attribute')->where(array('cateId'=>$id,'pid'=>0))->orderby(array('orderNum'=>'desc'))->execute();
              $ht = '';
              $script = array();
              foreach($rs as $value)
              {
                  $itemAttr = M('item_attribute')->getOneData(array('attrId'=>$value->id,'itemId'=>$itemId));
                  $ht .= '<select id="attr'.$value->id.'" attrid="'.$value->id.'" name="attr" class="puiSelect" size="10">';
                  $itemList = M('attribute')->where(array('pid'=>$value->id))->orderby(array('orderNum'=>'desc'))->execute();
                  foreach($itemList as $item)
                  {
                      $ht .= '<option value="'.$item->id.'"';
                      if($itemAttr && $itemAttr->optionId==$item->id)
                          $ht .= 'selected="selected"';
                      $ht .= '>'.$item->name.'</option>';
                  }
                  $ht .= '</select>';
                  $script[] = 'attr'.$value->id;
              }
              echo json_encode(array('page'=>$ht,'script'=>$script));
          }
      }
