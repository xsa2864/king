<?php defined('KING_PATH') or die('访问被拒绝.');
      class Cart_Controller extends Mobilebase_Controller
      {       
          public function __construct(){	
              parent::__construct();
              $this->template->currentCount = 2;
          }
          // 购物车页面
          public function show_cart(){
              $view = new View('mobile/cart/cart_view');
              $view->render();
          }
          // 获取购物车商品信息
          public function get_cart_info(){
              $re_msg['success'] = 0;
              $re_msg['msg'] = "购物车还没有商品";
              $sql = "SELECT c.id,c.item_attr_id,c.number,c.item_title,c.item_price,ma.attr_stock,ma.attr_name,ma.attr_pic,ma.attr_price,ma.attr_golds,i.`status` FROM tf_cart c LEFT JOIN tf_item_attr ma ON ma.id=c.item_attr_id
        LEFT JOIN tf_item i ON i.id=ma.item_id WHERE c.member_id=".$this->member_id;
              $result = M()->query($sql);
              if($result){
                  $re_msg['success']  = 1;
                  $re_msg['msg']      = "获取成功";
                  $re_msg['info']     = $result;
              }
              echo json_encode($re_msg);
          }

          // 加入购物车
          public function addCart(){  
              $attr_id = 11810;//P('item_attr_id','');
              $number  = 1;//P('number','');
              $item_id = !empty($item_id)?intval($item_id):0; //商品ID（也可能是套餐）
              $number = !empty($number)?intval($number):1; //默认数量1

              $re_msg['success'] = 0;
              $re_msg['msg'] = "操作失败";
              $flag = true;
              // $item_content = P('icontent','');   //商品内容
              if(empty($attr_id)){
                  $re_msg['msg'] = "无效的商品ID！";
                  $flag = false;
              }
              if(empty($number)){
                  $re_msg['msg'] = "商品数量错误！";
                  $flag = false;
              }
              $rs = M('item i')->select('i.title,i.mainPic,i.limit_num,i.addtime,ia.attr_price,ia.attr_stock')->join('item_attr ia','i.id=ia.item_id')->where("ia.id=$attr_id and i.status=1")->execute();
              $rs = $rs[0];

              if($rs->limit_num>0 && $number>$rs->limit_num){
                  $re_msg['msg'] = "购买数量超过限购数量！";
                  $flag = false;
              }
              if($number > $rs->attr_stock){

                  $re_msg['msg'] = "购买数量超过库存数量！";
                  $flag = false;
              }

              if(!empty($rs) && $flag){
                  
                  $data['member_id']    = $this->member_id;
                  $data['item_attr_id'] = $attr_id;
                  $data['number']       = $number;
                  $data['item_title']   = $rs->title;
                  $data['item_price']   = $rs->attr_price;
                  $data['addtime']      = time();

                  //购物车已有相同属性商品的加数量
                  $old = M('cart')->getOneData(array('member_id'=>$this->member_id,'item_attr_id'=>$attr_id),'id,number');
                  if(!empty($old)){
                      if((intval($old->number)+$number) > $rs->attr_stock){
                          $re_msg['msg'] = "购买总数量超过库存数量";
                      }else if((intval($old->number)+$number) > $rs->limit_num){
                          $re_msg['msg'] = "购买总数量超过限购数量";
                      }else{
                          $res = M('cart')->update(array('number'=>intval($old->number)+$number),array('id'=>$old->id));
                          if($res){
                              $re_msg['success'] = 1;
                              $re_msg['msg'] = "商品添加成功!";
                          }else{
                              $re_msg['msg'] = "添加购物车失败！";
                          }
                      }
                  }else{
                      $res = M('cart')->save($data);
                      if($res){
                          $re_msg['success'] = 1;
                          $re_msg['msg'] = "商品添加成功!";
                      }else{
                          $re_msg['msg'] = "添加购物车失败！";
                      }
                  }
              }
              
              echo json_encode($re_msg);
          }
          //更改购物车数量
          public function changeNum(){
              $re_msg['success'] = 0;
              $re_msg['msg'] = '更改失败';
              $flag = false;
              $id     = P('id',0);
              $number = intval(P('num',0));
              $item_attr_id = P('item_attr_id','');
              $itemRs = M('item i')->select('i.limit_num,ia.attr_stock')->join('item_attr ia','i.id=ia.item_id')->where(" ia.id=$item_attr_id and i.status=1")->execute();  
              $itemRs = $itemRs[0];

              if($itemRs->attr_stock < $number){
                  $re_msg['msg'] = "购买总数量超过库存数量";
                  $flag = true;
              }else if($number > $itemRs->limit_num){
                  $re_msg['msg'] = "购买总数量超过限购数量";
                  $flag = true;
              }
              if(!$flag){
                  $res = M('cart')->update(array('number'=>$number),"id = $id");
                  if($res){
                      $re_msg['success'] = 1;
                      $re_msg['msg'] = "更改成功!";
                  }
              }  
              echo json_encode($re_msg);
          }

          //清除失效商品
          public function clear_invalid(){
              $re_msg['success'] = 0;
              $re_msg['msg'] = '清除失败';

              $str = P('str','');
              $rs = M('cart')->delete("member_id = '".$this->member_id."' and id in ('$str')");
              if($rs){
                  $re_msg['success'] = 1;
                  $re_msg['msg'] = "清除成功!";
              }  
              echo json_encode($re_msg);
          }

          //删除购物车单品
          public function deleteAttr(){
              $re_msg['success'] = 0;
              $re_msg['msg'] = '删除失败';

              $item_attr_id =  P('item_attr_id',0);

              $rs = M('cart')->delete("member_id = ".$this->member_id." and item_attr_id = ".$item_attr_id);
              if($rs){     
                  $re_msg['success'] = 1;
                  $re_msg['msg'] = '删除成功';
              }      
              echo json_encode($re_msg);
          }
          
          // 清空购物车
          public function deleteAll(){
              $re_msg['success'] = 0;
              $re_msg['msg'] = '删除失败';
              $rs = M('cart')->delete("member_id = ".$this->member_id);
              if($rs){     
                  $re_msg['success'] = 1;
                  $re_msg['msg'] = '删除成功';
              }      
              echo json_encode($re_msg);
          }
      }
