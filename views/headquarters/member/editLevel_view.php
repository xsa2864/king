<!--编辑会员等级--->
<div class="up_box" style="display: none; width: 520px;" id="editLevel_view">
    <h1>编辑会员等级<i class="close"></i></h1>
    <div class="add_hy ma20 pad30">
        <dl class="cf">
            <dt><em class="asterisk">*</em>等级名称：</dt>
            <dd>
                <input id="editlevelname" class="inp1" type="text" /></dd>
        </dl>
        <dl class="cf ma20">
            <dt>排序：</dt>
            <dd>
                <input id="editlevelorder" class="inp2" type="text" /></dd>
        </dl>
        <dl class="cf ma20">
            <dt><em class="asterisk">*</em>交易额：</dt>
            <dd>
                <input id="editlevelmin" class="inp3" type="text" /><dd>
            <dd>&nbsp;到&nbsp;<input id="editlevelmax" class="inp3" type="text" /></dd>
        </dl>
        <dl class="cf ma20">
            <dt><em class="asterisk">*</em>积分倍数：</dt>
            <dd>
                <input id="editlevelpoint" class="inp2" type="text" /></dd>
            <dd class="ff">（该会员等级每1元消费获得的积分数）</dd>
        </dl>
    </div>
    <div class="btn_two btn_width cf">
        <a class="a1 close" style="cursor: pointer;" onclick="javascript:editlevel()">确定</a><a class="close" style="cursor: pointer;">取消</a>
    </div>
</div>
<script type="text/javascript">
    function editlevel()
    {
        var id = $('#editlevelname').attr('itemid');
        var editlevelname = $('#editlevelname').val();
        var editlevelorder = $('#editlevelorder').val();
        var editlevelmin = $('#editlevelmin').val();
        var editlevelmax = $('#editlevelmax').val();
        var editlevelpoint = $('#editlevelpoint').val();
        $.post("<?php echo input::site('admin/member/editLevel') ?>", { 'id': id, 'name': editlevelname, 'order': editlevelorder, 'min': editlevelmin, 'max': editlevelmax, 'point': editlevelpoint },
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