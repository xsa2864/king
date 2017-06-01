<?php defined('KING_PATH') or die('访问被拒绝.');
      class Goods_Controller extends Wechatbase_Controller
      {
          public function __construct(){	
              parent::__construct();
          }

          // 商品详情
          public function index()
          {
              $itemId = S('index');
              $data['itemId'] = $itemId;
              $data['item'] = M('tk_item')->getOneData(array('id'=>$itemId));
              
              $data['item']->pics = json_decode($data['item']->pics);

              if(!$data['item']->pics)
              {
                  $data['item']->pics = array();
              }

              $rs = M("member")->getOneData("id=".$this->user->id,"first");
              $data['first'] = $rs->first;

              $this->template->shareParam = '"'.$data['item']->title.'","'.input::site('wechat/share/item/'.$itemId.'/shareUser/'.$this->user->id).'","'.input::site($data['item']->img).'","'.'好商品才敢分享，'.$data['item']->title.'，仅售￥'.$data['item']->price.'"';
              $this->template->content = new View('wechat/goods/detail_view',$data);
              $this->template->render();
          }
          // 获取距离
          public function get_range(){
              $str = P('str','0,0');
              $cache = cache::getClass();
              $userpos = $cache->get('userPosition:'.$this->user->id);
              if($userpos){
                $userpos = json_decode($userpos);
                $elements = map_ext::getObjDistance($userpos->lat,$userpos->lng,$str); 
                if($elements->status==0){
                  $loc = $elements->result->elements[0];
                  $value = $loc->distance;
                  if($value>0){
                      if($value>800){
                          $value = round($value/1000,2).'k';
                      }
                      $distancs ='距离您 '.$value.'m';
                  }else if($value<0){
                      $distancs = '在您附近';
                  }else{
                      $distancs = '距离您 >10km';
                  }
                }else{
                  $distancs = '距离您 >10km';
                }
              }else{
                $distancs = '';
              }
              echo $distancs;
          }

          public function goodPic()
          {
              $data['goodId'] = S('goodPic');
              $data['good'] = M('item')->getOneData(array('id'=>$data['goodId']));
              $this->template->hideFooter = true;
              $this->template->content = new View('mobile/goods/detailPic_view',$data);
              $this->template->render();
          }

          //查询商品列表
          public function showSearch(){      
              $view = new View('mobile/goods/search_view');
              $view->render();
          }

          //查询商品 
          public function searchGoods(){
              $keyword = P('keyword','');
              $re_msg['success'] = 0;
              $re_msg['msg']     = '查询失败';   
              $arr = mobile_ext::note_keyword($this->member_id,$keyword);   
              if($keyword != ''){
                  $sql = "SELECT i.title,i.mainPic, MIN(ia.attr_golds) min_golds, MIN(ia.original_price) original_price, MIN(ia.attr_price) min_price, SUM(ia.attr_stock) total_stock, SUM(ia.sell_num) total_num
          FROM tf_item i LEFT JOIN tf_item_attr ia ON ia.item_id=i.id
          WHERE i.`status`=1 AND i.account_id=1 and i.title like '%$keyword%' GROUP BY i.id ORDER BY i.id DESC";
                  $result = M()->query($sql);
                  if($result){
                      $re_msg['success'] = 1;
                      $re_msg['msg']     = '查询成功';
                      $re_msg['info']    = $result;
                  }
              }
              echo json_encode($re_msg);
          }
          // 查询首页
          public function searchIndex(){
              $view = new View('mobile/goods/s_index_view');
              $view->render();
          }
          public function search_keyword(){
              $re_msg['success'] = 0;
              $re_msg['msg']     = '查询失败';      
              $result = M('search_keyword')->select()->where("member_id=".$this->member_id)->execute();
              if($result){
                  $re_msg['success'] = 1;
                  $re_msg['msg']     = '查询成功';
                  $re_msg['info']    = $result;
              }
              echo json_encode($re_msg);
          }
          // 清空查询历史
          public function clearKeyword(){
              $re_msg['success'] = 0;
              $re_msg['msg']     = '操作失败';
              $rs = M('search_keyword')->delete("member_id=".$this->member_id);
              if($rs){
                  $re_msg['success'] = 1;
                  $re_msg['msg']     = '操作成功';
              }
              echo json_encode($re_msg);
          }

          // 收藏页面
          public function show_collection(){
              $view = new View('mobile/goods/collection_view');
              $view->render();
          }
          // 获取收藏商品信息
          public function get_collection(){
              $re_msg['success'] = 0;
              $re_msg['msg']     = '获取失败';
              $re_msg['info']    = '';

              $sql = "SELECT i.mainPic, i.title, MIN(ia.attr_golds) min_golds, MIN(ia.original_price) original_price, MIN(ia.attr_price) min_price, SUM(ia.attr_stock) total_stock, SUM(ia.sell_num) total_num,c.addtime,c.id FROM tf_item i LEFT JOIN tf_item_attr ia ON ia.item_id=i.id left join tf_collection c on c.item_id=i.id WHERE i.account_id=".$this->account_id." and c.member_id=".$this->member_id." GROUP BY i.id ORDER BY c.addtime DESC";
              $rs = M()->query($sql);
              if($rs){
                  $re_msg['success'] = 1;
                  $re_msg['msg']     = '获取成功';
                  $re_msg['info']    = $rs;
              }
              echo json_encode($re_msg);
          }
          // 删除收藏商品信息
          public function del_collection(){
              $id = P('id');
              $re_msg['success'] = 0;
              $re_msg['msg']     = '删除失败';

              $rs = M('collection')->delete("member_id=".$this->member_id." and id in ($id)");
              if($rs){
                  $re_msg['success'] = 1;
                  $re_msg['msg']     = '删除成功';
              }
              echo json_encode($re_msg);
          }
      }
