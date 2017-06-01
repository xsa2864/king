<header class="header buys pad0">
    <div class="favorites">
        <p><a class="return" href="JavaScript:history.back();"><i></i>返回</a></p>
    </div>
</header>
<div class="container pad1">
    <div class="value_cen ">
        <div class="keyboard_h1">
            <h1 class="f32">提现金额</h1>
            <h2>
                <input placeholder="￥" readonly="readonly" type="text" /></h2>
            <h4>当前余额为¥<?php echo sprintf('%.2f',$commission-$freeze>0?$commission-$freeze:0);?>，<a href="JavaScript:allIn(<?php echo sprintf('%.2f',$commission-$freeze>0?$commission-$freeze:0);?>);">全部提现</a></h4>
            <h5>提现金额将转至您的微信钱包内。</h5>
            <h3 class="keyboard_btn">
                <span class="mask_box2 radius" style="display: none"></span>
                <span class="mask_btn radius " onclick="JavaScript:gotoCheck();"><font>确 定</font></span>
            </h3>
        </div>
    </div>

</div>

<script>
    $(function () {
        $('.balance_h1 dd,.keyboard_btn').on('touchstart', function () {
            $(this).find('.mask_box2').show();
        });
        $(document).on('touchend', function () {
            $(this).find('.mask_box2').hide();
        });

        // 数字录入
        $('.keyboard_h1 input').on('click', function () {
            var input = $(this);
            $.keyboard(function (val) {
                input.val('￥' + val);
            }, true);
            return false;
        });
    });

    function allIn(num) {
        $('.keyboard_h1 input').val('￥' + num);
    }
    function gotoCheck() {
        var money = $('.keyboard_h1 input').val();
        $.post("<?php echo input::site('wechat/member/gotoCheck');?>",{money:money}, function (data) {
            if (data) {
                alert(data);
            } else {
                location.href = "<?php echo input::site('wechat/member/safetyCheck');?>"
            }            
        });
    }

</script>

