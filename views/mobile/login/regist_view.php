<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>Bootstrap 101 Template</title>

    <!-- 新 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">      
    <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>    
    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- 引用自己的js -->
    <script type="text/javascript" src="<?php echo input::site("library/mobile/js/base.js"); ?>"></script>
  </head>
  <body>
    <h2 class="text-center">注册</h2>
    <form class="form-horizontal">
      <div class="form-group">
        <div class="col-xs-12">
          <label for="mobile">手机号</label>
        </div>
        <div class="col-xs-12">
          <input type="text" class="form-control" id="mobile" placeholder="手机号">
        </div>
      </div>
      <div class="form-group">
        <div class="col-xs-12">
          <label for="mobile">密码</label>
        </div>
        <div class="col-xs-12">
          <input type="text" class="form-control" id="passwd" placeholder="密码">
        </div>
      </div>

      <div class="form-group">
        <div class="col-xs-8">
          <input type="text" class="form-control" id="captcha" placeholder="验证码">
        </div>
        <div class="col-xs-4" style="padding-left:0px;">
          <button type="button" class="btn btn-success getcode" value="1">获取验证码</button>
        </div>
      </div>  

      <div class="form-group">
        <div class="col-xs-12">
          <button type="button" class="btn btn-info btn-block" onclick="register()">注册</button> 
        </div>
      </div>      
    </form>
<style type="text/css">
  .form-group{
   margin-left:0px !important;
   margin-right:0px !important;
  }
</style>
<script type="text/javascript">
// 获取验证码
$('.getcode').click(function(){
  count_down($(this));
});
// 按钮倒计时
function count_down(str){
  var flag = str.val();
  if(flag == 1){    
    var n=9;
    str.html('剩余时间 '+n);
    str.val('0');
    var i = setInterval(function(){
      n--;
      str.html('剩余时间 '+n);
      if(n==0){
        str.html('重新获取');
        str.val('1');
        clearInterval(i);
      }
    },1000);
  }
}
// 注册会员
function register(){
  var mobile = $('#mobile').val();
  var passwd = $('#passwd').val();
  var captcha = $("#captcha").val();
  $.ajax({
    type: "POST",
    url: fx_regist,
    data: {'mobile':mobile,'passwd':passwd,'captcha':captcha},
    success: function(data){
      var data = eval("("+data+")");
      if(data.success){
        window.location.href = '<?php echo input::site("mobile/login/login"); ?>';
      }else{
        alert(data.msg);
      }
    }
  });
};
</script>
  </body>
</html>