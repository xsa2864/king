<script type="text/javascript" src="<?php echo input::jsUrl('webuploader.js');?>"></script>
<link type="text/css" href="<?php echo input::cssUrl('webuploader.css');?>" rel="stylesheet" />

<div class="back_right right_width">
    <div class="right">
    <form>
        <h1>配置管理</h1>
        <div class="cen_box">               
<!--             <div class="bor_box">
                <dl class="cf">
                    <dt>店铺名称:</dt>
                    <dd>
                        <span>
                        <input id="name" name="name" type="text" placeholder="" value="<?php echo $name;?>">
                        </span>
                    </dd>
                </dl>                       
                <dl class="cf">
                    <dt>客服电话:</dt>
                    <dd>
                        <input id="phone" name="phone" type="text" placeholder="" value="<?php echo $phone;?>">                        
                    </dd>
                </dl>
                <dl class="cf">
                    <dt> <em class="asterisk">*</em>警戒库存:</dt>
                    <dd>
                        <span>
                        <input name="warning_stock" type="text" placeholder="警戒库存" value="<?php echo $warning_stock;?>">
                        </span>
                    </dd>
                </dl>
                <dl class="cf">
                    <dt> <em class="asterisk">*</em>商品分享描述:</dt>
                    <dd>
          <textarea id="share_description" class="form-control" style="width: 420px; height: 240px" name="share_description"><?php echo $share_description;?></textarea>
                    </dd>
                </dl>              
                <dl class="cf">
                    <dt> <em class="asterisk">*</em>销售量开关:</dt>
                    <span style="margin-left:10px;">
                    <input type="radio" name="sell_num" <?php if($sell_num==1){echo 'checked="true"';}?> value="1"> 开启
                    <input type="radio" name="sell_num" <?php if($sell_num==0){echo 'checked="true"';}?> value="0"> 关闭
                    </span>
                </dl>                 
            </div> -->
            <div class="bor_box">    
            <?php
            if(!empty($config)){
                foreach ($config as $key => $value) {
            ?>
                <dl class="cf">
                    <dt><?php echo $key;?> ：</dt>
                    <dd>
                        <input name="config" type="text" id="<?php echo $key;?>" value="<?php echo $value;?>">
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
// function save(){    
//     $.post('<?php echo input::site("admin/config/save")?>',
//         $("form").serialize(),
//         function(data){
//             var da = eval("("+data+")");
//             alert(da.msg);
//         }
//     )
// }   
   
// 保存配置
function save(){ 
    var add_key = $("input[name=add_key]").val();
    var add_value = $("input[name=add_value]").val();

    var str = '[{"';
    $("input[name=config]").each(function(n,e){
        if(str != '[{"'){
            str += '","';
        }
        str += $(e).attr('id')+'":"'+$(e).val();
    })
    if(add_key != ''){
        if(str != '[{"'){
            str += '","';
        }       
        str += add_key+'":"'+add_value;
    }
    str += '"}]';
    $.post("<?php echo input::site('admin/config/saveConfig')?>",
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
        $.post("<?php echo input::site('admin/config/delConfig')?>",
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