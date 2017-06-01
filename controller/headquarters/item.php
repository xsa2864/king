<?php defined('KING_PATH') or die('访问被拒绝.');
      class Item_Controller extends Template_Controller
      {
          private $mod;
          private $memcached;
          private $account_id;
          public function __construct()
          {
              parent::__construct();
              hcomm_ext::validUser();              
              $this->mod        = M('item');
              $this->account_id = accountInfo_ext::accountId(); 
          }



          public function manImgScript(){
              $goods_list =$this->mod->select('id,pics')->execute();
              echo '<pre>';
              foreach($goods_list as $gl){
                  //$img = output_ext::getCoverImg($gl->pics,'');

                  $pics	= unserialize($gl->pics);
                  $thumb	= '';
                  if (is_array($pics) && count($pics)>0)
                  {
                      foreach ($pics as $key=>$value)
                      {
                          if (!isset($img))
                          {
                              $img	= $key;
                          }
                          if ($value ==1)
                          {
                              $p	= $key;
                              break;
                          }
                      }
                      if (!$p)
                      {
                          $p	= $img;
                      }
                  }


                  //修改数据
                  $this->mod->update(array('mainPic'=>$p),array('id'=>$gl->id));
              }
          }




          public function index()
          {
              $data['rs']     = $this->mod->from('mod')->where(array('bid'=>82))->execute();
              $this->template->content    = new View('admin/item/index_view',$data);
              $this->template->render();
          }
          
          /**
           * 库存管理
           */
          public function inventory()
          {
              $where = '1=1';
              $itemCode = G('itemCode');
              $countMin = G('countMin');
              $countMax = G('countMax');
              $data['itemCode'] = $itemCode;
              $data['countMin'] = $countMin;
              $data['countMax'] = $countMax;
              if(isset($itemCode)){
                  $where .= ' and barcode like "%'.$itemCode.'%"';
              }
              if(isset($countMin) && intval($countMin) > 0){
                  if(isset($countMax) && intval($countMax) > 0){
                      $where .= ' and (store >='.intval($countMin).' and store <='.intval($countMax).')';
                  }else{
                      $where .= ' and store >='.intval($countMin);
                  }
              }
              $total		            = M('item')->getAllCount($where);
              $data['pagination']       = pagination::getClass(array(
                  'segment'             => 'page',
                  'total'               => $total,
                  'perPage'		        => 10
                  ));
              $start			        = ($data['pagination']->currentPage-1)*10;
              $data['items']         = M('item')->where($where)->orderby(array('id'=>'desc'))->limit($start,10)->execute();
              //echo $where;
              $this->template->content    = new View('admin/item/inventory_view',$data);
              $this->template->render();
          }

          /**
           * 修改商品库存
           */
          public function updateCount(){
              list($id,$count) = $this->input->getArgs();
              if(!isset($id) || !isset($count)){echo json_encode(array('status'=>0,'msg'=>'保存失败！'));exit;}
              $result = M('item')->update(array('store'=>$count),array('id'=>$id));
              if($result){echo json_encode(array('status'=>0,'msg'=>'保存成功！'));exit;}else{echo json_encode(array('status'=>0,'msg'=>'保存失败！'));exit;}
          }

          /**
           * 在售商品
           */
          public function onsellItem(){
            $this->getItemList(1);
          }
          /**
           * 下架商品
           */
          public function downItem(){
            $this->getItemList(0);
          }
          // 售罄商品
          public function sellOut(){
            $this->getItemList(2,0);
          }
          // 警戒商品
          public function warmItem(){
            $this->getItemList(3,0);
          }
          // 获取商品列表
          public function getItemList($status=1,$store='')
          {
              $wh = array('account_id'=>$this->account_id);
              // 状态或库存条件
              if($status <= 1){
                $wh['status'] = $status;                
              }else if($status == 2){
                $wh['store'] = $store;   
              }else if($status == 3){
                $wh['store'] = $store;      
              }

              if(G('keyword')&&G('keyword')!=''){
                  $wh['title like'] = '%'.G('keyword').'%';
                  $data['keyword'] = G('keyword');
              }
              if(G('itemId')&&G('itemId')!=''){
                  $wh['id'] = G('itemId');
                  $data['itemId'] = G('itemId');
              }
              if(G('categroy1')&&G('categroy1')>0){
                  $wh['cateId'] = G('categroy1');
                  $data['cateId'] = G('categroy1');
              }
            
              $data['itemTitle'] = G('itemTitle');
              $data['itemCode'] = G('itemCode');
              $data['categroy1'] = G('categroy1');
              $data['categroy2'] = G('categroy2');
              $data['categroy3'] = G('categroy3');


              $orderby = array('id'=>'desc');
              if((G('orderField') && G('orderField') != '') && G('orderType') != ''){
                  $field = G('orderField');
                  $adsc = G('orderType');
                  $adsc == 1 ? $orb = 'asc' : $orb = 'desc';
                 // echo $orb.'----';
                  if($field == 'store'){
                      $orderby = array('store'=>$orb);
                  }
                  if($field == 'sales'){
                      $orderby = array('sales'=>$orb);
                  }
              }

              $total		            = M('item')->getAllCount($wh);
              $data['pagination']       = pagination::getClass(array(
                  'segment'             => 'page',
                  'total'               => $total,
                  'perPage'		        => 20
                  ));

              $start			        = ($data['pagination']->currentPage-1)*20;
             // echo M('item')->setDebug();
              $data['itemList'] = M('item')->where($wh)->orderby($orderby)->limit($start,20)->execute();
              // 前端的显示效果
              $data['sales']    = M('item')->getAllCount(array('status'=>1));
              $data['downNum']  = M('item')->getAllCount(array('status'=>0));
              $data['sellOut']  = M('item')->getAllCount(array('store'=>0));
              $data['warm']     = M('item')->getAllCount(array('store'=>0));
              $data['status'] = $status;

              $data['tree']     = str_ext::getTree();
              $this->template->content  = new View('admin/item/onsellItemList_view',$data);
              $this->template->render();
          }

          // 2016/7/25   修改价格
          public function saveprice(){
              $id     = P('id');
              $price  = P('price');
              $re_msg['success'] = 0;
              if($id>0){
                $data['price'] = $price;
                $where['id'] = $id;
                $rs = M('item')->update($data,$where);
                if($rs){
                  $re_msg['success'] = 1;
                }
              }
              echo json_encode($re_msg);
          }
          
          /**
           * 下架商品
           */
          public function downItemList()
          {              
              $wh                       = array('down'=>0);
              
              if(G('itemTitle')&&G('itemTitle')!='')
              {
                  $wh['title like'] = '%'.G('itemTitle').'%';
              }
              if(G('itemCode')&&G('itemCode')!='')
              {
                  $wh['barcode'] = G('itemCode');
              }
              if(G('categroy1')&&G('categroy1')>0)
              {
                  $wh['parent'] = G('categroy1');
              }
              if(G('categroy2')&&G('categroy2')>0)
              {
                  $wh['cateId'] = G('categroy2');
              }
              if(G('categroy3')&&G('categroy3')>0)
              {
                  $wh['childId'] = G('categroy3');
              }

              $orderby = array('id'=>'desc');
              if((G('orderField') && G('orderField') != '') && G('orderType') != ''){
                  $field = G('orderField');
                  $adsc = G('orderType');
                  $adsc == 1 ? $orb = 'asc' : $orb = 'desc';
                  // echo $orb.'----';
                  if($field == 'store'){
                      $orderby = array('store'=>$orb);
                  }
                  if($field == 'sales'){
                      $orderby = array('sales'=>$orb);
                  }
              }


              $total                    = M('item')->getAllCount($wh);
              $data['pagination']       = pagination::getClass(array(
                  'segment'             => 4,
                  'total'               => $total,
                  'perPage'             => 10
                  ));
              $start                    = ($data['pagination']->currentPage-1)*10;
              $data['itemList']         = M('item')->where($wh)->orderby($orderby)->limit($start,10)->execute();
              $data['sales']          = M('item')->getAllCount(array('down'=>1));
              $data['downNum']          = M('item')->getAllCount(array('down'=>0));
              $data['tree']             = M('category')->where(array('pid'=>0,'visible'=>1))->orderby(array('orderNum'=>'desc'))->execute();
              $this->template->content	= new View('admin/item/downItemList_view', $data);
              $this->template->render();
          }
          
          /**
           * 新增商品
           */
          public function add()
          {              
              $time						= time();
              $data['validKey']			= md5($GLOBALS['config']['md5Key'].$time);
              $data['validTime']        = $time;
              $data['tree']             = str_ext::getTree();
              $this->template->content  = new View('admin/item/add_view',$data);
              // $this->template->tipBoxContent1 = new View('admin/attr/addAttr_view');
              // $this->template->tipBoxContent2 = new View('admin/category/addCategory_view',$val);
              $pic = D('picture')->GetData();
              $this->template->tipBoxContent3 = new View('admin/picture/useImg_view', $pic);
              $this->template->render();
          }

          /**
           * 修改商品
           */
          public function edit()
          {
              $id                       = S('edit');
              $data['item']             = M('item')->getOneData(array('id'=>$id));
              $time						          = time();
              $data['validKey']			    = md5($GLOBALS['config']['md5Key'].$time);
              $data['validTime']        = $time;
              $data['tree']             = str_ext::getTree();
              $data['itemAttr']         = M("item_attr")->where("item_id=$id")->select()->execute();
 
              $this->template->content  = new View('admin/item/edit_view',$data);
              $pic = D('picture')->GetData();
              $this->template->tipBoxContent3 = new View('admin/picture/useImg_view', $pic);
              $this->template->render();
          }
          
          public function upload()
          {
              $upload		= upload::getClass();
              foreach ($_FILES as $key => $file){
                  $dir		= 'upload/'.date('Ym/d');

                  $return 	= $upload->save(1,$key,'',$dir);
                  if ($return)
                  {
                      $pice[] = $return;
                  }
              }
              if (is_array($pice) && sizeof($pice) > 0){
                  return $pice;
              }
          }
          
          public function get()
          {
              $wh         = array();
              if ($this->input->post('cateId'))
              {
                  $wh['cateId'] = $this->input->post('cateId');
              }else if ($this->input->get('cateId')){
                  $wh['cateId'] = $this->input->get('cateId');
              }
              
              if ($this->input->post('keyword'))
              {
                  $wh['title like'] = '%'.$this->input->post('keyword').'%';
              }else if ($this->input->get('cateId')){
                  $wh['title like'] = '%'.$this->input->get('keyword').'%';
              }
              $total		= $this->mod->getAllCount($wh);

              if ($this->input->post()){
                  $page      = 1;
              }else{
                  $page		= $this->input->get("page") ? $this->input->get("page") : 1 ;
              }
              $size		= 10;
              $start		= ($page-1)*$size;
              $mod        = M('item a');
              $rs2		= array();
              $catemod        = M('category');
              $cate       = $catemod->select("*")->where("id in (SELECT cateId FROM `tf_item` group by cateId) ")->execute();
              foreach ($cate as $crow){
                  $rs2["gory"][] = array("id"=>$crow->id,"name"=>$crow->name);
              }
              $rs			= $mod->select("a.id,a.isfeatured,a.isspecial,a.prePrice,a.price,a.store,a.title,a.pics,a.ctime,b.name,a.cateId,a.down")->join('category b','a.cateId=b.id')->where($wh)->limit($start, $size)->execute();
              $rs2["page"] = ceil( $total / $size);
              $rs2["nowpage"] = $page;
              foreach ($rs as $row)
              {
                  $row->ctime    =  date('Y-m-d',$row->ctime);
                  $image =  unserialize($row->pics);
                  $prePrice = $row->prePrice;
                  if (empty($prePrice) or $prePrice == 0){
                      $prePrice = $row->price;
                  }
                  //$rs2["items"][] = array("id"=>$row->id, "title"=>$row->title,"prePrice"=>$prePrice,"count"=>$row->store, "price"=>$row->price, "ctime"=>$row->ctime, "name"=>$row->name, "cateId"=> $row->cateId,'isfeatured'=>$row->isfeatured, 'isspecial'=>$row->isspecial, "images"=>$image, "down"=>$row->down );
                  $rs2["items"][] = array("id"=>$row->id, "title"=>$row->title,"prePrice"=>$prePrice,"count"=>$row->store, "price"=>$row->price, "ctime"=>$row->ctime, "name"=>$row->name, "cateId"=> $row->cateId, "images"=>$image, "down"=>$row->down );
              }
              
              return $rs2;
              
          }

          public function getAttr()
          {
              $id  = $this->input->post("id");
              $cid = $this->input->post("cid");
              $array  = array();
              if (isset($cid) && $cid > 0 )
              {
                  $result = M("attr")->where(array('itemId' => $cid))->execute();
                  if ($result)
                  {
                      foreach($result as $optionId)
                      {
                          $array[] = $optionId->optionId;
                      }
                  }
              }
              
              if (intval($id) > 0)
              {
                  $result = M("category")->getFieldData('pid',array('id'=>$id));
                  while($result!=0)
                  {
                      $id = $result;
                      $result = M("category")->getFieldData('pid',array('id'=>$result));
                  }
                  $result = M("attribute")->where(array('cateId'=>$id,'pid'=>0))->execute();
                  $re = "";
                  foreach($result as $attrs)
                  {
                      $attr   = M("attribute")->where(array('pid'=>$attrs->id))->execute();
                      $att = "";
                      foreach ($attr as $val)
                      {
                          if (in_array($val->id, $array))
                          {
                              $c = "selected=\"selected\"";
                          }
                          else
                          {
                              $c = "";
                          }
                          $att.="<option value=\"".$val->id."\" $c >".$val->name."</option>";
                      }
                      $re .= "<div class=\"form-group\"><label class=\"col-sm-2\">".$attrs->name."属性: </label><div class=\"col-sm-4\"><select name='attr[]' class=\"form-control\">".$att."</select></div></div>";
                  }
                  echo $re;
              }
          }

          public function setAttr($array = array(),$item_id = 0){
              if($item_id == 0) {
                  $id = $this->input->segment('update');
              }else{
                  $id = $item_id;
              }
              $dict_value['itemId']  = $id;
              if (is_array($array)){
                  M("attr")->delete(array('itemId'=>$id));
                  foreach ($array as $value){
                      $attr = M("attribute")->getOneData(array('id'=>$value));
                      $dict_value = array('itemId'=>$id,'dictId'=>$attr->cateId,'optionId'=>$attr->id);
                      M("attr")->save($dict_value);
                  }
              }
          }

          public function getTree($id = "0" )
          {
              $category   = M("category");
              $pid        = $this->input->segment('pid') ? $this->input->segment('pid') :0;
              $rs			= $category->where(array('pid'=>$pid))->execute();
              $mods	= array();
              foreach ($rs as $row)
              {
                  $rs2	= $category->where(array('pid'=>$row->id))->execute();
                  $array2	= array();
                  foreach ($rs2 as $row2)
                  {
                      $array3		= array();
                      $count		= $category->getAllCount(array('pid'=>$row2->id));
                      $state		= '';
                      if ($count>0)
                      {
                          $state		= 'closed';
                          $rs3		= $category->where(array('pid'=>$row2->id))->execute();
                          foreach ($rs3 as $row3)
                          {
                              $c     = $this->getChecked($row3->id,$checks);
                              $array3[]	= array('id'=>$row3->id, 'pid'=>$row3->pid, 'text'=>$row3->name,'visible'=>$row3->visible,'orderNum'=>$row3->orderNum,'checked'=>$c);
                          }
                      }
                      $c     = $this->getChecked($row2->id,$checks);
                      $array2[]	= array('id'=>$row2->id,'text'=>$row2->name,'pid'=>$row2->pid,'visible'=>$row2->visible,'orderNum'=>$row2->orderNum,'children'=>$array3,'state'=>$state,'checked'=>$c);//三级树默认闭合
                  }
                  $c     = $this->getChecked($row->id,$checks);
                  $array[]		= array('id'=>$row->id,'text'=>$row->name,'pid'=>$row->pid,'children'=>$array2, 'visible'=>$row->visible, 'orderNum'=>$row->orderNum,'checked'=>$c, 'attr'=>unserialize($row->attr));
              }
              foreach ($array as $value){
                  if ($id != 0 && $id == $value['id']){
                      $selects = "selected";
                  }else{
                      $selects = "";
                  }
                  $option.= "<option $selects value=".$value['id']." disabled='disabled' >".$value['text']."</opiton>";
                  foreach ($value['children'] as $val){
                      if ($id != 0 && $id == $val['id']){
                          $selects = "selected";
                      }
                      else
                      {
                          $selects = "";
                      }
                      $option.= "<option $selects value=".$val['id'].">&nbsp;&nbsp;&nbsp;".$val['text']."</opiton>";
                      foreach ($val['children'] as $val3){
                          if ($id != 0 && $id == $val3['id']){
                              $selects = "selected";
                          }else{
                              $selects = "";
                          }
                          $option.= "<option $selects value=".$val3['id'].">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$val3['text']."</opiton>";
                      }
                  }
              }
              if (!isset($option)){
                  $option = "<option>没有目录</option>";
              }
              $option = "<select id='cateId' name='cateId' class='form-control' onchange='attrs(this)'>".$option."</select>";
              return $option;		
          }

          private function getChecked($id,$checks)
          {
              if (!is_array($checks))
                  return '';
              else 
              {
                  if (!in_array($id,$checks))
                      return '';
                  else 
                      return 'checked';
              }
          }

          public function getApp()
          {
              $total		= $this->mod->getAllCount();
              error_log(print_r($_POST,true),3,'logs/a.log');
              $page		= $this->input->post('page');
              $size		= $this->input->post('rows');
              $start		= ($page-1)*$size;
              $wh         = '1=1';
              if ($this->input->post('cateId'))
              {
                  $wh .= ' and cateId='.$this->input->post('cateId');
              }
              
              if ($this->input->post('keyword'))
              {
                  $wh .= " and title like '%{$this->input->post('keyword')}%'";
              }
              $rs			= $this->mod->where($wh)->orderby(array('id'=>'desc'))->limit($start,$size)->execute();
              $rs2		= array();
              foreach ($rs as $row)
              {
                  $row->goodId		= mall_ext::getGoodId($row->id);
                  $row->ctime		    = date('Y-m-d',$row->ctime);
                  $row->down          = $row->down ?'是' :'否';
                  $rs2[]				= $row;
              }
              echo json_encode($rs2);                
          }
          
          public function update(){   
              
              $re_msg['success'] = 0;
              $re_msg['msg'] = array();
              $itemId = P('itemId');
              if($itemId == ''){
                  $re_msg['msg'] = '更新失败！';
                  echo json_encode($re_msg);
                  exit;
              }   
              $title = P('title');    
              if($title == ''){
                  $re_msg['msg'] = '缺少商品名称！';
                  echo json_encode($re_msg);
                  exit;
              }       

              $cateId = P('cateId');
              if(empty($cateId)){
                  $re_msg['msg'] = '缺少商品分类！';
                  echo json_encode($re_msg);
                  exit;                  
              }

              $picskey = P('picskey');
              $picsvalue = P('picsvalue');
              if($picskey == '' && $picsvalue == '')
              {
                  echo json_encode(array('success'=>0,'msg'=>'缺少图片！'));
                  return;
              }
              $pics = array();
              $i = 0;
              foreach($picskey as $value)
              {
                  if(isset($picsvalue[$i]))
                      $pics[$value] = $picsvalue[$i];
                  else
                      $pics[$value] = '0';
                  $i++;
              }
              $pics = serialize($pics);             

              $content    = P('content');   
              $status     = P('status'); 
              $postage    = P('postage');   
              $limit_num  = P('limit_num',1);     
              $save = array(
                  'title'       => $title,               
                  'limit_num'   => $limit_num,    //限购数量                  
                  'cateId'      => $cateId,               
                  'pics'        => $pics,              
                  'content'     => $content,             
                  'update_time' => time(),
                  'mainPic'     => $picskey[0],
                  'status'      => $status,
                  'postage'     => $postage
                  );
  
              $return = M('item')->update($save,"id=$itemId");
              if($return){                  
                  //保存成功更新商品属性
                  $att_data = array();
                  $att_data['item_id'] = $itemId;
                  $att_data['add_time'] = time();
                  $id   = P('id');
                  $attr_pic   = P('attr_pic');
                  $attr_name  = P('attr_name');
                  $attr_price = P('attr_price');
                  $attr_stock = P('attr_stock');
                  $attr_jifen = P('attr_jifen');
                  $attr_golds = P('attr_golds');
                  $sell_num   = P('sell_num');
                  $i=0;
                  is_array($attr_name) ? null : $attr_name = array();
                  foreach($attr_name as $vala){
                      if(!empty($vala)){
                           $att_data['attr_name']  = $vala;
                           $att_data['attr_price'] = $attr_price[$i];
                           $att_data['attr_stock'] = $attr_stock[$i];
                           $att_data['attr_jifen'] = $attr_jifen[$i];
                           $att_data['attr_golds'] = $attr_golds[$i];
                           $att_data['sell_num']   = $sell_num[$i];
                           $att_data['attr_pic']   = $attr_pic[$i];
                           $id                     = $id[$i];
                           if($id>0){
                              M('item_attr')->update($att_data,"id=$id");
                           }else{
                              M('item_attr')->save($att_data);
                           }                           
                           $i++;
                      }
                  }
                  $re_msg['success'] = 1;
                  $re_msg['msg'] = '保存成功！';
              }else{
                  $re_msg['msg'] = '保存失败！';
              }
              echo json_encode($re_msg);
          }
          
          // 添加商品
          public function save(){       
              $account_id = accountInfo_ext::accountId();    
              $title = P('title');    
              $re_msg['success'] = 0;
              $re_msg['msg'] = array();
              if($title == ''){
                  $re_msg['msg'] = '缺少商品名称！';
                  echo json_encode($re_msg);
                  exit;
              }       

              $cateId = P('cateId');
              if(empty($cateId)){
                  $re_msg['msg'] = '缺少商品分类！';
                  echo json_encode($re_msg);
                  exit;                  
              }

              $picskey = P('picskey');
              $picsvalue = P('picsvalue');
              if($picskey == '' && $picsvalue == '')
              {
                  echo json_encode(array('success'=>0,'msg'=>'缺少图片！'));
                  return;
              }
              $pics = array();
              $i = 0;
              foreach($picskey as $value)
              {
                  if(isset($picsvalue[$i]))
                      $pics[$value] = $picsvalue[$i];
                  else
                      $pics[$value] = '0';
                  $i++;
              }
              $pics = serialize($pics);             

              $content    = P('content');   
              $status     = P('status'); 
              $postage    = P('postage');   
              $limit_num  = P('limit_num',1);     
              $addtime    = time();
              $save = array(
                  'account_id'       => $account_id,
                  'title'       => $title,               
                  'limit_num'   => $limit_num,    //限购数量                  
                  'cateId'      => $cateId,               
                  'pics'        => $pics,              
                  'content'     => $content,             
                  'addtime'     => $addtime,
                  'update_time' => $ptime,
                  'mainPic'     => $picskey[0],
                  'status'      => $status,
                  'postage'     => $postage
                  );
              $return = M('item')->save($save);
              if(!empty($return)){                  
                  //保存成功更新商品属性
                  $att_data = array();
                  $att_data['item_id'] = $return;
                  $att_data['add_time'] = time();
                  $attr_pic   = P('attr_pic');
                  $attr_name  = P('attr_name');
                  $attr_price = P('attr_price');
                  $attr_stock = P('attr_stock');
                  $attr_jifen = P('attr_jifen');
                  $attr_golds = P('attr_golds');
                  $sell_num   = P('sell_num');
                  $i=0;
                  is_array($attr_name) ? null : $attr_name = array();
                  foreach($attr_name as $vala){
                      if(!empty($vala)){
                           $att_data['attr_name']  = $vala;
                           $att_data['attr_price'] = $attr_price[$i];
                           $att_data['attr_stock'] = $attr_stock[$i];
                           $att_data['attr_jifen'] = $attr_jifen[$i];
                           $att_data['attr_golds'] = $attr_golds[$i];
                           $att_data['sell_num']   = $sell_num[$i];
                           $att_data['attr_pic']   = $attr_pic[$i];
                           M('item_attr')->save($att_data);
                           $i++;
                      }
                  }
                  $re_msg['success'] = 1;
                  $re_msg['msg'] = '保存成功！';
              }else{
                  $re_msg['msg'] = '保存失败！';
              }
              echo json_encode($re_msg);
          }
          
          public function delete()
          {
              $id = P('id');
              M('item_attribute')->delete(array('itemId'=>$id));
              M('desc')->delete(array('itemId'=>$id));
              M('item')->delete(array('id'=>$id));
              D('item')->updateCate('item_'.$id);
              // $xs = new xs_ext('mall');
              // $xs->save($id,'delete');
              echo json_encode(array('success'=>1,'msg'=>'删除成功！'));
          }
          
          /**
           * 上架商品
           * @return void
           */
          // public function listUp()
          // {
          //     $id		= P('id');
          //     if ($id>0)
          //     {
          //         $return 	= $this->mod->update(array('down'=>1),array('id'=>$id));
          //         if($return>0)
          //         {
          //             echo json_encode(array('success'=>1));
          //             D('item')->updateCate('item_'.$id);
          //             $xs = new xs_ext('mall');
          //             $xs->save($id,'add');
          //             return;
          //         }
          //     }
          //     echo json_encode(array('success'=>0,'msg'=>'下架失败！'));
          // }

          /**
           * 下架商品
           * @return void
           */
          // public function listDown()
          // {
          //     $id		= P('id');
          //     if ($id>0)
          //     {
          //         $return 	= $this->mod->update(array('down'=>0),array('id'=>$id));
          //         if($return>0)
          //         {
          //             echo json_encode(array('success'=>1));
          //             D('item')->updateCate('item_'.$id);
          //             $xs = new xs_ext('mall');
          //             $xs->save($id,'delete');
          //             return;
          //         }
          //     }
          //     echo json_encode(array('success'=>0,'msg'=>'下架失败！'));
          // }

          /**
           * 上下架商品
           * @return void
           */
          public function opItem()
          {
              $id     = P('id');
              $status = P('status');
              if ($id>0){
                  $return = $this->mod->update(array('status'=>$status),array('id'=>$id));
                  if($return>0){
                      echo json_encode(array('success'=>1));
                      D('item')->updateCate('item_'.$id);                    
                      return;
                  }
              }
              echo json_encode(array('success'=>0,'msg'=>'下架失败！'));
          }

          // 
          public function delAttr(){
            $id = P('id');
            if($id>0){
              $rs = M('item_attr')->delete("id=$id");
              if($rs){
                echo json_encode(array('success'=>1,'msg'=>'删除成功！'));
              }else{
                echo json_encode(array('success'=>0,'msg'=>'删除失败！'));
              }
            }
          }
          public function getFonts()
          {
              echo json_encode($GLOBALS['config']['fonts']);
          }
      }
?>