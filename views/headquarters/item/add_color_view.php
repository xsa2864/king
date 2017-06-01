<body>
<div class="easyui-layout" fit="true">
	<div region="center" border="false" style="padding:14px;background:#fff;border:1px solid #ccc;">
    <form id="formColor" method="post" enctype="multipart/form-data">
    <div class="ftitle">网站详细信息</div>
        <table id="tabwin2">
            <tr>
            	<td>颜色名称:</td>
            	<td><input type="text" name="name" value="" required="true" class="easyui-validatebox" /></td>	
            </tr>
            <tr>
            	<td>图片:</td>
            	<td><input type="file" name="ufile" value="上传" /></td>	
            </tr>
        </table>
    </form>		
	</div>
	<div region="south" border="false" style="text-align:center;padding-top:3px;background-color:#F2F2F2;">
		<a class="easyui-linkbutton" iconCls="icon-save" href="javascript:void(0)" onClick="return formSubmitCallFun('<?php echo input::site('solid/item/saveColor');?>', 'formColor',setColor);">保存</a>
	</div>	
</div>
<script type="text/javascript">
    function setColor(data){
		var input   = '<input type="hidden" name="colors[]" value="'+data.name+'"><input type="hidden" name="colorNames[]" value="'+data.url+'">';
		var srcData	= data.url.split('.');
		var thumb	= srcData[0]+'_50x50.'+srcData[1];
		var cols = '<div class="cancel-icon" onclick="return colorDel(this,\''+data.url+'\')"></div>'+input+'<img src="'+siteUrl+thumb+'" /><br/><span style="none">'+data.name+'</span>';   
    	$('#colorBox').append('<div class="img-wrap">'+cols+'</div>');	        
    }
</script>
</body>            