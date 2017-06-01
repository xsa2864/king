<script type="text/javascript" src="<?php echo input::jsUrl('webuploader.js');?>"></script>
<link type="text/css" href="<?php echo input::cssUrl('webuploader.css');?>" rel="stylesheet" />

<div class="back_right right_width">
    <div class="right">
        <h1>配置管理</h1>
        <div class="cen_box">
            <div class="back_title bold">基本信息</div>
            <div class="bor_box">
                <dl class="cf">
                    <dt> <em class="asterisk">*</em>佣金设置:</dt>
                    <span style="margin-left:10px;">
                    <input type="radio" name="commission" <?php if($commission==1){echo 'checked="true"';}?> value="1"> 自己购买也可以获得佣金
                    <input type="radio" name="commission" <?php if($commission==0){echo 'checked="true"';}?> value="0"> 自己购买无佣金，上级才有佣金
                    </span>
                </dl>
                <dl class="cf">
                    <dt> <em class="asterisk">*</em>积分设置:</dt>
                    <dd>
                        <span>
                        <input id="points" name="points" type="text" placeholder="填多少积分,多少积分等于1RMB" value="<?php echo $points;?>">
                        </span>
                    </dd>
                </dl>
                <dl class="cf">
                    <dt> <em class="asterisk">*</em>金币设置:</dt>
                    <dd>
                        <span>
                        <input id="golds" name="golds" type="text" placeholder="购买商品，获得金币。不同层级的上级获得金币不同。" value="<?php echo $golds;?>">
                        </span>
                    </dd>
                </dl>
                <dl class="cf">
                    <dt> <em class="asterisk">*</em>退款设置:</dt>
                    <span style="margin-left:10px;">
                    <input type="radio" name="refunds" <?php if($refunds==1){echo 'checked="true"';}?> value="1"> 可以退款
                    <input type="radio" name="refunds" <?php if($refunds==0){echo 'checked="true"';}?> value="0"> 不能退款
                    </span>
                </dl>
                <dl class="cf">
                    <dt> <em class="asterisk">*</em>销售量开关:</dt>
                    <span style="margin-left:10px;">
                    <input type="radio" name="sell_num" <?php if($sell_num==1){echo 'checked="true"';}?> value="1"> 开启
                    <input type="radio" name="sell_num" <?php if($sell_num==0){echo 'checked="true"';}?> value="0"> 关闭
                    </span>
                </dl>
                <dl class="cf">
                    <dt> <em class="asterisk">*</em>二维码开关:</dt>
                    <span style="margin-left:10px;">
                    <input type="radio" name="qr_code" <?php if($qr_code==1){echo 'checked="true"';}?> value="1"> 开启
                    <input type="radio" name="qr_code" <?php if($qr_code==0){echo 'checked="true"';}?> value="0"> 关闭
                    </span>
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
                        <textarea id="share_description" class="form-control" style="width: 420px; height: 240px" name="share_description">
                        <?php echo $share_description;?>
                        </textarea>
                    </dd>
                </dl>                 
            </div>
        </div>        
    </div>
    <div class="btn_two cf">
        <input type="hidden" name="id" id="id" value="<?php echo $id;?>">
        <a class="a1" href="javascript:save();">保存</a>
    </div>
</div>

<style type="text/css">
.bor_box dt {
     width: 100px; 
}
</style>

<script type="text/javascript">
function save(){
    var commission  = $('input[name=commission]:checked').val();
    var refunds     = $('input[name=refunds]:checked').val();
    var sell_num    = $('input[name=sell_num]:checked').val();
    var qr_code     = $('input[name=qr_code]:checked').val();
    var points      = $('input[name=points]').val();
    var golds       = $('input[name=golds]').val();
    var warning_stock = $('input[name=warning_stock]').val();
    var share_description = $('textarea[name=share_description]').val();
    var id = $('#id').val();
    $.post("<?php echo input::site('admin/config/save')?>",
        {   'id':id,
            'commission':commission,
            'refunds':refunds,
            'sell_num':sell_num,
            'qr_code':qr_code,
            'points':points,
            'golds':golds,
            'warning_stock':warning_stock,
            'share_description':share_description
        },function(data){
            var da = eval('('+data+')');
            alert(da.msg);
        }
    )
}   
   
</script>