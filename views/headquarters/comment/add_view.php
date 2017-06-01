<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <h1></h1><legend>回复评论</legend>
            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo $row->realName.'&nbsp;&nbsp;('.$row->ctime.')'; ?></h3>
                                </div>
                                <div class="panel-body">
                                    <?php echo $row->content; ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">回复：</label>
                                <div class="controls">
                                    <textarea class="form-control" style="width: 100%; height: 100px;" name="content"><?php echo $row->reply; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-5 controls">
                                    <button type="button" class="btn btn-success" onclick="javascript:btnSubmit()">保存</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<button type="button" class="btn" onclick="location.href='javascript:history.back()'">返回</button>
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

    function btnSubmit() {
        var content = editor.html();
        $.post("<?php echo input::site('admin/comment/update/') ?><?php echo $row->id;?>", { 'content': content },
                function (data) {
                    var da = JSON.parse(data);
                    alertMsg(da.msg, '', da.msg.length * 40, 40);
                });
    }
</script>
