<script>
    function send_sms() {

        var eles = document.forms['theForm'].elements;
        var mob = eles['mobile'].value;
        $.post("/admin/sms/testSend", { mobile: mob }, function (data, status) {
            alert(data);
        });
    }
</script>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <h1></h1><legend>短信参数设置</legend>
            <div class="col-sm-6">
                <form id="form1" class="form" name="theForm" method="post" action="/admin/sms/save" enctype="multipart/form-data">
                    <table class="table table-hover table-bordered">
                        <tr>
                            <th class="text-center info" width="150">类别</th>
                            <th class="text-center info">内容</th>
                        </tr>
                        <tr>
                            <td>账号:</td>
                            <td>
                                <input type="text" name="account" value="<?php echo $row['account'];?>"  class="form-control" /></td>
                        </tr>
                        <tr>
                            <td>密码:</td>
                            <td>
                                <input type="text" name="password" value="<?php echo $row['password'];?>" class="form-control" /></td>
                        </tr>
                        <tr>
                            <td>账号ID:</td>
                            <td>
                                <input type="text" name="userid" value="<?php echo $row['userid'];?>" class="form-control" /></td>
                        </tr>
                        <tr>
                            <td>
                                <label>手机号码:</label></td>
                            <td>
                                <input type="text" name="mobile" class="form-contorl" />&nbsp;&nbsp;
                                <button class="btn btn-primary" type="button" onclick="send_sms()">发送测试短信</button></td>
                        </tr>
                    </table>
                    <div class="col-sm-offset-5">
                        <button id="save" class="btn btn-success" type="submit">保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
