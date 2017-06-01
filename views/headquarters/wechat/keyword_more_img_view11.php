<link href="<?php echo input::cssUrl('tworel.css');?>" rel="stylesheet" type="text/css" />
<link href="<?php echo input::cssUrl('rqmd.css');?>" rel="stylesheet" type="text/css" />
<form name="moreImgForm" id="moreImgForm" method="post" action="">
            <div class="back_right" style="width:960px; position:relative">
                <div class="gzshf cf">
                    <div class="toubiaoti">多图文回复关键字编辑</div>
                    <div class="hf_input">
                        <label>关键词：</label>
                        &nbsp;&nbsp;<input type="text" name="keyword" id="keyword" placeholder=" 红酒 白酒 葡萄酒 黄酒 联系电话 客服 种类 运费 快递 上门"/>&nbsp; 多个关键词请用空格隔开，例如：红酒 白酒
                    </div>
                    <div class="hf_chekebox xg_chekebox">
                        <label>匹配规则：</label>
                        &nbsp;&nbsp;<input type="checkbox" name="matchRule" id="matchRule" value="0" />&nbsp; 完全匹配，用户输入的和此关键词一样才会匹配！
                    </div>       
                </div>
               
                <div class="gz_radio3">
                    <div class="opatx_box2">
                        <p class="gz_radio2_p">标题</p>
                        <a href="#"><img style="display:none" src="<?php echo input::imgUrl('fmtp_03.png'); ?>" width="320" height="135"/><img src="<?php echo input::imgUrl('wfxtp_03.png'); ?>" width="320" height="135"/></a>
                        <div class="tw_opat" style="display:none">
                            <span class="back_tw"></span>
                            <i></i>
                        </div>
                    </div>
                    <div class="gz_radio3slt">
                        <div class="opatx_box2">
                            <p class="gz_sltbt">标题</p>
                            <a href="#"><img class="gz_sltp" src="<?php echo input::imgUrl('slt_03.png'); ?>"width="80"height="80"/></a>
                            <div class="tw_opat tw_opat2" style="display:none">
                                <span class="back_tw"></span>
                                <i></i><em></em>
                            </div>
                         </div>
                    </div>
                    <div class="gz_radio3slt">
                        <div class="opatx_box2">
                            <p class="gz_sltbt">标题</p>
                            <a href="#"><img class="gz_sltp" src="<?php echo input::imgUrl('slt_03.png'); ?>"width="80"height="80"/></a>
                            <div class="tw_opat tw_opat2" style="display:none">
                                <span class="back_tw"></span>
                                <i></i><em></em>
                            </div>
                         </div>
                    </div>
                   <div class="tadd_btn"><a href="#"></a></div>
                </div>
                
            </div>
</form>



<script>
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
	$('.gz_radio3slt').hover(function(){
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

	// 编辑
	/*$('.gz_radio3 .opatx_box2').click(function(){
		var el = $(this),
			offset = el.offset();
		offset.left += el.width();
		offset.marginTop = '0px';
		$('.radio2_gz1').css(offset).appendTo('body');
	});*/
	
	// 增加
	$('.tadd_btn').click(function(){
		var el = $('.gz_radio3 .gz_radio3slt').eq(-1),
			newel = el.clone(true);
		el.after(newel);
		return false;
	});


	
});

	
	

</script>
