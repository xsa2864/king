<!--修改--->
<div class="up_box fz_box " style="display:none; width:365px;" id="edit_view">
	<h1>修改<i class="close"></i></h1>
 	<div class="export weix">
        <dl class="cf mab15 ma20">
            <dt><em class="asterisk">*</em>选择组别：</dt>
            <dd class="select_box" > 
                <select id="editgId" class="puiSelect" style="width:120px">
                    <?php
                    foreach($groupList as $gItem)
                    {
                        echo '<option value="'.$gItem->id.'">'.$gItem->groupName.'</option>';
                    }
                    ?>
                </select>
            </dd>             	
        </dl>
        <dl class="cf mab15">
            <dt><em class="asterisk">*</em>登录账号：</dt>
            <dd>
                <p><input id="edituserName" class="inp185" type="text"/></p>
            </dd>             	
        </dl>
        <dl class="cf mab15">
            <dt><em class="asterisk">*</em>登录密码：</dt>
            <dd>
                <p><input id="editpasswd" class="inp185" type="password"/></p>
            </dd>             	
        </dl>
        <dl class="cf mab15">
            <dt>电话：</dt>
            <dd>
                <p><input id="editmobile" class="inp185" type="text"/></p>
            </dd>             	
        </dl>
        <dl class="cf mar20">
            <dt>用户名称：</dt>
            <dd>
                <p><input id="editrealName" class="inp185" type="text"/></p>
            </dd>             	
        </dl>
    </div>
    <div class="btn_two btn_width cf">
        <a class="a1 close" href="javascript:ebtnSubmits()">确定</a><a class="close" style="cursor: pointer;">取消</a>
    </div>
</div>
<script type="text/javascript">
    
    function ebtnSubmits() {
        var id = $("#edituserName").attr('itemid');
        var userName = $("#edituserName").val();
        var mobile = $("#editmobile").val();
        var gId = $("#editgId").val();
        var passwd = $("#editpasswd").val();
        var realName = $("#editrealName").val();
        $.post("<?php echo input::site('admin/account/update'); ?>", { 'userName': userName, 'mobile': mobile, 'gId': gId, 'passwd': passwd, 'realName': realName, 'id': id },
                function (data) {
                    var da = JSON.parse(data);
                    if (da.success == 1)
                    {
                        location.href = '<?php echo input::site('admin/account/index'); ?>';
                    }
                    else
                    {
                        alert(da.msg);
                    }
                });
    }
</script>