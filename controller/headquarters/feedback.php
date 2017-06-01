<?php defined('KING_PATH') or die('访问被拒绝.');
      class Feedback_Controller extends Template_Controller
      {
          private $did;
          private $mod;
          public function __construct()
          {
              parent::__construct();
              hcomm_ext::validUser('admin');
              $this->mod	= M('feedback');
          }
          
          public function index()
          {
              $rs			= $this->mod->orderby(array('id'=>'desc'))->limit(0,9)->execute();
              $data         = array();
              foreach($rs as $value)
              {
                  $value->realName			= $this->mod->getFieldData('realName',array('id'=>$value->uid),'member');
                  if(!$value->realName)
                  {
                      $value->realName = '匿名';
                  }
              }
              $data['data']         = $rs;
              echo json_encode($data);
          }
          
          public function showList()
          {
              $total		        = $this->mod->getAllCount();
              $data['pagination'] = pagination::getClass(array(
                  'total'		=> $total,
                  'perPage'		=> 10
              ));
                            
              $start		= ($data['pagination']->currentPage-1)*10;
              $rs			= $this->mod->orderby(array('id'=>'desc'))->limit($start,10)->execute();
              foreach($rs as $value)
              {
                  $value->realName			= $this->mod->getFieldData('realName',array('id'=>$value->uid),'member');
                  if(!$value->realName)
                  {
                      $value->realName = '匿名';
                  }
              }
              $data['tree']         = $rs;
              $this->template->content = new View('admin/display/feedback_view',$data);
              $this->template->render();
          }

      }
?>