<?php defined('KING_PATH') or die('访问被拒绝.');
      class Dict_Controller extends Template_Controller
      {
          private $mod;
          private $cache;
          public function __construct()
          {
              parent::__construct();
              hcomm_ext::validUser();
              $this->mod		= M('dict');
              $this->cache	= cache::getClass();
          }
          
          public function index()
          {
              list($property) = $this->input->getArgs();
              $data['name']	= '字典管理';
              $data['button']	= '添加字典';
              $data['property']	= $property;
              $wh = array();
              if($property==0)
              {
                  $data['name']	= '商品属性'; 
                  $data['button']	= '添加属性';
              }
              $wh = array('property'=>$property);
              $total		= $this->mod->getAllCount($wh);
              $data['pagination'] = pagination::getClass(array(
                  'total'			=> $total,
                  'perPage'		=> 10
                  ));
              $start			= ($data['pagination']->currentPage-1)*10;
              $rs				= $this->mod->where($wh)->limit($start,10)->execute();
              $data['tree']	= $rs;
              $this->template->content	= new View('admin/dict/index_view', $data);
              $this->template->render();
          }
          
          public function add()
          {
              list($property) = $this->input->getArgs();
              $data['name']	= '字典管理';
              $data['property']	= $property;
              if($property==0)
              {
                  $data['name']	= '商品属性'; 
              }
              $this->template->content	= new View('admin/dict/add_view',$data);
              $this->template->render();
          }
          
          public function addItem()
          {
              list($id)	= $this->input->getArgs();
              $data['did']		= $id;
              $data['name']       = $this->input->get('name');
              $this->template->content	= new View('admin/dict/add_item_view',$data);
              $this->template->render();
          }

          public function showItem()
          {
              $id         = $this->input->get('id');
              $name       = $this->input->get('name');
              $total		= $this->mod->getAllCount(array('did'=>$id),'dict_item');
              $data['pagination'] = pagination::getClass(array(
                  'total'			=> $total,
                  'perPage'		=> 10
                  ));
              $start			= ($data['pagination']->currentPage-1)*10;
              $rs		= $this->mod->from('dict_item')->where(array('did'=>$id))->limit($start,10)->execute();
              $data['tree']	= $rs;
              $data['did']	= $id;
              $data['name']	= $name;
              $this->template->content	= new View('admin/dict/show_item_view',$data);
              $this->template->render();
          }
          
          public function edit()
          {
              list($edit)	= $this->input->getArgs();
              if ($edit >0)
              {
                  $data['row']	= $this->mod->getOneData(array('id'=>$edit));
              }
              $property         = $this->input->get('property');
              $data['name']	= '字典管理';
              $data['property']	= $property;
              if($property==0)
              {
                  $data['name']	= '商品属性'; 
              }
              $this->template->content = new View('admin/dict/add_view',$data);
              $this->template->render();
          }
          
          public function editItem()
          {
              $id			    = $this->input->get("id");
              $data['did']	= $this->input->get("did");
              $data['name']	= $this->input->get("name");
              if ($id >0)
              {
                  $data['row']	= $this->mod->getOneData(array('id'=>$id),'','dict_item');
              }
              $this->template->content = new View('admin/dict/add_item_view',$data);
              $this->template->render();
          }

          public function save()
          {
              $id			    = $this->input->post("id");
              $dName			= $this->input->post("dName");
              $dProperty	    = $this->input->post("dProperty");
              $dShow			= $this->input->post("dShow");
              if ($dName)
              {
                  if (!$id)
                  {
                      $count		= $this->mod->getAllCount(array('name'=>$dName));
                      if ($count >0)
                      {
                          echo json_encode(array('msg'=>'该字典已存在','success'=>0));	
                      }
                      else 
                      {		
                          $insert		= array(
                              'name'		=> $dName,
                              'property'	=> $dProperty,
                              'show'		=> $dShow
                              );
                          $return		= $this->mod->save($insert);
                          if ($return >0)
                          {							
                              echo json_encode(array('msg'=>'添加成功','success'=>1));
                              if ($dProperty==0)
                              {
                                  if ($dShow==0)
                                  {
                                      $key	= 'item_attr_0';
                                      $wh		= array('property'=>0,'show'=>0);
                                      $rs		= $this->mod->where($wh)->execute();
                                      $this->cache->set($key,$rs,864000);//存储10天								 
                                  }
                                  $key	= 'item_attr_1';								
                                  $wh		= array('property'=>0);
                                  $rs		= $this->mod->where($wh)->execute();
                                  $this->cache->set($key,$rs,864000);//存储10天
                              }							
                          }
                          else
                              echo json_encode(array('msg'=>'保存失败','success'=>0));
                      }
                  }
                  else
                  {
                      $update			= array(
                          'name'		=> $dName,
                          'property'	=> $dProperty,
                          'show'		=> $dShow
                          );
                      $wh					= array(
                          'id'			=> $id
                          );
                      $return			= $this->mod->update($update,$wh);
                      if ($return >0)
                      {							
                          echo json_encode(array('msg'=>'更新成功','success'=>1));
                          if ($dProperty==0)
                          {
                              if ($dShow==0)
                              {
                                  $key	= 'item_attr_0';
                                  $wh		= array('property'=>0,'show'=>0);
                                  $rs		= $this->mod->where($wh)->execute();
                                  $this->cache->set($key,$rs,864000);//存储10天								 
                              }
                              $key	= 'item_attr_1';								
                              $wh		= array('property'=>0);
                              $rs		= $this->mod->where($wh)->execute();
                              $this->cache->set($key,$rs,864000);//存储10天
                          }
                      }
                      else
                          echo json_encode(array('msg'=>'保存失败','success'=>0));	
                  }
              }
              else
                  echo json_encode(array('msg'=>'参数错误','success'=>0));
          }

          public function saveItem()
          {
              $id			    = $this->input->post("id");
              $did			= $this->input->post("did");
              $itemName		= $this->input->post("itemName");
              $itemData		= $this->input->post("itemData");
              $orderNum		= $this->input->post("orderNum");
              if ($itemName)
              {
                  if (!$id)
                  {
                      $count		= $this->mod->getAllCount(array('name'=>$itemName,'did'=>$did),'dict_item');
                      if ($count >0)
                      {
                          echo json_encode(array('msg'=>'该字典项已存在','success'=>0));	
                      }
                      else 
                      {		
                          $insert		= array(
                              'name'		=> $itemName,
                              'orderNum'	=> $orderNum,
                              'did'		=> $did,
                              'data'		=> $itemData
                              );
                          $return		= $this->mod->save($insert,'dict_item');
                          if ($return >0)
                          {
                              echo json_encode(array('msg'=>'添加成功','success'=>1));							
                              $key	= 'dict_'.$did;
                              $rs		= $this->mod->select('id,name')->from('dict_item')->where(array('did'=>$did))->orderby(array('orderNum'=>'asc'))->execute();
                              $this->cache->set($key,$rs,86400);
                          }
                          else
                              echo json_encode(array('msg'=>'保存失败','success'=>0));	
                      }
                  }
                  else
                  {
                      $upd		= array(
                          'name'		=> $itemName,
                          'orderNum'	=> $orderNum,
                          'data'	    => $itemData
                          );
                      $wh			= array('id'=>$id);
                      $return		= $this->mod->update($upd,$wh,'dict_item');
                      if ($return >0)
                      {
                          echo json_encode(array('msg'=>'更新成功','success'=>1));						
                          $key	= 'dict_'.$did;
                          $rs		= $this->mod->select('id,name')->from('dict_item')->where(array('did'=>$did))->orderby(array('orderNum'=>'asc'))->execute();
                          $this->cache->set($key,$rs,86400);
                      }
                      else
                          echo json_encode(array('msg'=>'更新失败','success'=>0));					
                  }
              }
              else
                  echo json_encode(array('msg'=>'参数错误','success'=>0));
          }
          
          public function del()
          {
              list($id)	= $this->input->getArgs();
              $property         = $this->input->get('property');
              if ($id>0)
              {
                  $rs			= $this->mod->getOneData(array('id'=>$id));
                  $return 	= $this->mod->delete(array('id'=>$id));
                  if ($return >0)
                  {
                      if ($rs->property==0)
                      {
                          if ($rs->show==0)
                          {
                              $key	= 'item_attr_0';
                              $wh		= array('property'=>0,'show'=>0);
                              $rs		= $this->mod->where($wh)->execute();
                              $this->cache->set($key,$rs,864000);//存储10天								 
                          }
                          $key	= 'item_attr_1';								
                          $wh		= array('property'=>0);
                          $rs		= $this->mod->where($wh)->execute();
                          $this->cache->set($key,$rs,864000);//存储10天
                      }
                      $key	= 'dict_'.$id;
                      $this->cache->delete($key);
                      $this->mod->delete(array('did'=>$id),'dict_item');
                  }
              }
              echo "<script>location.href='/admin/dict/index/$property'</script>";
          }
          
          public function delItem()
          {
              $id			    = $this->input->get("id");
              $did			= $this->input->get("did");
              $name			= $this->input->get("name");
              if ($id>0)
              {
                  $return 	= $this->mod->delete(array('id'=>$id),'dict_item');
                  if ($return >0)
                  {
                      $key	= 'dict_'.$id;
                      $this->cache->delete($key);
                  }
              }			
              echo "<script>location.href='/admin/dict/showItem?id=".$did."&name=".$name."'</script>";
          }
          
      }