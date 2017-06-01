<!-- 弹出框新增属性 -->
<div class="up_box" style="display:none" id="addAttr_view">
	<h1>新增属性<i class="close"></i></h1>
    <div class="bor_box box_pop ">
    	<dl class="cf">
            <dt><em class="asterisk">*</em> 分类：</dt>
            <dd><span><input id="categoryName" disabled="disabled" type="text" value="白酒" /></span></dd>
        </dl>
        <dl class="cf">
            <dt>属性：</dt>
            <dd><span><input id="attrName" type="text" /></span></dd>
        </dl>
    </div>
    <div class="btn_two btn_width cf">
        <a class="a1" href="javascript:btnattrSubmit()">确定</a><a style="cursor:pointer;" class="close">取消</a>
    </div>
    <input id="categoryId" type="text" style="display: none"/>
</div>
<script type="text/javascript">
    function btnattrSubmit() {
        var attrName = $("#attrName").val();
        var categoryId = $("#categoryId").val();
        var orderNum = $("#orderNum").val();
        if (!orderNum)
        {
            orderNum = 0;
        }
        $.post("<?php echo input::site('admin/attr/save');?>", { 'name': attrName, 'categoryId': categoryId, 'orderNum': orderNum },
                function (data)
                {
                    var da = eval('('+data+')');
                    if (da.success == 1)
                    {
                        location.reload();
                    }
                    else
                    {
                        alert(da.msg);
                    }
                });
    }
</script>