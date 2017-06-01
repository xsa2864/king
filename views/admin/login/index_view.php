<div id="loginbox">
    <form id="loginform" method="post" class="form-vertical">
        <div class="control-group normal_text">
            <h3>
                <img src="img/logo.png" alt="Logo" /></h3>
        </div>
        <div class="control-group">
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_lg"><i class="icon-user"></i></span>
                    <input type="text" name="userName" placeholder="帐号" required="true" />
                </div>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_ly"><i class="icon-lock"></i></span>
                    <input type="password" name="passwd" placeholder="密码" required="true" />
                </div>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <div class="main_input_box" id="capt">
                    <?php $capt->render();?>&nbsp;<input type="text" name="captcha" size="5" placeholder="验证码" required="true" />
                </div>
            </div>
        </div>
        <div class="form-actions">
            <!--<span class="pull-left"><a href="#" class="flip-link btn btn-info" id="to-recover">Lost password?</a></span>-->
            <span class="pull-right">
                <input type="submit" value=" 登 录 " class="btn btn-success" /></span>
        </div>
    </form>
</div>
<script type="text/javascript">
    $('#loginform').form({
        url: '',
        onSubmit: function () {
            return $(this).form('validate');
        },
        success: function (data) {
            console.log(data);
            data = vdata(data);
            if (data.success == 1) {
                parent.location.href = '<?php echo input::site('solid/display');?>';
            } else {
                //$.messager.alert('用户登录',data.msg);
                alert(data.msg);
                alert('1231');
                $('#capt img').attr('src', "<?php echo input::site('captcha/default');?>?r=" + Math.random()).show();
            }
        }
    });
    $('#capt img').click(function () {
        $('#capt img').attr('src', "<?php echo input::site('captcha/default');?>?r=" + Math.random()).show();
        });
        $('#capt img').attr('style', 'cursor:pointer');
</script>

