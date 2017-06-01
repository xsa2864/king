<link href="<?php echo input::cssUrl('tworel.css');?>" rel="stylesheet" type="text/css" />
<form name="txtReplFrom" id="txtReplFrom" method="post" action="<?php echo input::site('admin/wechat/saveAttention'); ?>">
    <input type="hidden" name="att" id="att" value="<?php echo $att ?>">
            <div class="back_right" style="width:960px">
                <div class="gzshf">
                    <div class="toubiaoti">关注时回复</div>
                    <div class="gz_radio">
                            <label>启动设置：</label>
                            <input  type="radio" name="radio" class="gz_radio_a" <?php if($att == 1){echo 'checked';} ?> onchange="window.location.href='<?php echo input::site('admin/wechat/attention/1'); ?>'" />&nbsp;&nbsp;文字模式：用户关注时会以文字模式向用户回复<br/>
                            <input type="radio" name="radio" class="gz_radio_b gz_radio_bb" <?php if($att == 2){echo 'checked';} ?> onchange="window.location.href='<?php echo input::site('admin/wechat/attention/2'); ?>'" /> &nbsp;&nbsp;单图文模式：用户关注时会以单图文模式向用户回复<br/>
                            <input type="radio" name="radio" class="gz_radio_c" <?php if($att == 3){echo 'checked';} ?> onchange="window.location.href='<?php echo input::site('admin/wechat/attention/3'); ?>'" /> &nbsp;&nbsp;多图文模式：用户关注时会以多图文模式向用户回复
                    </div>
                    <div class="gz_zdhf">
                         <!--   <label>自动回复内容：</label>-->
                            <textarea name="contentWechat" id="contentWechat" ><?php echo $info->content; ?></textarea>
                            <div class="gz_zhushi">
                                 <span>注：必填，用户关注您的公众账号时自动回复语</span>
                            </div>
                    </div>
                    <div class="gz_submit"><a href="javascript:" onclick="formSubmit();">保存</a></div>


                </div>
            </div>
</form>



<script>
    function formSubmit(){
      //  $('#txtReplFrom').submit();
        //$("#contentWechat").val(editor.html());
        if($("#contentWechat").val() == ''){
            alert('请输入内容');
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
    }
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


	
});
*/
	
	

</script>


</body>
</html>
