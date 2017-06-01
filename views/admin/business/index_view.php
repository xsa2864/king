<script src="<?php echo input::jsUrl('date/date.js'); ?>" type="text/javascript"></script>
<link href="<?php echo input::cssUrl('date.css'); ?>" rel="stylesheet" type="text/css" />

<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="back_right">
                <div class="right">
                    <h1>商家列表</h1>
                    <div class=" bor_box stock_box padd0 cf">
                        <form name="orderForm" id="orderForm" method="get" action="index">
                            <dl class="cf">
                                <dd>
                                    <div>
                                        店名:
                                    <input type="text" name="name" value="<?php echo $name; ?>" placeholder="店名" class="input9">
                                    </div>
                                </dd>
                                <dd>
                                    <div>
                                        联系人名字:
                                    <input type="text" name="realname" value="<?php echo $realname; ?>" placeholder="联系人名字" class="input9">
                                    </div>
                                </dd>
                                <dd>
                                    <div>
                                        手机号:
                                    <input type="text" name="mobile" value="<?php echo $mobile; ?>" placeholder="手机号" class="input9">
                                    </div>
                                </dd>
                                <dd>
                                    <div>
                                        城市:
                                    <input type="text" name="city" value="<?php echo $city; ?>" placeholder="城市" class="input9">
                                    </div>
                                </dd>
                                <dd class="inp5">
                                    <span>申请时间：
                                    <input type="text" name="startTime" value="<?php echo $startTime; ?>" placeholder="开始申请时间" class="puiDate date_input">
                                    </span>&nbsp;&nbsp;到&nbsp;
                                </dd>
                                <dd class="inp5">
                                    <span>
                                        <input type="text" name="endTime" value="<?php echo $endTime; ?>" placeholder="结束申请时间" class="puiDate date_input">
                                    </span>
                                </dd>
                                <dd class="query_box"><a href="javascript:" onclick="$('#orderForm').submit();">查询</a></dd>
                            </dl>
                        </form>
                        <div>
                            <button onclick="csv_import()">csv导入商家</button>
                            <a href="../../upload/csv/business.csv" style="margin-left: 10px; color: green;">下载csv模板</a>
                            &nbsp;&nbsp;&nbsp;
                            <button onclick="business_excel()">导出商家</button>
                        </div>
                    </div>
                    <div class="edit_box sale_cen mar_right cf">
                        <div class="title_all">
                            <ul class="edit_title bold cf">
                                <li <?php if($tab_class == '' || intval($tab_class) == 0){
                                              echo 'class="curr"';
                                          } ?>><a href="<?php echo input::site('admin/business/index/'); ?>">所有商家<i>（<?php echo $total; ?>）</i></a><b></b>
                                </li>
                                <li <?php if($tab_class == '100'){
                                              echo 'class="curr"';
                                          } ?>><a href="<?php echo input::site('admin/business/index/100'); ?>">正常<i>（<?php echo $run;?>）</i></a><b></b></li>
                                <li <?php if($tab_class == '102'){
                                              echo 'class="curr"';
                                          } ?>><a href="<?php echo input::site('admin/business/index/102'); ?>">申请开店<i>（<?php echo $apply;?>）</i></a><b></b></li>
                                <li <?php if($tab_class == '101'){
                                              echo 'class="curr"';
                                          } ?>><a href="<?php echo input::site('admin/business/index/101'); ?>">关闭<i>（<?php  echo $over;?>）</i></a><b></b></li>
                            </ul>
                        </div>
                        <!-- 所有订单 -->
                        <div style="display: block" class="box_zlm">
                            <div class="edit_cen order_box " style="overflow-y: auto;height:700px">
                                <table class="thead" style="width:1500px">
                                    <tbody>
                                        <tr>
                                            <th width="2%"></th>
                                            <th style="width:7%">图片LOGO<i></i></th>
                                            <th style="width:7%">商家名称<i></i></th>
                                            <th style="width:10%">所在城市<i></i></th>
                                            <th style="width:7%">联系人<i></i></th>
                                            <th style="width:9%">手机号<i></i></th>
                                            <th style="width:15%">openid<i></i></th>
                                            <th style="width:9%">销售量<i></i></th>
                                            <th style="width:9%">销售总金额<i></i></th>
                                            <th style="width:7%">申请时间<i></i></th>
                                            <th style="width:7%">审核时间<i></i></th>
                                            <th style="width:7%">店铺状态<i></i></th>
                                            <th style="width:9%">操作</th>
                                        </tr>

                                        <?php
                                        foreach($list as$key=> $ors) {
                                        ?>
                                        <tr>
                                            <td>
                                               <input type="checkbox" style="margin-right: -10px;" value="<?php echo $ors->id;?>" />          
                                            </td>
                                            <td>
                                                <img width="58" height="59" src="<?php echo $ors->pic==''?input::imgUrl('default.png','wechat'):input::site($ors->pic); ?>">
                                            </td>
                                            <td>
                                                <span><?php echo $ors->name;?></span>
                                            </td>
                                            <td>
                                                <span><?php echo $ors->city;?></span>
                                            </td>
                                            <td>
                                                <span><?php echo $ors->realname;?></span>
                                            </td>
                                            <td>
                                                <span><?php echo $ors->mobile;?></span>
                                            </td>
                                            <td>
                                                <span><?php echo $ors->openId;?></span>
                                            </td>
                                            <td>
                                                <span><?php echo $ors->sell_num;?></span>
                                            </td>
                                            <td>
                                                <span><?php echo $ors->amount;?></span>
                                            </td>
                                            <td>
                                                <span><?php echo date('Y-m-d H:i:s',$ors->addtime);?></span>
                                            </td>
                                            <td>
                                                <span><?php echo ($ors->suretime>0?date('Y-m-d H:i:s',$ors->suretime):'');?></span>
                                            </td>
                                            <td>
                                                <span>
                                                    <?php 
                                            if($ors->status == 1){
                                                echo "正常";
                                            }else if($ors->status == 2){
                                                echo "申请开店";
                                            }else if($ors->status == -1){
                                                echo "拒绝申请";
                                            }else{
                                                echo "关闭";
                                            }
                                                    ?>
                                                </span>
                                            </td>
                                            <td class="revise" style="text-align: center;">
                                                <!--不同订单状态会有不同的功能按钮-->
                                                <h1 class="h1_one">
                                                    <a href="javascript:show_detail('<?php echo $ors->id;?>')">查看详情</a>
                                                    <div class="revise_pop" style="display: none">
                                                        <a href="<?php echo input::site('admin/business/add?id='.$ors->id); ?>">修改商家</a>
                                                        <a href="javascript:apply('<?php echo $ors->id;?>')">审核店铺</a>
                                                        <a href="javascript:del_business('<?php echo $ors->id;?>')">删除商家</a>
                                                        <a href="javascript:mk_qrcode('<?php echo $ors->id;?>')">生成二维码</a>
                                                        <a href="javascript:see_qrcode('<?php echo $ors->qrCode;?>')">查看二维码</a>
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




<!--遮罩层-->
<div class="mask_box" style="display: none"></div>

<!--csv导入窗口-->
<div class="up_box" style="display: none; width: 475px;" id="up_box31">
    <form id="form1">
        <h1>导入商家列表<i class="close"></i></h1>
        <div class="order_xq">
            <h3>订单信息</h3>
            <div class="xq_cen">
                <dl class="cf">
                    <dt>选择文件：</dt>
                    <span>
                        <input type="file" name="file">
                        <button id="upload" type="button" onclick="upload_csv(this)" style="padding: 3px 13px;">导入</button>
                    </span>
                </dl>
            </div>
        </div>
        <div class="btn_two btn_width cf">
            <a class="close" href="###">取消</a>
        </div>
    </form>
</div>

<!--查看商家二维码-->
<div class="up_box" style="display: none; width: 260px;" id="up_box32">
    <h1>商家二维码<i class="close"></i></h1>
    <div class="order_xq">
        <div class="xq_cen" style="text-align: center;">
            <img src="" id="see_qrcode">
        </div>
    </div>
    <div class="btn_two btn_width cf">
        <a class="close" href="###">取消</a>
    </div>
</div>

<!--审核窗口-->
<div class="up_box" style="display: none; width: 475px;" id="up_box33">
    <h1>审核窗口商家<i class="close"></i></h1>
    <div class="order_xq">
        <div class="xq_cen">
            <dl class="cf">
                <dt>选择状态：</dt>
                <dd style="width: 120px;">
                    <div>
                        <input type="radio" name="status" id="status1" value="1">
                        <label for="status1">正常</label>
                    </div>
                    <div>
                        <input type="radio" name="status" id="status2" value="2">
                        <label for="status2">申请开店</label>
                    </div>
                    <div>
                        <input type="radio" name="status" id="status3" value="-1">
                        <label for="status3">拒绝申请</label>
                    </div>
                    <div>
                        <input type="radio" name="status" id="status0" value="0">
                        <label for="status0">关闭</label>
                        <input type="text" name="note" id="note" placeholder="关闭的理由" style="display: none;">
                    </div>
                </dd>
            </dl>
        </div>
    </div>
    <div class="btn_two btn_width cf">
        <input type="hidden" id="status_id">
        <a href="javascript:save_apply();">保存</a>
        <a class="close" href="###">取消</a>
    </div>
</div>

<style type="text/css">
    tr {
        text-align: center;
    }

    td {
        color: #000 !important;
    }

    #up_box16 img {
        float: left;
        border: 1px solid #eee;
    }

    #up_box16 input {
        border: 1px solid #000;
        width: 100px;
        height: 30px;
    }

    #up_box16 tr {
        height: 50px;
    }

    #up_box16 #footer_tr {
        color: #000;
        height: 70px;
    }

    .thead th i {
        height: 60%;
    }
</style>

<!--添加备注窗口-->
<div class="up_box" style="display: none; width: 700px;" id="up_box35">
    <h1>查看商家详情<i class="close"></i></h1>
    <div class="order_xq">
        <div class="xq_cen">
            <dl class="cf">
                <dt>LOGO：</dt>
                <dd id="pic"></dd>
            </dl>
            <dl class="cf">
                <dt>商家名称：</dt>
                <dd id="name"></dd>
            </dl>
            <dl class="cf">
                <dt>众合账号：</dt>
                <dd id="zh_name"></dd>
            </dl>
            <dl class="cf">
                <dt>城市：</dt>
                <dd id="city"></dd>
            </dl>
            <dl class="cf">
                <dt>地址：</dt>
                <dd id="address"></dd>
            </dl>
            <dl class="cf">
                <dt>联系人：</dt>
                <dd id="realname"></dd>
            </dl>
            <dl class="cf">
                <dt>手机号：</dt>
                <dd id="mobile"></dd>
            </dl>
            <dl class="cf">
                <dt>状态：</dt>
                <dd id="status"></dd>
            </dl>
            <dl class="cf">
                <dt>申请类型：</dt>
                <dd id="applytype"></dd>
            </dl>
            <dl class="cf">
                <dt>申请时间：</dt>
                <dd id="applytime"></dd>
            </dl>
            <dl class="cf">
                <dt>审核时间：</dt>
                <dd id="suretime"></dd>
            </dl>
            <dl class="cf">
                <dt>openid：</dt>
                <dd id="openid"></dd>
            </dl>
            <dl class="cf">
                <dt>详情介绍：</dt>
                <dd id="content" style="overflow-y: auto; height: 200px;"></dd>
            </dl>
        </div>
    </div>
    <div class="btn_two btn_width cf">
        <a class="close" href="###">取消</a>
    </div>
</div>


<style type="text/css">
    td {
        border: 0px !important;
    }

    #up_box35 .xq_cen dd {
        width: 500px;
    }

    #note {
        border: 1px solid #000;
    }
</style>

<script>
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
    $("input[name=status]").click(function () {
        var n = $(this).val();
        if (n == 0 || n == -1) {
            $("#note").attr("style", "display:block");
        } else {
            $("#note").attr("style", "display:none");
        }
    })
    // 审核店铺状态
    function apply(id) {
        $.post('<?php echo input::site('admin/business/get_status'); ?>', { 'id': id },
        function (data) {
            var da = eval("(" + data + ")");
            $("#status" + da.status).attr("checked", "true");
            if (da.status == 0) {
                $("#note").attr("style", "display:block");
            }
            if (da.status == -1) {
                $("#status3").attr("checked", "true");
                $("#note").attr("style", "display:block");
            }
            $("#note").val(da.note);
            $("#status_id").val(id);
        })
        open_box('#up_box33');
    }
    function save_apply() {
        var id = $("#status_id").val();
        var status = $("input[type=radio]:checked").val();
        var note = $("#note").val();
        if (status == 0) {
            if (note == '') {
                alert("关闭理由必须项");
                return false;
            }
        }
        $.post('<?php echo input::site('admin/business/apply_status'); ?>', { 'id': id, 'status': status, 'note': note },
        function (data) {
            var data = eval("(" + data + ")");
            if (data.success == 1) {
                location.reload();
            } else {
                alert(data.msg);
            }
        })
    }
    // 详情信息
    function show_detail(id) {
        var str = '';
        $.post('<?php echo input::site('admin/business/show_detail'); ?>', { 'id': id }, function (data) {
            var data = eval("(" + data + ")");
            var info = data.info;
            if (data.success == 1) {
                if (info.status == 1) {
                    var str = "正常";
                } else {
                    var str = "关闭";
                }
                if (info.pic != '') {
                    var img = "<img src=http://" + location.hostname + '/' + info.pic + " width=80 height=80>";
                }
                if (info.type == 1) {
                    var applytype = "后台添加";
                } else {
                    var applytype = "前端申请";
                }
                $("#pic").html(img);
                $("#name").html(info.name);
                $("#city").html(info.city);
                $("#zh_name").html(info.zh_name);
                $("#address").html(info.address);
                $("#realname").html(info.realname);
                $("#mobile").html(info.mobile);
                $("#status").html(str);
                $("#content").html(info.content);
                $("#openid").html(info.openId);
                $("#applytype").html(applytype);
                $("#applytime").html(formatDate(info.addtime));
                $("#suretime").html(info.suretime > 0 ? formatDate(info.suretime) : '');

            }

        })
        open_box('#up_box35');
    }
    function formatDate(now) {
        var now = new Date(parseInt(now) * 1000);
        var year = now.getFullYear();
        var month = now.getMonth() + 1;
        var date = now.getDate();
        var hour = now.getHours();
        var minute = now.getMinutes();
        var second = now.getSeconds();
        return year + "-" + month + "-" + date + " " + hour + ":" + minute + ":" + second;
    }
    // 删除活动
    function del_business(id) {
        if (confirm("确定删除!")) {
            $.post('<?php echo input::site("admin/business/del_business"); ?>',
            { 'id': id },
            function (data) {
                var data = eval("(" + data + ")");
                if (data.success == 1) {
                    window.location.reload();
                } else {
                    alert(data.msg);
                }
            }
        )
    }
}
// 导出商家
function business_excel() {
    var tab_class = '<?php echo $tab_class;?>';
    var name = $("input[name=name]").val();
    var startTime = $("input[name=startTime]").val();
    var endTime = $("input[name=endTime]").val();

    var str = '?';
    if (tab_class != '') {
        str += 'tab_class=' + tab_class;
    }

    if (name != '') {
        if (str.split("=").length > 1) {
            str += '&';
        }
        str += 'name=' + name;
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
    window.location.href = '<?php echo input::site("admin/business/business_excel")?>' + str;
}
// 商家导入
function csv_import() {
    open_box('#up_box31');
}
// 上传
function upload_csv(str) {
    var formData = new FormData(document.getElementById("form1"));
    var str = $("input[name=file]").val();
    if (str == "" || str == null) {
        alert("导入内容不能为空");
        return false;
    }
    $.ajax({
        url: '/admin/coupon/uploadcsv',
        type: 'POST',
        cache: false,
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
            var data = eval("(" + data + ")");
            if (data.info == '' || data.info == null) {
                if(data.success){
                    location.reload();
                }else{
                    alert(data.msg);
                }                
            } else {
                alert(data.info+'\n\t 这些数据已经添加,请不要重复添加!');
            }

        }
    })
}
// 生成店家二维码
function mk_qrcode(id) {
    if (confirm("确认生成二维码！")) {
        $.post('<?php echo input::site("admin/business/shop_code");?>', { 'id': id },
            function (data) {
                console.log(data);
                if (data) {
                    alert("生成成功");
                } else {
                    alert("生成失败");
                }
            })
    }
}
// 查看商家二维码
function see_qrcode(str) {
    var fx_prefix = location.protocol + '//' + location.hostname + '/';
    if (str != '' || str != null) {
        $("#see_qrcode").attr('src', fx_prefix + str);
    }
    open_box('#up_box32');
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

// 批量删除店铺
function del_more() {
    var id = get_checked();
    if (confirm("确定要批量删除选中店铺!")) {
            $.post("<?php echo input::site('admin/business/del_more');?>", { 'id': id }, function (data) {
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
