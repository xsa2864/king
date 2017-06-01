<link href="<?php echo input::cssUrl('tworel.css');?>" rel="stylesheet" type="text/css" />
<link href="<?php echo input::cssUrl('rqmd.css');?>" rel="stylesheet" type="text/css" />
<form name="txtFrom" id="txtFrom" method="post" action="saveTxtKeyword">
    <input type="hidden" name="id" id="id" value="">
            <div class="back_right" style="width:960px">
                <div class="gzshf">
						<div class="toubiaoti">添加文本回复关键词</div>
                        <div class="hf_input">
                    	<label>关键词：</label>
                        &nbsp;&nbsp;<input type="text" name="keyword" id="keyword" />&nbsp; 多个关键词请用,隔开，例如：红酒 白酒
                    	</div>
                    	<div class="hf_chekebox">
                    	<label>匹配规则：</label>
                        &nbsp;&nbsp;<input type="checkbox" name="matchRule" id="matchRule" value="0"/>&nbsp; 完全匹配，用户输入的和此关键词一样才会匹配！
                    	</div>
                    <div class="gz_zdhf gz_zdhf11">
                        <div class="hx_textarea">
                            <label>自动回复内容：</label>
                            <p>
                                <textarea name="content" id="content"></textarea>
                            </p>
                            <div class="gz_zhushi">
                                 <span>注：超链接添加形式，如：<img src="<?php echo input::imgUrl('baidu_03.png'); ?>"width="262"height="13"/></span>
                            </div>
                            </div>
                    </div>
                    <div class="cf">
                    	<div class="gz_submit"><a href="javascript:" onclick="txtSubmit();">保存</a></div>
                    	<div class="gz_esc"><a href="#">取消</a></div>
                    </div>
                
                </div>
            </div>
</form>
<div class="gz_zhqb" id="gz_anse">
<a href="#" ><img src="<?php echo input::imgUrl('tk_08.png'); ?>"width="12"height="11"/></a>
</div>



<script>
    function txtSubmit(){
        if($("#keyword").val() == ''){
            alert('请输入关键词');
            return false;
        }
        $("#content").val(editor.html());
        if($("#content").val() == ''){
            alert('请输入内容');
            return false;
        }
        $("#txtFrom").submit();
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


</body>
</html>
