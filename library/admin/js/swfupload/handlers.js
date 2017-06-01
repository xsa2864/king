
function attShow(serverData,file)
{
	if (serverData.substring(0, 7) === "FILEID:") {
		var data	= serverData.substring(7);
		data		= data.split(',');
		var id		= data[0];
		var desc	= data[1];
		var src		= data[2];
		var box = '<br />链接：<input type="text" name="urls[]" />';
		var srcData	= src.split('.');
		var thumb	= srcData[0]+'_200x50.'+srcData[1];
		var input   = '<input type="hidden" name="files[]" value="'+src+'"><input type="hidden" name="realName[]" value="'+desc+'">';
		var img = '<div class="cancel-icon" onclick=" return attDel(this,\''+src+'\')"></div><table class="table table-striped"><tr align="left"><td width="230">'+desc+'</td><td width="230">'+input+'<img src="'+siteUrl+thumb+'" /></td><td width="230">'+box+'</td></tr></table>';
		$('#processTarget').append('<div id="attachment_'+id+'" class="row">'+img+'</div>');		
	}
	else
	{
		alert('上传失败');
	}
}

//swfupload functions
function fileDialogStart() {
	/* I don't need to do anything here */
}

function attDel(obj,src){
	$.post(siteUrl+'admin/swfupd/delUpload',{filePath:src},function(data){
		data = vdata(data);
		if (data.success != true){
			alert(data.msg);	
		}
		$(obj).parent().remove();
		var swfObj   = eval(swfu);
		var stats = swfObj.getStats();
		stats.successful_uploads--;
		swfObj.setStats(stats);	
	});
}

function fileQueued(file) {
	if(file!= null){
		try {
			var progress = new FileProgress(file, this.customSettings.progressTarget);
			progress.toggleCancel(true, this);
		} catch (ex) {
			this.debug(ex);
		}
	}
}



function fileDialogComplete(numFilesSelected, numFilesQueued)
{
	try {
		if (this.getStats().files_queued > 0) {
			document.getElementById(this.customSettings.cancelButtonId).disabled = false;
		}
		
		/* I want auto start and I can do that here */
		//this.startUpload();
	} catch (ex)  {
        this.debug(ex);
	}
	$('#'+this.customSettings.progressTarget).parent().parent().show();
}
function uploadStart(file)
{
	var progress = new FileProgress(file, this.customSettings.progressTarget);
	progress.setStatus("正在上传请稍后...");
	return true;
}
function uploadProgress(file, bytesLoaded, bytesTotal)
{
	var percent = Math.ceil((bytesLoaded / bytesTotal) * 100);
	var progress = new FileProgress(file, this.customSettings.progressTarget);
	progress.setProgress(percent);
	progress.setStatus("正在上传("+percent+" %)请稍后...");
}
function uploadSuccess(file, serverData)
{
	attShow(serverData,file);
	var progress = new FileProgress(file, this.customSettings.progressTarget);
	progress.setComplete();
	progress.setStatus("文件上传成功");
}
function uploadComplete(file)
{
	if (this.getStats().files_queued > 0)
	{
		 this.startUpload();
	}
}
function uploadError(file, errorCode, message) {
	var msg;
	switch (errorCode)
	{
		case SWFUpload.UPLOAD_ERROR.HTTP_ERROR:
			msg = "上传错误: " + message;
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_FAILED:
			msg = "上传错误";
			break;
		case SWFUpload.UPLOAD_ERROR.IO_ERROR:
			msg = "服务器 I/O 错误";
			break;
		case SWFUpload.UPLOAD_ERROR.SECURITY_ERROR:
			msg = "服务器安全认证错误";
			break;
		case SWFUpload.UPLOAD_ERROR.FILE_VALIDATION_FAILED:
			msg = "附件安全检测失败，上传终止";
			break;
		case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
			msg = '上传取消';
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
			msg = '上传终止';
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
			msg = '单次上传文件数超过设定值';
			break;
		default:
			msg = message;
			break;
		}

	var progress = new FileProgress(file,this.customSettings.progressTarget);
	progress.setError();
	progress.setStatus(msg);
}

function fileQueueError(file, errorCode, message)
{
	var errormsg;
	switch (errorCode) 
	{
		case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
			errormsg = "请不要上传空文件";
			break;
		case SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED:
			//errormsg = "队列文件数量超过设定值";
			errormsg = "您最多只能上传"+ this.customSettings.fileUploadLimit +"个文件！";
			break;
		case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
			errormsg = "文件尺寸超过设定值";		
			break;
		case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
			errormsg = "文件类型不合法";
		default:
			errormsg = '上传错误，请与管理员联系！';
			break;
	}

	alert(errormsg);
	return false;

	var progress = new FileProgress('file',this.customSettings.progressTarget);
	progress.setError();
	progress.setStatus(errormsg);

}

