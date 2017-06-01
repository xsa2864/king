<?php defined('KING_PATH') or die('访问被拒绝.');
      class Unopened_Controller extends Template_Controller 
      {
          public function __construct()
          {
              parent::__construct();
          }

          public function index()
          {
              $this->template->content	= new View('admin/unopened_view', $data);
              $this->template->render();              
          }
      }