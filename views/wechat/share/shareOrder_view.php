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
<div class="container">
    <div class="order_box pad_none2">
        <div class="order_h1 m14">
            <img src="<?php echo $item->orderpng;?>" />
        </div>
        <div class="toker_order">
            <p>购买账号</p>
            <dl class="toker_dl">
                <dt>
                    <img src="<?php echo $user->head_img;?>" width="100%" height="100%" /></dt>
                <dd>
                    <span class="f32"><?php echo $user->nickname?></span>
                    <span class="f28">&nbsp;</span>
                </dd>

            </dl>
        </div>
        <div class="order_h3">
            <div class="order_p1">
                <div class="commodity_list">
                    <dl class="list_dl order_dl tb">
                        <dt>
                            <img src="<?php echo input::site($item->pic);?>" /></dt>
                        <dd class="flex_1">
                            <h1><?php echo $item->title?></h1>
                            <div class="list_text pad">
                                <h3><font>￥</font><?php echo $item->price?></h3>
                            </div>
                        </dd>
                    </dl>
                    <h4 class="toker_text pad21">
                        <span class="f28">有效期：</span>   至<?php echo date('Y-m-d',$item->validity);?>
                    </h4>
                </div>
            </div>
        </div>
        <?php
        if($item->orderStatus!='待付款')
        {
        ?>
        <!-- 待使用 -->
        <div class="give_cen back2 bor_top">
            <p>到店消费</p>
            <dl class="method">
                <dt class="f282">方法一<a <?php if($item->orderStatus=='交易完成' || $item->orderStatus=='交易关闭'){
                                                 echo ' class="two" ';
                                             } else {
                                                 echo ' href="javascript:useCoupon();" ';
                                            }?> >到店使用</a></dt>
                <dd>到店后，点击此按钮，扫描商家二维码，完成消费。</dd>
            </dl>
            <dl class="method method2">
                <dt class="f282">
                    <h2 class="f282">方法二</h2>
                    <h2 class="f282">券码：<?php echo $item->code;?></h2>
                    <?php if($item->orderStatus=='交易完成' || $item->orderStatus=='交易关闭'){?>
                    <h1>
                        <!--交易关闭和交易完成时显示-->
                        <span class="mask_box3"></span>
                        <span class="text"><font>二维码<br>已失效</font></span>
                        <img src="<?php echo input::imgUrl('fanx_07.jpg','wechat');?>" />
                    </h1>
                    <?php }else{?>
                    <h1 id="code">
                        <img src="<?php echo $qrcodeUrl;?>" />
                    </h1>
                    <?php }?>
                </dt>
                <dd>到店后让商家扫描您的订单二维码，或输入券码，完成消费。</dd>
            </dl>

        </div>
        <?php
        }
        ?>
        <div class="toker_store m14">
            <p class="h1 f362"><span></span><?php echo $item->orderStatus=='交易完成'?'已选':'可选';?>店铺</p>
            <?php if($item->orderStatus!='交易完成'){?>
            <h1 class="two">为您提供<?php echo $total;?>家店铺，供您挑选</h1>
            <?php }?>
            <div class="edit_cen">
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
                                <font><a class="tel" butitle="<?php echo $bus['name']; ?>" butel="<?php echo $bus['mobile']; ?>">电话咨询</a></font>
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
            <div class="top_iosn"><a href="JavaScript:topIosn();"></a></div>
        </div>
        <div class="toker_number back2 pad_bott">
            <p>订单编号:<?php echo $item->code?></p>
            <p>创建时间:<?php echo date('Y-m-d H:i',$item->addtime);?></p>
            <?php if($item->paytime){?>
            <p>付款时间:<?php echo date('Y-m-d H:i',$item->paytime);?></p>
            <?php }?>
            <?php if($item->returntime){?>
            <p>申请退款:<?php echo date('Y-m-d H:i',$item->returntime);?></p>
            <?php }?>
            <?php if($item->overtime){?>
            <p>退款完成:<?php echo date('Y-m-d H:i',$item->overtime);?></p>
            <?php }?>
            <?php if($item->usetime){?>
            <p>使用时间:<?php echo date('Y-m-d H:i',$item->usetime);?></p>
            <?php }?>
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
<div class="up up_box" id="up_box11" style="display: none;">
    <div class="up_cen">
        <dl class="code_text">
            <dt>
                <img src="<?php echo $qrcodeUrl;?>" /></dt>
            <dd class="">
                <p>到店消费时，可以打开此二维码，让商家扫描，完成这笔订单的消费。</p>
                <p>若您将订单赠送给您的亲友，当此二维码被商家扫描后，这笔订单的消费将同样完成。</p>
                <p>订单交易完成后，二维码将失效，不能再使用。</p>
            </dd>
        </dl>
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
$(function(){
    get_range();
})
function get_range(){
    $("span[class='flex_1 distancs']").each(function(n,e){
        var str = $(e).attr('loc');
        $.post("<?php echo input::site('wechat/goods/get_range')?>",{'str':str},
            function(data){
                $(e).html(data);
            })
    })
}
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
        //点击按钮
        $(function () {
            $('.back_none').on('touchstart', function (e) {
                $(this).find('a').addClass('on');
                e.stopPropagation();;
            });
            $(document).on('touchend', function () {
                $('.back_none a.on').removeClass('on');
            });
        })
        //点击按钮
        $('.share_h1 h2').on('touchstart', function (e) {
            $(this).addClass('into');
            e.stopPropagation();;
        });
        $(document).on('touchend', function () {
            $('.share_h1 h2.into').removeClass('into');
        });
        //电话咨询浮框
        $('.edit_list a.tel').on('click', function () {
            $('#butitle').html($(this).attr('butitle') + '<span>' + $(this).attr('butel') + '</span>');
            $('#butel').attr('href', 'tel:' + $(this).attr('butel'));
            open_box('#up_box1');
            return false;
        });
        //二维码
        $('#code').on('touchstart', function () {
            open_box('#up_box11');
        });
        $('#up_box11').on('touchend', function () {
            $('.mask_box').hide();
            $('#up_box11').hide();
            $('html,body').css({ overflow: 'initial' });
            return false;
        });
    });

    function useCoupon() {
        var code = '';
        wx.scanQRCode({
            needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
            scanType: ["qrCode", "barCode"], // 可以指定扫二维码还是一维码，默认二者都有
            success: function (res) {
                code = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
                $.post("<?php echo input::site('wechat/order/useCoupon');?>", { code: code }, function (data) {
                    if (data == 1) {
                        location.reload();
                    } else {
                        alert(data);
                    }
                });
            }
        });
    }

</script>