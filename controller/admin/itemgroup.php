<?php defined('KING_PATH') or die('访问被拒绝.');
      class ItemGroup_Controller extends Template_Controller
      {
          private $mod;
          private $memcached;
          private $dict;
          public function __construct()
          {
              parent::__construct();
              comm_ext::validUser();
          }
          
          public function index()
          {
              $mod        = M('special');
              $total		= $mod->getAllCount();
              $data['pagination'] = pagination::getClass(array(
                  'total'		    => $total,
                  'perPage'		=> 10
              ));
              $start		= ($data['pagination']->currentPage-1)*10;
              $rs			= $mod->orderby(array('order'=>'desc'))->limit($start,10)->execute();
              $data['tree']=$rs;
              $this->template->content    = new View('admin/itemgroup/index_view',$data);
              $this->template->render();
          }

          public function add($id = 0)
          {
              $this->template->content    = new View('admin/itemgroup/add_view',$data);
              $this->template->render();
          }

          public function edit()
          {
              list($id)	= $this->input->getArgs();
              $data['row'] = M("special")->getOneData(array('id'=>$id));
              $this->template->content    = new View('admin/itemgroup/add_view',$data);
              $this->template->render();
          }

          public function save()
          {
              $name     = $this->input->post('name');
              $page     = $this->input->post('page');
              $isSpecial = 0;
              if(isset($page) && $page!='')
              {
                  $isSpecial = 1;
              }
              $order    = $this->input->post('order');
              $item     = $this->input->post('item');
              $id       = $this->input->post('id');
              if (isset($name)&&$name!='')
              {
                  if ($id>0)
                  {
                      $num = M("special")->getAllCount(array('id<>'=>$id,'name'=>$name));
                      if($num>0)
                      {
                          echo json_encode(array('msg'=>'已有同名组合','success'=>0));
                      }
                      else
                      {
                          $re = M("special")->update(array('name'=>$name,'page'=>$page,'order'=>$order,'isSpecial'=>$isSpecial),array('id'=>$id));
                          if($re>0)
                              echo json_encode(array('msg'=>'','success'=>1));
                          else
                              echo json_encode(array('msg'=>'保存失败','success'=>0));
                      }
                  }
                  else
                  {
                      $num = M("special")->getAllCount(array('name'=>$name));
                      if($num>0)
                      {
                          echo json_encode(array('msg'=>'已有同名组合','success'=>0));
                      }
                      else
                      {
                          $re = M("special")->save(array('name'=>$name,'page'=>$page,'order'=>$order,'isSpecial'=>$isSpecial));
                          if($re>0)
                              echo json_encode(array('msg'=>'','success'=>1));
                          else
                              echo json_encode(array('msg'=>'保存失败','success'=>0));
                      }
                  }
              }
              else
                  echo json_encode(array('msg'=>'请输入组名','success'=>0));
          }

          public function del($id = 0)
          {
              list($id)	= $this->input->getArgs();
              $return 	= M("special")->delete(array('id'=>$id));
              input::redirect('admin/itemgroup'); 
          }

          public function addItem()
          {
              list($id)	= $this->input->getArgs();
              $data['id'] = $id;
              $this->template->content    = new View('admin/itemgroup/itemList_view',$data);
              $this->template->render();
          }

          public function itemList()
          {
              $id = $this->input->post('id');
              $page = $this->input->post('pageNum');
              $name = $this->input->post('name');
              $mod = M('item');
              $wh = array();
              $ItemIdList = D('itemgroup')->getItem($id);
              if(isset($name)&&$name!='')
              {
                  $wh['title like'] = '%'.$name.'%';
              }
              if(isset($ItemIdList)&&$ItemIdList!=array())
              {
                  $wh['id not in'] = $ItemIdList;
              }
              $total		        = $mod->getAllCount($wh);
              $totalPages           = floor($total/10)+($total%10>0?1:0);
              if($totalPages==0)
              {
                  $totalPages++;
              }
              if($page<=0)
              {
                  $page = 1;
              }
              if($page>$totalPages)
              {
                  $page = (string)$totalPages;
              }
              $start		= ($page-1)*10;
              $rs			= $mod->where($wh)->orderby(array('id'=>'desc'))->limit($start,10)->execute();
              $rs2          = array();
              foreach($rs as $value)
              {                  
                  $image =  unserialize($value->pics);
                  $images= input::imgUrl("default.png");
                  $img   = false;
                  if ((sizeof($image)) > 0 && is_array($image)) 
                  {
                      foreach($image as $key=>$val)
                      {
                          if ($val == 1 && !$img)
                          {
                              $images = input::site($key);
                              $img = true;
                          }
                          elseif ( !$img )
                          {
                              $images = input::site($key);
                          }
                      }
                  }
                  $rs2[] = array('id'=>$value->id,'order_id'=>$value->order_id,'images'=>$images,'title'=>$value->title);
              }
              $data['data']             = $rs2;
              $data['pageNum']          = $page;
              echo json_encode($data);
          }

          public function myItemList()
          {
              $id = $this->input->post('id');
              $page = $this->input->post('pageNum');
              $ItemIdList = D('itemgroup')->getItem($id);
              $mod = M('item');
              $wh = array();
              if(isset($ItemIdList)&&$ItemIdList!=array())
              {
                  $wh = array('id in'=>$ItemIdList);
              }
              else
              {
                  $wh = array('id in'=>array(0));                  
              }

              $total		        = $mod->getAllCount($wh);
              $totalPages           = floor($total/10)+($total%10>0?1:0);
              if($totalPages==0)
              {
                  $totalPages++;
              }
              if($page<=0)
              {
                  $page = 1;
              }
              if($page>$totalPages)
              {
                  $page = (string)$totalPages;
              }
              $start		= ($page-1)*10;
              $rs			= $mod->where($wh)->orderby(array('id'=>'desc'))->execute();
              $rs2          = array();
              foreach($rs as $value)
              {                  
                  $image =  unserialize($value->pics);
                  $images= input::imgUrl("default.png");
                  $img   = false;
                  if ((sizeof($image)) > 0 && is_array($image)) 
                  {
                      foreach($image as $key=>$val)
                      {
                          if ($val == 1 && !$img)
                          {
                              $images = input::site($key);
                              $img = true;
                          }
                          elseif ( !$img )
                          {
                              $images = input::site($key);
                          }
                      }
                  }
                  $rs2[] = array('id'=>$value->id,'order_id'=>$value->order_id,'images'=>$images,'title'=>$value->title);
              }
              $data['data']             = $rs2;
              $data['pageNum']          = $page;
              echo json_encode($data);
          }

          public function ItemListAdd()
          {
              $id = $this->input->post('id');
              $addId = $this->input->post('addId');
              $total = M('special_item')->getAllCount(array('groupId'=>$id,'itemId'=>$addId));
              if($total>0)
              {
                  echo json_encode(array('success'=>0,'msg'=>'已存在'));
              }
              else
              {
                  M('special_item')->save(array('groupId'=>$id,'itemId'=>$addId,'orderNum'=>0));
                  echo json_encode(array('success'=>1));
              }
          }

          public function ItemListRe()
          {
              $id = $this->input->post('id');
              $reId = $this->input->post('reId');
              M('special_item')->delete(array('groupId'=>$id,'itemId'=>$reId));
              echo json_encode(array('success'=>1));
          }
      }