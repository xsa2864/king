<script src="<?php echo input::jsUrl('date/date.js'); ?>" type="text/javascript"></script>
<link href="<?php echo input::cssUrl('date.css'); ?>" rel="stylesheet" type="text/css" />
<?php
$url = input::site("admin/order");
if (is_array($data['post'])){
    $status = array("","","","","","");
    $status[$data['post']['status']] = "selected";
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
                                <dd>
                                <div>收货人姓名:
                                    <input type="text" name="consignee" value="<?php echo $consignee; ?>" placeholder="输入姓名" class="input9">
                                </div>
                                <div>收货人手机:
                                    <input type="text" name="mobile" value="<?php echo $mobile; ?>" placeholder="输入手机号" class="input9">
                                </div>
                                <div>订单号:
                                    <input type="text" name="order_sn" value="<?php echo $order_sn; ?>" placeholder="输入订单号" class="input9">
                                </div>
                                </dd>
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
                            <!-- 所有订单 -->
                            <div style="display: block" class="box_zlm">
                                <div class="order_box ">
                                    <table class="thead">
                                        <tbody>
                                            <tr>
                                                <th width="45%" class="align_left">&nbsp;&nbsp;&nbsp;&nbsp;商品<i></i></th>
                                                <th width="10%">收货人<i></i></th>
                                                <th width="10%">实付金额<i></i></th>         
                                                <th>操作</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="table_list">
<table class="tbody tbody_cen">
    <tbody>
<?php
foreach($orders as$key=> $ors) {
?>
    <tr class="tbody_title">
        <th colspan="4" style="background: rgb(231, 232, 235) none repeat scroll 0% 0%;">
            <label style="float:left;">                
                <input type="checkbox" value="<?php echo $ors['id']; ?>" class="check_all" id="check_all">
            </label>
            <span class="one"  style="line-height: 30px;">
                <strong>&nbsp;&nbsp;&nbsp;订单编号：<?php echo $ors['order_sn'] ?></strong>
            </span>
            <span class="two"  style="line-height: 30px;"><?php echo date('Y-m-d H:i:s', $ors['addtime']) ?> </span>
            <span class="three"  style="line-height: 30px;"><i><?php echo comm_ext::getOrderStatus($ors['status']) ?></i></span>
        </th>
    </tr>
    <tr>
        <td width="45%" class="tbody_img" >
        <?php
        if(!empty($ors['child'])){
            foreach($ors['child'] as $item) {
        ?>
        <div style="display: inline-flex;">
            <span>
                <a href="#">
                    <img width="58" height="59" src="<?php echo input::site($item['pics']) ?>">
                </a>
            </span>
            <span class="text">
                <a href="javascript:;"><?php echo $item['name'] ?></a>
                <span>￥<?php echo $item['price']."   X ".$item['num'] ?></span>
            </span>
        </div>
        <?php
            }
        }
        ?>
        </td>
        <td >            
            <span><?php echo $ors['consignee'] ?></span>
        </td>
        <td>
            <span><?php echo $ors['amount'] ?></span>
        </td>
        <td style="text-align: center;">        
            <!--不同订单状态会有不同的功能按钮-->
            <a href="<?php echo input::site('admin/order/detail?id='.$ors['id']); ?>">查看详情</a> 
            <?php
            if ($ors['status'] == 0) { //待付款
            ?>
                <a href="javascript:change_price(<?php echo $ors['id'] ?>)">修改价格</a> 
                <a href="javascript:pay_order(<?php echo $ors['id'] ?>)">确认付款</a>
                <br>
                <a href="javascript:close_order(<?php echo $ors['id'] ?>)">关闭订单</a> 
                <a href="javascript:del_order(<?php echo $ors['id'] ?>)">删除订单</a> 
            <?php
            } elseif ($ors['status'] == 1) { //待发货
            ?>
                <a href="javascript:new_address(<?php echo $ors['id'] ?>)">修改地址</a>  
                <a href="javascript:orderSend(<?php echo $ors['id'] ?>)">标记发货</a> 
                <a href="javascript:new_note(<?php echo $ors['id'] ?>)">添加备注</a>               
            <?php
            } elseif ($ors['status'] == 2) { //确认收货
            ?>
                <a href="javascript:orderinfo(<?php echo $ors['id'] ?>)">修改发货</a>
                <a href="javascript:orderinfo(<?php echo $ors['id'] ?>)">查看物流</a> 
                <a href="javascript:make_sure(<?php echo $ors['id'] ?>)">标记收货</a>
            <?php
            } elseif ($ors['status'] == 3) { //申请退货
            ?>
                <a href="javascript:orderinfo(<?php echo $ors['id'] ?>)">查看详情</a>
            <?php
            } elseif ($ors['status'] == 4) { //订单完成
            ?>
                <a href="javascript:orderinfo(<?php echo $ors['id'] ?>)">查看物流</a> 
                <a href="javascript:del_order(<?php echo $ors['id'] ?>)">删除订单</a>
            <?php
            } elseif ($ors['status'] == 99) { //订单关闭
            ?>
                <a href="javascript:del_order(<?php echo $ors['id'] ?>)">删除订单</a>
            <?php
            } 
            ?>
            </td>
        </tr>
<?php
}
?>
        <tr>
            <th class="left" colspan="8" class="cen" width="8%" scope="col" style="text-align:left;">
                <input name="" id="box" type="checkbox" class="check_all" id="check_all">
                <label for="box"> 全选</label>
            </th>
        </tr>
    </tbody>
</table>
                                        <div class="bottom_btn cf"> 
                                        <?php 
                                        if($tab_class == 1){
                                        ?>
                                            <a class="bottom" href="javascript:send_goodsList()">批量发货</a>  
                                        <?php    
                                        }                   
                                        ?>
                                        </div>
                                        <div class="page">
                                            <?php
                                            echo $pagination->render();
                                            ?>
                                        </div>
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
<!--修改订单 -->
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
<!-- 标记发货 -->
<div class="up_box" style="display: none; width: 800px;" id="up_box15">
    <h1>标记发货<i class="close"></i></h1>
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
        </div>
    </div>
</div>
<!-- 修改订单价格 -->
<div class="up_box" style="display: none; width: 800px;" id="up_box16">
    <h1>修改订单价格<i class="close"></i></h1>
    <div class="order_xq">
        <div class="order_box cf" style="display: block">
            <table class="thead" > 
                <tbody id="goods_list"></tbody>
                <tr id="footer_tr">
                    <td></td>
                    <td>
                        <div>
                            共计<span id="number">0</span>件商品
                            合计：￥<span id="all_price">0</span>
                        </div>
                        <p>
                            实际支付：￥<span id="pay_amount">0</span>（包含<span id="shipping_price">0</span>元邮费）
                        </p>
                        <div>
                            <input type="button" name="btn" value="确定">
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<table>
    <tbody></tbody>
</table>
<style type="text/css">
#up_box16 img{
    float: left;border:1px solid #eee;
}
#up_box16 input{
    border:1px solid #000;width:100px;height:30px;
}
#up_box16 tr{
    height: 50px;
}
#up_box16 #footer_tr{
    color:#000;
    height: 70px;
}
</style>

<!--发货窗口-->
<div class="up_box" style="display: none; width: 475px;" id="up_box38">
    <form name="shipping_order_form" id="shipping_order_form" method="post" action="">
        <h1>发货标记<i class="close"></i></h1>
        <div class="bor_box modify_box">            
            <dl class="cf">
                <dt>物流公司：</dt>
                <dd class="inp4">
                    <select name="shipping_name" id="shipping_name">
                    <option value="">请选择快递</option>
                    <?php 
                    if(!empty($expressList)){
                        foreach ($expressList as $key => $value) {   
                    ?>
                    <option value="<?php echo $value->id;?>"><?php echo $value->name;?></option>
                    <?php
                        }
                    }
                    ?>
                    </select>
                </dd>
            </dl>
            <dl class="" >
                <dt>物流单号：</dt>
                <dd class="inp4">
                <input type="text" name="shipping_code" id="shipping_code" style="width:170px;"/>
                </dd>
            </dl>            
        </div>
        <div class="btn_two btn_width cf">
            <input type="hidden" value="" name="express_id">
            <a class="a1" href="javascript:" onclick="saveExpress()">保存</a><a class="close" href="###">取消</a>
        </div>
    </form>
</div>
<!--批量发货窗口-->
<div class="up_box" style="display: none; width: 475px;" id="up_box33">
    <form name="shipping_order_form" id="shipping_order_form">
        <h1>批量发货<i class="close"></i></h1>
        <div class="bor_box modify_box">            
            <dl class="cf">
                <dt>物流公司：</dt>
                <dd class="inp4">
                    <select name="shipping_name" id="shipping_name">
                    <option value="">请选择快递</option>
                    <?php 
                    if(!empty($expressList)){
                        foreach ($expressList as $key => $value) {   
                    ?>
                    <option value="<?php echo $value->id;?>"><?php echo $value->name;?></option>
                    <?php
                        }
                    }
                    ?>
                    </select>
                </dd>
            </dl>
            <dl>
                <dt>运单号1：</dt>
                <dd class="inp4">
                <input type="text" name="shipping_code[]" id="shipping_code" style="width:170px;"/>
                </dd>
            </dl>            
        </div>
        <div class="btn_two btn_width cf">
            <input type="hidden" value="" name="express_id">
            <a class="a1" href="javascript:" onclick="save_list()">保存</a><a class="close" href="###">取消</a>
        </div>
    </form>
</div>
<!--添加备注窗口-->
<div class="up_box" style="display: none; width: 475px;" id="up_box35">    
    <h1>添加备注<i class="close"></i></h1>
    <div class="bor_box modify_box">        
        <div>
            <textarea cols="50" rows="6" id="new_note" placeholder="填写备注"></textarea>
        </div>           
    </div>
    <div class="btn_two btn_width cf">
        <input type="hidden" value="" name="note_id">
        <a class="a1" href="javascript:" onclick="save_new_note()">保存</a><a class="close" href="###">取消</a>
    </div>    
</div>
<!--修改地址窗口-->
<div class="up_box" style="display: none; width: 475px;" id="up_box36">    
    <h1>修改地址<i class="close"></i></h1>
    <div class="bor_box modify_box">
        <b style="color:red;">您确认要修改地址吗？</b>
        <div>
            <textarea cols="50" rows="6" id="new_address" placeholder="填写新地址"></textarea>
        </div>           
    </div>
    <div class="btn_two btn_width cf">
        <input type="hidden" value="" name="save_id">
        <a class="a1" href="javascript:" onclick="save_new_address()">保存</a><a class="close" href="###">取消</a>
    </div>    
</div>
<!--删除窗口-->
<div class="up_box" style="display: none; width: 475px;" id="up_box37">    
    <h1>删除订单<i class="close"></i></h1>
    <div class="bor_box modify_box">
        <b style="color:red;">您确认要删除此订单吗？</b>
        <div>
            <textarea cols="50" rows="6" placeholder="可添加备注"></textarea>
        </div>           
    </div>
    <div class="btn_two btn_width cf">
        <input type="hidden" value="" name="delete_id">
        <a class="a1" href="javascript:" onclick="fu_delete()">保存</a><a class="close" href="###">取消</a>
    </div>    
</div>

<style type="text/css">
    td{
        border: 0px !important;
    }
</style>

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
                $("#info_status").html(order['order']['status']);
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
    // 添加备注弹窗
    function new_note(id){
        $("input[name='note_id']").val(id);  
        $.post('<?php echo input::site('admin/order/get_info'); ?>',
            {'id':id},function(data){
                var data = eval("("+data+")");
                if(data.success == 1){
                    var info = data.info;
                    $("#new_note").html(info.note);
                }
        })
        open_box('#up_box35');
    }
    // 保存备注
    function save_new_note(){
        var note = $('#new_note').val();
        var id = $("input[name=note_id]").val();
        $.post('<?php echo input::site('admin/order/save_new_note'); ?>',
            {'id':id,'note':note},function(data){
                var data = eval("("+data+")");
                if(data.success == 1){
                    window.location.reload();
                }else{
                    alert(data.msg);
                }
        })
    }
    // 修改地址弹窗
    function new_address(id){
        $("input[name='save_id']").val(id);  
        $.post('<?php echo input::site('admin/order/get_info'); ?>',
            {'id':id},function(data){
                var data = eval("("+data+")");
                if(data.success == 1){
                    var info = data.info;
                    $("#new_address").html(info.address);
                }
        })
        open_box('#up_box36');
    }
    // 保存更新地址
    function save_new_address(){
        var address = $('#new_address').val();
        var id = $("input[name=save_id]").val();
        $.post('<?php echo input::site('admin/order/save_new_address'); ?>',
            {'id':id,'address':address},function(data){
                var data = eval("("+data+")");
                if(data.success == 1){
                    window.location.reload();
                }else{
                    alert(data.msg);
                }
        })
    }
    //发货弹窗
    function send_goodsList() {     
        open_box('#up_box33');
    }
    // 保存物流信息
    function save_goodsList(){
        $("input[id=check_all]:checked").each(function(n,e){
            $
        });
        var id = $("input[name='express_id']").val();
        var name = $("select[id=shipping_id] option:selected").val();
        var code = $("#shipping_code").val();
        $.post('<?php echo input::site('admin/order/saveExpress'); ?>',
            {'id':id,'name':name,'code':code},function(data){
                var data = eval("("+data+")");
                if(data.success == 1){
                    window.location.reload();
                }else{
                    alert(data.msg);
                }
        })
    }
    //发货弹窗
    function orderSend(id) {     
        $("input[name='express_id']").val(id);  
        open_box('#up_box38');
    }
    // 保存物流信息
    function saveExpress(){
        var id = $("input[name='express_id']").val();
        var name = $("select[id=shipping_id] option:selected").val();
        var code = $("#shipping_code").val();
        $.post('<?php echo input::site('admin/order/saveExpress'); ?>',
            {'id':id,'name':name,'code':code},function(data){
                var data = eval("("+data+")");
                if(data.success == 1){
                    window.location.reload();
                }else{
                    alert(data.msg);
                }
        })
    }
    // 关闭订单
    function close_order(id){
        if(confirm("确认关闭?")){
            $.post('<?php echo input::site('admin/order/close_order'); ?>',
                {'id':id},
                function(data){
                    var data = eval("("+data+")");
                    if(data.success == 1){
                        window.location.reload();
                    }else{
                        alert(data.msg);
                    }
            })
        }
    }
    // 删除订单弹出
    function del_order(id){
        $("input[name='delete_id']").val(id);  
        open_box('#up_box37');
    }
    // 删除订单功能
    function fu_delete(){
        var id = $("input[name='delete_id']").val();
        $.post('<?php echo input::site('admin/order/deletes'); ?>',
            {'id':id},
            function(data){
                var data = eval("("+data+")");
                if(data.success == 1){
                    window.location.reload();
                }else{
                    alert(data.msg);
                }
        })
    }
    // 确认收货
    function make_sure(id){
        if(confirm("确认收货?")){
            $.post('<?php echo input::site('admin/order/make_sure'); ?>',
                {'id':id},
                function(data){
                    var data = eval("("+data+")");
                    if(data.success == 1){
                        window.location.reload();
                    }else{
                        alert(data.msg);
                    }
            })
        }
    }
    // 确认付款
    function pay_order(id){        
        if(confirm("确认付款?")){
            $.post('<?php echo input::site('admin/order/pay_order'); ?>',
                {'id':id},
                function(data){
                    var data = eval("("+data+")");
                    if(data.success == 1){
                        window.location.reload();
                    }else{
                        alert(data.msg);
                    }
            })
        }
    }
    // 修改价格
    function change_price(id){
        var str = '';
        $.post('<?php echo input::site('admin/order/get_goods_info'); ?>',{'id':id},function(data){
            var data = eval("("+data+")");
            var i = 0;           
            var all_price = 0; 
            var number = 0;
            if(data.success == 1){
                var info = data.info;
                for ( ; i < info.length; i++) {   
                    all_price += parseInt(info[i].price)*parseInt(info[i].num);

                    str += '<tr>                                                   ';
                    str += '    <td>                                               ';
                    str += '    <img src="'+info[i].pic+'">                        ';
                    str += '    <p>'+info[i].name+'</p>                            ';
                    str += '    <div>                                              ';
                    str += ' ￥ '+info[i].price+'  数量 '+info[i].num               ;
                    str += '    </div>                                             ';
                    str += '                                                       ';
                    str += '    </td>                                              ';
                    str += '    <td width="30%">                                   ';
                    str += '        <p style="float: left;">                       ';
                    str += '            修改价格<br>涨价+/减价-                    ';
                    str += '        </p>                                           ';
                    str += '        <input type="text" name="price[]">             ';
                    str += '    </td>                                              ';
                    str += '</tr>                                                  ';
                }
            }
            $("span[id=all_price]").html(all_price);
            $("span[id=all_price]").html(all_price);
            $("#goods_list").html(str);            
        })
        open_box('#up_box16');
    }
</script>
