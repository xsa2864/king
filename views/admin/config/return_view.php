<script type="text/javascript" src="<?php echo input::jsUrl('webuploader.js');?>"></script>
<link type="text/css" href="<?php echo input::cssUrl('webuploader.css');?>" rel="stylesheet" />

<div class="back_right right_width">
    <div class="right">
    <form>
        <h1>退款配置</h1>
        <div class="cen_box">            
            <div class="bor_box"> 
                <dl class="cf">
                    <dt>退款申请:</dt>
                    <dd>
                        <input name="return_day" type="text" class="input" value="<?php echo $return_day;?>"> (个工作日后，返还退款。)
                    </dd>
                </dl>                     
                <dl class="cf">
                    <dt>退回总金额的（1-X%）:</dt>
                    <dd>
                        <input name="percent" type="text" class="input" value="<?php echo $percent;?>"> (%)
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
.bor_box .input{
    width: 100px;
}
</style>

<script type="text/javascript">
function save(){    
    $.post("<?php echo input::site('admin/config/saveReturn')?>",
        $("form").serialize(),
        function(data){
            var da = eval('('+data+')');
            alert(da.msg);
        }
    )
}   
   
</script>