<link href="<?php echo input::cssUrl('tworel.css');?>" rel="stylesheet" type="text/css" />
<form name="wechatForm" id="wechatForm" method="post" action="">
            <div class="back_right" style="width:960px">
  						<div class="bdwxhao">
                        			<div class="toubiaoti">绑定微信号</div>
                                    <div class="fubiaoti">提示：只有先行绑定公众账号，其他的微信设置才能生效。</div>
                        			<div class="wxinput_a">
                                    		<label><span class="asterisk">*</span>公众号名称：</label>
                                            <input type="text" name="name" id="name" value="<?php echo $wc['name'] ?>"/>
                                    </div>
                                    <div class="wxinput_b">
                                    		<label><span class="asterisk">*</span>公众微信号ID：</label>
                                            <input type="text" id="id" name="id" value="<?php echo $wc['id'] ?>"/> &nbsp;请认真填写。如：gh_asdfadfafasf2
                        			</div>
                                    <div class="wxinput_c">
                                    		<label><span class="asterisk">*</span>微信号：</label>
                                            <input type="text" name="number" id="number" value="<?php echo $wc['number'] ?>" />
                                    </div>
                                    <div class="wxinput_d">
                                    		<label><span class="asterisk">*</span>appID：</label>
                                            <input type="text" name="appId" id="appId" value="<?php echo $wc['appId'] ?>" />
                                    </div>
                                    <div class="wxinput_e">
                                    		<label><span class="asterisk">*</span>appsecret：</label>
                                            <input type="text" name="appsecret" id="appsecret" value="<?php echo $wc['appsecret'] ?>" />
                                    </div>

                            <!--
                                    <div class="wxbutton">
                                    		<label>头像地址(URL)：</label><a href="#">上传头像</a>
                                            <p> 选择上传头像图片，建议大小200px*200px</p>
                                    </div>
                                    <div class="wxjiekou">
                                    		<label>接口地址：</label>
                                            <span>http://hao.360.cn/?wd_xp1</span> 
                                    </div>        
                        			<div class="wxtoken">
                                    		<label>TOKEN：</label>
                                            <span>676dd9</span>
                                    </div>
                                    -->
                                    <div class="wxemail">
                                    		<label>公众号邮箱：</label>
                                            <input type="text" name="email" id="email" value="<?php echo $wc['email'] ?>"/>
                                    </div>
                            <!--
                            <div class="wxinput_e">
                                <label><span class="asterisk">*</span>关注回复类型：</label>
                                <input type="radio" name="attentionDefault" value="1">文本回复
                                <input type="radio" name="attentionDefault" value="2">单图文回复
                                <input type="radio" name="attentionDefault" value="3">多图文回复
                            </div>
                            <div class="wxinput_e">
                                <label><span class="asterisk">*</span>关键词匹配类型：</label>
                                <input type="radio" name="matchRule" value="0">模糊匹配
                                <input type="radio" name="matchRule" value="1">完全匹配
                            </div>-->

                                    <div class="wxsubmit"><a href="javascript:" onclick="$('#wechatForm').submit();">保存</a></div>
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

	
});

	$("input").focus(function(){
		$(this).css({'border-color':'#148cd7'})
	});
	$("input").blur(function(){
		$(this).css({'border-color':'#b7b7b7'})
	});


</script>


</body>
</html>
