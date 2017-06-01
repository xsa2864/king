<div class="container-fluid">
	<div class="row-fluid">
		<div class="span12">
			<h1></h1><legend>修改资料</legend>
				<form class="form-horizontal">
				<div class="control-group">
					 <label class="control-label" for="project">部门:</label>
					<div class="controls">
						<input id="project" name="project" type="text" value="<?php echo $row->project; ?>" required="true" />
					</div>
				</div>
				<div class="control-group">
					 <label class="control-label" for="mobile">手机:</label>
					<div class="controls">
						<input id="mobile" name="mobile" type="text" value="<?php echo $row->mobile; ?>" required="true" />
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button type="button" class="btn" onclick="javascript:btnSubmit()">保存</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	var xmlHttp=null;
    
	try
	{
		// Firefox, Opera 8.0+, Safari
		xmlHttp=new XMLHttpRequest();
	}
	catch (e)
	{
		// Internet Explorer
		try
		{
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e)
		{
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	}

	function stateChanged()
	{
	    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
	        var a = JSON.parse(xmlHttp.responseText);
	        alert(a.msg);
	    }
	}

	function btnSubmit()
	{
	    var project = document.getElementById("project").value
	    var mobile = document.getElementById("mobile").value
		if (xmlHttp!=null)
		{
			var url=siteUrl;
			url = url + "admin/account/saveProfile?project=" + project + "&mobile=" + mobile;
			//回调函数，执行动作
			xmlHttp.onreadystatechange=stateChanged;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		}
	}

</script>