<!--添加会员等级--->
<div class="up_box" style="display: none; width: 520px;" id="addLevel_view">
    <h1>添加会员等级<i class="close"></i></h1>
    <div class="add_hy ma20 pad30">
        <dl class="cf">
            <dt><em class="asterisk">*</em>等级名称：</dt>
            <dd>
                <input id="addlevelname" class="inp1" type="text" /></dd>
        </dl>
        <dl class="cf ma20">
            <dt>排序：</dt>
            <dd>
                <input id="addlevelorder" class="inp2" type="text" /></dd>
        </dl>
        <dl class="cf ma20">
            <dt><em class="asterisk">*</em>交易额：</dt>
            <dd>
                <input id="addlevelmin" class="inp3" type="text" value="" /><dd>
            <dd>&nbsp;到&nbsp;<input id="addlevelmax" class="inp3" type="text" value="" /></dd>
        </dl>
        <dl class="cf ma20">
            <dt><em class="asterisk">*</em>积分倍数：</dt>
            <dd>
                <input id="addlevelpoint" class="inp2" type="text" /></dd>
            <dd class="ff">（该会员等级每1元消费获得的积分数）</dd>
        </dl>
    </div>
    <div class="btn_two btn_width cf">
        <a class="a1 close" style="cursor: pointer;" onclick="javascript:addlevel()">确定</a><a class="close" style="cursor: pointer;">取消</a>
    </div>
</div>
<script type="text/javascript">
    function addlevel()
    {
        var addlevelname = $('#addlevelname').val();
        var addlevelorder = $('#addlevelorder').val();
        var addlevelmin = $('#addlevelmin').val();
        var addlevelmax = $('#addlevelmax').val();
        var addlevelpoint = $('#addlevelpoint').val();
        $.post("<?php echo input::site('admin/member/addLevel') ?>", { 'name': addlevelname, 'order': addlevelorder, 'min': addlevelmin, 'max': addlevelmax, 'point': addlevelpoint },
                function (data) {
                    var da = JSON.parse(data);
                    if (da.success == 1) {
                        location.reload();
                    }
                    else {
                        alert(da.msg);
                    }
                });
    }
</script>