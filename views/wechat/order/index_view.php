<header class="header buys pad0">
    <div class="favorites">
        <p class="my_order"><a class="return" href="javascript:history.back();"><i></i>我的订单</a></p>
    </div>
</header>
<div class="container pad1 ">
    <div class="order_box ">
        <ul class="order_ul tb back2">
            <li class="flex_1 on"><a>全部</a></li>
            <li class="flex_1"><a>待付款</a></li>
            <li class="flex_1"><a>待收货</a></li>
            <li class="flex_1"><a>已完成</a></li>
        </ul>
        <div class="my_orderbox">
            <!-- 全部 -->
            <div class="my_ordercen">
                <?php                     
                foreach($allList as $key => $item){ 
                    $str = '';
                    if($item->paystatus==0)
                    {
                        $item->orderStatus='待付款';
                        $str = '<a onclick="javacript:tkCancel('.$item->id.');">取消订单</a><a onclick="javacript:pay('.$item->id.');">立即支付</a>';
                    }
                    else if($item->paystatus==1 && $item->is_use<=1){
                        $item->orderStatus='待收货';
                        $str = '<a onclick="javacript:pay('.$item->id.');">查看物流</a><a onclick="make_sure('.$item->id.');">确认收货</a>';                        
                    }               
                    else if($item->paystatus==1 && $item->is_use==2)
                    {
                        $item->orderStatus='交易完成';
                        $str = '<a href="tel:'.$tel.';">联系客服</a>';
                    }
                    else
                    {
                        $item->orderStatus='交易关闭';
                        $str = '<a href="javascript:delCoupon('.$item->id.')">删除订单</a>';
                    }
                ?>
                <div class="order_h3" >
                    <h5 class="tb">
                        <span class="flex_1">订单编号 <?php echo $item->code;?></span>
                        <span><?php echo $item->orderStatus;?></span>
                    </h5>
                    <div class="order_p1">
                        <div class="commodity_list" orderId="<?php echo $item->id;?>">
                            <dl class="list_dl order_dl tb">
                                <dt>
                                    <img src="<?php echo input::site($item->pic);?>" /></dt>
                                <dd class="flex_1">
                                    <h1><?php echo $item->title;?></h1>
                                    <div class="list_text pad">
                                        <h3><font>￥</font><?php echo $item->price;?></h3>
                                    </div>
                                </dd>
                            </dl>                            
                        </div>
                        <h5 class="order_btn">
                            <?php
                            echo $str;
                            ?>
                        </h5>
                    </div>
                </div>
                <?php
                }    
                if(empty($allList)){
                    echo "<img class='default' src=".input::imgUrl('list_default.png','wechat')."><p style='width: 100%;text-align: center;font-size:2em;'>订单列表为空</p>";
                }else{
                    if($all>10){
                        echo '<div class="more more_all" ><span onclick="more_all(1)">查看更多</span></div>';
                    }else{
                        echo '<div class="more more_all">已到达页面底部</div>';
                    }
                }                
                ?>
                
            </div>
            <!---待付款 -->
            <div class="my_ordercen" style="display: none">
                <?php
                foreach($payList as $item){                    
                ?>
                <div class="order_h3">
                    <h5 class="tb">
                        <span class="flex_1">订单编号 <?php echo $item->code;?></span>
                        <span>待付款</span>
                    </h5>
                    <div class="order_p1">
                        <div class="commodity_list"  orderId="<?php echo $item->id;?>">
                            <dl class="list_dl order_dl tb">
                                <dt>
                                    <img src="<?php echo input::site($item->pic);?>" /></dt>
                                <dd class="flex_1">
                                    <h1><?php echo $item->title;?></h1>
                                    <div class="list_text pad">
                                        <h3><font>￥</font><?php echo $item->price;?></h3>
                                    </div>
                                </dd>
                            </dl>                            
                        </div>
                        <h5 class="order_btn">
                            <a onclick="javacript:tkCancel('<?php echo $item->id;?>');">取消订单</a>
                            <a onclick="javacript:pay('<?php echo $item->id;?>');">立即支付</a>
                        </h5>
                    </div>
                </div>
                <?php 
                }                
                ?>

                <?php                    
                
                if(empty($payList)){
                    echo "<img class='default' src=".input::imgUrl('list_default.png','wechat')."><p style='width: 100%;text-align: center;font-size:2em;'>待付款订单为空</p>";
                }else{
                    if($pay>10){
                        echo '<div class="more more_pay" ><span onclick="more_pay(1)">查看更多</span></div>';
                    }else{
                        echo '<div class="more more_pay">已到达页面底部</div>';
                    }
                }
                ?>
            </div>
            <!---待收货-->
            <div class="my_ordercen" style="display: none">
                <?php
                foreach($useList as $item){                    
                ?>
                <div class="order_h3">
                    <h5 class="tb">
                        <span class="flex_1">订单编号 <?php echo $item->code;?></span>
                        <span>待收货</span>
                    </h5>
                    <div class="order_p1">
                        <div class="commodity_list"  orderId="<?php echo $item->id;?>">
                            <dl class="list_dl order_dl tb">
                                <dt>
                                    <img src="<?php echo input::site($item->pic);?>" /></dt>
                                <dd class="flex_1">
                                    <h1><?php echo $item->title;?></h1>
                                    <div class="list_text pad">
                                        <h3><font>￥</font><?php echo $item->price;?></h3>
                                    </div>
                                </dd>
                            </dl>                            
                        </div>  
                        <h5 class="order_btn">
                            <a onclick="make_sure('<?php echo $item->id;?>');">查看物流</a>
                            <a onclick="make_sure('<?php echo $item->id;?>');">确认收货</a>
                        </h5>                     
                    </div>
                </div>
                <?php 
                }
                ?>

                <?php   
                if(empty($useList)){
                    echo "<img class='default' src=".input::imgUrl('list_default.png','wechat')."><p style='width: 100%;text-align: center;font-size:2em;'>待使用订单为空</p>";
                }else{
                    if($use>10){
                        echo '<div class="more more_use" ><span onclick="more_use(1)">查看更多</span></div>';
                    }else{
                        echo '<div class="more more_use">已到达页面底部</div>';
                    }
                }
                ?>
            </div>
            
            <!--交易完成-->
            <div class="my_ordercen" style="display: none">
                <?php    
                foreach($overList as $item){    
                ?>
                <div class="order_h3">
                    <h5 class="tb">
                        <span class="flex_1">订单编号 <?php echo $item->code;?></span>
                        <span>交易完成</span>
                    </h5>
                    <div class="order_p1">
                        <div class="commodity_list" orderId="<?php echo $item->id;?>">
                            <dl class="list_dl order_dl tb">
                                <dt>
                                    <img src="<?php echo input::site($item->pic);?>" /></dt>
                                <dd class="flex_1">
                                    <h1><?php echo $item->title;?></h1>
                                    <div class="list_text pad">
                                        <h3><font>￥</font><?php echo $item->price;?></h3>
                                    </div>
                                </dd>
                            </dl>                            
                        </div>
                        <h5 class="order_btn">
                            <a class="" href="tel:<?php echo $item->tkb_tel;?>">联系客服</a> 
                        </h5>     
                    </div>
                </div>
                <?php 
                }                
                ?>
                
                <?php 
                if(empty($overList)){
                    echo "<img class='default' src=".input::imgUrl('list_default.png','wechat')."><p style='width: 100%;text-align: center;font-size:2em;'>交易完成订单为空</p>";
                }else{
                    if($over>10){
                        echo '<div class="more more_over" ><span onclick="more_over(1)">查看更多</span></div>';
                    }else{
                        echo '<div class="more more_over">已到达页面底部</div>';
                    }
                }
                ?>
            </div>
            <!---退款中-->
            
        </div>
    </div>
</div>
<!--遮罩层 -->
<div class="mask_box" style="display: none"></div>
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
.my_ordercen .order_h3{
    margin-bottom: 8px;
}
.default{
    width: 80px;
    margin: auto;
    padding-top: 100px;
}
.more_all,.more_pay,.more_over,.more_use{
    font-size: 2em;
}
</style>
<script>
    var payStatus = 0;
    var payItemId;
    $(function () {
        if (history.length <= 1) {
            $('.return').css('background-image', 'initial');
        }
        $('#up_box4').on('touchend', function () {
            $('.mask_box').hide();
            $('#up_box4').hide();
            $('html,body').css({ overflow: 'initial' });
            return false;
        });
        $('.order_ul li').on('touchstart', function () {
            var ind = $('.order_ul li').index(this);
            $('.order_ul li').removeClass('on');
            $(this).addClass('on');
            $('.my_ordercen').hide().eq(ind).show();
        });
        bind_click();
    });
    function goto(tourl) {
        location.href = tourl;
    }

    function pay(itemId) {
        payStatus = 1;
        payItemId = itemId;
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
                    location.href = '<?php echo input::site('wechat/order/index');?>';
                }
            } else {
                if (da.msg) {
                    alert(da.msg);
                    $('.mask_box').hide();
                }
            }
        });        
    }

    //调用微信JS api 支付
    function jsApiCall() {
        WeixinJSBridge.invoke(
            'getBrandWCPayRequest',
            jsApiParameters,
            function (res) {
                location.href = '<?php echo input::site('wechat/order/paySuccess/');?>' + payItemId;
            }
        );
    }

    function tkCancel(itemId) {
        payStatus = 1;
        $.post("<?php echo input::site('wechat/order/tkCancel');?>", { orderId: itemId }, function (data) {
            if (data === '1') {
                location.reload();
            } else {
                alert(data);
            }
        });
    }

    function delCoupon(itemId) {
        if(confirm("是否确认删除订单")){            
            $.post("<?php echo input::site('wechat/order/delCoupon');?>", { orderId: itemId }, function (data) {
                if (data === '1') {
                    location.reload();
                } else {
                    alert(data);
                }
            });
        }
    }

    function useCoupon(code) {
        payStatus = 1;
        var shopurl = '';
        wx.scanQRCode({
            needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
            scanType: ["qrCode", "barCode"], // 可以指定扫二维码还是一维码，默认二者都有
            success: function (res) {
                open_box('#up_box4');
                shopurl = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
                $.post("<?php echo input::site('wechat/order/useCoupon');?>", {'shopurl':shopurl,'code': code }, function (data) {
                // console.log(shopurl);
                    if (data == 1) {
                        location.reload();
                    } else {
                        alert(data);
                    }
                });
            }
        });
    }
// 绑定点击事件
function bind_click(){
    $('.commodity_list').click(function () {
        if (payStatus == 1) {
            payStatus = 0;
        } else {
            location.href = '<?php echo input::site('wechat/order/detail/');?>' + $(this).attr('orderId');
        }
    });
}

// 查看更多
function more_all(n){
    $.post('<?php echo input::site("wechat/order/get_more_list");?>',{'page':n,'str':'all'},
        function(data){            
            if(data != ""){    
                $(".more_all").before(data);
                $(".more_all>span").attr("onclick","more_all("+(n+1)+")");
                bind_click();
            }
            if((n*10+10)>=<?php echo $all;?>){
                $(".more_all").html("已到达页面底部");
            }
        })
}
// 查看更多
function more_pay(n){
    $.post('<?php echo input::site("wechat/order/get_more_list");?>',{'page':n,'str':'pay'},
        function(data){            
            if(data != ""){    
                $(".more_pay").before(data);
                $(".more_pay>span").attr("onclick","more_pay("+(n+1)+")");
                bind_click();
            }
            if((n*10+10)>=<?php echo $pay;?>){
                $(".more_pay").html("已到达页面底部");
            }
        })
}
// 查看更多
function more_use(n){
    $.post('<?php echo input::site("wechat/order/get_more_list");?>',{'page':n,'str':'use'},
        function(data){            
            if(data != ""){    
                $(".more_use").before(data);
                $(".more_use>span").attr("onclick","more_use("+(n+1)+")");
                bind_click();
            }
            if((n*10+10)>=<?php echo $use;?>){
                $(".more_use").html("已到达页面底部");
            }
        })
}
// 查看更多
function more_over(n){
    $.post('<?php echo input::site("wechat/order/get_more_list");?>',{'page':n,'str':'over'},
        function(data){            
            if(data != ""){    
                $(".more_over").before(data);
                $(".more_over>span").attr("onclick","more_over("+(n+1)+")");
                bind_click();
            }
            if((n*10+10)>=<?php echo $over;?>){
                $(".more_over").html("已到达页面底部");
            }
        })
}   
 // 在收货tab标签中确认收货 
// function make_sure(str,id){    
//     if(confirm("确认收到货!")){        
//         $.post('<?php echo input::site("wechat/order/make_sure");?>',{'id':id},
//             function(data){            
//                 var data = eval("("+data+")");
//                 if(data.success == 1){
//                     $(str).parent().parent().parent().hide();
//                 }
//                 alert(data.msg);
//             })
//     }
// }
// 在收货tab标签中确认收货 
function make_sure(id){    
    if(confirm("确认收到货!")){        
        $.post('<?php echo input::site("wechat/order/make_sure");?>',{'id':id},
            function(data){            
                var data = eval("("+data+")");
                if(data.success == 1){
                    location.reload();
                }
                alert(data.msg);
            })
    }
}
</script>

