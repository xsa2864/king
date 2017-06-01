<!-- 弹出框添加分类 -->
<div class="up_box" style="display: none" id="addCategory_view">
    <h1>添加分类<i class="close"></i></h1>
    <div class="bor_box box_pop ">
        <dl class="cf">
            <dt><em class="asterisk">*</em> 分类名称：</dt>
            <dd><span>
                <input id="name" type="text" /></span></dd>
        </dl>
        <dl class="cf">
            <dt><em class="asterisk">*</em>上级分类：</dt>
            <dd class="select_box">
                <select id="pid" class="puiSelect" style="width: 184px;">
                    <option value="0">主类</option>
                    <?php
                    foreach($tree as $value)
                    {
                        echo '<option value="'.$value['id'].'">'.$value['text'].'</option>';
                        
                        if($value['children'])
                        {
                            foreach($value['children'] as $value2)
                            {
                                echo '<option value="'.$value2['id'].'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$value2['text'].'</option>';
                            }
                        }
                    }
                    ?>
                </select>
            </dd>
        </dl>
        <dl class="cf">
            <dt>分类排序：</dt>
            <dd><span>
                <input id="orderNum" type="text" /></span></dd>
        </dl>
    </div>
    <div class="btn_two btn_width cf">
        <a class="a1" href="javascript:btnSubmit()">保存</a><a style="cursor:pointer;" class="close">取消</a>
    </div>
</div>
<script type="text/javascript">
    function btnSubmit() {
        var name = $("#name").val();
        var pid = $("#pid").val();
        var orderNum = $("#orderNum").val();
        if (!orderNum)
        {
            orderNum = 0;
        }
        $.post("<?php echo input::site('admin/category/save');?>", { 'name': name, 'pid': pid, 'orderNum': orderNum, 'visible': 1 },
                function (data)
                {
                    var da = eval('('+data+')');
                    if (da.success == 1)
                    {
                        location.href = '<?php echo input::site('admin/category/index'); ?>';
                    }
                    else
                    {
                        alert(da.msg);
                    }
                });
    }
</script>
