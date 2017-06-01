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
    <h2 class="text-center">登录</h2>
    <form>
      <div class="form-group">
        <label for="mobile">手机号</label>
        <input type="text" class="form-control" id="mobile" placeholder="手机号">
      </div>
      <div class="form-group">
        <label for="passwd">密码</label>
        <input type="email" class="form-control" id="passwd" placeholder="密码">
      </div>
      <button type="button" class="btn btn-info btn-block" onclick="checkLogin()">登录</button>
      <div class="form-group div-top">
        <div class="col-xs-6"><a href="javascript:regist();">注册</a></div>
        <div class="col-xs-6 text-right" ><a href="javascript:;">忘记密码</a></div>
      </div>
      <div class="form-group text-center div-tops">
        <img src="..." alt="..." class="img-rounded">
        <img src="..." alt="..." class="img-circle">
        <img src="..." alt="..." class="img-thumbnail">
      </div>
    </form>
<style type="text/css">
  form{
    padding: 10px 10px 0px 10px;
  }
  form>.div-top{
    margin-top: 10px;
  }
  form>.div-tops{
    margin-top: 80px;
  }
</style>
<script type="text/javascript">
function checkLogin(){
  var mobile = $('#mobile').val();
  var passwd = $('#passwd').val();

  $.ajax({
    type: "POST",
    url: fx_login,
    data: {'mobile':mobile,'passwd':passwd},
    success: function(data){
      var data = eval("("+data+")");
      if(data.success){
        window.location.href = '<?php echo input::site("mobile/goods/index"); ?>';
      }else{
        alert(data.msg);
      }
    }
  });
};
function regist(){
  window.location.href='<?php echo input::site("mobile/login/regist"); ?>';
}
</script>
  </body>
</html>