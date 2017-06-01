<script type="text/javascript" src="http://3gimg.qq.com/lightmap/components/geolocation/geolocation.min.js"></script>
<header class="header buys pad0">
    <div class="favorites">
        <p><a class="return" href="JavaScript:history.back();"><i></i>订单详情</a></p>
    </div>
</header>
<div class="container pad1">
    <div class="order_box">
        <div class="order_h1">
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
                    <dl class="list_dl order_dl tb" itemId="<?php echo $item->item_id?>">
                        <dt>
                            <img src="<?php echo input::site($item->pic);?>" /></dt>
                        <dd class="flex_1">
                            <h1><?php echo $item->title?></h1>
                            <div class="list_text pad">
                                <h3><font>￥</font><?php echo $item->price?></h3>
                            </div>
                        </dd>
                    </dl>
                    <h4 class="toker_text">                        
                        <span style="float:right;color:red;">
                        <?php
                        if($item->paystatus == -1){
                            echo "订单取消";
                        }
                        ?>
                        </span>
                    </h4>                    
                </div>
                <?php
                if($item->orderStatus=='待付款')
                {
                ?>
                <h5 class="order_btn mar_bottom">
                    <a id="cancel">取消订单</a><a href="JavaScript:pay('<?php echo $item->id;?>');">立即支付</a>
                </h5>
                <?php
                }
                else if($item->orderStatus=='待收货')
                {
                ?>
                <h5 class="order_btn give">
                    <a onclick="JavaScript:;">查看物流</a>
                    <a onclick="JavaScript:make_sure('<?php echo $item->id;?>');">确认收货</a>
                </h5>
                <?php
                }
                else if($item->orderStatus=='退款中' && false)
                {
                ?>
                <h5 class="order_btn give" style="display: block">
                    <!---申请退款时显示-->
                    <a href="JavaScript:kfPhone();">联系客服</a><a class="red" href="JavaScript:tkCancel('<?php echo $item->id;?>');">取消退款</a><a href="JavaScript:showToFriend();">赠送亲友</a>
                </h5>
                <h6 class="f28">申请退款期间，您仍可正常使用这笔消费，使用后，退款申请失效，订单交易完成。</h6>
                <?php
                }
                else if($item->orderStatus=='交易关闭')
                {
                ?>
                <h5 class="order_btn give" style="display: block">
                    <!---交易关闭时显示-->
                    <a href="JavaScript:kfPhone();">联系客服</a><a href="JavaScript:delCoupon('<?php echo $item->id;?>');">删除订单</a>
                </h5>
                <?php                
                }
                else if($item->orderStatus=='交易完成')
                {
                ?>
                <h5 class="order_btn give" style="display: block">
                    <!---交易完成时显示-->
                    <a href="JavaScript:kfPhone();">联系客服</a>
                </h5>
                <?php
                }
                ?>
            </div>
        </div>        
       
        <div class="toker_number back2 pad_bott">
            <p>订单编号:<?php echo $item->code?></p>
            <p>创建时间:<?php echo date('Y-m-d H:i',$item->addtime);?></p>
            <?php 
            if($item->paytime){
            ?>
            <p>付款时间:<?php echo date('Y-m-d H:i',$item->paytime);?></p>
            <?php 
            }
            if($item->returntime){
            ?>
            <p>申请退款:<?php echo date('Y-m-d H:i',$item->returntime);?></p>
            <?php 
            }            
            if($item->usetime){
            ?>
            <p>收货时间:<?php echo date('Y-m-d H:i',$item->usetime);?></p>
            <?php 
            }
            if($item->overtime){
            ?>
            <p>完成时间:<?php echo date('Y-m-d H:i',$item->overtime);?></p>
            <?php
            }
            if($item->closetime){
            ?>
            <p>关闭时间:<?php echo date('Y-m-d H:i',$item->closetime);?></p>
            <?php 
            }
            ?> 
        </div>
    </div>
</div>

<!--遮罩层 -->
<div class="mask_box" style="display: none"></div>
<!--弹出框 -->
<div class="up up_box" id="up_box1" style="display: none">
    <div class="up_cen ">
        <p class="h3">电话咨询</p>
        <h1 class="two" id="butitle">福州经络通理疗馆工业路1号店<span>12345678901</span></h1>
        <h3 class="back_none">
            <a id="butel" href="tel:13955555701" class="mask_confirm">确认</a>
        </h3>
    </div>
</div>
<div class="up up_box" id="up_box3" style="display: none">
    <div class="up_cen">
        <h1>您确定要取消订单吗？</h1>
        <h2 class="up_btn tb">
            <a class="flex_1 close" href="JavaScript:orderCancel('<?php echo $item->id;?>')">确认</a><a class="flex_1 close">取消</a>
        </h2>
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
<div class="up up_box" id="up_box2" style="display: none;">
    <img src="<?php echo input::imgUrl('shareGuide.png','wechat');?>" />
</div>
<div class="up up_box" id="up_box4" style="display: none;background:initial;box-shadow:initial;">
    <div class="up_cen">
        <dl class="code_text">
            <dt>
                <img src="<?php echo input::imgUrl('loading.gif','wechat');?>" style="width: 2.5rem;height: 2.5rem;" />
            </dt>
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
    var geolocation;
    var posi;

    $(function () {
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
        //查看更多
        $('.more span').on('touchstart', function () {
            $(this).parents('.edit_cen').find('.edit_shop').css('height', 'auto')
        })
        //电话咨询浮框
        $('.edit_list a.tel').on('click', function () {
            $('#butitle').html($(this).attr('butitle') + '<span>' + $(this).attr('butel') + '</span>');
            $('#butel').attr('href', 'tel:' + $(this).attr('butel'));
            open_box('#up_box1');
            return false;
        });
        //取消订单
        $('#cancel').on('click', function () {
            open_box('#up_box3');
        });
        //二维码
        $('#code').on('click', function () {
            open_box('#up_box11');
        });
        $('#up_box11').on('touchend', function () {
            $('.mask_box').hide();
            $('#up_box11').hide();
            $('html,body').css({ overflow: 'initial' });
            return false;
        });
        $('#up_box4').on('touchend', function () {
            $('.mask_box').hide();
            $('#up_box4').hide();
            $('html,body').css({ overflow: 'initial' });
            return false;
        });
        $('#up_box2').on('touchend', function () {
            $('.mask_box').hide();
            $('#up_box2').hide();
            $('html,body').css({ overflow: 'initial' });
            return false;
        });
        //商品详情
        $('.order_dl').on('click', function () {
            <?php 
            if($item->item_id)
            {
                $good = M('tk_item')->getOneData(array('id'=>$item->item_id));
                if($good)
                {
            ?>
            location.href = '<?php echo input::site('wechat/goods/index/'); ?>' + $(this).attr('itemId');
            <?php 
                }
                else
                {
            ?>
            alert('商品不存在');
            <?php 
                }
            }
            else
            {
            ?>
            alert('商品不存在');
            <?php 
            }
            ?>
        });

    });

        function pay(itemId) {
            $('.mask_box').off();
            $('.mask_box').show();
            $.post("<?php echo input::site('wechat/order/wepay');?>", { orderId: itemId }, function (data) {
            var da = eval("(" + data + ")");
            if (da.success == 1) {
                if (da.jsApiParameters) {
                    jsApiParameters = da.jsApiParameters
                    if (typeof WeixinJSBridge == "undefined") {
                        if (document.addEventListener) {
                            document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
                        } else if (document.attachEvent) {
                            document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                            document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
                        }
                    } else {
                        jsApiCall();
                    }
                } else {
                    location.href = '<?php echo input::site('wechat/order/paySuccess/'.S('detail'));?>';
                }
            } else {
                if (da.msg) {
                    alert(da.msg);
                    $('.mask_box').hide();
                    $('.mask_box').on('touchend', function (e) {
                        $('.mask_box').hide();
                        $('#up_box1').hide();
                        $('#up_box11').hide();
                        $('#up_box3').hide();
                        $('html,body').css({ overflow: 'initial' });
                        return false;
                    });
                }
            }
        });
    }

    //调用微信JS api 支付
    function jsApiCall() {
        WeixinJSBridge.invoke('getBrandWCPayRequest', jsApiParameters, function (res) {
            if (res.err_msg == "get_brand_wcpay_request：ok") {
                location.href = '<?php echo input::site('wechat/order/paySuccess/'.S('detail'));?>';
            } else {
                location.href = '<?php echo input::site('wechat/order/paySuccess/'.S('detail'));?>';
            }
        });
    }

    function showToFriend() {
        if (confirm('您确定要将本次消费赠送给您的亲友吗？限一人使用哦。')) {
            open_box('#up_box2');
            $('#up_box2').css('top', '0.6rem');
            $('#up_box2').css('box-shadow', '0px 0px 0px #000');
            $('#up_box2').css('background', 'rgba(0, 0, 0, 0)');
        }
    }

    function kfPhone() {
        $('#butitle').html('拓客客服电话<span><?php echo $kfPhone; ?></span>');
        $('#butel').attr('href', 'tel:<?php echo $kfPhone; ?>');
        open_box('#up_box1');
    }

    function tkApply(itemId) {
        $.post("<?php echo input::site('wechat/order/tkApply');?>", { orderId: itemId }, function (data) {
            if (data === '1') {
                location.reload();
            } else {
                alert(data);
            }
        });
    }

    function tkCancel(itemId) {
        $.post("<?php echo input::site('wechat/order/tkCancel');?>", { orderId: itemId }, function (data) {
            if (data === '1') {
                location.reload();
            } else {
                alert(data);
            }
        });
    }

    function delCoupon(itemId) {
        if(confirm("是否确认删除订单!")){            
            $.post("<?php echo input::site('wechat/order/delCoupon');?>", { orderId: itemId }, function (data) {
                if (data === '1') {
                    location.href="<?php echo input::site('wechat/order/index');?>";
                } else {
                    alert(data);
                }
            });
        }
    }

    function orderCancel(itemId) {
        $.post("<?php echo input::site('wechat/order/cancelCoupon');?>", { orderId: itemId }, function (data) {
            if (data === '1') {
                location.reload();
            } else {
                alert(data);
            }
        });
    }

    function useCoupon() {
        var code = "<?php echo $item->code;?>";
        var shopurl = '';
        wx.scanQRCode({
            needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
            scanType: ["qrCode", "barCode"], // 可以指定扫二维码还是一维码，默认二者都有
            success: function (res) {
                open_box('#up_box4');
                shopurl = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
                $.post("<?php echo input::site('wechat/order/useCoupon');?>", {'shopurl':shopurl,'code':code},
                function (data) {
                    console.log(shopurl);
                    if (data == 1) {
                        location.reload();
                    } else {
                        alert(data);
                    }
                });
            }
        });
    }
 // 确认收货
function make_sure(id){
    $.post('<?php echo input::site("wechat/order/make_sure");?>',{'id':id},
        function(data){            
            var data = eval("("+data+")");
            if(data.success == 1){
                location.reload();
            }
            alert(data.msg);
        })
}
</script>

