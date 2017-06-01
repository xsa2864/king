<!-- 弹出框新增内容 -->
<div class="up_box" style="display:none" id="addAttrItem_view">
	<h1>新增内容<i class="close"></i></h1>
    <div class="bor_box box_pop ">
    	<dl class="cf">
            <dt><em class="asterisk">*</em> 属性：</dt>
            <dd><span><input id="attrNameDis" disabled="disabled" type="text" value="其他"/></span></dd>
        </dl>
        <dl class="cf">
            <dt>内容：</dt>
            <dd><span><input id="attrItemName" type="text" /></span></dd>
        </dl>
        
    </div>
    <div class="btn_two btn_width cf">
        <a class="a1" href="javascript:btnAddAttrItem()">确定</a><a style="cursor:pointer;" class="close">取消</a>
    </div>
    <input id="attrId" type="text" style="display: none"/>
</div>
<script type="text/javascript">
    function btnAddAttrItem() {
        var attrItemName = $("#attrItemName").val();
        var categoryId = $("#attrId").val();
        var orderNum = $("#orderNum").val();
        if (!orderNum)
        {
            orderNum = 0;
        }
        $.post("<?php echo input::site('admin/attr/saveItem');?>", { 'name': attrItemName, 'categoryId': categoryId, 'orderNum': orderNum },
                function (data)
                {
                    var da = eval('('+data+')');
                    if (da.success == 1)
                    {
                        location.href = '<?php echo input::site('admin/attr/index/'); ?>' + da.cid;
                    }
                    else
                    {
                        alert(da.msg);
                    }
                });
    }
</script>