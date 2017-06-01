<header class="header buys pad0">
    <div class="favorites">
        <p><a class="return" href="JavaScript:history.back();"><i></i>确认订单</a></p>
    </div>
</header>
    <!-- 下拉弹窗插件 -->
    <link href="<?php echo input::jsUrl('linkage/linkage.css','wechat');?>" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?php echo input::jsUrl('linkage/linkage.js','wechat'); ?>"></script>
<div class="container pad1 mar1">
    <div class="order_box">
        <div class="toker_order toker_back">
            <p class="f32">购买账号</p>
            <dl class="toker_dl">
                <dt>
                    <img src="<?php echo $user->head_img;?>" width="100%" height="100%" /></dt>
                <dd>
                    <span class="f32"><?php echo $user->nickname;?></span>
                    <span class="f28">&nbsp;</span>
                </dd>
            </dl>
        </div>
        <div>
            <div class="memberinfo">
                <font>*</font>
                <input type="text" id="realname" name="realname" placeholder="必填，收件人姓名" maxlength="20" />
            </div>
            <div class="memberinfo">
                <font>*</font>
                <input type="text" id="mobile" name="mobile" placeholder="必填，您的手机号" maxlength="11" />
            </div>
            <div class="memberinfo">
                <font style="float: left;">*</font>                
                <p class="h2 linkage_el">
                    <label style="padding-left: 16px;"><i></i>所在地区 <span></span></label>
                    <select name="s">
                    <?php 
                    foreach ($list as $key => $value) {
                        echo '<option value='.$value['id'].'>'.$value['region_name'].'</option>';
                    }
                    ?>               
                    </select>
                    <select name="c" id="city">                
                    </select>
                    <select name="a" id="city2">               
                    </select>                    
                    <a href="#"></a>
                </p>
            </div>
            <div class="memberinfo">
                <font>*</font>
                <input type="text" id="address" name="address" placeholder="必填，您的详细收货地址"  />
            </div>
        </div>
        <div class="order_h3">
            <div class="order_p1 order_bor">
                <div class="commodity_list">
                    <dl class="list_dl order_dl tb">
                        <dt>
                            <img src="<?php echo input::site($item->img);?>" /></dt>
                        <dd class="flex_1">
                            <h1><?php echo $item->title;?></h1>
                            <div class="list_text pad">
                                <h3> <font>￥</font>
                                    <span id="item_price"><?php echo $item->price;?></span>
                                </h3>
                            </div>
                        </dd>
                    </dl>
                    <h4 class="toker_text toker_text2">                        
                        <p>
                            <span class="f28">购买数量：</span>
                            <a href="javascript:;" class="cart" id="down">-</a>
                            <input type="text" name="number" class="cart_num" value="1" onchange="item_number()" />
                            <a href="javascript:;" class="cart" id="up">+</a>
                        </p>
                    </h4>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="footer">
    <dl class="footer_dl tb">
        <dt class="f30 flex_1">实付&nbsp;<font class="f30">￥</font><font class="f36"><?php echo $item->price;?></font>&nbsp;&nbsp;&nbsp;</dt>
        <dd><a href="JavaScript:pay();">确认</a></dd>
    </dl>
</div>
<style type="text/css">
.toker_text .cart{
    font-size: 24px;
}
.toker_text .cart_num{
    width: 30px;
    text-align: center;
}
.memberinfo input{
    width: 75%;
    font-size: 0.25rem;
    padding: 5px 0.25rem;
}
.memberinfo font{
    padding-left: 0.2rem;
    font-size: 0.2rem;
    color: red;
}
.linkage_el label{
    font-size: 0.25rem;
}
.linkage_flex ul{
    font-size: 0.25rem;
}
</style>

<!--遮罩层-->
<div class="mask_box" style="display: none"></div>
<script>    
$(function(){
    //点击按钮样式
    $('.verification .btn,.next_btn a').on('touchstart',function(){
        $(this).addClass('on')
    });
    $(document).on('touchend',function(){
        $('.verification .btn.on,.next_btn a.on').removeClass('on');
    });
    
    $('.linkage_el').linkage(); // 触发选择区域

    // 切换城市示例 // AJAX切换option数据时执行$('select[name=s]').trigger('reset_linkage');
    $('select[name=a]').on('change',function(){
        write_address();
    });
    show_city('2');
});

$(".ok").click(function(){
    write_address();
})

function write_address(){
    var str = $('select[name=s] :selected').text()+$('select[name=c] :selected').text()+$('select[name=a] :selected').text();
        $('.linkage_el>label>span').html(str);
}

// 获取城市列表
$('select[name=s]').on('change',function(){
    var id = $(this).val();
    show_city(id);
});
$('select[name=c]').on('change',function(){
    var id = $(this).val();
    show_city2(id);
});
function show_city(id){
    $.post('<?php echo input::site("wechat/member/get_city")?>',{'id':id},
        function(data){
            var data = eval("("+data+")");
            var op_str = '';
            var li_str = '';
            for(var i=0;i<data.length;i++){                
                op_str += '<option value='+data[i].id+'>'+data[i].region_name+'</option>';
                li_str += '<li value='+data[i].id+'>'+data[i].region_name+'</li>';
            }    

            $("#city").html(op_str);
            $(".linkage_flex:nth-child(3) div>ul").html(li_str);     
            show_city2(data[0].id)
    })
}
function show_city2(id){
    $.post('<?php echo input::site("wechat/member/get_city")?>',{'id':id},
        function(data){
            var data = eval("("+data+")");
            var op_str = '';
            var li_str = '';
            for(var i=0;i<data.length;i++){
                op_str += '<option value='+data[i].id+'>'+data[i].region_name+'</option>';
                li_str += '<li value='+data[i].id+'>'+data[i].region_name+'</li>';
            }    
            $("#city2").html(op_str);
            $(".linkage_flex:nth-child(4) div>ul").html(li_str);
    })
}



$("#down").on("click touch",function(){
    var price = parseInt($("#item_price").html());
    var number = parseInt($("input[name=number]").val());
    var sum = 0;
    number = number-1;
    if(number < 1){
        alert('购买数量不能小于1');
        sum = parseInt(price)*1;
    }else{
        $("input[name=number]").val(number);
        sum = parseInt(price)*number;
    }
    $(".f36").html(sum);
})

$("#up").on("click touch",function up(){
    var price = parseInt($("#item_price").html());
    var number = parseInt($("input[name=number]").val());
    var sum = 0;
    number = number+1;
    if(number > 99){
        alert('购买数量不能大于99');
        sum = parseInt(price)*99;
    }else{
        $("input[name=number]").val(number);  
        sum = parseInt(price)*number;
    }
    $(".f36").html(sum);
})
function item_number(){
    var price = parseInt($("#item_price").html());
    var number = $("input[name=number]").val();
    var rule = /^[0-9]+$/;
    if(!rule.test(number)){
        number = 1;
        $("input[name=number]").val(number);
    }
    
    if(number < 1){
        alert('购买数量不能小于1');
        number = 1;
        $("input[name=number]").val(number);
    }
    if(number > 99){
        alert('购买数量不能大于99');
        number = 99;
        $("input[name=number]").val(number);
    }
    var sum = parseInt(price)*number;
    $(".f36").html(sum);
}
    var orderId;
    function pay() {
        var number = $("input[name=number]").val();
        var realname = $("#realname").val();
        var mobile = $("#mobile").val();
        var address = $('.linkage_el>label>span').html()+$("#address").val();
        if(realname == '' || mobile == '' || address == ''){
            alert("收货信息必填不");
            return false;
        }
        $('.mask_box').off();
        $('.mask_box').show();
        $.post("<?php echo input::site('wechat/order/wepay');?>",
         { itemId: '<?php echo $item->id;?>','number':number,'realname':realname,'mobile':mobile,'address':address },
         function (data) {
            var da = eval("(" + data + ")");
            if (da.success == 1) {
                orderId = da.orderId;
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
                    location.href = '<?php echo input::site('wechat/order/paySuccess/');?>' + orderId;
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
                location.href = '<?php echo input::site('wechat/order/paySuccess/');?>' + orderId;
            }
        );
        }
</script>


