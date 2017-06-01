    <header class="header buys pad0">
        <div class="favorites">
            <p>
                <a class="return" href="javascript:location.reload();"><i></i>店铺管理</a>
                <em class="shop_code">
                    <img src="<?php echo input::site('library/wechat/images/dianp_03.png');?>" onclick="show_qrCode('<?php echo $shop->qrCode;?>')"/>
                </em>
            </p>
        </div>
    </header>
    <div class="container pad1 pad4">
    	<div class="shop2_cen">
        	<div class="shop2_h1">
            	<ul class="shop2_one tb">
                	<li class="flex_1">
                    	<span>近七天收益</span>
                        <font><em>¥</em><?php echo $seven_price<=0?'--':$seven_price;?></font>
                    </li>
                    <li class="flex_1">
                    	<span>本月收益</span>
                        <font><em>¥</em><?php echo $this_price<=0?'--':$this_price;?></font>
                    </li>
                    <li class="flex_1">
                    	<span>上月收益</span>
                        <font><em>¥</em><?php echo $last_price<=0?'--':$last_price;?></font>
                    </li>
                </ul>
                <p class="shop2_two">总收益&nbsp;&nbsp;&nbsp; <span>
                <font>¥ </font><?php echo $shop->amount<=0?'--':$shop->amount;?></span>
                </p>
            </div>
            <div class="shop2_h2">收益已转入您本账户的微信钱包，如有疑问请
            <a href="tel:<?php echo $telphone;?>"><font>联系客服</font></a>。
            </div>
            <div class="shop2_h3">
                <ul class="shop2_three tb">
                    <li class="flex_1">
                        <span>近七天订单</span>
                        <font><?php echo $seven_order<=0?'--':$seven_order;?></font>
                    </li>
                    <li class="flex_1">
                        <span>本月订单</span>
                        <font><?php echo $this_order<=0?'--':$this_order;?></font>
                    </li>
                    <li class="flex_1">
                        <span>上月订单</span>
                        <font><?php echo $last_order<=0?'--':$last_order;?></font>
                    </li>
                    <li class="flex_1">
                        <span>总订单</span>
                        <font><?php echo $all_order<=0?'--':$all_order;?></font>
                    </li>
                </ul>
                <ul class="shop2_three tb">
                    <li class="flex_1">
                        <span>近七天会员</span>
                        <font><?php echo $seven_member<=0?'--':$seven_member;?></font>
                    </li>
                    <li class="flex_1">
                        <span>本月会员</span>
                        <font><?php echo $this_member<=0?'--':$this_member;?></font>
                    </li>
                    <li class="flex_1">
                        <span>上月会员</span>
                        <font><?php echo $last_member<=0?'--':$last_member;?></font>
                    </li>
                    <li class="flex_1">
                        <span>总会员</span>
                        <font><?php echo $all_member<=0?'--':$all_member;?></font>
                    </li>
                </ul>
            </div>
            <div class="shop2_h4 f32"><i></i>完成消费</div>
            <div class="shop2_h5  back2">
                <div class="shop2_four tb">
                    <dl class="flex_1">
                        <dt>方法一</dt>
                        <dd><a href="javascript:scan();">扫一扫</a></dd>
                    </dl>
                    <dl class="flex_1">
                        <dt>方法二</dt>
                        <dd><a id="vouc" href="#">输入券码</a></dd>
                    </dl>
                </div> 
                <p class="shop2_five f28">扫描订单的二维码，或输入券码，成交订单！从其他位置扫描，将无法完成交易。</p>
            </div>
        </div>
    </div> 
    <div class="shop2_h6 back2 tb footer">
        <a class="flex_1" href="<?php echo input::site('wechat/businessManage/show_orderlist')?>">订单列表</a>
        <a class="flex_1" href="<?php echo input::site('wechat/businessManage/show_member')?>">会员列表</a>
        <a class="flex_1" href="<?php echo input::site('wechat/businessManage/shopdetail')?>">店铺介绍</a>
    </div>

<script type="text/javascript">
function scan(){  
    var code = '';
    wx.scanQRCode({
        needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
        scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
        success: function (res) {
            code = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
            if(code != ''){
                // var code = eval("("+code+")");
                $.post('<?php echo input::site("wechat/businessManage/valid")?>',{'code':code},
                    function(data){
                        var data = eval("("+data+")");
                        alert(data.msg);
                    });
            }else{
                alert("二维码无效!");
            }
        }
    });    
}
</script>
<!-- 遮罩层 -->
 <div  class="mask_box" style="display:none"></div>
 <!-- 弹出框 -->
<div  class="up up_box" id="up_box1" style="display:none">
    <div class="up_cen voucher">
        <p class="v1">请输入12位订单券码</p>
        <h1 class="v2">
            <input type="text" name="code" maxlength=12/>
        </h1>
        <p id="msg"></p>
        <h3 class="back_none">
            <a href="javascript:valid();">确认</a>
        </h3>
    </div>
</div>
<!-- 弹出框__二维码 -->
<div  class="up up_box" id="up_box11" style="display:none; ">
    <div class="up_cen ">
        <dl class="code_text">
            <dt><img src="" /></dt>
            <dd class="">
                <p>商家二维码</p>
                <p>使用方法：用户到店消费时，可以打开此二维码，让用户从TA的订单详情页点击 【到店使用】按钮，进行扫描，以完成订单。</p>
            </dd>
        </dl>
    </div>
</div>

<style type="text/css">
#msg{
    margin-top: -5%;
    padding-bottom: 15px;
    margin-left: 5%;
    color: #fb0505;
    font-size: 16px;
}
</style>
<script>
$(function(){
	$('#vouc').on('touchstart',function(){
		open_box('#up_box1');	
	});
});
// 跳转编辑店铺信息
function edit(id){
    if(id>0){
        var str = '<?php echo input::site('wechat/businessManage/shop_edit');?>';
        location.href = str+"/"+id;
    }
}
// 验证订单
function valid(){
    var code = $("input[name=code]").val();
    var rule = /^[0-9]{12}$/;
    
    if(rule.exec(code)){
        $.post('<?php echo input::site("wechat/businessManage/valid")?>',{'code':code},
            function(data){
                var data = eval("("+data+")");
                if(data.success!=1){
                    $("#msg").html("");
                }else{
                    $(".up_box").attr("style","display:none;");
                    $(".mask_box").attr("style","display:none;");
                    $("input[name=code]").val();
                }
                alert(data.msg);
        })
    }else{
        $("#msg").html("请输入12位数字");
        return false;
    }
}
// 显示二维码
function show_qrCode(url){
    if(url != "" && url != null){            
        var fx_prefix   = location.protocol+'//'+location.hostname+'/';
        $("#up_box11 img").attr("src",fx_prefix+url);
    }
    open_box('#up_box11');
}
</script>