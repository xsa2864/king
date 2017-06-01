<!--调整积分--->
<div class="up_box up_hy" style="display: none; width: 358px;" id="changePoints_view">
    <h1>调整积分<i class="close"></i></h1>
    <div class="par_bottom">
        <div class="inspection" style="margin: 20px 0 20px 15px">
            <dl class="cf up_hy_dl padd">
                <dt class="bold">调整积分：</dt>
                <dd class="input1">
                    <input id="changePoints" type="text"></dd>
            </dl>

        </div>
    </div>
    <div class="btn_two btn_width cf">
        <a class="a1 close" style="cursor: pointer;" onclick="javascript:changepoint()">确定</a><a class="close" style="cursor: pointer;">取消</a>
    </div>
</div>
<script type="text/javascript">
    function changepoint()
    {
        var np = $('#changePoints').val();
        var id = $('#changePoints').attr('itemId');
        $.post("<?php echo input::site('admin/member/changePoint') ?>", { 'id': id, 'points': np},
                function (data) {
                    var da = JSON.parse(data);
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