<?php 
	$url	= input::site('solid/category/saveAd/'.$id);
?>
<body>
<div class="easyui-layout" fit="true">
	<div region="center" border="false" style="padding:14px;background:#fff;border:1px solid #ccc;">
    <form id="formAd" method="post">
    <div class="ftitle">广告详细信息</div>
        <table id="tabwin2">
            <tr>
                <td>广告选择</td>
                <td><input class="easyui-combobox" value="<?php echo $row->ad;?>" name="ad" valueField="id" textField="name" url="<?php echo input::site('solid/advert/get?total=1');?>" panelHeight="200" style="width:300px" data-options="required:true"></td>
            </tr>
        </table>
    </form>		
	</div>
	<div region="south" border="false" style="text-align:center;padding-top:3px;background-color:#F2F2F2;">
		<a class="easyui-linkbutton" iconCls="icon-save" href="javascript:void(0)" onClick="return formSubmitBoxClose('<?php echo $url;?>','formAd','','wCate');">保存</a>&nbsp;<a class="easyui-linkbutton" iconCls="icon-cancel" href="javascript:void(0)" onclick="closeWin('wCate')">关闭</a>
	</div>
</div>
</body>