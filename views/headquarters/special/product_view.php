    <script language="JavaScript">
function viewData(cid,cname){
		//获取a1.html对象window对象
		//对话框可以通过调用程序从 window 对象的 dialogArguments 属性提取这些值。 		
		//a1.html页面的window对象在a2.html页面上被封装到dialogArguments属性中
		var sdata=window.dialogArguments;		
		//调用a1.html页面的函数
        sdata.setValue(cid,cname);
		window.close();
	 }

function setValue(itemid, itemname){	 
	//var itemname = window.opener.document.getElementById("itemname"); 
	window.opener.document.getElementById("itemname").innerHTML=itemname;
	window.opener.document.getElementById("itemTitle").value=itemname;
	window.opener.document.getElementById("itemId").value=itemid;
	
 	window.close();
}
	
  </script>
 <div class="container-fruid" style="padding:20px 0 50px 0;">
    <form name="form2" class="form-inline" method="post" action="<?php echo $url; ?>">
    <table border="0" class="hxy_table">
    	 <tr><td width="200"><label>搜索:</label>&nbsp;&nbsp;&nbsp;<input type="text" value="" name="title"  />&nbsp;&nbsp;&nbsp;<select name="cateId">
    	 	<?php 
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
		    						<td><input id="chkbox" type="checkbox"   onclick="setValue('.$product->id.',\''.$product->title.'\');" /></td>
		    						<td><img src="'.input::site(output_ext::getCoverImg($product->pics)).'" /></td>
		    						<td>'.$product->title.'</td>
		    						<td>'.$product->price.'</td>
		    					</tr>';
		              	}
	              ?>
	              <tr><td colspan="4"><?php echo $pagination->render();?></td></tr>
	              <!-- <tr>				
	                    <td colspan="4"><button class="btn btn-success btn-sm" type="submit" >提交</button></td>
				  </tr> -->
			</table> 
			
			</form>   
	    </div>    
	</div>
</div>