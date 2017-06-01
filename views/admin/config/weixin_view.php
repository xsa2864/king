<script type="text/javascript" src="<?php echo input::jsUrl('webuploader.js');?>"></script>
<link type="text/css" href="<?php echo input::cssUrl('webuploader.css');?>" rel="stylesheet" />

<div class="back_right right_width">
    <div class="right">
    <form>
        <h1>微信信息配置</h1>
        <div class="cen_box">            
            <div class="bor_box">    
            <?php
            if(!empty($config)){
                foreach ($config as $key => $value) {
            ?>
                <dl class="cf">
                    <dt><?php echo $key;?> ：</dt>
                    <dd>
                        <input name="weixin" type="text" id="<?php echo $key;?>" value="<?php echo $value;?>">
                    </dd>
                    &nbsp;<a href="javascript:del('<?php echo $key;?>');">删除</a>
                </dl>                
            <?php 
                }
            }
            ?>   
                <dl class="cf">
                    <dt><input name="add_key" type="text" id="add_key" placeholder="键值key" > ：</dt>
                    <dd>
                        <input name="add_value" type="text" id="add_value" placeholder="参数值" >
                    </dd>
                </dl>          
            </div>
        </div>        
    </div>
    <div class="btn_two cf">
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
// 保存配置
function save(){ 
    var add_key = $("input[name=add_key]").val();
    var add_value = $("input[name=add_value]").val();

    var str = '[{"';
    $("input[name=weixin]").each(function(n,e){
        if(str != '[{"'){
            str += '","';
        }
        str += $(e).attr('id')+'":"'+$(e).val();
    })
    if(add_key != ''){
        str += '","';
        str += add_key+'":"'+add_value;
    }
    str += '"}]';
    $.post("<?php echo input::site('admin/config/saveWeixin')?>",
        {'str':str},
        function(data){
            if(data == 1){
                location.reload();
            }
        }
    )
}   
// 删除配置
function del(name){
    if(confirm("确定删除?")){        
        $.post("<?php echo input::site('admin/config/delWeixin')?>",
            {'name':name},
            function(data){
                if(data == 1){
                    location.reload();
                }else{
                    alert("删除失败！");
                }
            }
        )
    }
}
</script>