<?php defined('KING_PATH') or die('访问被拒绝.');
      class Picture_Controller extends Template_Controller
      {
          public function __construct()
          {
              parent::__construct();
              comm_ext::validUser();
          }
          
          public function index()
          {
              $data = D('picture')->GetData();
              $this->template->content    = new View('admin/picture/index_view',$data);
              $this->template->tipBoxContent1 = new View('admin/picture/showBig_view');
              $this->template->tipBoxContent2 = new View('admin/picture/moveImg_view',$data);
              $this->template->render();
          }

          public function renameImg()
          {
              $id = P('id');
              $name = P('name');
              $rs = M('picture')->update(array('name'=>$name),array('id'=>$id));
              echo json_encode(array('success'=>1));
          }

          public function deleteImg()
          {
              $id = P('id');
              $check = M('picture')->getOneData(array('id'=>$id));
              $rs = M('picture')->delete(array('id'=>$id));
              $dm = output_ext::delImg($check->img);
              echo json_encode(array('success'=>1));
          }
          
          public function getPic()
          {
              $id = P('id');
              $select = P('select');
              $wh = array();
              if(isset($select))
              {
                  $wh['name like'] = '%'.$select.'%';
              }
              $onCategory = M('picture_category')->getOneData(array('id'=>$id));
              if($onCategory)
              {
                  $wh['cid'] = $id;
              }
              $return =  M('picture')->where($wh)->execute();
              foreach($return as $value)
              {
                  $names    = explode('.',$value->img);
                  $value->pic = input::site($names[0].'_88x83.'.$names[1]);
                  $value->name = $value->name.'.'.$names[1];
              }
              $picList = $return;
              $return1 = M('picture_category')->where(array('pid'=>$id))->execute();
              $pl = '';
              foreach($return1 as $item)
              {
                  $pl .= '<li>
                                    	<div class="c1" ondblclick="javascript:openFile('.$item->id.')">
                                            <img src="'.input::imgUrl('imgs_03.png').'" width="88" height="83" />
                                            <span class="span_see">'.$item->name.'</span>
                                            <dl class="dl_see " style="display:none" >
                                                <dd class="wbk" style="display:none"><input type="text" /></dd>
                                            </dl>
                                         </div>
                                         
                                    </li>';
              }
              foreach($picList as $item)
              {
                  $pl .= '  <li id="'.$item->id.'">
                                <div class="c1">
                                    <img src="'.$item->pic.'" width="88" height="83" />
                                    <span class="span_see">'.$item->name.'</span>
                                    <dl class="dl_see " style="display: none">
                                        <dt><a class="a2" style="cursor:pointer;"></a><a class="a1" style="cursor:pointer;"></a></dt>
                                        <dd class="wbk" style="display: none">
                                            <input type="text" />
                                        </dd>
                                    </dl>
                                </div>
                                <div id="'.$item->id.'" class="ze_box" style="display: none">
                                    <span></span>
                                    <i></i>
                                </div>
                            </li>';
              }
              
              echo json_encode(array('success'=>1, 'ht'=>$pl));
          }

          public function getCategory()
          {              
              $id = P('id');
              $ht = '';
              $rs = M('picture_category')->where(array('pid'=>0))->execute();
              foreach($rs as $ch)
              {
                  $ch->child = M('picture_category')->where(array('pid'=>$ch->id))->execute();
                  foreach($ch->child as $ch1)
                  {
                      $ch1->child = M('picture_category')->where(array('pid'=>$ch1->id))->execute();
                  }
              }
              $sid = M('picture_category')->getFieldData('pid',array('id'=>$id));
              $ht = $this->getTree($rs,$id,$sid);
              echo json_encode(array('success'=>1,'html'=>$ht));
          }
          
          public function addCategory()
          {
              $id = P('id');
              $message = '';
              if($id>0)
              {
                  $pid = M('picture_category')->getOneData(array('id'=>$id));
                  if($pid)
                  {
                      $ppid = M('picture_category')->getOneData(array('id'=>$pid->pid));
                      if($ppid && $ppid->pid>0)
                      {                      
                          echo json_encode(array('success'=>0,'msg'=>'分类最多只允许添加三级，请重新选择分类'));
                          return;
                      }
                  }
              }
              $rs = M('picture_category')->save(array('pid'=>$id,'name'=>'新建分类'));
              if($rs>0)
              {
                  if($pid)
                  {
                      $cl1 = M('picture_category')->where(array('pid'=>$id))->execute();
                      $cl = array();
                      $cl= array_merge($cl, $cl1);
                      foreach($cl1 as $child1)
                      {
                          $cl= array_merge($cl, M('picture_category')->where(array('pid'=>$child1->id))->execute());
                      }
                      $cls = array();
                      foreach($cl as $child)
                      {
                          $cls[] = $child->id;
                      }
                      $cls = implode(',',$cls);
                      M('picture_category')->update(array('childList'=>$cls),array('id'=>$id));
                  }
                  if($ppid)
                  {
                      $cl1 = M('picture_category')->where(array('pid'=>$ppid->id))->execute();                      
                      $cl = array();
                      $cl= array_merge($cl, $cl1);
                      foreach($cl1 as $child1)
                      {
                          $cl= array_merge($cl, M('picture_category')->where(array('pid'=>$child1->id))->execute());
                      }
                      $cls = array();
                      foreach($cl as $child)
                      {
                          $cls[] = $child->id;
                      }
                      $cls = implode(',',$cls);
                      M('picture_category')->update(array('childList'=>$cls),array('id'=>$ppid->id));
                  }
                  $ht = '';
                  $rs = M('picture_category')->where(array('pid'=>0))->execute();
                  foreach($rs as $ch)
                  {
                      $ch->child = M('picture_category')->where(array('pid'=>$ch->id))->execute();
                      foreach($ch->child as $ch1)
                      {
                          $ch1->child = M('picture_category')->where(array('pid'=>$ch1->id))->execute();
                      }
                  }
                  $ht = $this->getTree($rs,$pid->id,$ppid->id);
                  echo json_encode(array('success'=>1,'msg'=>$message,'html'=>$ht));
              }
              else
              {
                  echo json_encode(array('success'=>0,'msg'=>'新建失败'));
              }
          }

          public  function renameCategory()
          {
              $id = P('id');
              $name = P('name');
              $rs = M('picture_category')->update(array('name'=>$name),array('id'=>$id));
              echo json_encode(array('success'=>1));
          }

          public function deleteCategory()
          {
              $id = P('id');
              $rs = M('picture_category')->getOneData(array('id'=>$id));
              $fid = $rs->pid;
              if($fid==0)
              {
                  echo json_encode(array('success'=>0,'msg'=>'无法删除主类别'));
                  exit;
              }
              $ca = array();
              if(strstr($rs->childList, ','))
              {
                  $ca = array_filter(explode(",",$rs->childList));
              }
              else if($rs->childList)
              {
                  $ca[] = $rs->childList;
              }
              $ca[] = $id;
              $wh = array('cid in'=>$ca);
              M('picture')->delete($wh);
              M('picture_category')->delete(array('id in'=>$ca));
              $ht = '';
              $rs = M('picture_category')->where(array('pid'=>0))->execute();
              foreach($rs as $ch)
              {
                  $ch->child = M('picture_category')->where(array('pid'=>$ch->id))->execute();
                  foreach($ch->child as $ch1)
                  {
                      $ch1->child = M('picture_category')->where(array('pid'=>$ch1->id))->execute();
                  }
              }
              $ht = $this->getTree($rs,$fid);
              echo json_encode(array('success'=>1,'html'=>$ht,'url'=> input::site('admin/picture/index/1/on/'.$fid), 'nid'=>$fid));
          }

          /**
           * 获取分类树HTML
           * @param mixed 分类树数据 
           * @param mixed 选中树节点 
           * @param mixed 选中树父节点
           * @return string HTML字符串
           */
          public function getTree($picCategory,$fid=0,$sid=0)
          {
              $ht = '';
              if($picCategory && is_array($picCategory))
              {                  
                  foreach($picCategory as $item)
                  {
                      $ht .= '<li>
                                <a';
                      if($item->id==$fid)
                      {
                          $ht .= ' class="open on"';
                      }
                      else
                      {
                          $ht .= ' class="open"';
                      }
                      $ht .= ' style="cursor:pointer;" name="'.$item->id.'">';
                      if($item->child) $ht .= '<em></em>';
                      $ca = array();
                      if(strstr($item->childList, ','))
                      {
                          $ca = array_filter(explode(",",$item->childList));
                      }
                      else if($ch1->childList)
                      {
                          $ca[] = $ch1->childList;
                      }
                      $ca[] = $item->id;
                      $wh = array('cid in'=>$ca);
                      $total = M('picture')->getAllCount($wh);
                      $ht .= $item->name.'（'.$total.'）</a>';
                      if($item->child)
                      {
                          $ht .= '<ul class="left_sum" style="display: block">';
                          foreach($item->child as $ch1)
                          {
                              $ht .= '<li>
                                        <a';
                              if($ch1->id==$fid)
                              {
                                  $ht .= ' class="open on"';
                              }
                              else if($ch1->id==$sid)
                              {
                                  $ht .= ' class="open"';
                              }
                              $ht .= ' style="cursor:pointer;" name="'.$ch1->id.'">';
                              if($ch1->child) $ht .= '<em></em>';
                              $ca = array();
                              if(strstr($ch1->childList, ','))
                              {
                                  $ca = array_filter(explode(",",$ch1->childList));
                              }
                              else if($ch1->childList)
                              {
                                  $ca[] = $ch1->childList;
                              }
                              $ca[] = $ch1->id;
                              $wh = array('cid in'=>$ca);
                              $total = M('picture')->getAllCount($wh);
                              $ht .= $ch1->name.'（'.$total.'）</a>';
                              if($ch1->child)
                              {
                                  $ht .= '<ul class="left_sum2" style="display: ';
                                  if($ch1->id==$fid || $ch1->id==$sid)
                                  {
                                      $ht .= 'block';
                                  }
                                  else
                                  {
                                      $ht .= 'none';
                                  }
                                  $ht .= '">';
                                  foreach($ch1->child as $ch2)
                                  {
                                      $ca = array();
                                      $ca[] = $ch2->id;
                                      $wh = array('cid in'=>$ca);
                                      $total = M('picture')->getAllCount($wh);
                                      $ht .= '<li><a';
                                      if($ch2->id==$fid)
                                      {
                                          $ht .= ' class="on"';
                                      }
                                      $ht .= ' style="cursor:pointer;" name="'.$ch2->id.'">'.$ch2->name.'（'.$total.'）</a></li>';
                                  }
                                  $ht .= '</ul>';
                              }
                              $ht .= '</li>';
                          }                                    
                          $ht .= '</ul>';
                      }
                      $ht .= '</li>';
                  }
              }
              return $ht;
          }

          /**
           * 保存图片
           */
          public function savePic()
          {
              $id = P('id');
              $img = P('img');
              $filename = P('filename');
              $rs = M('picture')->save(array('cid'=>$id,'name'=>$filename,'img'=>$img));
              if($rs>0)
              {
                  echo json_encode(array('success'=>1));
              }
              else
              {                  
                  echo json_encode(array('success'=>0,'msg'=>'保存图失败！'));
              }
          }

          /**
           * 移动图片
           */
          public function moveImg()
          {
              $id = P('id');
              $on = P('on');
              $rs = M('picture')->update(array('cid'=>$on),array('id'=>$id));
              if($rs>0)
              {
                  echo json_encode(array('success'=>1));
              }
              else
              {                  
                  echo json_encode(array('success'=>0,'msg'=>'移动图失败！'));
              }
          }
      }