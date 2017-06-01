<!-- 滚动图片插件 -->
<link href="<?php echo input::jsUrl("touchslideimg/touchslideimg.css",'wechat'); ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo input::jsUrl("touchslideimg/touchslideimg.js",'wechat'); ?>"></script>

<div class="share_top">
    <div class="share_h1" style="background: initial;">
        <p>拓客共享商城</p>
        <h2>
            <a style="display: none" href="http://www.tpy10.net/create.php?name=hzcs168" class="gotosee">进入拓客</a>
        </h2>
        <img src="<?php echo input::imgUrl('fenxiang_03.png','wechat');?>" style="width:100%;height:100%;left:0px;top:0px;z-index:-1;" />
        <img src="<?php echo input::imgUrl('fenxiang_03.png','wechat');?>" style="width:100%;height:100%;left:0px;top:0px;opacity:0.0;"/>
    </div>
</div>
<div class="banner_box m14">
    <ul class="banner_img cf">
        <?php 
        foreach($item->pics as $pic)
        { 
        ?>
        <li><a href="javascript:void(0);">
            <img src="<?php echo input::site($pic); ?>" /></a></li>
        <?php }?>
    </ul>
</div>
<div class="commodity_box">
    <p class="commodity_title"><?php echo $item->title;?></p>
    <dl class="commodity_h2 tb">
        <dt><font>￥</font><?php echo $item->price;?></dt>
    </dl>
    <dl class="commodity_h3 tb">
        <dd class="flex_1">有效期：至<?php echo date('Y-m-d',$item->validity);?></dd>
        <dd>已售<?php echo $item->sell_num;?>笔</dd>
    </dl>

</div>
<div class="commodity_box2 mar8">
    <ul class="order_ul tb back2">
        <li class="flex_1 on"><a>详情介绍</a></li>
        <li class="flex_1"><a>可选店铺</a></li>
    </ul>
    <div class="edit_text">
        <!--详情介绍-->
        <div class="edit_cen">
            <?php echo $item->content;?>
        </div>
        <!--可选店铺-->
        <div class="edit_cen" style="display: none">
            <div class="edit_shop" style="height: auto;">
                <?php 
                foreach($business as $bus)
                { 
                ?>
                <dl class="edit_list">
                    <dt>
                        <img src="<?php echo input::site($bus['pic']); ?>" /></dt>
                    <dd>
                        <h2><?php echo $bus['name']; ?></h2>
                        <h1 class="tb">
                            <span class="flex_1 distancs" id="<?php echo $bus['id']; ?>" loc="<?php echo $bus['lat'].','.$bus['lng']; ?>">
                                <img style="width: 18px;" src="<?php echo input::imgUrl('wait.gif','wechat'); ?>">
                            </span>                            
                            <font><a class="tel" butitle="<?php echo $bus['name']; ?>" butel="<?php echo $bus['mobile']; ?>">联系商家</a></font>
                        </h1>
                        <p>店铺地址：<?php echo $bus['address']; ?></p>
                        <p>详细地址：<?php echo $bus['full_address']; ?></p>
                    </dd>
                </dl>
                <?php }?>
            </div>
            <?php 
            if(empty($business)){
                echo "<img class='default' src=".input::imgUrl('list_default.png','wechat')."><p style='width: 100%;text-align: center;font-size:2em;'>商家列表为空</p>";
            }else{
                if($total>10){
                    echo '<div class="more more2"><span onclick="more(1)">查看更多</span></div>';                    
                }else{        
                    echo '<div class="more more3">已到达页面底部</div>';
                }
            }
            ?>
            <input type="hidden" name="itemId" id="itemId" value="<?php echo $itemId?>">
        </div>
    </div>
</div>
<div class="share_top">
    <div class="share_h1" style="background: initial;">
        <p>拓客共享商城</p>
        <h2>
            <a style="display: none" href="http://www.tpy10.net/create.php?name=hzcs168" class="gotosee">进入拓客</a>
        </h2>
        <img src="<?php echo input::imgUrl('fenxiang_03.png','wechat');?>" style="width:100%;height:100%;left:0px;top:0px;z-index:-1;" />
        <img src="<?php echo input::imgUrl('fenxiang_03.png','wechat');?>" style="width:100%;height:100%;left:0px;top:0px;opacity:0.0;"/>
    </div>
</div>
<div class="top_iosn"><a href="JavaScript:topIosn();"></a></div>

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
// $(function(){
//     get_range();
// })
// function get_range(){
//     $("span[class='flex_1 distancs']").each(function(n,e){
//         var str = $(e).attr('loc');
//         $.post("<?php echo input::site('wechat/goods/get_range')?>",{'str':str},
//             function(data){
//                 $(e).html(data);
//             })
//     })
// }
// 查看更多
function more(n){
    var id = $("#itemId").val();

    $.post('<?php echo input::site("wechat/business/get_more");?>',{'page':n,'id':id},
        function(data){            
            if(data != ""){
                $(".edit_shop").append(data);
                $(".more>span").attr("onclick","more("+(n+1)+")");
                get_range();
            }
            if((n*10+10)>=<?php echo $total;?>){
                $(".more2").html("已到达页面底部");
            }
        })
}
    $(function () {
        $('div.box').css('z-index', 1);
        if ((navigator.userAgent.match(/(Android)/i))) {
            //$('.gotosee').show();
        }

        // 轮播图
        $('.banner_img').touchslideimg();

        //标签
        $('.order_ul li').on('touchstart', function () {
            var ind = $('.order_ul li').index(this);
            $('.order_ul li').removeClass('on');
            $(this).addClass('on');
            $('.edit_cen').hide().eq(ind).show();
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

</script>

