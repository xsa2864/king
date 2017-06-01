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
    <div class="container">
    <?php 
    foreach ($goodsList as $key => $value) {
      $pic = empty($value->mainPic) ? 'library/admin/images/slt_03.png':$value->mainPic; 
    ?>
    <div class="col-xs-6">      
    <a href="<?php echo input::site('mobile/goods/goodsDetail?id='.$value->id);?>">
      <img src="<?php echo input::site($pic);?>" class="img-responsive" width="100%"> 
      <p class="text-center text-warning"><?php echo $value->title;?></p>    
    </a>              
    </div>
    <?php 
    }
    ?>
    </div>
  </body>
</html>