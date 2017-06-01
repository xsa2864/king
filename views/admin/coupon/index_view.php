<script src="<?php echo input::jsUrl('date/date.js'); ?>" type="text/javascript"></script>
<link href="<?php echo input::cssUrl('date.css'); ?>" rel="stylesheet" type="text/css" />

<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="back_right">
                <div class="right">
                    <h1>订单列表</h1>
                    <div class=" bor_box stock_box padd0 cf">
                        <form>
                            <dl class="cf">
                                <dd>
                                    <div>
                                        订单号:
                                        <input type="text" name="code" value="<?php echo $code; ?>" placeholder="订单号" class="input9">
                                    </div>
                                </dd>
                                <dd>
                                    <div>
                                        商品名称:
                                        <input type="text" name="title" value="<?php echo $title; ?>" placeholder="商品名称" class="input9">
                                    </div>
                                </dd>
                                <dd>
                                    <div>
                                        用户昵称:
                                        <input type="text" name="nickname" value="<?php echo $nickname; ?>" placeholder="用户昵称" class="input9">
                                    </div>
                                </dd>                               
                                <br>
                                <dd>
                                    <span>价格区间:
                                        <input type="text" name="minPrice" value="<?php echo $minPrice; ?>" placeholder="最小价格" class="input3">
                                    </span>&nbsp;&nbsp;到&nbsp;               
                                </dd>
                                <dd>
                                    <span>
                                        <input type="text" name="maxPrice" value="<?php echo $maxPrice; ?>" placeholder="最大价格" class="input3">
                                    </span>
                                </dd>
                                <dd class="inp5">
                                    <span>订单时间：
                                    <input type="text" name="startTime" value="<?php echo $startTime; ?>" placeholder="订单日期" class="puiDate date_input">
                                    </span>&nbsp;&nbsp;到&nbsp;
                                </dd>
                                <dd class="inp5">
                                    <span>
                                        <input type="text" name="endTime" value="<?php echo $endTime; ?>" placeholder="订单日期" class="puiDate date_input">
                                    </span>
                                </dd>
                                <dd class="query_box"><a href="javascript:;" onclick="$('form').submit();">查询</a></dd>
                            </dl>
                        </form>
                    </div>
                    <div>
                        <button onclick="order_excel()">导出订单</button>
                    </div>
                    <div class="edit_box sale_cen mar_right cf">
                        <div class="title_all">
                            <ul class="edit_title bold cf">
                                <li <?php if($tab_class == '99' || $tab_class==0){
                                              echo 'class="curr"';
                                          } ?>>
                                    <a href="<?php echo input::site('admin/coupon/index/99').$total_url; ?>">所有订单<i>
                                        (<?php echo $total; ?>)</i></a><b></b>
                                </li>
                                <li <?php if($tab_class == '1'){
                                              echo 'class="curr"';
                                          } ?>>
                                    <a href="<?php echo input::site('admin/coupon/index/1').$no_pay_url; ?>">待付款<i>
                                        (<?php echo $no_pay; ?>)</i></a><b></b>
                                </li>
                                <li <?php if($tab_class == '4'){
                                              echo 'class="curr"';
                                          } ?>>
                                    <a href="<?php echo input::site('admin/coupon/index/4').$no_send_url; ?>">待发货<i>
                                        (<?php echo $no_send; ?>)</i></a><b></b>
                                </li>
                                <li <?php if($tab_class == '2'){
                                              echo 'class="curr"';
                                          } ?>>
                                    <a href="<?php echo input::site('admin/coupon/index/2').$no_use_url; ?>">待收货<i>
                                        (<?php echo $no_use; ?>)</i></a><b></b>
                                </li>
                                <li <?php if($tab_class == '3'){
                                              echo 'class="curr"';
                                          } ?>>
                                    <a href="<?php echo input::site('admin/coupon/index/3').$use_url; ?>">交易完成<i>
                                        (<?php echo $use; ?>)</i></a><b></b>
                                </li>

                                <li <?php if($tab_class == '5'){
                                              echo 'class="curr"';
                                          } ?>>
                                    <a href="<?php echo input::site('admin/coupon/index/5').$close_url; ?>">交易关闭<i>
                                        (<?php echo $close; ?>)</i></a><b></b>
                                </li>
                            </ul>
                        </div>
                        <!-- 所有订单 -->
                        <div style="display: block" class="box_zlm">
                            <div class="edit_cen order_box " style="overflow-y: auto; height: 700px">
                                <table class="thead">
                                    <tbody>
                                        <tr style="height:auto">
                                            <th width="4%"></th>
                                            <th>昵称<i></i></th>
                                            <th>订单号<i></i></th>
                                            <th>快递单号<i></i></th>
                                            <th>商品名称<i></i></th>
                                            <th>商品价格<i></i></th>
                                            <th>下单时间<i></i></th>
                                            <th>状态<i></i></th>
                                            <th>操作</th>
                                        </tr>
                                        <?php
                                        foreach($list as$key=> $value) {
                                        ?>
                                        <tr>
                                            <td>
                                               <input type="checkbox" style="margin-right:-30px;" value="<?php echo $value->id;?>" />        
                                            </td> 
                                            <td> 
                                                <?php echo json_decode($value->nickname); ?></td>
                                            <td><?php echo $value->code; ?></td>
                                            <td><?php echo $value->express; ?></td>
                                            <td><?php echo $value->title; ?></td>
                                            <td>
                                                <?php echo $value->price;?>
                                            </td>
                                            <td><?php echo date('Y-m-d H:i:s',$value->addtime); ?></td>
                                            <td>
                                                <?php 
                                            
                                            if($value->paystatus == 0){
                                                echo '<p>待付款</p>'; 
                                            }else if($value->paystatus == -1){
                                                echo '<p>关闭</p>'; 
                                            }else if($value->paystatus == 1 && $value->is_use == 2){                            
                                                echo '<p class="is">交易完成</p>';    
                                            }else if($value->paystatus == 1 && $value->is_use == 0){                            
                                                echo '<p class="noSend">待发货</p>';    
                                            }else if($value->paystatus == 1 && $value->is_use == 1){                            
                                                echo '<p class="isSend">待收货</p>';    
                                            }
                                                ?>
                                            </td>
                
                                            <td class="revise" style="text-align: center;">
                                                <!--不同订单状态会有不同的功能按钮-->
                                                <h1 class="h1_one">
                                                    <a href="<?php echo input::site('admin/coupon/detail?id=').$value->id;?>">查看详情</a>
                                                    <div class="revise_pop" style="display: none">
                                                        <a href="<?php echo input::site('admin/coupon/coupon_edit?id=').$value->id;?>">编辑</a>                                                        
                                                        <?php                            
                                                        if($value->paystatus == 0){
                                                            echo '<a href="javascript:close('.$value->id.');">关闭订单</a> ';
                                                        }else if($value->paystatus == 1 && $value->is_use == 0){
                                                            echo '<a href="javascript:write('.$value->code.','.$value->id.')">填写物流单号</a>';
                                                        }                      
                                                        ?>
                                                    </div>
                                                </h1>
                                            </td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <span class="sp1">
                                    <input name="" type="checkbox" value="" class="check_all" id="check_all" style="margin:0 5px 0 10px;" />
                                    <label for="check_all">全选</label>
                                </span>
                                <span class="sp2"><a href="javascript:del_more();">批量删除</a></span>
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
</div>
<!--添加备注窗口-->
<div class="up_box" style="display: none; width: 475px;" id="up_box35">
    <h1>填写快递单号<i class="close"></i></h1>
    <div class="bor_box modify_box">
        <div>
            订单号:<label id="show_code"></label>
        </div>
        <div>
            <label style="float: left;">快递公司：</label>
            <select id="express_name" class="puiSelect" size="12">
                <option value="" selected>请选择</option>
                <option value="shunfeng" >顺丰速运</option>
                <option value="zhongtong">中通快递</option>
                <option value="ems">EMS</option>                            
                <option value="yuantong">圆通快递</option>
                <option value="shentong">申通快递</option>
                <option value="tiantian">天天快递</option>
                <option value="yunda">韵达快递</option>
                <option value="huitong">汇通快运</option>
                <option value="quanfeng">全峰快递</option>
                <option value="zhaijisong">宅急送</option>
                <option value="pingyou">中国邮政</option>
            </select>
        </div>
        <br>
        <div>
            快递单号:<input type="text" name="express" id="express">
        </div>
    </div>
    <div class="btn_two btn_width cf">
        <input type="hidden" value="" name="send_id" id="send_id">
        <a class="a1" href="javascript:" onclick="send_sure()">发货</a><a class="close" href="###">取消</a>
    </div>
</div>
<style type="text/css">
.order_box tr {
    height: 50px;
}

.order_box td {
    border: 0;
    text-align: center;
    font-weight: bold;
    color: #000;
}

.order_box .no {
    color: green;
}

.order_box .is {
    color: red;
}
.order_box .noSend{
    color:green;
}
.order_box .isSend{
    color:#f39c12;
}
.bor_box dd .input3 {
    width: 60px;
}
.up_box .bor_box{
    font-size: 1rem;
}
.up_box .bor_box input{
    height: 1.2rem;
    border: solid 1px #866d6d !important;
}
</style>

<!--遮罩层-->
<div class="mask_box" style="display: none"></div>
<script type="text/javascript">
// 发货弹窗
function write(code,id){
    $("#show_code").html(code);
    $("#send_id").val(id);
    open_box('#up_box35');
}
// 发货
function send_sure(){
    var id = $("#send_id").val();
    var express = $("#express").val();
    var express_name = $("#express_name").val();
    if(express_name == ''){
        alert("请选择快递公司");
        return false;
    }
    if(express == ''){
        alert("请填写快递单号");
        return false;
    }
    $.post('<?php echo input::site("admin/coupon/send_sure")?>',{'id':id,'express':express,'express_name':express_name},
        function(data){
            if(data.success == 1){
                location.reload();
            }
            alert(data.msg);
    },'json')
}
    $(function () {
        //全选
        $('.check_all').click(function () {
            var checked = $(this).is(':checked');
            $('.order_box input[type=checkbox]').prop('checked', (checked ? 'checked' : false));
        });
        //移动到显示
        $('.revise h1').hover(function () {
            $(this).parents('.revise').find('.revise_pop').toggle();
            return false;

        }, function () {
            $(this).parents('.revise').find('.revise_pop').toggle();
            return false;
        });
    });

    // 确认退款
    function mk_sure() {
        var id = $("input[name=return_id]").val();
        var type = $("input[name=r_type]:checked").val();
        var note = $("#note").val();
        console.log(note);
        $.post('<?php echo input::site('admin/coupon/mk_sure');?>',
        { 'id': id, 'type': type, 'note': note },
        function (data) {
            var data = eval("(" + data + ")");
            if (data.success == 1) {
                location.reload();
            }
            alert(data.msg);
        });
    }
    // 关闭订单
    function close(id) {
        if (id == '' || id == null) {
            alert("操作失败");
            return false;
        }
        if (confirm("确认关闭订单?")) {
            $.post('<?php echo input::site('admin/coupon/close');?>',
            { 'id': id },
            function (data) {
                var data = eval("(" + data + ")");
                if (data.success == 1) {
                    location.reload();
                } else {
                    alert(data.msg);
                }
            });
    }
}
// 导出订单列表
function order_excel() {
    var tab_class = '<?php echo $tab_class;?>';
    var code = $("input[name=code]").val();
    var startTime = $("input[name=startTime]").val();
    var endTime = $("input[name=endTime]").val();

    var str = '?';
    if (tab_class != '') {
        str += 'tab_class=' + tab_class;
    }

    if (code != '') {
        if (str.split("=").length > 1) {
            str += '&';
        }
        str += 'code=' + code;
    }
    if (startTime != '') {
        if (str.split("=").length > 1) {
            str += '&';
        }
        str += 'startTime=' + startTime;
    }
    if (endTime != '') {
        if (str.split("=").length > 1) {
            str += '&';
        }
        str += 'endTime=' + endTime;
    }
    console.log(str);
    window.location.href = '<?php echo input::site("admin/coupon/order_excel")?>' + str;
}

// 选中用户的id
function get_checked() {
    var id = '';
    $('td>input[type=checkbox]').filter(function () {
        return this.checked;
    }).each(function (i, e) {
        if (id != '') {
            id += ','
        }
        id += e.value;
    })

    return id;
}

// 批量删除订单
function del_more() {
    var id = get_checked();
    if (confirm("确定要批量删除选中订单!")) {
            $.post("<?php echo input::site('admin/coupon/del_more');?>", { 'id': id }, function (data) {
            var data = eval("(" + data + ")");
            if (data.success == 1) {
                window.location.reload();
            } else {
                alert(data.msg);
            }
        })
    }
}
</script>
