<link href="<?php echo input::cssUrl('tworel.css');?>" rel="stylesheet" type="text/css" />
<link href="<?php echo input::cssUrl('rqmd.css');?>" rel="stylesheet" type="text/css" />
<form name="singRForm" id="singRForm" method="post" action="saveSingleImgKeyword">
    <input type="hidden" name="id" id="id" value="">
            <div class="back_right" style="width:960px">
                    <div class="gzshf">
                            <div class="toubiaoti">单图文回复关键字编辑</div>
                            <div class="hf_input">
                            <label>关键词：</label>
                            &nbsp;&nbsp;<input type="text" name="keyword" id="keyword"  placeholder=" 红酒 白酒 葡萄酒 黄酒 联系电话 客服 种类 运费 快递 上门"/>&nbsp; 多个关键词请用空格隔开，例如：红酒 白酒
                            </div>
                            <div class="hf_chekebox xg_chekebox">
                            <label>匹配规则：</label>
                            &nbsp;&nbsp;<input type="checkbox" name="matchRule" id="matchRule" value="0" />&nbsp; 完全匹配，用户输入的和此关键词一样才会匹配！
                            </div>
                                <div class="cf">
                                    <div class="gz_radio2">
                                            <div class="opatx_box2">
                                                <p class="gz_radio2_p" id="gz_radio2_pId">标题</p>
                                                <a href="#"><img style="display:none" src="<?php echo input::imgUrl('wfxtp_03.png'); ?>" width="320" height="135"/>
                                                    <img id="titleImgSrc" src="<?php echo input::imgUrl('fmtp_03.png'); ?>" width="320" height="135"/></a>
                                                <div class="tw_opat" style="display:none">
                                                    <span class="back_tw"></span>
                                                    <i></i>
                                                </div>
                                            </div>
                                            <div class="gz_radio2wz" id="gz_radio2wzId">
                                               摘要
                                            </div>
                            
                                    </div>
                                        <div class="radio2_gz">
                                            <div class="xsjimg"><img src="<?php echo input::imgUrl('xsj_03.png'); ?>"width="11"height="14"/></div>
                                            <div><p class="radio2_gz_p">标题</p></div>
                                            <div class="radio2_gz_input">

                                                    <input type="text" name="title" id="title" oninput="if(this.value == ''){$('#gz_radio2_pId').html('标题')}else{$('#gz_radio2_pId').html(this.value)}" value="" placeholder="标题"/>
                                            </div>
                                            <div class="radio2_gz3">
                                                <input type="hidden" name="coverImg" id="coverImg" value="">
                                                    <label>封面</label><span> ( 大图片建议尺寸：900像素 * 500像素)</span>
                                            </div>
                                            <div class="radio2_gza"><a href="javascript:" onclick="useImg();">上传图片</a></div>
                                            <div class="radio2_gz4">
                                                    <input type="checkbox" name="displayCover" id="displayCover" value="1">&nbsp; 封面图片显示在正文中</input>
                                            </div>
                                            <div><p class="radio2_gz_p1">摘要</p></div>
                                            <div class="radio2_gzarea">
                                                    <textarea name="brief" oninput="if(this.value == ''){$('#gz_radio2wzId').html('摘要')}else{$('#gz_radio2wzId').html(this.value)}" id="brief" placeholder="信息摘要"></textarea>
                                            </div>

                                            <div><p class="radio2_gz_p2">正文</p></div>
                                            <div class="radio2_gz5">
                                                    <input type="radio" name="isLink" value="1">&nbsp; 连接地址 <span> （设置后链接将指向此地址）</span></input>
                                            </div>
                                            <div class="radio2_gz_input"><input type="text" id="contentLink" name="contentLink" placeholder="http://hao.360.cn/?wd_xp1"/></div>
                                            <div class="radio2_gz5">
                                                    <input type="radio" name="isLink" value="0" checked>&nbsp; 内容编辑</input>
                                            </div>
                                            <div class="radio2_gzimg">
                                                <textarea id="itemContent" class="form-control" style="width: 579px; height: 300px" name="content"><?php echo $info->content; ?></textarea>
                                            </div>
                                     </div>
                            </div>
                                    <div class="cf">
                                        <div class="gz_submit"><a href="javascript:" onclick="formSubmit();">保存</a></div>
                                        <div class="gz_esc"><a href="#">取消</a></div>
                                    </div>
                    </div>

                
            </div>

</form>
<div class="gz_zhqb" id="gz_anse">
<a href="#" ><img src="<?php echo input::imgUrl('tk_08.png'); ?>"width="12"height="11"/></a>
</div>



<script>
function formSubmit(){
    if($("#keyword").val() == ''){
        alert('请输入关键词');
        return false;
    }
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
    $("#itemContent").val(editor.html());
    $("#singRForm").submit();
}

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


	
});

	
	

</script>

