<script type="text/javascript" src="<?php echo input::jsUrl('swfupload/swfupload.js');?>"></script>
<script type="text/javascript" src="<?php echo input::jsUrl('swfupload/handlers.js');?>"></script>
<script type="text/javascript" src="<?php echo input::jsUrl('swfupload/fileprocess.js');?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo input::jsUrl('swfupload/swf.css');?>" />
<div class="container-fruid">
    <div class="row-fluid">
        <div class="span12">
            <h1></h1><legend>首页定制</legend>
            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                    </div>
                    <div class="panel-body">
                        <form name="form1" id="form1" action="<?php echo input::site('admin/swfupd/saveImg');?>" enctype="multipart/form-data" method="post">
                            <table border="0" class="hxy_table" height="500">
                                <tr>
                                    <td>
                                        <div id="processTarget" class="fl">
                                            <div class="addnew" id="addnew"><span id="placeHandle"></span></div>
                                            <input type="button" class="btupload" value="开始上传" onclick="swfu.startUpload();" />
                                            <div style="clear: both"></div>
                                            <br />
                                        </div>
                                        <?php 
                                        if ($tagValue)
                                        {
                                            $tagValue	= unserialize($tagValue);
                                        }
                                        if (is_array($tagValue))
                                        {
                                            foreach ($tagValue as $key=>$value)
                                            {
                                                $picName    = output_ext::getThumb($key,'200x50');
                                                echo '<div class="img-wrap">
			                        		<div class="cancel-icon" onclick=" return attDel(this,\''.$key.'\')"></div>
			                                <table class="table table-striped">
			 									<tr align="left">
			 										<td width="230"><input type="hidden" value="'.$key.'" name="files[]"><span>'.$key.'</span></td>
			                                		<td width="230"><img src="'.input::site($picName).'"></td><td width="230">链接：<input type="text" name="urls[]" value="'.$value.'" /></td>
												</tr>
											</table>
										</div><br />';
                                            }
                                        }
                                        ?>
                                        <input type="hidden" name="tagName" value="<?php echo $tagName;?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="center">
                                        <button class="btn btn-success btn-sm" type="button" onclick="return chg()">提交</button>&nbsp;&nbsp;<a class="btn btn-sm" href="<?php echo input::site('admin/home/index');?>">返回</a></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var swfu;

    $(function () {
        swfu = new SWFUpload({
            flash_url: "<?php echo input::jsUrl('swfupload/swfupload.swf');?>",
                        upload_url: "<?php echo input::site('admin/swfupd/saveImg');?>",
                        file_post_name: "userFile",
                        post_params: { "validKey": "<?php echo $validKey;?>", "validTime": "<?php echo $validTime;?>" },
	    file_size_limit: "2048",
	    file_types: "*.*",
	    file_types_description: "All Files",
	    file_upload_limit: "4",
	    custom_settings: { progressTarget: "processTarget", cancelButtonId: "btnCancel" },

	    button_image_url: "",
	    button_width: 75,
	    button_height: 28,
	    button_placeholder_id: "placeHandle",
	    button_text_style: "",
	    button_text_top_padding: 3,
	    button_text_left_padding: 12,
	    button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
	    button_cursor: SWFUpload.CURSOR.HAND,

	    file_dialog_start_handler: fileDialogStart,
	    file_queued_handler: fileQueued,
	    file_queue_error_handler: fileQueueError,
	    file_dialog_complete_handler: fileDialogComplete,
	    upload_progress_handler: uploadProgress,
	    upload_error_handler: uploadError,
	    upload_success_handler: uploadSuccess,
	    upload_complete_handler: uploadComplete
                    });
                });

function chg() {
    $('#form1').attr('action', '<?php echo input::site('admin/tag/saveImg');?>');
    $('#form1').submit();
}
</script>
