<header class="header buys pad0">
    <div class="favorites">
        <p><a class="return" href="JavaScript:history.back();"><i></i>返回</a></p>
    </div>
</header>
<div class="container pad1">
    <h1 class="prompt_text">为了您的资金安全，请通过手机号验证</h1>
    <div class="address password cash">
        <p class="tb "><span>
            <input id="phone" type="text" readonly placeholder="请输入手机号码" /></span><span class="flex_1 verification"><a id="codeBtn" href="JavaScript:getCode();">获取验证码</a></span></p>
        <p class="tb ">
            <span class="">
                <input id="msgCode" type="text" readonly="readonly" placeholder="请输入短信验证码" /></span>
        </p>
    </div>
    <h3 class="keyboard_btn">
        <span class="mask_box2 radius" style="display: none"></span>
        <span class="mask_btn radius "><font>去提现</font></span>
    </h3>
</div>

<script>
    $(function () {
        $('.pass_box,.keyboard_btn').on('touchstart', function () {
            $(this).find('.mask_box2').show();
        });
        $(document).on('touchend', function () {
            $(this).find('.mask_box2').hide();
        });

        // 数字录入
        $('.password input').on('click', function () {
            var input = $(this);
            $.keyboard(function (val) {
                input.val(val);
            }, true);
            return false;
        });

        // 错误提示
        $('.pass_box,.keyboard_btn').on('touchstart', function () {
            var phone = $('#phone').val();
            var code = $('#msgCode').val();
            $.post("<?php echo input::site('wechat/member/checkCode');?>", { phone: phone, code: code }, function (data) {
                if (data) {
                    $.bottomTips(data);
                } else {
                    alert('已提交申请，等待审核');
                    location.href = '<?php echo input::site('wechat/member/index'); ?>';
                }
            });
        });
    });

    // 倒计时
    var sec, obj, secs;
    function getCode() {
        if (!sec) {
            var phone = $('#phone').val();
            $.post("<?php echo input::site('wechat/member/getCode');?>", { phone: phone }, function (data) {
                console.log(data);
                var da = eval("(" + data + ")");
                if (da.sec > 0) {
                    secs = da.sec;
                    waitCode();
                } else if (da.msg) {
                    alert(da.msg);
                }
            });
        }
    }

    function waitCode() {
        if (!sec) {
            obj && clearInterval(obj);
            sec = secs;
            $('#codeBtn').attr('style', 'color:#9c9898 !important');
            $('#codeBtn').html('剩余' + --sec + 's');
            obj = setInterval(function () {
                $('#codeBtn').html('剩余' + --sec + 's');
                if (sec <= 0) {
                    clearInterval(obj);
                    $('#codeBtn').attr('style', 'color:#ff3434 !important').html('重新获取');
                }
            }, 1000);
        }
    }

</script>

