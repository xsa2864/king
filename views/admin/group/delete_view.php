<!--删除组员--->
<div class="up_box" style="display:none; width:340px;" id="delete_view">
	<h1>删除组员<i class="close"></i></h1>
    <div id="deleteAccount" class="multiple cf">
    </div>
    <div class="btn_two btn_width cf">
        <a class="a1 close" style="cursor: pointer;" onclick="javascript:deleteAccount()">确定</a><a class="close" style="cursor: pointer;">取消</a>
    </div>
</div>
<script type="text/javascript">
        
    function deleteAccount() {
        $("input:checkbox[name='accountId']:checked").each(function () {
            var id = $(this).attr('value');
            c+=id;
            c+=',';
        });
        c = c.substring(0, c.length - 1);
        $.post("<?php echo input::site('admin/group/deleteAccount'); ?>", { 'ids': c },
                    function (data) {
                        var da = JSON.parse(data);
                        if (da.success == 1) {
                            alert(da.msg);                            
                            location.reload();
                        }
                        else {
                            alert(da.msg);
                        }
                    });
    }

</script>