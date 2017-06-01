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
    	<div class="search_box">
        	<dl class="find">
            	<dt>历史搜索<a id="remove" href="javascript:del();"></a></dt>
                <dd id="keyword_list"></dd>
            </dl>
            <dl class="find hot">
            	<dt>热词搜索</dt>
                <dd>
                	<a href="#">喜洋洋拖鞋</a><a class="on" href="#">情侣人字拖</a><a href="#">沙滩鞋</a><a href="#">新婚红鞋</a><a href="#">居家老人保暖鞋</a><a href="#">新婚红鞋</a>
                    
                </dd>
            </dl>
        </div>
    	
    </div>
    
 </div>
 <script>
	$(function(){        
		$('.find dd a').on('touchstart',function(){
			$('.find dd a').removeClass('on');
			$(this).addClass('on');
		});
		$('#remove').on('touchstart',function(){
			$(this).parents('.find').css('display','none');
		});
	});

    // 显示查询记录
    (function(){
        $.post(fx_search_keyword,function(data){
            var data = eval("("+data+")");
            var arr  = data.info;
            var str  = '';
            if(data.success == 1){
                for (var i=0; i<arr.length; i++) {
                    str += '<a href="'+fx_showSearch+'?keyword='+arr[i].keyword+'">'+arr[i].keyword+'</a>';
                }
            }else{
                str = "还没有查询记录";
            }
            $("#keyword_list").append(str);
        });
    })();

    // 查询商品
    function search(){
        var keyword = $("#keyword").val();
        if(keyword == '' || keyword == null){
            alert("查询内容不为空");
            return false;
        }
        window.location.href = fx_showSearch+'?keyword='+keyword;
    }
    // 清空搜索记录
    function del(){
        if(confirm("确定清空搜索记录？")){
            $.post(fx_clearKeyword ,function(data){
                var data = eval("("+data+")");
                if(data.success==1){
                   window.location.reload()
                }else{
                    alert(data.msg);
                }
            })
        }
    }
 </script>
</body>  
</html>
