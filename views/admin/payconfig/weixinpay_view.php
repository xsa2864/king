
            <form name="payform" id="payform" method="post" action="savePay" enctype="multipart/form-data">
                <input type="hidden" name="payType" id="payType" value="weixinpay">
            <div class="back_right">
            	<div class="right">
                    <h1>微信收款</h1>
                    <div class="export weix">
                    	<dl class="cf mab15">
                        	<dt><em class="asterisk">*</em>微信支付：</dt>
                            <dd><input type="radio" name="status" value="1" <?php if($pay['status'] == 1){echo 'checked';} ?>/>开启&nbsp;&nbsp;&nbsp;</dd>
                            <dd><input type="radio" name="status" value="0" <?php if($pay['status'] == 0){echo 'checked';} ?>/>关闭</dd>
                        </dl>
                        <dl class="cf mab15">
                        	<dt><em class="asterisk">*</em>设为默认：</dt>
                            <dd><input type="radio" name="is_default" value="1" <?php if($pay['is_default'] == 1){echo 'checked';} ?>/>是&nbsp;&nbsp;&nbsp;</dd>
                            <dd><input type="radio" name="is_default" value="0" <?php if($pay['is_default'] == 0){echo 'checked';} ?>/>否</dd>
                        </dl>
                        <dl class="cf mab15">
                        	<dt><em class="asterisk">*</em>是否为财付通：</dt>
                            <dd><input type="radio" name="tenpay" value="1" <?php if($pay['tenpay'] == 1){echo 'checked';} ?> />是&nbsp;&nbsp;&nbsp;</dd>
                            <dd><input type="radio" name="tenpay" value="0" <?php if($pay['tenpay'] == 0){echo 'checked';} ?> />否</dd>
                        </dl>
                        <dl class="cf mab15">
                        	<dt><em class="asterisk">*</em>APPID：</dt>
                            <dd>
                            	<p><input class="inp185" type="text" name="app_id" id="app_id" value="<?php echo $pay['app_id'] ?>" /></p>
                                <p>微信公众号身份唯一标识</p>
                            </dd>             	
                        </dl>
                        <dl class="cf mab15">
                        	<dt><em class="asterisk">*</em>APPSECRET：</dt>
                            <dd>
                            	<p><input class="inp185" type="text" name="app_secret" id="app_secret" value="<?php echo $pay['app_secret'] ?>" /></p>
                                <p>审核后在公众平台开启开发模式后可查看</p>
                            </dd>             	
                        </dl>
                        <dl class="cf mab15">
                        	<dt><em class="asterisk">*</em>MCHID：</dt>
                            <dd>
                            	<p><input class="inp185" type="text" name="mchid" id="mchid"  value="<?php echo $pay['mchid'] ?>" /></p>
                                <p>微信支付商户号</p>
                            </dd>             	
                        </dl>
                        <dl class="cf mab15">
                        	<dt><em class="asterisk">*</em>KEY：</dt>
                            <dd>
                            	<p><input class="inp185" type="text" name="key" id="key" value="<?php echo $pay['key'] ?>" /></p>
                                <p>商户支付密钥KEY</p>
                            </dd>             	
                        </dl>
                        <dl class="cf mab15">
                        	<dt><em class="asterisk">*</em>PAYSIGNKEY：</dt>
                            <dd>
                            	<p><input class="inp185" type="text" name="paysignkey" id="paysignkey" value="<?php echo $pay['paysignkey'] ?>" /></p>
                                <p>财付通商户专用签名串</p>
                            </dd>             	
                        </dl>
                        <dl class="cf mab15">
                        	<dt><em class="asterisk">*</em>微信支付批量转账：</dt>
                            <dd>
                                <p><input type="radio" name="batch_transfer" value="1" <?php if($pay['batch_transfer'] == 1){echo 'checked';} ?>/>开启&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="batch_transfer" value="0" <?php if($pay['batch_transfer'] == 0){echo 'checked';} ?>/>关闭</p>
                                <p>手工转账客户,请关闭此功能,，退款提现时，审核通过后，可以批量实现自动转账；开启前，请&nbsp;<a class="weix_pay" href="https://qy.weixin.qq.com/cgi-bin/loginpage" target="_blank">去微信企业</a>&nbsp;付款。</p>
                           </dd> 
                            
                        </dl>
                        <dl class="cf mab15">
                        	<dt><em class="asterisk">*</em>上传apiclient_cert：</dt>
                            <dd class="">
                                <input type="hidden" name="apiclient_cert" id="apiclient_cert" value="<?php echo $pay['apiclient_cert'] ?>">
                            	<p class="text"><input type="file" name="file_cert" id="file_cert" /> <?php echo $pay['apiclient_cert'] ?></p>
                                <p>证书：登录商户平台——安全设置——API安全下载证书</p>
                            </dd>              	
                        </dl>
                       
                    </div>
                    <div class="add_mem mab15 cf "><a class="ma_left" href="javascript:" id="saveBtn">保存</a></div>
                </div>
            </form>

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