<?php defined('KING_PATH') or die('访问被拒绝.');
      class Link_Controller extends Template_Controller
      {
          private $mod;
          public function __construct()
          {
              parent::__construct();
              hcomm_ext::validUser();
              $this->mod    = M('link');
          }
          
          public function index()
          {            
              $total		= $this->mod->getAllCount();
              $data['pagination'] = pagination::getClass(array(
                  'total'			=> $total,
                  'perPage'		=> 10
                  ));
              $start			= ($data['pagination']->currentPage-1)*10;
              $rs				= $this->mod->limit($start,10)->execute();
              $data['tree']	= $rs;
              $this->template->content    = new View('admin/link/index_view',$data);
              $this->template->render();
          }
          
          public function add()
          {
              $this->template->content    = new View('admin/link/add_view');
              $this->template->render();
          }
          
          public function edit()
          {
              list($id)	= $this->input->getArgs();
              $data['row']        = $this->mod->getOneData("id='$id'");
              $this->template->content = new View('admin/link/add_view',$data);
              $this->template->render();            
          }        
          
          public function save()
          {
              list($id)	    = $this->input->getArgs();
              $lName			= $this->input->post("lName");
              $lHref			= $this->input->post("lHref");
              if ($lName)
              {
                  if($id)
                  {
                      $insert        = array(
                              'name'      => $lName,
                              'href'      => $lHref
                          );
                      $wh					= array(
                          'id'			=> $id
                          );
                      $return        = $this->mod->update($insert,$wh);
                      if ($return >0)
                      {
                          echo json_encode(array('msg'=>'','success'=>1));
                      }
                      else
                      {
                          echo json_encode(array('msg'=>'更新链接失败','success'=>0));
                      }
                  }
                  else
                  {
                      $count        = $this->mod->getAllCount(array('name'=>$lName));
                      if ($count >0)
                      {
                          echo json_encode(array('msg'=>'该站点已存在','success'=>0));
                      }
                      else
                      {
                          $insert        = array(
                              'name'      => $lName,
                              'href'      => $lHref
                          );
                          $return        = $this->mod->save($insert);
                          if ($return >0)
                          {
                              echo json_encode(array('msg'=>'','success'=>1));
                          }
                          else
                          {
                              echo json_encode(array('msg'=>'保存链接失败','success'=>0));
                          }
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
              list($id)	    = $this->input->getArgs();
              if ($id>0)
              {
                  $return     = $this->mod->delete(array('id'=>$id));
              }
              input::redirect('admin/link/index');
          }
      }
