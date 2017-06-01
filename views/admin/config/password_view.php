<script type="text/javascript" src="<?php echo input::jsUrl('webuploader.js');?>"></script>
<link type="text/css" href="<?php echo input::cssUrl('webuploader.css');?>" rel="stylesheet" />

<div class="back_right right_width">
    <div class="right">
    <form>
        <h1>修改密码</h1>
        <div class="cen_box">     
            <form>      
            <div class="bor_box">
                <dl class="cf">
                    <dt>旧密码:</dt>
                    <dd>
                        <input id="oldpwd" name="oldpwd" type="password" placeholder="旧密码">
                    </dd>
                </dl>                       
                <dl class="cf">
                    <dt>新密码:</dt>
                    <dd>
                        <input id="password" name="password" type="password" placeholder="新密码">                        
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>确认密码:</dt>
                    <dd>
                        <input id="rpassword" name="rpassword" type="password" placeholder="确认密码">                        
                    </dd>
                </dl>                
            </div> 
            </form>    
        </div>        
    </div>
    <div class="btn_two cf">
        <input type="hidden" name="id" id="id" value="<?php echo $id;?>">
        <a class="a1" href="javascript:save();">保存</a>
    </div>
    </form>
</div>

<style type="text/css">
.bor_box dt {
     width: 200px; 
}
</style>

<script type="text/javascript">
function save(){    
    var oldpwd = $("#oldpwd").val();
    var password = $("#password").val();
    var rpassword = $("#rpassword").val();
    if(oldpwd==''){
        alert("旧密码不能为空!");
        return false;
    }
    if(password==''){
        alert("新密码不能为空!");
        return false;
    }
    if(rpassword==''){
        alert("确认密码不能为空!");
        return false;
    }
    if(password!=rpassword){
        alert("新密码和确认密码不一致!");
        return false;
    }

    $.post('<?php echo input::site("admin/config/save_pwd")?>',
        $("form").serialize(),
        function(data){            
            var da = eval("("+data+")");
            if(da.success == 1){
                location.reload();
            }
            alert(da.msg);
        }
    )
}   

</script>