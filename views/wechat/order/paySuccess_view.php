<header class="header buys pad0">
    <div class="favorites">
        <p><a class="return" href="JavaScript:history.go(-2);"><i></i><?php if($coupon->paystatus==1){echo '支付成功';}else if($coupon->paystatus==0){echo '支付失败';}?></a></p>
    </div>
</header>
<div class="container pad1">
    <div class="order_box">
        <div class="order_h1">
            <img src="<?php if($coupon->paystatus==1){
                                echo input::imgUrl('paysuccess.png','wechat');
                            }else if($coupon->paystatus==0){
                                echo input::imgUrl('payfaule.png','wechat');
                            }?>" /><!--暂替图片，后期更换---->
        </div>
        <?php
        if($coupon->paystatus==1)
        {
        ?>
        <div class="ck_btn">
            <h3 class="back_none btn_red2">
                <a href="<?php echo input::site('wechat/order/detail/'.S('paySuccess'));?>" class="mask_confirm">查看订单</a>
            </h3>
        </div>        
        <?php
        }
        else if($coupon->paystatus==0)
        {
        ?>
        <div class="ck_btn">
            <!---支付失败时显示--->
            <h3 class="back_none btn_red2">
                <a href="<?php echo input::site('wechat/order/detail/'.S('paySuccess'));?>" class="mask_confirm">请继续支付</a>
            </h3>
        </div>
        <?php
        }
        ?>
    </div>
</div>

<script>
    $(function () {

    });

</script>

