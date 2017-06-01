<body>
<?php 
		$url	= input::site('solid/category/saveAssoc/'.$id);
?>
<div class="easyui-layout" fit="true">
	<div region="center" border="false" style="padding:14px;background:#fff;border:1px solid #ccc;">
    <form id="form1" method="post">
    <div class="ftitle">商品属性</div>
        <table id="tabwin2">
            <tr>
                <td>筛选类型:</td>
                <td><td><input class="easyui-combobox" value="<?php echo $did ? $did :'';?>" name="did" id="did" url="<?php echo input::site('solid/attr/get?total=1');?>" valueField="did" textField="name" panelHeight="auto" style="width:100px" data-options="required:true"></td></td>
            </tr>
        </table>
    </form>		
	</div>
	<div region="south" border="false" style="text-align:center;padding-top:3px;background-color:#F2F2F2;">
		<a class="easyui-linkbutton" iconCls="icon-save" href="javascript:void(0)" onClick="return formSubmitBoxClose('<?php echo $url;?>', 'form1', 'ttCate', 'wCate');">保存</a>&nbsp;<a class="easyui-linkbutton" iconCls="icon-cancel" href="javascript:void(0)" onclick="closeWin('wCate')">关闭</a>
	</div>
</div>
</body>