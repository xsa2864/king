<!DOCTYPE html>
<html><head>
	<meta charset="utf-8">
	<title>搜索</title>
	<meta content="" name="keywords"/>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
	<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    <meta content="application/xhtml+xml;charset=UTF-8" http-equiv="Content-Type">
    <meta content="no-cache,must-revalidate" http-equiv="Cache-Control">
    <meta content="no-cache" http-equiv="pragma">
    <meta content="0" http-equiv="expires">
    <meta content="telephone=no, address=no" name="format-detection">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link href="<?php echo input::site("library/mobile/css/common.css"); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo input::site("library/mobile/css/box.css"); ?>" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?php echo input::site("library/mobile/js/jquery-1.10.1.min.js"); ?>"></script>
    <script type="text/javascript" src="<?php echo input::site("library/mobile/js/touchslideimg.js"); ?>"></script>
    <script type="text/javascript" src="<?php echo input::site("library/mobile/js/base.js"); ?>"></script>
</head>
<body>
<div class="box">
	<header class="header">
    	<a class="return" href="javascript:history.go(-1);"><i></i></a>
        <p><input type="text" placeholder="输入关键词" id="keyword"/>
        <a class="ser" href="javascript:search();">搜索</a></p>
    </header>
    <div class="container pad1">
    	<ul class="search_nav tb">
        	<li class="flex_1 on"><a href="#">综合</a></li>
            <li class="flex_1"><a href="#">销量</a></li>
            <li class="flex_1"><a href="#">新品</a></li>
            <li class="flex_1 "><a href="#">价格<i></i></a></li>
            <li class="flex_1"><a href="#">金币<i class="i2"></i></a></li> <!-- class‘i2’ -->
        </ul>
        <p class="commodity_text"></p>
        <div class="commodity_list">        	
            <h5>没有更多商品啦~</h5>
        </div>
        <div class="no_commodity">
            <p>抱歉没有找到相关商品</p>
        </div>
    </div>
    
 </div>
<script>
	$(function(){
		$('.search_nav li').on('touchstart',function(){
			$('.search_nav li').removeClass('on');
			$(this).addClass('on');
		});
	
	});
    (function() {
        var str = decodeURI(location.search);
        var arr = str.split('=');
        var keyword = arr['1'];
        $("#keyword").val(keyword);
        $.post(fx_search, {
            'keyword': keyword
        }, function(data) {
            var data = eval('(' + data + ')');
            var arr = data.info;
            var str = '';
            var i = 0
            if (data.success == 1) {
                for (; i < arr.length; i++) {
                    var min_price = arr[i].min_price != null ? arr[i].min_price : '0.00'; 
                    var min_golds = arr[i].min_golds != null ? arr[i].min_golds : '0.00'; 
                    var total_num = arr[i].total_num != null ? arr[i].total_num : '0.00'; 
                    str += '<dl class="list_dl tb">                                          ';
                    str += '    <dt ><img src="' + fx_prefix + arr[i].mainPic + '"/></dt>    ';
                    str += '    <dd class="flex_1">                                          ';
                    str += '        <h1>' + arr[i].title + '</h1>                            ';
                    str += '        <div class="list_text">                                  ';
                    str += ' <h3><font>￥</font>' + min_price + '<p>' + min_golds + '</p></h3>';
                    str += '            <h4>已售 ' + total_num + '</4>    ';
                    str += '        </div>                                                   ';
                    str += '    </dd>                                                        ';
                    str += '</dl>                                                            ';
                }
                $(".commodity_list").show();
                $(".no_commodity").hide();
                $('.commodity_text').html('共为您搜索到'+i+'件商品');
            } else {
                $(".commodity_list").hide();
                $(".no_commodity").show();
                $('.commodity_text').html('共为您搜索到 0 件商品');
            }
            $(".commodity_list").before(str);
        });
    })();
    // 查询商品
    function search(){
        var keyword = $("#keyword").val();
        if(keyword == '' || keyword == null){
            alert("查询内容不为空");
            return false;
        }
        window.location.href = encodeURI(fx_showSearch+'?keyword='+keyword);
    }
 </script>
</body>  
</html>
