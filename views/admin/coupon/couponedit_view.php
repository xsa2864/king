<script type="text/javascript" src="<?php echo input::jsUrl('webuploader.js');?>"></script>
<link type="text/css" href="<?php echo input::cssUrl('webuploader.css');?>" rel="stylesheet" />

<div class="back_right right_width">
    <div class="right">
        <h1>编辑订单</h1>
        <div class="cen_box">
        <form>
            <div class="back_title bold">基本信息</div>
            <div class="bor_box">
                <dl class="cf">
                    <dt>订单号：</dt>
                    <dd><input type="hidden" name="id" value="<?php echo $coupon->id;?>">
                        <input type="text" name="code" value="<?php echo $coupon->code;?>">
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>数量：</dt>
                    <dd>
                        <input type="text" name="number" class="input_t" value="<?php echo $coupon->number;?>">
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>价格：</dt>
                    <dd>
                        <input type="text" name="price" class="input_t" value="<?php echo $coupon->price;?>">
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>订单状态:</dt>
                    <span style="margin-left:10px;">
                    <input type="radio" name="paystatus" id="paystatus_1" <?php if($coupon->paystatus==1){echo 'checked="true"';}?> value="1">
                    <label for="paystatus_1">支付完成</label> 

                    <input type="radio" name="paystatus" id="paystatus_0" <?php if($coupon->paystatus==0){echo 'checked="true"';}?> value="0">
                    <label for="paystatus_0">待支付</label>

                    <input type="radio" name="paystatus" id="paystatus_3" <?php if($coupon->paystatus==-1){echo 'checked="true"';}?> value="-1">
                    <label for="paystatus_3">关闭</label> 
                    </span>
                </dl>
                <dl class="cf">
                    <dt>下单时间：</dt>
                    <dd>
                        <input type="text" name="addtime" class="input_t" value="<?php echo $coupon->addtime>0?date('Y-m-d H:i:s',$coupon->addtime):'';?>">
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>付款时间：</dt>
                    <dd>
                        <input type="text" name="paytime" class="input_t" value="<?php echo $coupon->paytime>0?date('Y-m-d H:i:s',$coupon->paytime):'';?>">
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>是否使用:</dt>
                    <span style="margin-left:10px;">
                    <input type="radio" name="is_use" id="is_use_1" <?php if($coupon->is_use==1){echo 'checked="true"';}?> value="1">
                    <label for="is_use_1">是</label> 
                    <input type="radio" name="is_use" id="is_use_0" <?php if($coupon->is_use<=0){echo 'checked="true"';}?> value="0">
                    <label for="is_use_0">否</label> 
                    </span>
                </dl>
                <dl class="cf">
                    <dt>使用时间：</dt>
                    <dd>
                        <input type="text" name="usetime" class="input_t" value="<?php echo $coupon->usetime>0?date('Y-m-d H:i:s',$coupon->usetime):'';?>">
                    </dd>
                </dl>                
                <!-- <dl class="cf">
                    <dt>是否赠送:</dt>
                    <span style="margin-left:10px;">
                    <input type="radio" name="is_give" id="is_give_1" <?php if($coupon->is_give==1){echo 'checked="true"';}?> value="1">
                    <label for="is_give_1">是</label> 
                    <input type="radio" name="is_give" id="is_give_0" <?php if($coupon->is_give==0){echo 'checked="true"';}?> value="0">
                    <label for="is_give_0">否</label> 
                    </span>
                </dl>
                <dl class="cf">
                    <dt>赠送时间：</dt>
                    <dd>
                        <input type="text" name="givetime" class="input_t" value="<?php echo $coupon->givetime>0?date('Y-m-d H:i:s',$coupon->givetime):'';?>">
                    </dd>
                </dl> -->
                <dl class="cf">
                    <dt>有效期类型:</dt>
                    <span style="margin-left:10px;">
                    <input type="radio" name="timetype" id="timetype_1" <?php if($coupon->timetype==1){echo 'checked="true"';}?> value="1">
                    <label for="timetype_1">有效时间段</label> 
                    <input type="radio" name="timetype" id="timetype_0" <?php if($coupon->timetype==0){echo 'checked="true"';}?> value="0">
                    <label for="timetype_0">有效期</label> 
                    </span>
                </dl>
                <dl class="cf" id="ck0">
                    <dt>有效期：</dt>
                    <dd>
                        <input type="text" name="validtime" class="input_t" value="<?php echo $coupon->validtime;?>">（天）
                    </dd>
                </dl>
                <dl class="cf" id="ck1">
                    <dt>有效时间段：</dt>
                    <dd>
                        <input type="text" name="starttime" class="input_t" value="<?php echo $coupon->starttime>0?date('Y-m-d H:i:s',$coupon->starttime):'';?>">
                        ~
                        <input type="text" name="endtime" class="input_t" value="<?php echo $coupon->endtime>0?date('Y-m-d H:i:s',$coupon->endtime):'';?>">
                    </dd>
                </dl>
        <div class="cen_box mar_15">
            <div class="back_title bold">商家佣金设置：</div>
            <div class="bor_box cf">
                <dl class="cf">
                    <dt>佣金形式：</dt>
                    <dd>
                        <input type="radio" name="bus_type" id="bus_type0" value="0" <?php if($coupon->bus_type == 0){echo 'checked="true"';}?> style="width:14px;"><label for="bus_type0">a.固定金额</label>
                        <input type="radio" name="bus_type" id="bus_type1" value="1" <?php if($coupon->bus_type == 1){echo 'checked="true"';}?> style="width:14px;margin-left:25px;"><label for="bus_type1">b.百分比金额</label>
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>佣金金额：</dt>
                    <dd>
                        <input type="text" name="bus_num" id="bus_num" value="<?php echo $coupon->bus_num;?>" style="width:60px;">
                    </dd>
                        <span class="bs"> 元</span><span class="bp"> %</span>
                </dl>
            </div>           
        </div>
        <div class="cen_box mar_15">
            <div class="back_title bold">用户佣金设置：</div>
            <div class="bor_box cf">
                <dl class="cf">
                    <dt>佣金形式：</dt>
                    <dd>
                        <input type="radio" name="mem_type" id="mem_type0" value="0" <?php if($coupon->mem_type == 0){echo 'checked="true"';}?> style="width:14px;"><label for="mem_type0">a.固定金额</label>
                        <input type="radio" name="mem_type" id="mem_type1" value="1" <?php if($coupon->mem_type == 1){echo 'checked="true"';}?> style="width:14px;margin-left:25px;"><label for="mem_type1">b.百分比金额</label>
                    </dd>
                </dl>
                <dl class="cf">
                    <dt style="width:150px;">一级用户佣金形式：</dt>
                    <dd>
                        <input type="text" name="mem_num1" id="mem_num1" value="<?php echo $coupon->mem_num1;?>" style="width:60px;">
                    </dd>
                        <span class="ms"> 元</span><span class="mp"> %</span>
                </dl>
                <dl class="cf">
                    <dt style="width:150px;">二级用户佣金形式：</dt>
                    <dd>
                        <input type="text" name="mem_num2" id="mem_num2" value="<?php echo $coupon->mem_num2;?>" style="width:60px;">
                    </dd>
                        <span class="ms"> 元</span><span class="mp"> %</span>
                </dl>
                <dl class="cf">
                    <dt style="width:150px;">三级用户佣金形式：</dt>
                    <dd>
                        <input type="text" name="mem_num3" id="mem_num3" value="<?php echo $coupon->mem_num3;?>" style="width:60px;">
                    </dd>
                        <span class="ms"> 元</span><span class="mp"> %</span>
                </dl>
            </div>           
        </div>
                <dl class="cf">
                    <dt>备注：</dt>
                    <dd>
                        <textarea rows="3" cols="65" name="note"><?php echo $coupon->note;?></textarea>
                    </dd>
                </dl>
            </div>
        </div>
        <div class="cen_box mar_15">            
            <div class="back_title bold">会员信息</div>
            <div class="bor_box"> 
            <?php 
            if(!empty($member)){                
            ?>
                <div>
                    <img src="<?php echo $member->head_img;?>" width=80>
                </div>  
                <div>
                    <label>昵称:</label>
                    <b><?php echo json_decode($member->nickname);?> </b>
                </div>         
            <?php  
            }else{
                echo "无";
            }
            ?>                
            </div>
        </div>
        <div class="cen_box mar_15">            
            <div class="back_title bold">商家信息</div>
            <div class="bor_box"> 
            <?php 
            if(!empty($business)){                
            ?>
                <div>
                    <dl class="cf">
                        <dt>店铺名称：</dt>
                        <dd>
                            <label><?php echo $business->name;?></label>
                        </dd>
                    </dl>
                    <dl class="cf">
                        <dt>联系人：</dt>
                        <dd>
                            <label><?php echo $business->realname;?></label>
                        </dd>
                    </dl>
                    <dl class="cf">
                        <dt>手机号：</dt>
                        <dd>
                            <label><?php echo $business->mobile;?></label>
                        </dd>
                    </dl>
                </div>        
            <?php                     
            }else{
                echo "无";
            }
            ?>                
            </div>
        </div>
        <div class="cen_box mar_15">            
            <div class="back_title bold">佣金信息</div>
            <div class="bor_box"> 
            <?php 
            if(!empty($commission)){
                foreach ($commission as $key => $value) {
            ?>
                <div>
                    <label><?php echo  $value->realName;?>获得<?php echo $value->price;?>元</label>
                    <b><?php echo $value->note;?> </b>
                </div>         
            <?php    
                }  
            }else{
                echo "无";
            }
            ?>                
            </div>
        </div>
        </form>
        <div style="text-align:center;">            
            <button style="width: 70px;height: 35px;" onclick="coupon_save()">保存</button>
        </div>      
    </div>   
</div>

<style type="text/css">
.cf dt{
    width: 140px;
}
.input_t{
    width: 140px !important;
}
</style>
<script type="text/javascript">
// 保存修改
function coupon_save(){
    $.post('<?php echo input::site("admin/coupon/coupon_save");?>',$("form").serialize(),
        function(data){
            var data = eval("("+data+")");
            alert(data.msg);
        })
    
}
$(function() {
    var ck = $("input[name=timetype]:checked").val();
    if(ck == 0){
        $("#ck0").show();
        $("#ck1").hide();
    }else{
        $("#ck0").hide();
        $("#ck1").show();
    }
      var bus_type = $("input[name=bus_type]:checked").val();
    if(bus_type==0){
        $(".bs").show();
        $(".bp").hide();
    }else{
        $(".bp").show();
        $(".bs").hide();
    }
    var mem_type = $("input[name=mem_type]:checked").val();
    if(mem_type==0){
        $(".ms").show();
        $(".mp").hide();
    }else{
        $(".mp").show();
        $(".ms").hide();
    }
})
 
$("input[name=timetype]").click(function(){
    var ck = $(this).val();
    if(ck == 0){
        $("#ck0").show();
        $("#ck1").hide();
    }else{
        $("#ck0").hide();
        $("#ck1").show();
    }
});
// 商家佣金类型
$("input[name=bus_type]").click(function(){
    var n = $(this).val();
    if(n == 0){
        $(".bs").show();
        $(".bp").hide();
    }else{
        $(".bp").show();
        $(".bs").hide();
    }
    $("#bus_num").val('');

})
// 用户佣金类型
$("input[name=mem_type]").click(function(){
    var n = $(this).val();
    if(n == 0){
        $(".ms").show();
        $(".mp").hide();
    }else{
        $(".mp").show();
        $(".ms").hide();
    }
    $("#mem_num1").val('');
    $("#mem_num2").val('');
    $("#mem_num3").val('');
})
</script>