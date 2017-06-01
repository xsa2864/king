<script type="text/javascript" src="<?php echo input::jsUrl('swfupload/swfupload.js');?>"></script>
<script type="text/javascript" src="<?php echo input::jsUrl('swfupload/handlers.js');?>"></script>
<script type="text/javascript" src="<?php echo input::jsUrl('swfupload/fileprocess.js');?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo input::jsUrl('swfupload/swf.css');?>" />
<div class="back_right right_width">
    <div class="right">
        <h1>添加广告</h1>
        <div class="cen_box">

            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4>添加新广告</h4>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="lName">广告名称：</label>
                                <div class="col-sm-4 controls">
                                    <input id="name" class="form-control" name="name" type="text" required="required" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">图片：</label>
                                <div class="col-sm-10 controls">
                                    <div id="processTarget" class="fl">
                                        <div class="addnew" id="addnew"><span id="placeHandle"></span></div>
                                        <input type="button" class="btupload" value="开始上传" onclick="swfu.startUpload();" />
                                        <div style="clear: both"></div>
                                        <br />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">


                                <div class="btn_two cf">
                                    <a class="a1" href="javascript:" onclick="javascript:btnSubmitNew()">保存</a><a href="javascript:" onclick="location.href='javascript:history.back()'">取消</a>
                                </div>



                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4>选择现有广告</h4>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="lName">广告名称：</label>
                                <div class="col-sm-6 controls">
                                    <select id="lAd" class="form-control" onchange="image1.src=this.options[this.options.selectedIndex].label">
                                        <?php
                                        $img = '';
                                        foreach($options as $value)
                                        {
                                            $pics	= unserialize($value->pics);
                                            $thumb	= '';
                                            if (is_array($pics) && count($pics)>0)
                                            {
                                                foreach ($pics as $pk=>$pv)
                                                {
                                                    $p = $pk;
                                                    break;
                                                }
                                            }
                                            $thumb = input::site(output_ext::getThumb($p, $row->adSize));
                                            if($img=='')
                                                $img = $thumb;
                                            echo '<option label="'.$thumb.'" value="'.$value->id.'">';
                                            echo $value->name;
                                            echo '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">图片：</label>
                                <div class="col-sm-2 controls">
                                    <img id="image1" src="<?php echo $img;?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="btn_two cf">
                                    <a class="a1" href="javascript:" onclick="javascript:btnSubmitOld()">保存</a><a href="javascript:" onclick="location.href='javascript:history.back()'">取消</a>
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

    function btnSubmitNew() {
        var name    = $('#name').val();
        var files   = $("input[name='files[]']").val();
        var url     = $("input[name='url[]']").val();

        $.post("<?php echo input::site('admin/advert/upNew/') ?><?php echo $row->id?$row->id:'' ?>", { 'name': name, 'files': files, 'url': url },
                function (data) {
                    var da = JSON.parse(data);
                    if (da.success == 1) {
                        var url = '/admin/advert/adPositionList';
                        location.href = url;
                    }
                    else {
                        alertMsg(da.msg, '', da.msg.length * 40, 40);
                    }
                });
    }

    function btnSubmitOld() {
        var lAd = $('#lAd').val();

        $.post("<?php echo input::site('admin/advert/upOld/') ?><?php echo $row->id?$row->id:'' ?>", { 'adId': lAd },
                function (data) {
                    var da = JSON.parse(data);
                    if (da.success == 1) {
                        var url = '/admin/advert/adPositionList';
                        location.href = url;
                    }
                    else {
                        alertMsg(da.msg, '', da.msg.length * 40, 40);
                    }
                });
    }

</script>
