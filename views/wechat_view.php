<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>拓客共享商城</title>
    <meta content="" name="keywords" />
    <link href="<?php echo input::cssUrl("common.css",'wechat'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo input::cssUrl("tokers.css",'wechat'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo input::cssUrl("box.css",'wechat'); ?>" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?php echo input::jsUrl("jquery-1.10.1.min.js",'wechat'); ?>"></script>
    <script type="text/javascript" src="<?php echo input::jsUrl("touchslideimg.js",'wechat'); ?>"></script>
    <script type="text/javascript" src="http://3gimg.qq.com/lightmap/components/geolocation/geolocation.min.js"></script>
    <script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script type="text/javascript" src="<?php echo input::jsUrl("geolocal.js",'wechat'); ?>"></script>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    <meta content="application/xhtml+xml;charset=UTF-8" http-equiv="Content-Type">
    <meta content="no-cache,must-revalidate" http-equiv="Cache-Control">
    <meta content="no-cache" http-equiv="pragma">
    <meta content="0" http-equiv="expires">
    <meta content="telephone=no, address=no" name="format-detection">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <script type="text/javascript">  
    function onBridgeReady(){
        wx.hideOptionMenu();
    }

    if (typeof WeixinJSBridge == "undefined"){
        if( document.addEventListener ){
            document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
        }else if (document.attachEvent){
            document.attachEvent('WeixinJSBridgeReady', onBridgeReady); 
            document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
        }
    }else{
        onBridgeReady();
    }

    function getConfig(){        
        wxConfig("<?php echo $appId;?>", "<?php echo $timestamp;?>", "<?php echo $noncestr;?>", "<?php echo $signature;?>");  
    } 
    var i = setTimeout(getConfig,100);
    

    </script>
</head>
<body>
<img src='http://tok.uszhzh.com/library/wechat/images/zhzh_logo.jpg' height="0" width="0">
    <div class="box <?php echo $bgcss;?>">
        <?php echo $content;?>
    </div>
    <script>     
        wx.ready(function () {
            wx.checkJsApi({
                jsApiList: ['onMenuShareAppMessage','onMenuShareQQ'], // 需要检测的JS接口列表，所有JS接口列表见附录2,
                success: function(res) {
                    if(res.checkResult.onMenuShareAppMessage){
                        wx.showOptionMenu();
                        getConfig();
                    }
                    // 以键值对的形式返回，可用的api值true，不可用为false
                    // 如：{"checkResult":{"chooseImage":true},"errMsg":"checkJsApi:ok"}
                }
            });
            share(<?php echo $shareParam;?>);     
            

        });
        
    </script>
</body>
</html>
