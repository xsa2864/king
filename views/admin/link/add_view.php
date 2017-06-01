<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <h1></h1><legend>链接管理</legend>
            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="lName">链接名称：</label>
                                <div class="col-sm-4 controls">
                                    <input id="lName" name="lName" value="<?php echo $row->name;?>" type="text" required="true" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="lHref">链接地址：</label>
                                <div class="col-sm-4 controls">
                                    <input id="lHref" name="lHref" value="<?php echo $row->href?$row->href:'http://';?>" type="text" required="true" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10 controls">
                                    <button type="button" class="btn" onclick="javascript:btnSubmit()">保存</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
        var lName = $('#lName').val();
        var lHref = $('#lHref').val();

        $.post("<?php echo input::site('admin/link/save/') ?><?php echo $row->id?$row->id:'' ?>", { 'lName': lName, 'lHref': lHref },
                function (data) {
                    var da = JSON.parse(data);
                    if (da.success == 1) {
                        var url = '/admin/link/index';
                        location.href = url;
                    }
                    else
                    {
                        alertMsg(da.msg, '', da.msg.length * 40, 40);
                    }
                });
    }

</script>
