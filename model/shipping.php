<?php defined('KING_PATH') or die('访问被拒绝.');
      class Shipping_Model extends Model
      {
          private $mod;
          public function __construct($dbSet)
          {
              parent::__construct('',$dbSet);
              $this->mod = M("shipping");
          }
          public function getShipping($check=""){
              $result = $this->mod->where("shipping_type = 2 and enabled = 1")->execute();
              if ($result)
              {
                  $select      = "<select name='shipping_name'><option value='0'>未选择</option>";                  
                  foreach($result as $value){
                      if($check=="")
                      {
                          $check = trim($value->shipping_name);
                      }
                      if (trim($check) == trim($value->shipping_name)){
                          $cd   = "selected";
                      }else{
                          $cd   = "";
                      }
                      $select .= "<option value='$value->shipping_name'  $cd />$value->shipping_name</option>";
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
              if ($this->mod->getOneData("shipping_type = 0 and enabled = 1")){
                  return 0;
              }elseif ($this->mod->getOneData("shipping_type = 1 and enabled = 1")){
                  $result = M("shipping_area")->getOneData("shipping_type = 1");
                  $price = 0;
                  foreach($array['goods'] as $value){
                      $price += $value['price'] * $value['count'];
                  }
                  if ($price >= $result->configure){
                      return 0;
                  }
              }
              
              $ship     = $this->mod->where("shipping_type = 2 and enabled = 1")->execute();
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
                      $ship     = M("shipping_area")->where("shipping_id = ".intval($shipping_id))->execute();
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
      