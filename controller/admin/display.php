<?php defined('KING_PATH') or die('访问被拒绝.');
      class Display_Controller extends Template_Controller 
      {
          public function __construct()
          {
              parent::__construct();
              comm_ext::validUser('admin');
              ini_set('date.timezone','Etc/GMT-8');
              session_start();
          }

          public function index()
          {
              input::redirect("admin/item/onsellItemList");
              if (true){
                  $data['uid']	= $_SESSION['uid']; 
                  
                  $this->template->content	= new View('admin/display/main_view', $data);
                  $this->template->render();
              }
          }
      }
      