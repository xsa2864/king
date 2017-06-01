<?php defined('KING_PATH') or die('访问被拒绝.');
      class Advert_Controller extends Template_Controller
      {
          private $mod;
          public function __construct()
          {
              parent::__construct();
              hcomm_ext::validUser();
              $this->mod      = M('advert');
          }
          
          public function index()
          {
              //$limit		= 10;
              //$total		= M('adposition')->getAllCount();
              //$data['pagination'] = pagination::getClass(array(
              //        'segment'		=> 'index',
              //        'total'    		=> $total,//总条数
              //        'perPage' 		=> $limit//每页显示的条数
              //));
              //$start		= $limit*($data['pagination']->currentPage-1);
              $data['adList']	= M('ad_position')->where(array('adType'=>1))->orderby(array('id'=>'asc'))->execute();
              $this->template->content    = new View('admin/advert/index_view',$data);              
              $this->template->tipBoxContent1 = new View('admin/advert/edit_view');
              $pic = D('picture')->GetData();
              $this->template->tipBoxContent2 = new View('admin/picture/useImg_view', $pic);
              $this->template->render();
          }
          
          public function add()
          {
              $time				= time();
              $data['validKey']	= md5($GLOBALS['config']['md5Key'].$time);
              $data['validTime']	= $time;
              $data['ad_type'] = $this->getType();
              $this->template->content	= new View('admin/advert/add_view',$data);
              $this->template->render();
          }
          
          public function edit()
          {
              $time				= time();
              $data['id']			= $this->input->segment('edit');
              $data['validKey']	= md5($GLOBALS['config']['md5Key'].$time);
              $data['row']		= $this->mod->getOneData(array('id'=>$data['id']));
              $data['validTime']	= $time;
              $data['ad_type'] = $this->getType();
              $this->template->content	= new View('admin/advert/add_view',$data);
              $this->template->render();
          }
          
          public function save()
          {
              $post	= $this->input->post();
              $files	= array();
              if ($post['name'])
              {
                  $count  = $this->mod->getAllCount(array('name'=>$post['name']));
                  if($count<=0)
                  {
                      foreach ($post['files'] as $key=>$value)
                      {
                          $files[$value]	= $post['urls'][$key];
                      }
                      
                      $rs		= $this->mod->insert(array('name'=>$post['name'],'pics'=>serialize($files),'adType'=>$post['adType']));
                  }
              }      	
          }
          
          public function update()
          {
              $id = P('id');
              $url = P('url');
              $pic = P('pic');
              M('ad_position')->update(array('url'=>$url, 'pic'=>$pic), array('id'=>$id));              
              $this->refleshAdp();
              input::redirect('admin/advert/index');        	
          }
          
          public function delete()
          {
              $id        = $this->input->segment('delete');
              if ($id>0)
              {
                  $pics       = $this->mod->getFieldData('pics',array('id'=>$id));
                  $pics       = unserialize($pics);
                  if (count($pics)>0)
                  {
                      foreach ($pics as $key=>$value)
                      {
                          output_ext::delImg($key);
                      }
                  }
                  $this->mod->delete(array('id'=>$id));
                  input::redirect('admin/advert/index');
              }
          }
          /*
           * 获取广告分类
           */
          public function getType()
          {
              $ad_type = M('dict_item')->select("*")->where("did=12")->execute();
              return $ad_type;
          }

          public function adPositionList()
          {
              $data['rs'] = M('ad_position')->execute();
              foreach($data['rs'] as $value)
              {
                  if($value->adId>0)
                      $value->add = M('advert')->getFieldData('name',array('id'=>$value->adId));
                  else
                  {
                      $value->add = '（空）';
                  }
              }
              $this->template->content	= new View('admin/advert/adPositionList_view',$data);
              $this->template->render();
          }

          public function addPosition()
          {
              $this->template->content	= new View('admin/advert/addPosition_view',$data);
              $this->template->render();
          }

          public function deletePosition()
          {
              $id        = $this->input->segment('deletePosition');
              M('ad_position')->delete(array('id'=>$id));
              $this->refleshAdp();
              input::redirect('admin/advert/adPositionList');
          }

          public function editPosition()
          {
              $id        = $this->input->segment('editPosition');
              $data['row'] = M('ad_position')->getOneData(array('id'=>$id));
              if(strstr($data['row']->adSize, 'x'))
              {
                  $ca = array_filter(explode("x",$data['row']->adSize));
                  $data['row']->adSizeX=$ca[0];
                  $data['row']->adSizeY=$ca[1];
              }
              $this->template->content	= new View('admin/advert/addPosition_view',$data);
              $this->template->render();
          }

          public function savePosition()
          {
              $id        = $this->input->segment('savePosition');
              $post	= $this->input->post();
              if($id)
              {
                  if ($post['name']&&$post['adSizeX']&&$post['adSizeY']&&$post['divId'])
                  {
                      $count = M('ad_position')->getAllCount(array('name'=>$post['name'],'id!='=>$id));
                      if($count>0)
                      {
                          echo json_encode(array('msg'=>'该广告位名称已存在','success'=>0));
                      }
                      else
                      {
                          $count = M('ad_position')->getAllCount(array('divId'=>$post['divId'],'id!='=>$id));
                          if($count>0)
                          {
                              echo json_encode(array('msg'=>'该广告位divId已存在','success'=>0));
                          }
                          else
                          {
                              if(!is_numeric($post['adSizeX']) || !is_numeric($post['adSizeY']))
                              {
                                  echo json_encode(array('msg'=>'宽高必须为数字','success'=>0));
                              }
                              else
                              {
                                  $ins = array('name'=>$post['name'], 'divId'=>$post['divId'], 'adSize'=>$post['adSizeX'].'x'.$post['adSizeY']);
                                  $return = M('ad_position')->update($ins,array('id'=>$id));
                                  if($return>0)
                                  {
                                      echo json_encode(array('msg'=>'','success'=>1));
                                  }
                                  else
                                  {
                                      echo json_encode(array('msg'=>'保存失败','success'=>0));
                                  }
                              }
                          }
                      }
                  }
                  else
                  {
                      echo json_encode(array('msg'=>'参数错误','success'=>0));
                  }
              }
              else
              {
                  if ($post['name']&&$post['adSizeX']&&$post['adSizeY'])
                  {
                      $count = M('ad_position')->getAllCount(array('name'=>$post['name']));
                      if($count>0)
                      {
                          echo json_encode(array('msg'=>'该广告位名称已存在','success'=>0));
                      }
                      else
                      {
                          $count = M('ad_position')->getAllCount(array('divId'=>$post['divId']));
                          if($count>0)
                          {
                              echo json_encode(array('msg'=>'该广告位divId已存在','success'=>0));
                          }
                          else
                          {
                              if(!is_numeric($post['adSizeX']) || !is_numeric($post['adSizeY']))
                              {
                                  echo json_encode(array('msg'=>'宽高必须为数字','success'=>0));
                              }
                              else
                              {
                                  $ins = array('name'=>$post['name'], 'divId'=>$post['divId'], 'adSize'=>$post['adSizeX'].'x'.$post['adSizeY']);
                                  $return = M('ad_position')->insert($ins);
                                  if($return>0)
                                  {
                                      echo json_encode(array('msg'=>'','success'=>1));
                                  }
                                  else
                                  {
                                      echo json_encode(array('msg'=>'保存失败','success'=>0));
                                  }
                              }
                          }
                      }
                  }
                  else
                  {
                      echo json_encode(array('msg'=>'参数错误','success'=>0));
                  }
              }
              $this->refleshAdp();        	
          }
          
          public function appendAd()
          {
              $id        = $this->input->segment('appendAd');
              $data['row'] = M('ad_position')->getOneData(array('id'=>$id));
              if(strstr($data['row']->adSize, 'x'))
              {
                  $ca = array_filter(explode("x",$data['row']->adSize));
                  $data['row']->adSizeX=$ca[0];
                  $data['row']->adSizeY=$ca[1];
              }
              $time				= time();
              $data['validKey']	= md5($GLOBALS['config']['md5Key'].$time);
              $data['validTime']	= $time;
              $options            = M('advert')->orderby(array('id'=>'desc'))->execute();
              $data['options']    = $options;
              $this->template->content	= new View('admin/advert/appendAd_view',$data);
              $this->template->render();
          }

          public function upNew()
          {
              $id         = $this->input->segment('upNew');
              $post       = $this->input->post();
              $files	= array();
              if ($post['name'])
              {
                  $count  = $this->mod->getAllCount(array('name'=>$post['name']));
                  if($count<=0)
                  {
                      $files[$post['files']]	= $post['urls'];
                      
                      $rs		= $this->mod->insert(array('name'=>$post['name'],'pics'=>serialize($files),'adType'=>1));
                      if($rs>0)
                          $adId   = $this->mod->getFieldData('id', array('name'=>$post['name']));
                      else
                      {
                          echo json_encode(array('msg'=>'添加广告失败','success'=>0));
                          exit;
                      }
                  }
                  else
                  {
                      echo json_encode(array('msg'=>'该广告已存在,可选择现有广告','success'=>0));
                      exit;
                  }
              }
              else
              {
                  echo json_encode(array('msg'=>'参数错误','success'=>0));
                  exit;
              }
              if($id && $adId)
              {
                  $ins = array('adId'=>$adId);
                  $return = M('ad_position')->update($ins,array('id'=>$id));
                  if($return>0)
                  {
                      echo json_encode(array('msg'=>'','success'=>1));
                  }
                  else
                  {
                      echo json_encode(array('msg'=>'保存失败','success'=>0));
                  }
              }
              else
              {
                  echo json_encode(array('msg'=>'参数错误','success'=>0));
              }
              $this->refleshAdp();
          }

          public function upOld()
          {              
              $id         = $this->input->segment('upOld');
              $post       = $this->input->post();
              if($id && $post['adId'])
              {
                  $ins = array('adId'=>$post['adId']);
                  $return = M('ad_position')->update($ins,array('id'=>$id));
                  if($return>0)
                  {
                      echo json_encode(array('msg'=>'','success'=>1));
                  }
                  else
                  {
                      echo json_encode(array('msg'=>'保存失败','success'=>0));
                  }
              }
              else
              {
                  echo json_encode(array('msg'=>'参数错误','success'=>0));
              }
              $this->refleshAdp();
          }

          public function getAdPosition()
          {
              $data['rs'] = M('ad_position')->execute();
              $data['id'] = $this->input->segment('getAdPosition');
              $this->template->content	= new View('admin/advert/getAdPosition_view',$data);
              $this->template->render();              
          }

          public function saveAllAdPosition()
          {
              $id         = $this->input->segment('saveAllAdPosition');
              $post       = $this->input->post();
              if(!is_array($post['ids']))
              {
                  $post['ids']=array();
              }
              if($id)
              {
                  $adpList = M('ad_position')->execute();
                  $ins = array('adId'=>$id);
                  $upd = array('adId'=>0);

                  foreach($adpList as $value)
                  {
                      if(in_array($value->id,$post['ids']))
                      {
                          if($value->adId!=$id)
                          {
                              $return = M('ad_position')->update($ins,array('id'=>$value->id));
                          }
                      }
                      else
                      {
                          if($value->adId==$id)
                          {
                              $return = M('ad_position')->update($upd,array('id'=>$value->id));
                          }
                      }
                  }
                  echo json_encode(array('msg'=>'','success'=>1));
              }
              else
              {
                  echo json_encode(array('msg'=>'参数错误','success'=>0));
              }
              $this->refleshAdp();
          }

          public function refleshAdp()
          {
              $adpList = M('ad_position')->where(array('terminal'=>1))->execute();
              file_ext::operaFile($GLOBALS['config']['basePath']."../library/www/js/adPosition/adPosition.js","");
              foreach($adpList as $value)
              {
                  if(strstr($value->picSize, 'x'))
                  {
                      $size = array_filter(explode("x",$value->picSize));
                      $adSizeX = $size[0];
                      $adSizeY = $size[1];
                  }
                  $fa = '1';
                  if($value->channel=='专题'){
                      $fa = '2';
                  }
                  $divId = 'add_'.$fa.$value->site;
                  if($value->itemId>0)
                  {
                      $item = M('item')->getOneData(array('id'=>$value->itemId));
                      file_ext::operaFile($GLOBALS['config']['basePath']."../library/www/js/adPosition/adPosition.js", '$(\'#'.$divId.'\').html(\'<a target="_blank" href="'.input::site('detail-'.$item->id).'.html"><img src="'.output_ext::getCoverImg($item->pics,$value->picSize).'" style="width:'.$adSizeX.'px; height:'.$adSizeY.'px"/><span class="text bold">'.str_ext::msubstr($item->title,0,20).'...</span><span><strong>'.$item->price.'元</strong><i>原价<del>'.$item->prePrice.'元</del></i></span></a>\');','a');
                  }
                  else
                  {
                      $url='';
                      if($value->url)
                          $url =  'target="_blank" href="'.$value->url.'"';
                      file_ext::operaFile($GLOBALS['config']['basePath']."../library/www/js/adPosition/adPosition.js", '$(\'#'.$divId.'\').html(\'<a style="cursor: pointer;" '.$url.'><img src="'.$value->pic.'" style="width:'.$adSizeX.'px; height:'.$adSizeY.'px"/></a>\');','a');
                  }
              }
              
              $adpList = M('ad_position')->where(array('terminal'=>2))->execute();
              file_ext::operaFile($GLOBALS['config']['basePath']."../library/wechat/js/adPosition/adPosition.js","");
              foreach($adpList as $value)
              {
                  if(strstr($value->picSize, 'x'))
                  {
                      $size = array_filter(explode("x",$value->picSize));
                      $adSizeX = $size[0];
                      $adSizeY = $size[1];
                  }
                  $fa = '1';
                  if($value->channel=='专题'){
                      $fa = '2';
                  }
                  $divId = 'add_'.$fa.$value->site;
                  if($value->itemId>0)
                  {
                      $item = M('item')->getOneData(array('id'=>$value->itemId));
                      file_ext::operaFile($GLOBALS['config']['basePath']."../library/wechat/js/adPosition/adPosition.js", '$(\'#'.$divId.'\').html(\'<a target="_blank" href="'.input::site('detail-'.$item->id).'.html"><img src="'.output_ext::getCoverImg($item->pics,$value->picSize).'" style="width:'.$adSizeX.'px; height:'.$adSizeY.'px"/><span class="text bold">'.str_ext::msubstr($item->title,0,20).'...</span><span><strong>'.$item->price.'元</strong><i>原价<del>'.$item->prePrice.'元</del></i></span></a>\');','a');
                  }
                  else
                  {
                      $url='';
                      if($value->url)
                          $url =  'target="_blank" href="'.$value->url.'"';
                      file_ext::operaFile($GLOBALS['config']['basePath']."../library/wechat/js/adPosition/adPosition.js", '$(\'#'.$divId.'\').html(\'<a style="cursor: pointer;" '.$url.'><img src="'.$value->pic.'" style="width:'.$adSizeX.'px; height:'.$adSizeY.'px"/></a>\');','a');
                  }
              }
          }
      }
?>