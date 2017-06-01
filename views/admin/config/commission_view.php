<script type="text/javascript" src="<?php echo input::jsUrl('webuploader.js');?>"></script>
<link type="text/css" href="<?php echo input::cssUrl('webuploader.css');?>" rel="stylesheet" />

<div class="back_right right_width">
    <div class="right">
    <form>
        <h1>佣金管理</h1>
        <div class="cen_box">            
            <div class="bor_box">
                <dl class="cf">
                    <dt>是否开启佣金赠送功能:</dt>
                    <span style="margin-left:10px;">
                    <input type="radio" name="give_type" id="give_1" <?php if($give_type==1){echo 'checked="true"';}?> value="1"> 
                    <label for="give_1">开启</label> 
                    <input type="radio" name="give_type" id="give_0" <?php if($give_type==0){echo 'checked="true"';}?> value="0">
                    <label for="give_0">关闭</label> 
                    </span>
                </dl> 
                <dl class="cf">
                    <dt>是否向上裂变佣金:</dt>
                    <span style="margin-left:10px;">
                    <input type="radio" name="fission_type" id="fission_1" <?php if($fission_type==1){echo 'checked="true"';}?> value="1">
                    <label for="fission_1">开启</label> 
                    <input type="radio" name="fission_type" id="fission_0" <?php if($fission_type==0){echo 'checked="true"';}?> value="0">
                    <label for="fission_0">关闭</label> 
                    </span>
                </dl>
                 <dl class="cf">
                    <dt>结算佣金时机:</dt>
                    <span style="margin-left:10px;">
                    <input type="radio" name="fission_time" id="t_1" <?php if($fission_time==1){echo 'checked="true"';}?> value="1">
                    <label for="t_1">交易完成</label>   
                    <input type="radio" name="fission_time" id="t_0" <?php if($fission_time==0){echo 'checked="true"';}?> value="0">
                    <label for="t_0">支付完成</label>  
                    </span>
                </dl>
                <dl class="cf">
                    <dt>结算佣金类型:</dt>
                    <span style="margin-left:10px;">
                    <input type="radio" name="price_type" id="p_1" <?php if($price_type==1){echo 'checked="true"';}?> value="1">
                    <label for="p_1">固定金额</label>  
                    <input type="radio" name="price_type" id="p_0" <?php if($price_type==0){echo 'checked="true"';}?> value="0">
                    <label for="p_0">百分比</label>   
                    </span>
                </dl>
                <dl class="cf">
                    <dt>
                        <b class="rate">一级用户佣金为百分比（%）:</b>
                        <b class="price">一级用户佣金为固定金额:</b></dt>
                    <dd>
                        <span>
                        <input id="one_price" name="one_price" type="text" class="input" value="<?php echo $one_price;?>">
                        
                        </span>
                    </dd>
                </dl>                       
                <dl class="cf">
                    <dt>
                        <b class="rate">二级用户佣金为百分比（%）:</b>
                        <b class="price">二级用户佣金为固定金额:</b></dt>
                    <dd>
                        <span>
                        <input id="two_price" name="two_price" type="text" class="input" value="<?php echo $two_price;?>">
                        </span>
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>
                        <span class="rate">三级用户佣金为百分比（%）:</span>
                        <span class="price">三级用户佣金为固定金额:</span></dt>
                    <dd>
                        <span>
                        <input id="three_price" name="three_price" type="text" class="input" value="<?php echo $three_price;?>">
                        </span>
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>佣金获得的上限:</dt>
                    <dd>
                        <input name="max_commission" type="text" class="input" value="<?php echo $max_commission;?>"> (会员每次获得的佣金，将不超过这个数值)
                    </dd>
                </dl>  
                <dl class="cf">
                    <dt>冻结天数:</dt>
                    <dd>
                        <input name="freeze_day" type="text" class="input" value="<?php echo $freeze_day;?>"> (天)
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
    $.post("<?php echo input::site('admin/config/saveCommission')?>",
        $("form").serialize(),
        function(data){
            var da = eval('('+data+')');
            alert(da.msg);
        }
    )
}   
   
// 佣金类型选择
$("input[name=price_type]").click(function(){
    checked();
})
// 显示或隐藏
function checked(){
    $("input[name=price_type]:checked").each(function(n,e){
        if($(e).val()==0){
            $(".rate").attr("style","display:block;")
            $(".price").attr("style","display:none;")
        }else{
            $(".rate").attr("style","display:none;")
            $(".price").attr("style","display:block;")
        }
    })
}
(checked())();
</script>