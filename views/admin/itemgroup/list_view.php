<?php
    $url = input::site("admin/itemgroup/add/");
?>
<script>
    function adds(){
        var id = $("#optionId").val();
		if (id > 0){
			location.href = "<?php echo $url; ?>" + id;
		}
    }
	function del(item){
        var id = $("#optionId").val();
		if (id>0)
		{
			location.href = "<?php echo input::site('admin/itemgroup/del?'); ?>" + "item_id=" + item + "&cid=" + id;
		}
	}
</script>
<div class="container-fluid">
    <div class="row">
         <div class="col-sm-12">
<form method="post" class="form-inline">
    <select class="form-control" id="optionId" name="optionId" onchange="this.form.submit()">
         <?php
              if (is_array($data['group'])){
				  $option = "";
                  foreach($data['group'] as $val){
					  if ($val->id == $data['post']['optionId']){
                          $select = "selected";
					  }else{
                          $select = "";
					  }
                      $option .= "<option value='$val->id' $select>$val->name</option>";
				  }
				  echo $option;
              }
		 ?>
	</select>
	<button type="button" class="btn btn-default" onclick="adds()" target="menu">添加产品</button>
</form>
        </div>
    </div>
	<div class="row">
         <div class="col-sm-12">
              <?php
                  if (is_array($data['items'])){
					   $icon       = array("X", "√");
					  $table = '<div class="hx_table"><table border="0" class="hxy_table"><tr>';
					  $table .= '
                                  <th width="5%" scope="col">ID</th>
									<th width="24%" scope="col">标题</th>
									<th width="10%" scope="col">价格</th>
									<th width="10%" scope="col">特价</th>
									   <th width="3%" scope="col">推荐</th>
				<th width="3%" scope="col">特价</th>
				<th width="3%" scope="col">上架</th>
									<th width="10%" scope="col">库存</th>
									<th width="18%" colspan="3" scope="col">操作</th>
								  </tr>';
               foreach ($data['items'] as $item){
				    $images= input::imgUrl("default.png");
		            $img   = false;
					$item[0]->pics = unserialize($item[0]->pics);
				  if ((sizeof($item[0]->pics)) > 0 && is_array($item[0]->pics)) {
					  foreach($item[0]->pics as $key=>$val){
							if ($val == 1 && !$img){
							   $images = input::site($key);
							   $img = true;
							}elseif ( !$img ){
							   $images = input::site($key);
							}
					   }
				  }
				  $table .= '<tr>
                
                <td>'.$item[0]->id.'</td>
                <td class="text"><span class="sp1"><img class="bor" src="'.$images.'"  width="60" height="60" /></span>'.$item[0]->title.'</td>
                <td>￥ '.$item[0]->prePrice.'</td>
                <td class="color">￥ '.$item[0]->price.'</td>
  
				<td>'.$icon[$item[0]->isfeatured].'</td>
				 <td>'.$icon[$item[0]->isspecial].'</td>
				  <td>'.$icon[$item[0]->down].'</td>
                <td>'.$item[0]->store.'</td>
                <td>
				  <button onclick="del('.$item['ids'].')" target="menu" href="javascript:void(0)"><img border="0" title=" 删除 " alt="删除" src="'.input::imgUrl('admin/icon_delete.gif').'"></button>
               </td>
        
              </tr>';
			   }
             
                      $table .= '</table></div>';
					  echo $table;
		          }else{
                      echo $data['items'];
				  }
			  ?>
		 </div>
	</div>
</div>