<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>众合分销</title>
    <meta content="" name="keywords" />
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    <meta content="application/xhtml+xml;charset=UTF-8" http-equiv="Content-Type">
    <meta content="no-cache,must-revalidate" http-equiv="Cache-Control">
    <meta content="no-cache" http-equiv="pragma">
    <meta content="0" http-equiv="expires">
    <meta content="telephone=no, address=no" name="format-detection">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <link href="<?php echo input::cssUrl("common.css",'mobile'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo input::cssUrl("box.css",'mobile'); ?>" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?php echo input::site("library/mobile/js/jquery-1.10.1.min.js"); ?>"></script>
    <script type="text/javascript" src="<?php echo input::site("library/mobile/js/touchslideimg.js"); ?>"></script>
    <script type="text/javascript" src="<?php echo input::site("library/mobile/js/base.js"); ?>"></script>
</head>
<body>
    <div class="box">
        <?php echo $content;?>
        <?php if(!$hideFooter) {?>
        <footer class="footer">
            <ul class="tb">
                <li class="flex_1<?php echo $currentCount=='1'?' on':'';?>">
                    <a href="<?php echo input::site();?>" ><em></em><i>首页</i></a>
                </li>
                <li class="flex_1<?php echo $currentCount=='2'?' on':'';?>">
                    <a href="<?php echo input::site('mobile/order/show_cart');?>" ><em></em><i>购物车</i></a>
                </li>
                <li class="flex_1<?php echo $currentCount=='3'?' on':'';?>">
                    <a href="#" ><em></em><i>订单</i></a>
                </li>
                <li class="flex_1<?php echo $currentCount=='4'?' on':'';?>">
                    <a href="<?php echo input::site('mobile/member/member_center');?>" ><em></em><i>我的</i></a>
                </li>
            </ul>
        </footer>
        <?php } ?>
    </div>
    <?php echo $masklayer; ?>
</body>
</html>
