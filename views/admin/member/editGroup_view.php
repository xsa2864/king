<!--编辑分组--->
<div class="up_box up_hy" style="display: none; width: 358px;" id="editGroup_view">
    <h1>编辑分组<i class="close"></i></h1>
    <div class="par_bottom">
        <div class="inspection" style="margin: 20px 0 20px 15px">
            <dl class="cf up_hy_dl padd">
                <dt class="bold">分组名称：</dt>
                <dd class="input1">
                    <input id="editgroup" type="text" placeholder="核心会员"></dd>
            </dl>

        </div>
    </div>
    <div class="btn_two btn_width cf">
        <a class="a1 close" style="cursor: pointer;" onclick="javascript:editgroup()">确定</a><a class="close" style="cursor: pointer;">取消</a>
    </div>
</div>
<script type="text/javascript">
    function editgroup()
    {
        var nn = $('#editgroup').val();
        var itemId = $('#editgroup').attr('itemId');
        $.post("<?php echo input::site('admin/member/editGroup') ?>", { 'name': nn, 'id': itemId },
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