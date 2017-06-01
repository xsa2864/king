<!DOCTYPE html>
<html><head>
	<meta charset="utf-8">
	<title>收藏夹</title>
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
	<header class="header buys pad0">
        <div class="favorites">
            <p><a class="return" href="javascript:history.go(-1);"><i></i>收藏夹</a></p>
            <span class="edit del"></span>
        </div>
    </header>
    <div class="container pad2">
        <div class="commodity_list mar1">
        	<!-- 显示收藏内容 -->
        </div>
        <dl class="checkbox_btn none tb">
            <dt><span class="input_click"><input type="checkbox" class="checkbox selectall"><font>全选</font></span></dt>
            <dd class="flex_1">
                <p class="tb collection">
                    <a class="flex_1" href="#">取消收藏</a>
                </p>
            </dd>
        </dl>
    </div>
    <div class="container pad1" style="display:none;">
        <div class="no_commodity back_img">
            <p>您还没收藏过任何宝贝~</p>
        </div>
    </div>
 </div>
 <!-- 遮罩层 -->
 <div  class="mask_box" style="display:none"></div>
 <!-- 弹出框 -->
 <div  class="up up_box" id="up_box1" style="display:none">
 	<div class="up_cen">
    	<h1>您真的不再收藏我吗？::>_<::</h1>
        <h2 class="up_btn tb">
        	<a class="flex_1 close" href="javascript:del()">确认</a>
            <a class="flex_1 close" href="#">取消</a>
        </h2>
    </div>
 
 </div>
<script>
	$(function(){
		$('.edit.del').on('touchstart',function(){
			if($(this).text()=='完成'){
				$('.title').removeClass('d3');
				$(this).removeClass('banone').html('');
				$('.checkbox_btn').addClass('none').removeClass('btn_bottom');
			}else{
				$('.title').addClass('d3');
				$(this).addClass('banone').html('完成');
				$('.checkbox_btn').addClass('btn_bottom').removeClass('none');
			}
		});
		$('.up_btn a').on('touchstart',function(){
			$('.up_btn a').removeClass('on');
			$(this).addClass('on');
		});
		$(document).on('touchend',function(){
			$('.up_btn a').removeClass('on');
		});
		$('.collection a').on('touchstart',function(){
			open_box('#up_box1')	
		});
		
	});
    (function(){
        $.post(fx_get_collection,function(data){
            var data = eval("("+data+")");
            var str = '';
            if(data.info == ''){
                $(".pad1").attr("style","display:block");
                $(".pad2").attr("style","display:none");                
            }else{
                $(".pad1").attr("style","display:none");
                $(".pad2").attr("style","display:block");
                var info = data.info;
                for (var i=0; i<info.length; i++) {
                    var pic = fx_prefix+info[i].mainPic;
                    str += '<div class="title">';
                    str += '    <input type="checkbox" class="checkbox none" value='+info[i].id+'>';
                    str += '    <dl class="list_dl d4 tb" >';
                    str += '        <dt ><img src='+pic+'></dt>';
                    str += '        <dd class="flex_1 ">';
                    str += '            <h1>'+info[i].title+'</h1>';
                    str += '            <div class="list_text">';
                    str += '                <h3 class="mar3"><font>￥</font>'+info[i].min_price+'<p>'+info[i].min_golds+'</p></h3>';
                    str += '            </div>';
                    str += '        </dd> ';
                    str += '    </dl>';
                    str += '</div>';
                }
                $(".commodity_list").append(str);
            }
        })
    })();
    // 删除收藏
    function del(){
        var id = '';
        $(".commodity_list [type=checkbox]:checked").each(function(n,e){
            if(id != ''){
                id += ',';
            }
            id += $(e).val();
        })
        $.post(fx_del_collection,{'id':id},function(data){
            var data = eval("("+data+")");
            if(data.success == 1){
                window.location.reload();
            }else{
                alert(data.msg);
            }
        })
    }
 </script>
</body>  
</html>
