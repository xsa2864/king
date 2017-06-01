<link href="<?php echo input::cssUrl('tworel.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo input::jsUrl('webuploader.js');?>"></script>
<link type="text/css" href="<?php echo input::cssUrl('webuploader.css');?>" rel="stylesheet" />

<form name="txtReplFrom" id="txtReplFrom" method="post" action="<?php echo input::site('admin/wechat/saveAttention'); ?>">
<div class="back_right" style="width:960px">
    <input type="hidden" name="att" id="att" value="<?php echo $att ?>">
                <div class="gzshf">
                    <div class="toubiaoti">关注时回复</div>
                    <div class="gz_radio">
                            <label>启动设置：</label>
                            <input  type="radio" name="radio" class="gz_radio_a" <?php if($att == 1){echo 'checked';} ?> onchange="window.location.href='<?php echo input::site('admin/wechat/attention/1'); ?>'" />&nbsp;&nbsp;文字模式：用户关注时会以文字模式向用户回复<br/>
                            <input type="radio" name="radio" class="gz_radio_b gz_radio_bb" <?php if($att == 2){echo 'checked';} ?> onchange="window.location.href='<?php echo input::site('admin/wechat/attention/2'); ?>'" /> &nbsp;&nbsp;单图文模式：用户关注时会以单图文模式向用户回复<br/>
                            <input type="radio" name="radio" class="gz_radio_c" <?php if($att == 3){echo 'checked';} ?> onchange="window.location.href='<?php echo input::site('admin/wechat/attention/3'); ?>'" /> &nbsp;&nbsp;多图文模式：用户关注时会以多图文模式向用户回复
                    </div>
                    <div class="cf">
                    	<div class="gz_radio2">
                            <div class="opatx_box2">
                             	<p class="gz_radio2_p" id="titleP"><?php if($info->title == ''){echo '标题';}else{echo $info->title;} ?></p>
                            	<a href="#">
                                    <img style="display:none" src="<?php echo input::imgUrl('fmtp_03.png'); ?>" width="320" height="135"/>

                                    <img id="titleImgSrc" src="<?php if($info->coverImg == ''){ echo input::imgUrl('fmtp_03.png');}else{echo $info->coverImg;}  ?>" width="320" height="135"/>
                                </a>
                                <input type="hidden" name="coverImg" id="coverImg" value="<?php echo $info->coverImg ?>">
                                <div class="tw_opat" style="display:none">
                                	<span class="back_tw"></span>
                                    <i></i>
                                </div>
                            </div>
                            <div class="gz_radio2wz">
                                <p id="contentP"><?php if($info->brief == ''){echo '摘要';}else{echo $info->brief;} ?></p>
                        	</div>
                    </div>
                    	<div class="radio2_gz">
                            <div class="xsjimg"><img src="<?php echo input::imgUrl('xsj_03.png'); ?>"width="11"height="14"/></div>
                            <div><p class="radio2_gz_p">标题</p></div>
                            <div class="radio2_gz_input">
                                    <p class="gzppp" style="display: none;">0/64</p>
                                    <input type="text" name="title" id="title" oninput="if(this.value != ''){$('#titleP').html(this.value)}else{$('#titleP').html('标题')}" value="<?php echo $info->title ?>"/>
                            </div>
                            <div class="radio2_gz3">
                                    <label>封面</label><span> ( 大图片建议尺寸：900像素 * 500像素)</span>
                            </div>
                            <div class="radio2_gza"><a href="javascript:" onclick="useImg();">上传图片</a></div>
                            <div class="radio2_gz4">
                                    <input type="checkbox" name="displayCover" id="displayCover" <?php if($info->displayCover == 1){echo 'checked';} ?> value="1">&nbsp; 封面图片显示在正文中</input>
                            </div>
                            <div><p class="radio2_gz_p1">摘要</p></div>
                            <div class="radio2_gzarea">
                                    <textarea name="brief" id="brief" oninput="if(this.value != ''){$('#contentP').html(this.value)}else{$('#contentP').html('摘要')}" ><?php echo $info->brief; ?></textarea>
                            </div>
                            <div><p class="gz123gz" style="display: none;">0/120</p></div>
                            <div><p class="radio2_gz_p2">正文</p></div>
                            <div class="radio2_gz5">
                                    <input type="radio" name="isLink" <?php if($info->isLink == 1){echo 'checked';} ?> value="1" >&nbsp; 连接地址 <span> （设置后链接将指向此地址）</span>
                            </div>
                            <div class="radio2_gz_input"><input type="text" name="contentLink" id="contentLink" value="<?php echo $info->contentLink; ?>"/></div>
                            <div class="radio2_gz5">
                                    <input type="radio" name="isLink"  <?php if($info->isLink == 0 || !isset($info->isLink)){echo 'checked';} ?> value="0">&nbsp; 内容编辑
                            </div>
                            <div class="radio2_gzimg" >
                                <textarea id="itemContent" class="form-control" style="width: 579px; height: 300px" name="content"><?php echo $info->content; ?></textarea>
                            </div>
                     </div>
                    </div>
                    <div class="gz_submit"><a href="javascript:" id="saveHref">保存</a></div>
                </div>

                
            </div>
    </form>



<script>
    /*
$(function(){
	//分类标签
	$('.edit_title li').click(function(){
		var index=$('.edit_title li').index(this);
		$('.edit_title li').removeClass('curr');
		$('.edit_title b').show();
		$(this).addClass('curr').find('b').hide();
		$(this).prev().find('b').hide();
		$(".table_box table").hide().eq(index).show();	
	});	
	//移动到显示
	$('.revise h1').hover(function(){
		$(this).parents('.revise').find('.revise_pop').toggle();
		return false;
		
	},function(){
		$(this).parents('.revise').find('.revise_pop').toggle();		
		return false;
	});
	//文本框颜色
	$("input").focus(function(){
		$(this).css({'border-color':'#148cd7'})
	});
	$("input").blur(function(){
		$(this).css({'border-color':'#b7b7b7'})
	});
	$("textarea").focus(function(){
		$(this).css({'border-color':'#148cd7'})
	});
	$("textarea").blur(function(){
		$(this).css({'border-color':'#b7b7b7'})
	});
	//移动到显示编辑
	$('.opatx_box2').hover(function(){
		$(this).find('.tw_opat').show();	
	},function(){
		$(this).find('.tw_opat').hide();	
	});
	//编辑点击下去的样式
	$('.tw_opat i').mousedown(function(){
		$(this).addClass('i2');		
	});
	$('.tw_opat i').mouseup(function(){
		$(this).removeClass('i2');		
	});
	$('.tw_opat2 em').mousedown(function(){
		$(this).addClass('em2');		
	});
	$('.tw_opat2 em').mouseup(function(){
		$(this).removeClass('em2');		
	});


	
});	*/

    function useImg() {
        open_box('#useImg_view');
        $('#useImg_view').attr('modid', "0");
    }
function getImg(){
    var src = $(this).parents('li:first').find('img').attr('src');
    var modid = $('#useImg_view').attr('modid');
    $('.ze_box').each(function () {
        if ($(this).attr('style') == 'display: block;' || $(this).attr('style') == '') {
            var src = $(this).parents('li:first').find('img').attr('src');
            var srclist = src.split('_');
            var nsrc = srclist[0] + '.' + srclist[1].split('.')[1];
            $("#titleImgSrc").attr('src',nsrc);
            $("#coverImg").val(nsrc);
          //  editor.insertHtml('<img src="' + nsrc + '">');
          //  re = true;
        }
    });
}

    $("#saveHref").click(function(){
        $("#itemContent").val(editor.html());
        //信息验证
        if($("#title").val() == ''){
            alert('请输入标题');
            return false;
        }
        if($("#coverImg").val() == ''){
            alert('请上传封面图片');
            return false;
        }
        if($("#brief").val() == ''){
            alert('请输入摘要信息');
            return false;
        }
        if($("#contentLink").val() == '' && $("#itemContent").val() == ''){
            alert('请输入内容信息');
            return false;
        }
        $.ajax({
            type: 'post',
            url: '<?php echo input::site('admin/wechat/saveAttention') ?>',
            cache: false,
            data:$("#txtReplFrom").serialize(),
            dataType: 'json',
            success: function (data) {
                alert(data);
            },
            error: function () {
            }
        });
    });

</script>
