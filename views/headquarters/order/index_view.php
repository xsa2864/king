<script src="<?php echo input::jsUrl('date/date.js'); ?>" type="text/javascript"></script>
<link href="<?php echo input::cssUrl('date.css'); ?>" rel="stylesheet" type="text/css" />
<?php
$url = input::site("admin/order");
if (is_array($data['post'])){
    $status = array("","","","","","");
    $status[$data['post']['order_status']] = "selected";
    $link = "";
    foreach ($data['post'] as $key=>$val){
        if ($key != "page" && $val != ""){
            $link[] = $key."=".$val;
        }
    }
    if (sizeof($link) >0 && is_array($link) ){
        $link = implode("&", $link);
        $link = "&".$link;
    }
}

?>

<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">

            <form name="orderForm" id="orderForm" method="get" action="index">
                <div class="back_right">
                    <div class="right">
                        <h1>订单处理中心</h1>
                        <div class=" bor_box stock_box padd0 cf">
                            <dl class="cf">
                                <dd><span>
                                    <input type="text" name="searchName" value="<?php echo $searchName; ?>" placeholder="输入收货人/手机号/单号/收货地址" class="input9"></span></dd>
                                <dd class="inp5"><span>
                                    <input type="text" name="startTime" value="<?php echo $startTime; ?>" placeholder="订单日期" class="puiDate date_input"></span>&nbsp;&nbsp;到&nbsp;</dd>
                                <dd class="inp5"><span>
                                    <input type="text" name="endTime" value="<?php echo $endTime; ?>" placeholder="订单日期" class="puiDate date_input"></span></dd>

                                <dd class="select_box">
                                    <select class="puiSelect" style=" width:124px">
                                        <option value="0">订单来源</option>
                                        <option value="1">微信</option>
                                        <option value="2">app</option>
                                    </select>
                                </dd>


                                <dd class="query_box"><a href="javascript:" onclick="$('#orderForm').submit();">查询</a></dd>
                            </dl>
                        </div>
                        <div class="edit_box sale_cen mar_right cf">
                            <div class="title_all">
                                <ul class="edit_title bold cf">
                                    <li <?php if($tab_class == '' || intval($tab_class) == 0){echo 'class="curr"';} ?>><a href="<?php echo input::site('admin/order/index/'); ?>">所有订单<i>（<?php echo $all_total; ?>）</i></a><b></b></li>
                                    <li <?php if($tab_class == '100'){echo 'class="curr"';} ?>><a href="<?php echo input::site('admin/order/index/100'); ?>">待付款<i>（<?php echo $all_noPay;?>）</i></a><b></b></li>
                                    <li <?php if($tab_class == '1'){echo 'class="curr"';} ?>><a href="<?php echo input::site('admin/order/index/1'); ?>">待发货<i>（<?php  echo $all_Pay;?>）</i></a><b></b></li>
                                    <li <?php if($tab_class == '2'){echo 'class="curr"';} ?>><a href="<?php echo input::site('admin/order/index/2'); ?>">已发货<i>（<?php  echo $all_send;?>）</i></a><b></b></li>
                                    <li <?php if($tab_class == '4'){echo 'class="curr"';} ?>><a href="<?php echo input::site('admin/order/index/4'); ?>">交易完成<i>（<?php  echo $all_ok;?>）</i></a><b></b></li>
                                    <li <?php if($tab_class == '99'){echo 'class="curr"';} ?>><a href="<?php echo input::site('admin/order/index/99'); ?>">已关闭<i>（<?php  echo $all_close;?>）</i></a></li>
                                </ul>

                            </div>
                            <!--所有订单--->
                            <div style="display: block" class="box_zlm">
                                <div class="order_box ">
                                    <table class="thead">
                                        <tbody>
                                            <tr>
                                                <th width="35%" class="align_left">&nbsp;&nbsp;&nbsp;&nbsp;商品<i></i></th>
                                                <th width="14%">收货人<i></i></th>
                                                <th width="14%">实付金额<i></i></th>
                                                <th width="21%">买家留言<i></i></th>
                                                <th width="15%">操作</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="table_list">




                                        <?php
                                        foreach($orders as $ors) {
                                        ?>
                                        <table class="tbody tbody_cen">
                                            <tbody>
                                            <tr class="tbody_title"
                                                style="background: rgb(255, 255, 255) none repeat scroll 0% 0%;">
                                                <th colspan="5">
                                                    <span class="one"><strong>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;订单编号：<?php echo $ors['order_sn'] ?></strong></span>
                                                        <span
                                                            class="two"><?php echo date('Y-m-d H:i:s', $ors['add_time']) ?> </span>
                                                    <span
                                                        class="three"><i><?php echo comm_ext::getOrderStatus($ors['order_status']) ?></i></span>
                                                </th>
                                            </tr>
                                            <tr class=""
                                                style="background: rgb(255, 255, 255) none repeat scroll 0% 0%;">
                                                <td width="35%" class="tbody_img">
                                                        <span><a href="#">
                                                                <img width="58" height="59"
                                                                     src="<?php echo input::site($ors['pics']) ?>"></a></span>
                                                    <span class="text"><a href="#"><?php echo $ors['goods_title'] ?></a><span>数量：<?php echo $ors['goods_count'] ?></span></span>
                                                </td>
                                                <td width="14%">
                                                    <span><?php echo $ors['consignee'] ?></span>
                                                    <span><?php echo $ors['consignee_tel'] ?></span>
                                                </td>
                                                <td width="14%">
                                                    <span><?php echo $ors['goods_total'] ?></span>
                                                    <span>（含运费<?php echo $ors['shipping_total'] ?>元）</span>
                                                </td>
                                                <td width="21%"><span
                                                        class="bold"><?php echo $ors['user_note'] ?></span></td>
                                                <td width="15%" class="revise">
                                                    <h1 class="h1_one">
                                                        <!--不同订单状态会有不同的功能按钮-->
                                                        <?php
                                                        if ($ors['order_status'] == 4) { //未付款
                                                            ?>
                                                            <a class="ck_rder" href="javascript:"
                                                               onclick="orderinfo(<?php echo $ors['order_id'] ?>)">查看详情<span>∨</span></a>
                                                            <div style="display: none" class="revise_pop">
                                                                <a href="#">关闭</a>
                                                            </div>
                                                        <?php
                                                        } elseif ($ors['order_status'] == 0) { //已付款
                                                            ?>
                                                            <a class="xg_rder" href="javascript:"
                                                               onclick="updateOrder(<?php echo $ors['order_id'] ?>)">修改订单<span>∨</span></a>
                                                            <div style="display: none" class="revise_pop">
                                                                <a class="ck_rder" href="javascript:"
                                                                   onclick="orderinfo(<?php echo $ors['order_id'] ?>)">查看详情</a>
                                                                <a href="###">关闭</a>
                                                            </div>

                                                        <?php
                                                        } elseif ($ors['order_status'] == 1) { //未发货
                                                            ?>
                                                            <a class="xg_rder" href="javascript:"
                                                               onclick="orderSend(<?php echo $ors['order_id'] ?>);">发货<span>∨</span></a>
                                                            <div style="display: none" class="revise_pop">
                                                                <a class="ck_rder" href="javascript:"
                                                                   onclick="orderinfo(<?php echo $ors['order_id'] ?>)">查看详情</a>
                                                                <a href="###">关闭</a>
                                                            </div>
                                                        <?php
                                                        } elseif ($ors['order_status'] == 2) { //已发货
                                                            ?>
                                                            <a class="ck_rder" href="javascript:"
                                                               onclick="orderinfo(<?php echo $ors['order_id'] ?>)">查看详情<span>∨</span></a>
                                                            <div style="display: none" class="revise_pop">
                                                                <a href="#">关闭</a>
                                                            </div>
                                                        <?php
                                                        }
                                                            ?>
                                                        </h1>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <?php
                                        }
                                        ?>

                                        <div class="page">
                                            <?php
                                            echo $pagination->render();
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--待付款--->
                            <div style="display: none" class="box_zlm">
                                <div class="order_box ">
                                    <table class="thead">
                                        <tbody>
                                            <tr>
                                                <th width="35%" class="align_left">&nbsp;&nbsp;&nbsp;&nbsp;商品<i></i></th>
                                                <th width="14%">收货人<i></i></th>
                                                <th width="14%">实付金额<i></i></th>
                                                <th width="21%">买家留言<i></i></th>
                                                <th width="15%">操作</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="table_list">
                                        <table class="tbody tbody_cen">
                                            <tbody>
                                                                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--待分配--->
                            <div style="display: none" class="box_zlm">
                                <div class="order_box">
                                    <table class="thead">
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                    <div class="table_list">
                                        <table class="tbody tbody_cen">
                                            <tbody>
                                                
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="allocate cf">
                                        
                                    </div>
                                </div>
                            </div>
                            <!--已发/待发--->
                            <div style="display: none" class="box_zlm">
                                <div class="order_box sub">
                                    <table class="thead">
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                    <div class="table_list address">
                                        <table class="tbody_cen">
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                            <!--完成交易--->
                            <div style="display: none" class="box_zlm">
                                <div class="order_box">
                                    <table class="thead">
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                    <div class="table_list">
                                        <table class="tbody tbody_cen">
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!--已关闭--->
                            <div style="display: none" class="box_zlm">
                                <div class="order_box">
                                    <table class="thead">
                                        <tbody>
                                            
                                        </tbody>
                                    </table>

                                    <div class="table_list">
                                        <table class="tbody tbody_cen">
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>












<!--遮罩层-->
<div class="mask_box" style="display: none"></div>
<!--弹出框订单详情--->
<div class="up_box" style="display: none; width: 800px;" id="up_box13">
    <h1>订单详情<i class="close"></i></h1>
    <h2 class="dhao">订单号：<span id="info_order_sn">20150803974956</span></h2>
    <div class="order_xq">
        <h3>订单信息</h3>
        <div class="xq_cen">
            <dl class="cf">
                <dt>订单状态：</dt>
                <dd id="info_order_status">待付款</dd>
            </dl>
            <dl class="cf">
                <dt>订单来源：</dt>
                <dd>官网</dd>
            </dl>
            <dl class="cf">
                <dt>配送方式：</dt>
                <dd>快递</dd>
            </dl>
            <dl class="cf">
                <dt>快递单号：</dt>
                <dd id="expressNumber">快递</dd>
            </dl>
            <dl class="cf">
                <dt>收货地址：</dt>
                <dd id="info_order_address">中央第五街2号1925室</dd>
            </dl>
            <dl class="cf">
                <dt>买家信息：</dt>
                <dd id="info_order_user">DAWEI   18650318756</dd>
            </dl>
            <dl class="cf">
                <dt>买家留言：</dt>
                <dd id="info_order_note">注意包装哦亲注意包装哦亲注意包装哦亲注意包装哦亲注意包装哦亲注意包装哦亲注意包装哦亲注意包装哦亲注意包装哦亲注意包装哦亲注意包装哦亲</dd>
            </dl>
        </div>
        <!----->
        <div class="order_box cf" style="display: block">
            <table class="thead">
                <tr>
                    <th width="33%">商品<i></i></th>
                    <th width="20%">条码<i></i></th>
                    <th width="15%">单价<i></i></th>
                    <th width="15%">数量<i></i></th>
                    <th width="17%">小计</th>
                </tr>
            </table>
            <div class="table_list address">
                <table class="tbody_cen" id="info_order_goods">

                    <td width="33%" class="tbody_img">
                        <span><a href="#">
                            <img src="images/ord_03.png" width="58" height="59" /></a></span>
                        <span class="text"><a href="#">喜力330ml</a><span>数量：6</span></span>
                    </td>
                    <td width="20%">69143015796</td>
                    <td width="15%">11,00</td>
                    <td width="15%">552</td>
                    <td width="17%">552</td>

                </table>
            </div>
            <div class="shopp_text cf">
                <dl class="cf">
                    <dt>商品小计：</dt>
                    <dd>￥66</dd>
                </dl>
                <dl class="cf">
                    <dt>运费：</dt>
                    <dd>￥446</dd>
                </dl>
                <dl class="cf">
                    <dt>实际支付：</dt>
                    <dd class="ff f14">￥0</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
<!--修改订单--->
<div class="up_box" style="display: none; width: 475px;" id="up_box14">
    <form name="update_order_form" id="update_order_form" method="post" action="">
        <h1>修改订单<i class="close"></i></h1>
        <div class="bor_box modify_box">
            <dl class="cf two">
                <dt>订单号：</dt>
                <dd class="bold" id="update_order_sn">20150803974956</dd>
            </dl>

            <dl class="cf">
                <dt>价格：</dt>
                <dd class="inp4"><span>
                    <input type="text" name="update_order_price" id="update_order_price" /></span></dd>
            </dl>
            <dl class="cf" style="display: none;">
                <dt>运费：</dt>
                <dd>
                    <span class="inp7">
                        <input type="radio" name="freight" value="1" class="" />包邮：</span>
                </dd>
                <dd>
                    <span class="inp7">
                        <input type="radio" name="freight" value="2" class="" checked />运费：</span>
                    <span class="inp4">
                        <input type="text" name="freight_input" id="freight_input" /></span>
                </dd>
            </dl>
            <dl class="cf">
                <input type="hidden" name="update_order_id" id="update_order_id">
                <dt>地址：</dt>
                <dd class="inp14"><span>
                    <input type="text" id="update_order_address" name="update_order_address" /></span></dd>
            </dl>
        </div>
        <div class="btn_two btn_width cf">
            <a class="a1" href="javascript:" onclick="updateSubmit()">保存</a><a class="close" href="###">取消</a>
        </div>
    </form>
</div>
<!--门店待发订单-->
<div class="up_box" style="display: none; width: 800px;" id="up_box15">
    <h1>门店待发订单<i class="close"></i></h1>
    <h2 class="dhao">泉州丰泽店</h2>
    <div class="order_xq">
        <div class="order_box cf" style="display: block">
            <table class="thead">
                <tr>
                    <th width="17%">订单号<i></i></th>
                    <th width="30%">买家地址<i></i></th>
                    <th width="17%">买家<i></i></th>
                    <th width="17%">金额<i></i></th>
                    <th width="19%">留言</th>
                </tr>
            </table>
            <div class="table_list address">
                <table class="tbody_cen">
                    <td width="17%">69143015796</td>
                    <td width="30%">中央第五街</td>
                    <td width="17%">不哭的小孩</td>
                    <td width="17%">552</td>
                    <td width="19%">不你空间</td>
                </table>
            </div>

        </div>
    </div>
</div>
<!--门店已发订单-->
<div class="up_box" style="display: none; width: 800px;" id="up_box16">
    <h1>门店已发订单<i class="close"></i></h1>
    <h2 class="dhao">泉州丰泽店</h2>
    <div class="order_xq">
        <div class="order_box cf" style="display: block">
            <table class="thead">
                <tr>
                    <th width="17%">订单号<i></i></th>
                    <th width="30%">买家地址<i></i></th>
                    <th width="17%">买家<i></i></th>
                    <th width="17%">金额<i></i></th>
                    <th width="19%">留言</th>
                </tr>
            </table>
            <div class="table_list address">
                <table class="tbody_cen">
                    <td width="17%">69143015796</td>
                    <td width="30%">中央第五街</td>
                    <td width="17%">不哭的小孩</td>
                    <td width="17%">552</td>
                    <td width="19%">不你空间</td>
                </table>
            </div>

        </div>
    </div>
</div>



<!--发货窗口-->
<div class="up_box" style="display: none; width: 475px;" id="up_box38">
    <form name="shipping_order_form" id="shipping_order_form" method="post" action="">
        <h1>修改订单<i class="close"></i></h1>
        <div class="bor_box modify_box">
            <dl class="cf two">
                <dt>订单号：</dt>
                <input type="hidden" name="shipping_order_sn_hidden" id="shipping_order_sn_hidden" value="">
                <dd class="bold" id="shipping_order_sn">20150803974956</dd>
            </dl>

            <dl class="cf">
                <dt>物流公司：</dt>
                <dd class="inp4"><span>
                    <select name="shipping_id" id="shipping_id">
                    </select>
                    </span></dd>
            </dl>
            <dl class="cf" >
                <dt>物流单号：</dt>
                    <span class="inp4">
                        <input type="text" name="shipping_number" id="shipping_number" /></span>
                </dd>
            </dl>
            <dl class="cf">
                <input type="hidden" name="update_order_id" id="update_order_id">
                <dt>发货地址：</dt>
                <dd class="inp14">
                    <span id="orderAddress">
                        福建省福州市台江区
                        <!--
                    <input type="text" id="update_order_address" name="update_order_address" />--></span></dd>

            </dl>
        </div>
        <div class="btn_two btn_width cf">
            <a class="a1" href="javascript:" onclick="shippingSubmit()">保存</a><a class="close" href="###">取消</a>
        </div>
    </form>
</div>











<script>
    $(function () {
        //分类标签
        $('.title_all .edit_title li').click(function () {
            var index = $('.title_all .edit_title li').index(this);
            $('.title_all .edit_title li').removeClass('curr');
            $('.title_all .edit_title b').show();
            $(this).addClass('curr').find('b').hide();
            $(this).prev().find('b').hide();
            $(".box_zlm ").hide().eq(index).show().find('select').trigger('resetOption').trigger('resetStyle');
        });
        //全选
        $('.check_all').click(function () {
            var checked = $(this).is(':checked');
            $('.order_box input[type=checkbox]').prop('checked', (checked ? 'checked' : false));
        });
        //移动到显示背景颜色
        $('.tbody_cen tr').hover(function () {
            $(this).css('background', '#f5f5f5')
        }, function () {
            $(this).css('background', '#fff')

        });
        //移动到显示
        $('.revise h1').hover(function () {
            $(this).parents('.revise').find('.revise_pop').toggle();
            return false;

        }, function () {
            $(this).parents('.revise').find('.revise_pop').toggle();
            return false;
        });
        //弹出框
        $('.xg_rder').click(function () {
            //open_box('#up_box14')
        });
        /*
        $('.ck_rder').click(function(){
            //详情
            open_box('#up_box13')
        });*/

        $('.fp_rder').click(function () {
            open_box('#up_box15')
        });
        $('.yf_rder').click(function () {
            open_box('#up_box16')
        });


    });

    function orderinfo(id) {
        if (id <= 0) {
            alert('错误');
            return false;
        }
        $.ajax({
            type: 'post',
            url: '<?php echo input::site('admin/order/ajaxGetInfo'); ?>',
            data: 'id=' + id,
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data['status'] == false) {
                    alert(data['msg'])
                    return false;
                }
                var order = data['msg']
                $("#info_order_sn").html(order['order']['order_sn']);
                $("#info_order_status").html(order['order']['order_status']);
                $("#info_order_address").html(order['order']['consignee_book']);
                $("#info_order_user").html(order['order']['consignee'] + ' ' + order['order']['consignee_tel']);
                $("#info_order_note").html(order['order']['user_note']);
                $("#expressNumber").html(order['order']['expressId']);
                var str = '';
                for (i = 0; i < order['goods'].length; i++) {
                    str = str + '<tr><td width="33%" class="tbody_img">';
                    str = str + '<span><a href="#"><img src="' + order["goods"][i]["img"] + '" width="58" height="59" /></a></span>';
                    str = str + '<span class="text"><a href="#">' + order["goods"][i]["title"] + '</a><span>数量：' + order["goods"][i]["count"] + '</span></span>';
                    str = str + '</td>';
                    str = str + '<td width="20%" >' + order["goods"][i]["goods_sn"] + '</td>';
                    str = str + '<td width="15%">' + order["goods"][i]["price"] + '</td>';
                    str = str + '<td width="15%">' + order["goods"][i]["count"] + '</td>';
                    str = str + '<td width="17%">' + order["goods"][i]["total_price"] + '</td></tr>';
                }
                $("#info_order_goods").html(str);
            },
            error: function () {
            }
        });
        open_box('#up_box13');
    }
    //修改订单
    function updateOrder(id) {
        /*
        var re = /^[0-9]*[1-9][0-9]*$/;
        if (!re.test(id)) {
            alert('请传入正确的参数');
            return false;
        }*/
        $.ajax({
            type: 'post',
            url: '<?php echo input::site('admin/order/updateOrderMoney'); ?>',
            data: 'id=' + id,
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data['status'] == false) {
                    alert(data['msg']);
                    return false;
                }
                $("#update_order_id").val('');
                var order = data['msg'];
                $("#update_order_sn").html(order['order_sn']);
                $("#update_order_price").val(order['goods_total']);
                $("#update_order_address").val(order['address']);
                $("#freight_input").val(order['shipping_total']);
                $("#update_order_id").val(order['order_id']);
                open_box('#up_box14');
            },
            error: function () {
            }
        });
    }

    //提交修改订单
    function updateSubmit() {
        var order_id = $("#update_order_id").val();
        /*
        var re = /^[0-9]*[1-9][0-9]*$/;
        if (!re.test(order_id)) {
            alert('请传入正确的参数');
            return false;
        }*/
        $.ajax({
            type: 'post',
            url: '<?php echo input::site('admin/order/editOrderMoney'); ?>',
            data: $('#update_order_form').serialize(),
            cache: false,
            dataType: 'json',
            success: function (data) {
                alert(data['msg']);
            },
            error: function () {
            }
        });
    }


    //发货
    function orderSend(id) {
        var re = /^[0-9]*[1-9][0-9]*$/;
        if (!re.test(id)) {
            alert('请传入正确的参数');
            return false;
        }
        $.ajax({
            type: 'post',
            url: '<?php echo input::site('admin/order/send'); ?>',
            data: 'id=' + id,
            cache: false,
            dataType: 'json',
            success: function (data) {
                if(data['status'] == false) {
                    alert(data['msg']);
                    return false;
                }
                $("#shipping_order_sn").html(data['msg']['orderNumber']);
                $("#shipping_order_sn_hidden").val(data['msg']['orderNumber']);
                $("#orderAddress").html(data['msg']['orderAddress']);
                var i = 0;
                $("#shipping_id").html('');
                for(var i = 0 ;i <= data['msg']['shipping'].length;i++){
                 //   alert(i);
                    $("#shipping_id").append('<option value="'+data['msg']['shipping'][i]['id']+'">'+data['msg']['shipping'][i]['name']+'</option>');
                }
            },
            error: function () {
            }
        });
        open_box('#up_box38');
    }

    function shippingSubmit(){
        var shipping_number = $("#shipping_number").val();
        if (shipping_number == '') {
            alert('请输入物流单号');
            return false;
        }
        $.ajax({
            type: 'post',
            url: '<?php echo input::site('admin/order/saveSend'); ?>',
            data: $('#shipping_order_form').serialize(),
            cache: false,
            dataType: 'json',
            success: function (data) {
                alert(data['msg']);
                window.location.reload();
            },
            error: function () {
            }
        });
    }

</script>
