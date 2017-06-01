
<form name="payform" id="payform" method="post" action="savePay" enctype="multipart/form-data">
            <div class="back_right">
            	<div class="right">
                    <h1>支付宝账户</h1>
                    <div class="export weix ">
                        <input type="hidden" name="payType" id="payType" value="alipay">
                        <!--
                    	<dl class="cf mab15">
                        	<dt><em class="asterisk">*</em>微信支付：</dt>
                            <dd><a class="weix_pay" href="#">去支付宝</a></dd> 
                            
                        </dl>-->
                        <dl class="cf mab15">
                        	<dt><em class="asterisk">*</em>支付宝支付：</dt>
                            <dd><input type="radio" name="status" value="1" <?php if($pay['status'] == 1){echo 'checked';} ?>/>开启&nbsp;&nbsp;&nbsp;</dd>
                            <dd><input type="radio" name="status" value="0" <?php if($pay['status'] == 0){echo 'checked';} ?>/>关闭</dd>
                        </dl>
                        <dl class="cf mab15">
                        	<dt><em class="asterisk">*</em>设为默认支付：</dt>
                            <dd><input type="radio" name="is_default" value="1" <?php if($pay['is_default'] == 1){echo 'checked';} ?>/>是&nbsp;&nbsp;&nbsp;</dd>
                            <dd><input type="radio" name="is_default" value="0" <?php if($pay['is_default'] == 0){echo 'checked';} ?>/>否</dd>
                        </dl>
                        <dl class="cf mar20">
                        	<dt><em class="asterisk">*</em>支付宝账号：</dt>
                            <dd>
                            	<p><input class="inp185" type="text" name="seller_email" id="seller_email" value="<?php echo $pay['seller_email'] ?>" /></p>
                            </dd>             	
                        </dl>
                        <dl class="cf mar20">
                        	<dt><em class="asterisk">*</em>支付宝账号姓名：</dt>
                            <dd>
                            	<p><input class="inp185" type="text" name="userName" id="userName" value="<?php echo $pay['userName'] ?>" /></p>
                            </dd>             	
                        </dl>
                        <dl class="cf mab15">
                        	<dt><em class="asterisk">*</em>PID：</dt>
                            <dd>
                            	<p><input class="inp185" type="text" name="partner" id="partner" value="<?php echo $pay['partner'] ?>" /></p>
                                <p>申请成功后获得</p>
                            </dd>             	
                        </dl>
                        <dl class="cf mab15">
                        	<dt><em class="asterisk">*</em>KEY：</dt>
                            <dd>
                            	<p><input class="inp185" type="text" name="key" id="key" value="<?php echo $pay['key'] ?>" /></p>
                                <p>申请成功后获得</p>
                            </dd>             	
                        </dl>
                        
                        <dl class="cf mab15">
                        	<dt><em class="asterisk">*</em>支付宝批量转账：</dt>
                            <dd>
                            	<p><input type="radio" name="batch_transfer" value="1" <?php if($pay['batch_transfer'] == 1){echo 'checked';} ?>/>开启&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="batch_transfer" value="0" <?php if($pay['batch_transfer'] == 0){echo 'checked';} ?>/>关闭</p>
                                <p>手工转账客户,请关闭此功能,，退款提现时，审核通过后，可以批量实现自动转账；开启前，请&nbsp;<a class="weix_pay" href="https://www.alipay.com/" target="_blank">去支付宝签约</a></p>
                           </dd>  
                        </dl>
                        <dl class="cf mab15">
                        	<dt><em class="asterisk">*</em>上传apiclient_key：</dt>
                            <dd class="">
                            	<p class="text"><input type="file" name="file_cert" id="file_cert" /><?php echo $pay['cacert'] ?></p>
                                <p>证书：登录商户平台——安全设置——API安全下载证书</p>
                            </dd>             	
                        </dl>
                       
                    </div>
                    <div class="add_mem mab15 cf "><a class="ma_left" href="javascript:" id="saveBtn">保存</a></div>
                </div>
            </form>

<!--遮罩层-->
<div class="mask_box" style="display:none"></div>



<script>
$(function(){
    //提交表单
    $("#saveBtn").click(function(){
        $("#payform").submit();
    });
	//分类标签
	$('.edit_title li').click(function(){
		var index=$('.edit_title li').index(this);
		$('.edit_title li').removeClass('curr');
		$('.edit_title b').show();
		$(this).addClass('curr').find('b').hide();
		$(this).prev().find('b').hide();
		$(".order_box2 ").hide().eq(index).show();	
	});	
	//全选
	$('.check_all').click(function(){
		var checked=$(this).is(':checked');
		$(this).parents('li').find('.next_box input[type=checkbox]').prop('checked',(checked ? 'checked' : false));	
	});
	
	//点击显示子类目
	$('.power li .h1 i').click(function(){
		var el=$(this).parents('li:first').find('.next_box').toggle();
		$(this)[el.is(':hidden') ? 'removeClass' : 'addClass']('i2');
	}).click().click();	
	//弹出框
	$('.qx_rder').click(function(){
		open_box('#up_hy3')	
	});
	$('.del_rder').click(function(){
		open_box('#up_hy2')	
	});
	//设置value值颜色
	$('.add_hy input').value('color','#000')

});


</script>
</body>
</html>