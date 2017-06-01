<?php defined('KING_PATH') or die('访问被拒绝.');
      class AutoOrder_controller extends Controller
      {
          
          public function __construct()
          {
              parent::__construct();
          }
          
          public function index()
          {
              set_time_limit(0);
              ignore_user_abort(true);
              $cache = cache::getClass();
              $testAuto = $cache->hget('config','自动时间');
              $autoOrder = $cache->hget('config','自动状态');
              header("Content-type:text/html;charset=utf-8");
              if(!$autoOrder)
              {
                  if($autoOrder!==0)
                  {
                      $cache->hset('config','自动状态',0);
                  }
                  echo '关闭';
                  return;
              }
              if(!$testAuto)
              {
                  $cache->hset('config','自动时间',date('Y-m-d H:i:s',time()-80));
              }
              if(strtotime($testAuto)+70>time())
              {
                  echo '存在'.$testAuto;
                  return;
              }
              while(true)
              {
                  $autoOrder = $cache->hget('config','自动状态');
                  if($autoOrder==0)
                  {
                      echo '结束';
                      break;
                  }
                  //自动处理业务

                  auto_ext::autorun();

                  //end 自动处理业务
                  
                  $cache->hset('config','自动时间',date('Y-m-d H:i:s',time()));
                  sleep(10);
              }
          }
      }