<script type="text/javascript" src="<?php echo input::jsUrl('webuploader.js');?>"></script>
<link type="text/css" href="<?php echo input::cssUrl('webuploader.css');?>" rel="stylesheet" />

<div class="back_right right_width">
    <form>
    <div class="right">
        <h1>金币设置</h1>
        <div class="cen_box">
            <div class="bor_box">
                <dl class="cf">
                    <dt>是否开启金币赠送功能</dt>
                    <span style="margin-left:10px;">
                    <input type="radio" name="give_type" <?php if($give_type==1){echo 'checked="true"';}?> value="1"> 是
                    <input type="radio" name="give_type" <?php if($give_type==0){echo 'checked="true"';}?> value="0"> 否
                    </span>
                </dl>
                <dl class="cf">
                    <dt>设置金币有效期:</dt>
                    <dd>每
                    <input id="valid_time" name="valid_time" type="text" class="input" value="<?php echo $valid_time;?>">
                    个月清零1次
                    </dd>
                </dl>                
            </div>
            <div class="back_title bold">签到送金币</div>
            <div class="bor_box">
                <dl class="cf">
                    <dt>首次签到赠送的金币数量:</dt>
                    <dd>
                    <span>
                    <input id="mask_points" name="mask_points" type="text" class="input" value="<?php echo $mask_points;?>"></span>
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>以天为单位，连续签到获赠金币的数量是否相同:</dt>
                    <span style="margin-left:10px;">
                    <input type="radio" name="mask_type" <?php if($mask_type==1){echo 'checked="true"';}?> value="1"> 是
                    <input type="radio" name="mask_type" <?php if($mask_type==0){echo 'checked="true"';}?> value="0"> 否
                    </span>
                </dl>
                <dl class="cf">
                    <dt>每日增加的金币基数:</dt>
                    <dd>
                    <span>
                    <input id="continuity_points" name="continuity_points" type="text" class="input" value="<?php echo $continuity_points;?>"> %</span>                     
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>连续赠送金币天数上线:</dt>
                    <dd>
                    <span>
                    <input id="continuity_day" name="continuity_day" type="text" class="input" value="<?php echo $continuity_day;?>"> 天</span>                     
                    </dd>
                </dl>
            </div>
            <div class="back_title bold"> 金币抵扣提现</div>
            <div class="bor_box">
                <dl class="cf">
                    <dt>100金币 = </dt>
                    <dd>
                    <input id="money" name="money" type="text" class="input" value="<?php echo $money;?>">
                    RMB
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>金币是否参加订单金额抵扣:</dt>
                    <span style="margin-left:10px;">
                    <input type="radio" name="order_discount" <?php if($order_discount==1){echo 'checked="true"';}?> value="1"> 是
                    <input type="radio" name="order_discount" <?php if($order_discount==0){echo 'checked="true"';}?> value="0"> 否
                    </span>
                </dl>
                <dl class="cf">
                    <dt>金币是否可以提现:</dt>
                    <span style="margin-left:10px;">
                    <input type="radio" name="points_cash" <?php if($points_cash==1){echo 'checked="true"';}?> value="1"> 是
                    <input type="radio" name="points_cash" <?php if($points_cash==0){echo 'checked="true"';}?> value="0"> 否
                    </span>
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
// 保存金币设置
function save(){
    $.post("<?php echo input::site('admin/config/saveGolds')?>",
        $("form").serialize(),
        function(data){
            var data = eval('('+data+')');
            alert(data.msg);
        }
    )
}   
   
</script>
