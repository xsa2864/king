<?php defined('KING_PATH') or die('访问被拒绝.');
      class Express_Model extends Model
      {
          private $mod;
          public function __construct($dbSet)
          {
              parent::__construct('',$dbSet);
              $this->mod = M("express");
          }
          public function getShipping($check=""){
              $result = $this->mod->where("expressType = 2 and enabled = 1")->execute();
              if ($result)
              {
                  $select      = "<select name='shipping_name'><option value='0'>未选择</option>";                  
                  foreach($result as $value){
                      if($check=="")
                      {
                          $check = trim($value->name);
                      }
                      if (trim($check) == trim($value->name)){
                          $cd   = "selected";
                      }else{
                          $cd   = "";
                      }
                      $select .= "<option value='$value->name'  $cd />$value->name</option>";
                  }
                  return $select."</select>";
              }
              return;
          }
          public function isfree($array){
              // 首先判断是否启用免费配送
              if (!is_array($array['goods'])){
                  return false;
              }
              if ($this->mod->getOneData("expressType = 0 and enabled = 1")){
                  return 0;
              }elseif ($this->mod->getOneData("expressType = 1 and enabled = 1")){
                  $result = M("express_area")->getOneData("expressType = 1");
                  $price = 0;
                  foreach($array['goods'] as $value){
                      $price += $value['price'] * $value['count'];
                  }
                  if ($price >= $result->configure){
                      return 0;
                  }
              }
              
              $ship     = $this->mod->where("expressType = 2 and enabled = 1")->execute();
              //$checkbox = "";
              //foreach ($ship as $value){
              //$checkbox .= "<label class='checkbox-inline'><input type='raido' name='shipping_id' value='$value->shipping_id' />$value->shipping_name</label>";
              //}
              return $ship;
          }
          public function getPrice($shipping_id, $array){
              $weight = intval($array['weight']);
              //file_put_contents("shipping.txt", serialize($array));
              if ($weight <= 0 ){
                  return 0;
              }else{
                  if (intval($shipping_id) > 0 ){
                      $ship     = M("express_area")->where("id = ".intval($shipping_id))->execute();
                      foreach ($ship as $value){
                          $configure = unserialize($value->configure);
                          if (in_array($array['provincial'], $configure['cityid'])){
                              $result = $configure;
                          }
                      }
                      
                      //Array ( [fkg] => 2 [ekg] => 2 [cityid] => Array ( [0] => 3 [1] => 28 ) ) 
                      if (isset($result)){
                          if ($weight <= 1000){
                              return $result['fkg'];
                          }else{
                              $num = ceil(($weight - 1000) / 1000);
                              return $result['fkg'] + $result['ekg'] * $num;
                          }
                      }

                  }
                  
              }
          }
      }
      