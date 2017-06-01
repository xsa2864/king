<body>
<div id="w" class="easyui-window" cache="false" closed="true" title=""  style="width:800px;height:450px;padding:10px;background: #fafafa;"></div>
<div class="easyui-tabs" fit="true" id="tb">
<div title="商品管理" style="padding:10px">
<table>
    <tr>
    <?php 
        foreach ($rs as $row)
        {
            echo '<td width="100" class="fb"><img src="'.input::jsUrl('desktop/images/icons/').$row->icon.'" border="0" onclick="return addPanel(\''.$row->modName.'\',\''.$row->app.'/'.$row->url.'\')" style="cursor:pointer;margin-left:5px;" /><br /><span class="href">'.$row->modName.'</span></td>';
        }
    ?>
    </tr>
</table>
</div>
</div>
</body>
