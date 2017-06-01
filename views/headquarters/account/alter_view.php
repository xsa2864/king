<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <h1></h1><legend>修改密码</legend>
            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="oldPassword">旧密码：</label>
                                <div class="col-sm-4 controls">
                                    <input id="oldPassword" name="oldPassword" type="password" required="required" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="newPassword">新密码：</label>
                                <div class="col-sm-4 controls">
                                    <input id="newPassword" name="newPassword" type="password" required="required" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="confirmPassword">确认新密码：</label>
                                <div class="col-sm-4 controls">
                                    <input id="confirmPassword" name="confirmPassword" type="password" required="required" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10 controls">
                                    <button type="button" class="btn btn-success" onclick="javascript:btnSubmit()">保存</button>
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
        var oldPassword = $('#oldPassword').val();
        var newPassword = $('#newPassword').val();
        var confirmPassword = $('#confirmPassword').val();

        $.post("<?php echo input::site('admin/account/savePwd') ?>", { 'oldPassword': oldPassword, 'newPassword': newPassword, 'confirmPassword': confirmPassword },
                function (data) {
                    var da = JSON.parse(data);
                    if (da.success == 0) {
                        alertMsg(da.msg, '', da.msg.length * 40, 40);
                        $('#oldPassword').val('');
                        $('#newPassword').val('');
                        $('#confirmPassword').val('');
                    }
                    else {
                        alertMsg(da.msg, '', da.msg.length * 40, 40);
                    }
                });
    }

</script>
