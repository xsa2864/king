<?php defined('KING_PATH') or die('访问被拒绝.');
      class Express_Controller extends Template_Controller
      {
          private $mod;
          public function __construct()
          {
              parent::__construct();
              $this->mod  = M('express');
          }
          
          public function index()
          {
              $data['shipping']        = $this->get();
              $this->template->content = new View("admin/express/ship_view", $data);
              $this->template->render();
          }

          public function  get(){
              $rs			= $this->mod->orderby(array('orderNum'=> 'desc'))->execute();
              $rs2		= array();
              foreach ($rs as $row)
              {
                  $row->enabled		= $row->enabled == 0 ? '<a href="'.input::site("admin/express/config/".$row->id).'" target="menu">启用</a>':'<a href="'.input::site("admin/express/uninstall/".$row->id).'" target="menu">关闭</a>&nbsp;&nbsp;<a href="'.input::site("admin/express/area/".$row->id).'" target="menu">运费配置</a>';
                  $rs2[]				= $row;
              }
              return $rs2;
          }

          public function config(){
              $sid = $this->input->segment('config');
              if ( $sid > 0 ){
                  $update   = array(
                            "enabled" => 1   
                      );
                  $rs       = $this->mod->update($update," enabled = 0 and id =".$sid);
              }	 
              input::redirect('admin/express');
          }

          public function area(){
              $post                        = $this->input->post();
              $data                        = array();
              $sid                         = $this->input->segment('area');
              if ($post){
                  $data['note']             = $this->save($post,$sid);
              } 
              if ($sid > 0){
                  $data['shipping']        = $this->mod->getOneData("id = ".$sid);
                  $result                  = M("express_area")->where(array('expressType' => 2, 'expressId' => $sid))->execute();
                  $cityid       = array();
                  if ($result){
                      foreach ($result as $value){
                          $configure = unserialize($value->configure);
                          $cityid    = array_merge($cityid, $configure['cityid']);
                          $normal[]  = $value;
                      }
                      $data['normal']  = $normal;
                  }
                  $provincial      = $this->getcity();
                  $data['city']    = $provincial;
                  $data['city_s']  = $cityid;
              }
              $this->template->content = new View("admin/express/area_set", $data);
              $this->template->render();
          }

          public function save($array, $sid){
              $note                        = "操作失败";
              if (is_array($array) && sizeof($array) > 0 ){
                  foreach ($array as $key => $value){
                      if (!strstr($key, "rule")){
                          $update[$key] = $value;
                      }
                  }
                  switch ($update['expressType']){
                      case 0:
                          break;
                      case 1:
                          $result = M("express_area")->getOneData("expressId = ".$sid." and expressType = 1 ");
                          $rule = array(
                                "name"  => $update['name'],
                                "expressId"         => $sid,
                                "expressType"       => $update['expressType'],
                                "configure"           => $array['rule']
                          );
                          if ($result){
                              M("express_area")->update($rule," id =".$result->id);
                          }else{
                              M("express_area")->insert($rule);
                          }
                          break;
                      case 2:
                          if($array['rule_citys'])
                          {
                              $result   = M("express_area")->getOneData("expressId = ".$sid." and expressType = 2 ");
                              $config   = array("fkg"=>$array['rule_fkg'],"ekg"=>$array['rule_ekg'],"cityid"=>$array['rule_citys']);
                              $oper     = false;
                              $rule     = array(
                                    "name"  => $update['name'],
                                    "expressId"         => $sid,
                                    "expressType"       => $update['expressType']
                              );
                              if ($result)
                              {
                                  $area     =  M("express_area")->where(array('expressId' => $sid, 'expressType' => 2 ))->execute();
                                  foreach ($area as $value){
                                      $configure = unserialize($value->configure);
                                      if ($configure['fkg'] == $array['rule_fkg'] && $configure['ekg'] == $array['rule_ekg']){
                                          if (is_array($configure['cityid']) && sizeof($configure['cityid']) >0){
                                              $configure['cityid']    = array_merge($configure['cityid'], $array['rule_citys']);
                                              $rule["configure"] =  serialize($configure);
                                              M("express_area")->update($rule," id =". $value->id);
                                              $oper = true;
                                              break;
                                          }
                                      }
                                  }
                                  if (!$oper)
                                  {
                                      $rule["configure"] = serialize($config);
                                      M("express_area")->insert($rule);
                                  }
                              }
                              else
                              {
                                  $con = $config;
                                  $rule["configure"] = serialize($con);
                                  M("express_area") ->insert($rule);
                              }
                          }
                          break;
                      default:
                          exit;
                  }
                  $rs   = $this->mod->update($update, " id =".$sid);
                  if ($rs){
                      $note = "操作成功";
                  }
              }
              return $note;
              
          }

          public function deletes(){
              $sid    = $this->input->get();
              if ($sid['del']>0){ 
                  $return 	= M("express_area")->delete(array('id'=>$sid['del']));
                  input::redirect('admin/express/area/'.$sid['area']);
              }
          }

          public function getcity(){
              $provincial =  M("provincial")->execute();
              foreach($provincial as $value){  
                  $city[$value->id]      = array(
                       "name" =>$value->name,
                       "wm"   =>$value->wm
                  );
              }
              return $city;
          }
          
          public function uninstall(){
              $sid = $this->input->segment('uninstall');
              if ( $sid > 0 ){
                  $update   = array(
                            "enabled" => 0   
                      );
                  $rs       = $this->mod->update($update," enabled = 1 and id =".$sid);
              }	 
              input::redirect('admin/express/');

          }

          public function install()
          {
              $post            = $this->input->post();
              $free            = array(
                              'name'		    => "免费配送",
                              'brief'		    => "商城全国免费配送模式,默认首选,启用则放弃所有配送规则",
                              'expressType'         => 0,
                              'orderNum'		=> 100

              );
              $result   = $this->mod->getOneData("expressType = 0");
              if (!$result){
                  $this->mod->save($free);
              }

              $free            = array(
                              'name'		    => "满额免运费",
                              'brief'		    => "商城全国启用满金额全国免运费模式",
                              'expressType'         => 1,
                              'orderNum'		=> 90

              );
              $result   = $this->mod->getOneData("expressType = 1");
              if (!$result){
                  $this->mod->save($free);
              }
              if (!empty($post["shipping_name"]) && !empty($post["shipping_desc"]) && !empty($post["shipping_order"])){
                  $insert		= array(
                            'name'		    => $post['shipping_name'],
                            'brief'		    => $post['shipping_desc'],
					        'expressType'         => 2,
                            'orderNum'		=> $post['shipping_order']
                  );
                  $return		= $this->mod->save($insert);
              }
              input::redirect('admin/express');
          }	
      }