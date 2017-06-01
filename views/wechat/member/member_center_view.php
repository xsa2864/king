<div class="container mar1">
    <div class="photo_top">
        <p></p>
        <h1 id ="user">
            <span id="head_img">
                <img src="<?php echo input::imgUrl('member_03.png','mobile')?>" /></span>
            <label id="nickname">佚名</label>
        </h1>
        <div class="report">
            <h2>
                <span class="mask_box2 radius"></span>
                <span class="mask_btn radius "><i></i><font>签到</font></span>
            </h2>
        </div>
    </div>
    <ul class="member">
        <li class="member_list" onclick="#">
            <p class="mask_box2"></p>
            <dl class="tb">
                <dt class=" flex_1">我的名片</dt>
                <dd class=" flex_1"><i></i></dd>
            </dl>
        </li>
        <li class="member_list" onclick="#">
            <p class="mask_box2"></p>
            <dl class="tb">
                <dt class=" flex_1">会员等级</dt>
                <dd class=" flex_1"><span id="leval"></span><i></i></dd>
            </dl>
        </li>
        <li class="member_list" onclick="location.href='<?php echo input::site('mobile/member/showPoints')?>'">
            <p class="mask_box2"></p>
            <dl class="tb">
                <dt class=" flex_1">积分中心</dt>
                <dd class=" flex_1"><span id="points">0</span><i></i></dd>
            </dl>
        </li>
        <li class="member_list" onclick="location.href='<?php echo input::site('mobile/member/showGold')?>'">
            <p class="mask_box2"></p>
            <dl class="tb">
                <dt class=" flex_1">我的金币</dt>
                <dd class=" flex_1"><span id="golds">0</span><i></i></dd>
            </dl>
        </li>
        <li class="member_list" onclick="#">
            <p class="mask_box2"></p>
            <dl class="tb">
                <dt class=" flex_1">余额提现</dt>
                <dd class=" flex_1"><i></i></dd>
            </dl>
        </li>
        <li class="member_list" onclick="location.href='<?php echo input::site('mobile/goods/show_collection')?>'">
            <p class="mask_box2"></p>
            <dl class="tb">
                <dt class=" flex_1">我的收藏</dt>
                <dd class=" flex_1"><i></i></dd>
            </dl>
        </li>
        <li class="member_list" onclick="#">
            <p class="mask_box2"></p>
            <dl class="tb">
                <dt class=" flex_1">消息提醒</dt>
                <dd class=" flex_1"><span class="none">0</span><i></i></dd>
            </dl>
        </li>
        <li class="member_list" onclick="#">
            <p class="mask_box2"></p>
            <dl class="tb">
                <dt class=" flex_1">地址管理</dt>
                <dd class=" flex_1"><i></i></dd>
            </dl>
        </li>
    </ul>
</div>


<script>
    $(function () {
        $('footer li').on('touchstart', function () {
            $('footer li').removeClass('on');
            $(this).addClass('on');
        });
        $('.member_lis,.report h2').on('touchstart', function () {
            $('.member_list,.report h2').removeClass('on');
            $(this).addClass('on');
        });
        $('li[href]').on('touchstart', function () {
            $('li[href] .mask_box2').hide();
            $(this).find('.mask_box2').show();
        }).on('touchend', function () {
            location.href = $(this).attr('href');
        });
        // $('.report h2').on('touchend',function(){
        //   $('.report h2').find('i').css('display','none');
        //   $('.report h2').find('font').html('已签到');
        // });
        $(document).on('touchend', function () {
            $('.mask_box2').hide();
            $('.member_list,.report h2').removeClass('on');
        }).on('touchmove', function () {
            $('.mask_box2').hide();
        });
    });
    (function () {
        $.post(fx_get_center_info, function (data) {
            var data = eval("(" + data + ")");
            console.log(data);
            if (data.success == 1) {
                var info = data.info;
                console.log(info);
                $("#golds").html(info.golds);
                $("#points").html(info.points);
                $("#leval").html(info.levelName);
                $(".none").html(info.note);
                if (info.head_img) {
                }else{
                    info.head_img = '<?php echo input::imgUrl('member_03.png','mobile')?>';
                }
                if (!info.nickname) {
                    info.nickname = '佚名';
                }
                $("#user").html('<span> <img src="' + info.head_img + '" /></span>' + info.nickname);
            }
        })
    })();
    // 签到
    $(".mask_btn").click(function () {
        $.post(fx_member_mask, function (data) {
            var data = eval("(" + data + ")");
            alert(data.msg);
            location.reload();
        })
    });

</script>
