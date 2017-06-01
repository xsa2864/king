<?php defined('KING_PATH') or die('访问被拒绝.');
      class Show_Controller extends Controller
      {
          public function __construct(){              
              parent::__construct();
          }

          public function explain()
          {
              $this->template = new View('wechat/main/explain_view');
              $this->template->render();
          }

          public function call()
          {
              $this->template = new View('wechat/main/call_view');
              $this->template->render();
          }
      }

