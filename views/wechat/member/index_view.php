<div class="container mar1">
    <div class="photo_top">
        <p><a class="return2" href="JavaScript:history.back();"><i></i></a></p>
        <h1 class="member_name">
            <img src="<?php echo $user->head_img;?>" />
            <p class=""><font><?php echo $user->nickname?></font><font>&nbsp;</font></p>
        </h1>

    </div>
    <ul class="member taker_member">
        <li class="member_list" href="<?php echo input::site('wechat/order/index');?>">
            <p class="mask_box2"></p>
            <dl class="tb">
                <dt class=" flex_1">我的订单</dt>
                <dd class=" flex_1"><span class="none"><?php echo $orderNum;?></span><i></i></dd>
            </dl>
        </li>
        <li class="member_list" href="<?php echo input::site('wechat/member/wallet');?>">
            <p class="mask_box2"></p>
            <dl class="tb">
                <dt class=" flex_1">收入明细</dt>
                <dd class=" flex_1"><span class="none"><em>￥</em><?php echo sprintf('%.2f',$commission);?></span><i></i></dd>
            </dl>
        </li>
        <li class="member_list" href="<?php echo input::site('wechat/member/next_list');?>">
            <p class="mask_box2"></p>
            <dl class="tb">
                <dt class=" flex_1">团队伙伴</dt>
                <dd class=" flex_1"><i></i></dd>
            </dl>
        </li>
        <li class="member_list" href="<?php echo input::site('wechat/member/nopay_list');?>">
            <p class="mask_box2"></p>
            <dl class="tb">
                <dt class=" flex_1">关注伙伴</dt>
                <dd class=" flex_1"><i></i></dd>
            </dl>
        </li>
    </ul>
</div>

<script>
    $(function () {
        $('.member_lis,.report h2').on('touchstart', function () {
            $('.member_list,.report h2').removeClass('on');
            $(this).addClass('on');
        });
        $('li[href]').on('touchstart', function () {
            $('li[href] .mask_box2').hide();
            $(this).find('.mask_box2').show();
        }).on('click', function () {
            location.href = $(this).attr('href');
        });

        $(document).on('touchend', function () {
            $('.mask_box2').hide();
            $('.member_list,.report h2').removeClass('on');
        }).on('touchmove', function () {
            $('.mask_box2').hide();
        });
    });

</script>

