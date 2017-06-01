<?php defined('KING_PATH') or die('访问被拒绝.');
      class Goods_Controller extends Mobilebase_Controller
      {
          public function __construct(){	
              parent::__construct();
              $this->template->currentCount = 1;
          }

          // 商品首页列表
          public function index(){
              //$sql = "SELECT i.mainPic, i.title,MIN(ia.attr_golds) min_golds, MIN(ia.original_price) original_price, MIN(ia.attr_price) min_price, SUM(ia.attr_stock) total_stock, SUM(ia.sell_num) total_num
        //FROM tf_item i LEFT JOIN tf_item_attr ia ON ia.item_id=i.id
        //WHERE i.`status`=1 AND i.account_id=".$this->account_id." GROUP BY i.id ORDER BY i.id DESC";
              //$data['goodsList'] = M()->query($sql);
              $this->template->content = new View('mobile/goods/index_view');
              $this->template->render();
          }

          // 商品首页列表
          public function getGoods(){
              
              $str = '';
              $goodsList = M('item')->where(array('status'=>1,'account_id'=>$this->account_id,'stock >'=>0))->orderby(array('id'=>'asc'))->execute();
              foreach($goodsList as $good)
              {
                  $str .= '<div class="index_good" onclick="location.href=\''.input::site('mobile/goods/goodsDetail/'.$good->id).'\'">
            <dl>
                <dt>
                    <img src="'.(empty($good->mainPic) ? '' : input::site($good->mainPic)).'" /></dt>
                <dd class="good_cont">
                    <h2>'.$good->title.'</h2>
                    <h1 class="tb">
                        <p class="flex_1">
                            会员价 <strong>¥'.$good->price.'</strong>
                            <span class="good_num">'.$good->points.'</span>
                        </p>
                    </h1>
                    <h3 class="tb">
                        <p class="flex_1"><del>原价 ¥'.$good->prePrice.'</del></p>
                        <span class="flex_1" style="color: #8e8e8e;">库存 '.$good->stock.'&nbsp;&nbsp;
                          已售 '.$good->sales.'
                        </span>
                    </h3>
                </dd>
            </dl>
        </div>';
              }
              echo $str;
          }

          public function goodsDetail(){
              $data['goodId'] = S('goodsDetail');
              $data['good'] = M('item')->getOneData(array('id'=>$data['goodId']));
              $data['goodAttr'] = M('item_attr')->where(array('item_id'=>$data['goodId']))->execute();
              $this->template->hideFooter = true;
              $this->template->content = new View('mobile/goods/detail_view',$data);
              $this->template->masklayer = new View('mobile/goods/masklayer_view',$data);
              $this->template->render();
          }

          public function goodPic()
          {
              $data['goodId'] = S('goodPic');
              $data['good'] = M('item')->getOneData(array('id'=>$data['goodId']));
              $this->template->hideFooter = true;
              $this->template->content = new View('mobile/goods/detailPic_view',$data);
              $this->template->render();
          }

          public function goodInfo(){

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
