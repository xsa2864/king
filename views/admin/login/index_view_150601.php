<body>
<div class="LoginContainer">
<div align="center" style="margin-bottom:28px;"><img src="../../library/images/login/login_title.gif" /></div>
<div class="LoginContent" style="position:relative">
<form method="post" name="form1" id="form1" action="">
	<div class="hang"><label for="userName">帐号</label><input type="text" name="userName" class="easyui-validatebox" required="true" /></div>
    <div class="hang"><label for="passwd">密码</label><input type="password" name="passwd" class="easyui-validatebox"  required="true"/></div>
    <div style="text-align: left; margin-left:50px; margin-top:5px;font-size:14px;" id="capt">验证码&nbsp;&nbsp;&nbsp;<?php $capt->render();?>&nbsp;<input type="text" name="captcha" size="5" class="easyui-validatebox"  required="true" ／></div>
    <div style="margin-top:5px"><input type="submit" value=" 登 录 " class="button" /></div>
</form>
</div>
</div>
	<script type="text/javascript">
	$('#form1').form({
	    url:'',
	    onSubmit:function(){
	        return $(this).form('validate');
	    },
	    success:function(data){
		    data	= vdata(data);
		    if (data.success ==1){				
				parent.location.href='<?php echo input::site('solid');?>';  
		    }else{
		    	$.messager.alert('用户登录',data.msg);
			 	$('#capt img').attr('src', "<?php echo input::site('captcha/default');?>?r="+Math.random()).show();
		    }  
	    }
	});	

	$('#capt img').click(function(){
		$('#capt img').attr('src', "<?php echo input::site('captcha/default');?>?r="+Math.random()).show();
	});
	$('#capt img').attr('style','cursor:pointer');
	</script>
</body>
