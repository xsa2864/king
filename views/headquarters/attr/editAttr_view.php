<!-- 弹出框编辑 -->
<div class="up_box" style="display:none" id="editAttr_view">
	<h1>编辑<i class="close"></i></h1>
    <div class="bor_box box_pop ">
        <dl class="cf padd">
            <dt>内容：</dt>
            <dd><span><input id="eAttrItemName" type="text" /></span></dd>
        </dl>
        
    </div>
    <div class="btn_two btn_width cf">
        <a class="a1" href="javascript:btnEditAttr()">确定</a><a style="cursor:pointer;" class="close">取消</a>
    </div>
    <input id="attrItemId" type="text" style="display: none"/>
    <input id="cId" type="text" style="display: none"/>
</div>
<script type="text/javascript">
    function btnEditAttr() {
        var attrName = $("#eAttrItemName").val();
        var attrItemId = $("#attrItemId").val();
        var cId = $("#cId").val();
        var orderNum = $("#orderNum").val();
        if (!orderNum)
        {
            orderNum = 0;
        }
        $.post("<?php echo input::site('admin/attr/updateItem');?>", { 'name': attrName, 'categoryId': cId, 'orderNum': orderNum, 'id': attrItemId },
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