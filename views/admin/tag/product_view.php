 <div class="container-fruid" style="padding:20px 0 50px 0;">
    <form name="form2" class="form-inline" method="get" action="<?php echo $url; ?>">
    <table border="0" class="hxy_table">
    	 <tr><td width="200"><label>搜索:</label>&nbsp;&nbsp;&nbsp;<input type="text" value="" name="title"  />&nbsp;&nbsp;&nbsp;<select name="cateId">
    	 	<?php 
    	 		echo '<option value="0">全部类别</option>';
    	 		foreach ($cates as $row)
    	 		{
    	 			echo '<option value="'.$row->id.'">'.$row->name.'</option>';
    	 		}
    	 	?>					
		</select>&nbsp;&nbsp;&nbsp;<input type="submit" value="搜索" /></td>
		</tr>
	</table>
    </form>
	<div class="hx_list">
		<div class="hx_list_h1"></div>
	    <div class="hx_table">
	    	<form name="form1" action="<?php echo input::site('admin/tag/saveProduct');?>" method="post">
	    	<table border="0" class="hxy_table">
	              <tr>
	                <th width="10%" scope="col">选择</th>
	                <th width="20%" scope="col">图片</th>
	                <th width="30%" scope="col">标题</th>
	                <th  width="10%" scope="col">价格</th>
	              </tr>
					<?php 
		              if ($tagValue)
		              {
		              		$tagValue	= unserialize($tagValue);
		              		$ids		= array();
		              		if (is_array($tagValue))
		              		{
		              			foreach ($tagValue as $tag)
		              			{
		              				$ids[]	= $tag->id;
		              			}
		              		}
		              }
		              
						foreach ($products as $product)
		              	{
		              		$check	= '';
		              		if (count($ids)>0)
		              		{
		              			if (in_array($product->id,$ids))
		              			{
		              				$check	= 'checked="checked"';
		              			}
		              		}
		              		echo '<tr>
		    						<td><input name="chk[]" type="checkbox" value="'.$product->id.'" '.$check.' /></td>
		    						<td><img src="'.input::site(output_ext::getCoverImg($product->pics)).'" /></td>
		    						<td>'.$product->title.'</td>
		    						<td>'.$product->price.'</td>
		    					</tr>';
		              	}
	              ?>
	              <tr><td colspan="4"><?php echo $pagination->render();?></td></tr>
	              <tr>				
	                    <td colspan="4"><button class="btn btn-success btn-sm" type="submit" >提交</button>&nbsp;&nbsp;<a class="btn btn-sm" href="<?php echo input::site('admin/home/index');?>">返回</a></td>
				  </tr>
			</table> 
			<input type="hidden" name="tagName" value="<?php echo $tagName;?>" />
			</form>   
	    </div>    
	</div>
</form>
</div>