<?php 
if ($id)
{
    $postUrl	= input::site('admin/advert/update');
    $title		= '更新广告';
}
else 
{
    $postUrl	= input::site('admin/advert/save');
    $title		= '添加广告';
}
?>
<script type="text/javascript" src="<?php echo input::jsUrl('swfupload/swfupload.js');?>"></script>
<script type="text/javascript" src="<?php echo input::jsUrl('swfupload/handlers.js');?>"></script>
<script type="text/javascript" src="<?php echo input::jsUrl('swfupload/fileprocess.js');?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo input::jsUrl('swfupload/swf.css');?>" />
<div class="back_right right_width">
    <div class="right">
        <h1><?php echo $title;?></h1>

        <div class="cen_box">


            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" name="form1" id="form1" action="<?php echo input::site('admin/swfupd/saveImg');?>" enctype="multipart/form-data" method="post">
                            <div class="form-group">
                                <label class="col-sm-2">广告名称：</label>
                                <div class="col-sm-4">
                                    <input type="text" name="name" id="adName" value="<?php echo $row->name; ?>" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2">广告分类：</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="adType">
                                        <?php
                                        foreach($ad_type as $av) {
                                        ?>
                                        <option value="<?php echo $av->id ?>" <?php if($av->id == $row->adType){echo 'selected';} ?>><?php echo $av->name; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2">
                                    <div id="processTarget" class="fl">
                                        <div class="addnew" id="addnew"><span id="placeHandle"></span></div>
                                        <input type="button" class="btupload" value="开始上传" onclick="swfu.startUpload();" />
                                        <div style="clear: both"></div>
                                        <br />
                                    </div>
                                    <?php 
                                    
                                    if ($row->pics)
                                    {
                                        $pics	= unserialize($row->pics);
                                        foreach ($pics as $key=>$value)
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
                                    <input type="hidden" name="id" value="<?php echo $id;?>" />
                                </div>
                            </div>
                            <div class="form-group">

                                <div class="btn_two cf">
                                    <a class="a1" href="javascript:" onclick="return chg()">保存</a><a href="<?php echo input::site('admin/advert/index');?>">取消</a>
                                </div>


                            </div>
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
        if ($('#adName').val() == '') {
            alert('必须填写广告名称');
            return false;
        }
        $('#form1').attr('action', '<?php echo $postUrl;?>');
        $('#form1').submit();
    }
</script>
