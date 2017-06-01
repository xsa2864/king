<script type="text/javascript" src="<?php echo input::jsUrl('webuploader.js');?>"></script>
<link type="text/css" href="<?php echo input::cssUrl('webuploader.css');?>" rel="stylesheet" />

<div class="back_right right_width">
    <div class="right">
    <form>
        <h1>财务配置</h1>
        <div class="cen_box">            
            <div class="bor_box"> 
                <dl class="cf">
                    <dt>提现手续百分比:</dt>
                    <dd>
                        <input name="poundage" type="text" class="input" value="<?php echo $poundage;?>"> (%)
                    </dd>
                </dl>                     
                <dl class="cf">
                    <dt>提现税费百分比:</dt>
                    <dd>
                        <input name="tax" type="text" class="input" value="<?php echo $tax;?>"> (%)
                    </dd>
                </dl>    
                <dl class="cf">
                    <dt>选择类型:</dt>
                    <dd>
                        <input type="radio" name="type" id="p_1" <?php if($type==1){echo 'checked="true"';}?> value="1">
                        <label for="p_1">固定金额</label>  
                        <input type="radio" name="type" id="p_0" <?php if($type==0){echo 'checked="true"';}?> value="0">
                        <label for="p_0">百分比</label>   
                    </dd>
                </dl>
                <dl class="cf">
                    <dt id="title">百分比(%):</dt>
                    <dd>
                        <input name="percent" type="text" class="input" value="<?php echo $percent;?>"> 
                    </dd>
                </dl>     
                <dl class="cf">
                    <dt id="title">xx时间后发红包给用户:</dt>
                    <dd>
                        <input name="member_time" type="text" class="input" value="<?php echo $member_time;?>"> 天
                    </dd>
                </dl>  
                <dl class="cf">
                    <dt id="title">XX时间后发红包给商家:</dt>
                    <dd>
                        <input name="business_time" type="text" class="input" value="<?php echo $business_time;?>"> 天
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
.bor_box dt{
     width: 200px; 
}
.bor_box dd .input{
     width: 100px; 
}
.bor_box dd #p_1,#p_0{
    margin-left: 15px;
    width: 15px;
}
</style>

<script type="text/javascript">
function save(){    
    $.post("<?php echo input::site('admin/finance/saveFinance')?>",
        $("form").serialize(),
        function(data){
            var da = eval('('+data+')');
            alert(da.msg);
        }
    )
}   
   
$("input[name=type]").click(function(){
    var val = $(this).val();
    if(val == 0){
    $("#title").html('百分比(%)：');
    }else{
    $("#title").html('固定金额(元)：');
    }
})
</script>