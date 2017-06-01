<header class="header buys pad0">
    <div class="favorites">
        <p><a class="return" href="JavaScript:history.back();"><i></i>我的</a></p>
        <span class="edit iosn" onclick="location.href='<?php echo input::site('mobile/member/showPointsInstruction')?>'"></span>
    </div>
</header>
<div class="container pad1">
    <div class="gole_cen">
        <div class="gole_box">
            <dl class="gole_h1">
                <dt>您当前拥有</dt>
                <dd class="tb">
                    <span class="flex_1">
                        <p><i></i><font id="points">&nbsp;11000</font></p>
                        <p class="text">积分</p>
                    </span>
                    <em></em>
                    <span class="flex_1">
                        <p id="sharePoints"><font class="f30">¥</font> 10000</p>
                        <p class="text">积分分红</p>
                    </span>
                </dd>
            </dl>
        </div>
        <dl class="gole_h1 gole_h2">
            <dt>本季度预计分红</dt>
            <dd class="tb">
                <span class="flex_1">
                    <p id="amount"><font class="f30">¥</font> 23333.00</p>
                    <p class="text">商城累计消费</p>
                </span>
                <em></em>
                <span class="flex_1">
                    <p id="fenhonglv">2 <font class="f30">%</font></p>
                    <p class="text">积分分红率</p>
                </span>
            </dd>
        </dl>
        <div class="gole_h3 bor">
            <p>年终预计分红收益=账户积分*积分分红率</p>
            <p id="forsee">10000*2%=¥200</p>
        </div>
        <div class="gole_h4">
            <h1><i></i><font>积分获得</font></h1>
            <ul class="gole_classify tb">
                <li class="flex_1 on">
                    <a>全部</a>
                </li>
                <li class="flex_1 ">
                    <a>朋友赠送</a>
                </li>
                <li class="flex_1">
                    <a>购买获得</a>
                </li>
            </ul>
            <div class="gole_list">
                <!--全部-->
                <div class="gole_content">
                </div>
                <!--朋友赠送-->
                <div class="gole_content" style="display: none">
                </div>
                <!--购买获得-->
                <div class="gole_content" style="display: none">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        //金币获得分类
        $('.gole_classify li').on('touchstart', function () {
            var ind = $('.gole_classify li').index(this);
            $('.gole_classify li').removeClass('on');
            $(this).addClass('on');
            $('.gole_content').hide().eq(ind).show();
            getPointsLog(ind);

        });

        $.post('<?php echo input::site('mobile/member/getPoints');?>', function (data) {
            var data = eval("(" + data + ")");
            if (data.success == 1) {
                var info = data.info;
                $('#points').html('&nbsp;' + info.points);
                $('#sharePoints').html('<font class="f30">¥</font> ' + info.share_points);
                $('#amount').html('<font class="f30">¥</font> ' + info.amount);
                $('#forsee').html(info.amount+'*'+info.fenhonglv+'%=¥'+info.forsee);
                $('#fenhonglv').html(info.fenhonglv + ' <font class="f30">%</font>');
            }
        });
        getPointsLog(0);
    });

    function getPointsLog(ty,str) {
        str = '<h2 class=" bor_bott">共计???，其中本月获得???</h2>';
        $.post('<?php echo input::site('mobile/member/getPointsLog');?>', { ty: ty, str: str }, function (data) {
            var data = eval("(" + data + ")");
            if (data.success == 1) {
                var info = data.info;
                str = info.str;
            }
            $('.gole_content').eq(ty).html(str);
        });
    }

</script>

