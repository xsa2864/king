<!-- 滚动图片插件 -->
<link href="<?php echo input::jsUrl("touchslideimg/touchslideimg.css",'wechat'); ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo input::jsUrl("touchslideimg/touchslideimg.js",'wechat'); ?>"></script>


<div class="banner_box">
    <ul class="banner_img cf">
        <?php 
        foreach($item->pics as $pic)
        { 
        ?>
        <li><a href="javascript:void(0);">
            <img src="<?php echo input::site($pic); ?>" /></a></li>
        <?php }?>
    </ul>
    <div class="iosn_box">
        <a class="back" href="JavaScript:history.back();"></a>
        <a style="display: none"></a>
    </div>
</div>
<div class="commodity_box">
    <p class="commodity_title"><?php echo $item->title;?></p>
    <dl class="commodity_h2 tb">
        <dt><font>￥</font><?php echo $item->price;?></dt>
        <dd class="flex_1" style="font-size: 0.28rem;color: #aeaeae;">库存<?php echo $item->stock;?>件</dd>
    </dl>
    <dl class="commodity_h3 tb">
        <dd>已售<?php echo $item->sell_num;?>笔</dd>
    </dl>

</div>
<div class="commodity_box2 mar8">
    <ul class="order_ul tb back2">
        <li class="flex_1 on"><a>详情介绍</a></li>
    </ul>
    <div class="edit_text">
        <!--详情介绍-->
        <div class="edit_cen">
            <?php echo $item->content;?>
        </div>       
    </div>
</div>
<div class="top_iosn"><a href="JavaScript:topIosn();"></a></div>
<div class="receipt_foot btn_mask">
    <?php 
    if($item->stock>0 && $item->status==1){
    ?>
    <a href="JavaScript:makeOrder();">立即购买<span class="mask_box2" style="display: none;"></span></a>
    <?php
    }else{
    ?>
    <a style="background: #b8b8b8;">商品已下架</a>
    <?php
    }
    ?>
</div>

<!--遮罩层-->
<div class="mask_box" style="display: none"></div>
<!--弹出框-->
<div class="up up_box" id="up_box1" style="display: none">
    <div class="up_cen ">
        <p class="h3">电话咨询</p>
        <h1 class="two" id="butitle">福州经络通理疗馆工业路1号店<span>12345678901</span></h1>
        <h3 class="back_none">
            <a id="butel" href="tel:13955555701" class="mask_confirm">确认</a>
        </h3>
    </div>
</div>

<style type="text/css">
.default{
    width: 70px;
    margin: auto;
    padding-top: 100px;
}
.more2,.more3{
    font-size: 2em;
}
</style>

<script>
    var geolocation;
    var posi;
    $(function () {
        //数字
        $('.edit_num span').on('touchstart', function () {
            var value = parseInt($('.edit_num input').val());
            $(this).text() == '1' ? value-- : value++;
            $('.edit_num input').val(value).blur();
        });

        // 轮播图
        $('.banner_img').touchslideimg();

        //标签
        $('.order_ul li').on('click', function () {
            var ind = $('.order_ul li').index(this);
            $('.order_ul li').removeClass('on');
            $(this).addClass('on');
            $('.edit_cen').hide().eq(ind).show();
        });
        //点击按钮
        $(function () {
            $('.btn_mask').on('touchstart', function (e) {
                $(this).find('a').addClass('on');
                e.stopPropagation();
            });
            $(document).on('touchend', function () {
                $('.btn_mask a.on').removeClass('on');
            });
        });

        //电话咨询浮框
        $('.edit_list a.tel').on('click', function () {
            $('#butitle').html($(this).attr('butitle') + '<span>' + $(this).attr('butel') + '</span>');
            $('#butel').attr('href', 'tel:' + $(this).attr('butel'));
            topIosn();
            open_box('#up_box1');
            return false;
        });
    });

    function makeOrder() {
        if(<?php echo $first;?>){
            location.href = "<?php echo input::site('wechat/member/get_bind/'.$item->id);?>";
            return false;
        }        
        $.post("<?php echo input::site('wechat/order/checkLimit/'.$item->id);?>", function (data) {
            if (data==1) {
                location.href = "<?php echo input::site('wechat/order/makeOrder/'.$item->id);?>";
            } else {
                alert(data);
            }
        });
    }

</script>

