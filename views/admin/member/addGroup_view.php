<!--新建分组--->
<div class="up_box up_hy" style="display: none; width: 358px;" id="addGroup_view">
    <h1>新建分组<i class="close"></i></h1>
    <div class="par_bottom">
        <div class="inspection" style="margin: 20px 0 20px 15px">
            <dl class="cf up_hy_dl padd">
                <dt class="bold">分组名称：</dt>
                <dd class="input1">
                    <input id="addgroup" type="text" placeholder=""></dd>
            </dl>

        </div>
    </div>
    <div class="btn_two btn_width cf">
        <a class="a1 close" style="cursor: pointer;" onclick="javascript:addgroup()">确定</a><a class="close" style="cursor: pointer;">取消</a>
    </div>
</div>
<script type="text/javascript">
    function addgroup()
    {
        var nn = $('#addgroup').val();
        $.post("<?php echo input::site('admin/member/addGroup') ?>", { 'name': nn },
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