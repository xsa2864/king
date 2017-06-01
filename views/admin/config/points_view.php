<script type="text/javascript" src="<?php echo input::jsUrl('webuploader.js');?>"></script>
<link type="text/css" href="<?php echo input::cssUrl('webuploader.css');?>" rel="stylesheet" />

<div class="back_right right_width">
    <form>
    <div class="right">
        <h1>积分设置</h1>
        <div class="cen_box">           
            <div class="bor_box">
                <dl class="cf">
                    <dt>是否开启积分赠送功能</dt>
                    <span style="margin-left:10px;">
                    <input type="radio" name="give_type" <?php if($give_type==1){echo 'checked="true"';}?> value="1"> 是
                    <input type="radio" name="give_type" <?php if($give_type==0){echo 'checked="true"';}?> value="0"> 否
                    </span>
                </dl>
                <dl class="cf">
                    <dt>是否向上裂变积分:</dt>
                    <span style="margin-left:10px;">
                    <input type="radio" name="fission_type" <?php if($fission_type==1){echo 'checked="true"';}?> value="1"> 是
                    <input type="radio" name="fission_type" <?php if($fission_type==0){echo 'checked="true"';}?> value="0"> 否
                    </span>
                </dl>
                <dl class="cf">
                    <dt>设置裂变比例:</dt>
                    <dd>
                    <span>
                    <input id="fission_rate" name="fission_rate" type="text" class="input" value="<?php echo $fission_rate;?>"> %</span>
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>设置裂变的层级数量:</dt>
                    <dd>
                    <span>
                    <input id="fission_number" name="fission_number" type="text" class="input" value="<?php echo $fission_number;?>"></span>
                    </dd>
                </dl>
            </div>
            <div class="back_title bold">积分分红提现</div>
            <div class="bor_box">
                <dl class="cf">
                    <dt>积分是否在提现后清零:</dt>
                    <span style="margin-left:10px;">
                    <input type="radio" name="cash_clear" <?php if($cash_clear==1){echo 'checked="true"';}?> value="1"> 是
                    <input type="radio" name="cash_clear" <?php if($cash_clear==0){echo 'checked="true"';}?> value="0"> 否
                    </span>
                </dl>
                <dl class="cf">
                    <dt>积分分红满￥:</dt>
                    <dd>
                    <span>
                    <input id="cash_to" name="cash_to" type="text" class="input" value="<?php echo $cash_to;?>"></span>
                     方可提现
                    </dd>
                </dl>
            </div>
            <div class="back_title bold"> 积分分红率设置</div>
            <div class="bor_box">
                <dl class="cf">
                    <dt>积分分红  =  积分  X  积分分红率</dt>
                    <dd>
                    ￥ <input id="valid" name="valid" type="text" class="input" value="<?php echo $valid;?>">
                    =
                    <input id="valid" name="valid" type="text" class="input" value="<?php echo $valid;?>"> %
                    <a href="javascript:;">+</a>
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>设置积分分红率有效期:</dt>
                    <dd>每
                    <input id="valid_time" name="valid_time" type="text" class="input" value="<?php echo $valid_time;?>">
                    个月清零1次
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
    width: 180px; 
}
.bor_box .input{
    width: 100px;
}
.bor_box a{
    font-size: 24px;
}
</style>

<script type="text/javascript">
// 保存积分设置
function save(){
    $.post("<?php echo input::site('admin/config/savePoints')?>",
        $("form").serialize(),
        function(data){
            var data = eval('('+data+')');
            alert(data.msg);
        }
    )
}    
   
</script>