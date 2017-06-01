<?php defined('KING_PATH') or die('访问被拒绝.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>酒泉网</title>
    <link href="<?php echo input::cssUrl('home.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo input::cssUrl('backstage.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo input::jsUrl('form/form.css');?>" rel="stylesheet" type="text/css" />
    <script src="<?php echo input::jsUrl('jquery-1.11.3.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo input::jsUrl('form/form.js');?>" type="text/javascript"></script>
    <script src="<?php echo input::jsUrl('home.js');?>" type="text/javascript"></script>
    <script src="<?php echo input::jsUrl('json2.js');?>"></script>
</head>
<body>
    <!--头部-->
    <div class="back_sign">
        <div class="sign_top">
            <div class="q">
                <a>
                    <img src="<?php echo input::imgUrl('lohim_03.png');?>" width="280" height="50"></a>
            </div>
        </div>
        <div class="sign">
            <div class="q">
                <div class="Position">
                    <div class="sign_box">
                        <h1>系统登录</h1>
                        <div class="sign_inp">
                            <dl>
                                <dd><i class="one"></i>
                                    <input id="user" type="text" placeholder="用户名" /></dd>
                            </dl>
                            <dl>
                                <dd><i class="two"></i>
                                    <input id="pass" type="password" placeholder="密码" /></dd>
                            </dl>
                            <dl class="proving cf">
                                <dt>
                                    <input id="captcha" type="text" placeholder="验证码" /></dt>
                                <dd id="capt"><?php $capt->render(); ?></dd>
                                <dd><a style="cursor:pointer;" id="captButton">换一张</a></dd>
                            </dl>
                            <div class="sign_btn">
                                <a href="javascript:login();">登录</a><a href="javascript: location.reload()">重置</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function () {
            $('input').focus(function () {
                $(this).css({ 'border-color': '#a5a5a5' })
            });
            $('input').blur(function () {
                $(this).css({ 'border-color': '#ebebeb' })
            });
            $('#captButton').click(function () {
                $('#capt img').attr('src', "<?php echo input::site('captcha/default');?>?r=" + Math.random()).show();
            });
            $("html").on("keydown", function (event) {
                if (event.keyCode == 13) {
                    login();
                }
            });
        });

        function login() {
            var user = $('#user').val();
            var pass = $('#pass').val();
            var captcha = $('#captcha').val();
            $.post("<?php echo input::site('headquarters/login/checkLogin');?>", { 'user': user, 'pass': pass, 'captcha': captcha }, function (data) {
                var da = JSON.parse(data);
                if (da.success == 0) {
                    alert(da.msg);
                    $('#capt img').attr('src', "<?php echo input::site('captcha/default');?>?r=" + Math.random()).show();
                    $('#captcha').val('');
                }
                else {
                    // javascript: location.reload()
                    window.location="<?php echo input::site('headquarters/member');?>";
                }
            });
        }
    </script>
</body>
</html>
