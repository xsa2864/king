<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>地址列表</title>

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
  <ul class="list-group">
  </ul>
  <button type="button" class="btn btn-info btn-block" id="add">添加地址</button>

<script type="text/javascript">
// 获取地址列表
(function(){
  $.post(fx_addressList,function(data){
    var data = eval("("+data+")");
    console.log(data);
    var str_li = '';
    if(data.success == 1){
      if(data.info.length != 0){
        for (var i=0;i<data.info.length;i++){
          str_li += '<li class="list-group-item">     ';
          str_li += '  <div class="alert alert-info"> ';
          str_li += '<p>'+data.info[i].consignee+':'+data.info[i].mobile+'</p>';
          str_li += '<p>'+data.info[i].local+data.info[i].address+'</p>';
          str_li += '  </div>                         ';
          str_li += '</li>                            ';
        }        
      }
    }else{
      str_li += '<li class="list-group-item">     ';
      str_li += '  <div class="alert alert-info"> ';
      str_li += '     <p>暂无地址记录</p>         ';
      str_li += '  </div>                         ';
      str_li += '</li>                            ';  
    }
    $('.list-group').append(str_li);
  })
})();

$("#add").click(function (){
  window.location.href='<?php echo input::site("mobile/member/add"); ?>';
})
</script>
  </body>
</html>