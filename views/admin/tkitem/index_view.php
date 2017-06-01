<script src="<?php echo input::jsUrl('date/date.js'); ?>" type="text/javascript"></script>
<link href="<?php echo input::cssUrl('date.css'); ?>" rel="stylesheet" type="text/css" />

<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="back_right">
                <div class="right">
                    <h1>商品列表</h1>
                    <div class=" bor_box stock_box padd0 cf">
                        <form name="orderForm" id="orderForm" method="get" action="index">
                            <dl class="cf">
                                <dd>
                                    <div>
                                        名称:
                                        <input type="text" name="title" value="<?php echo $title; ?>" placeholder="名称" class="input9">
                                    </div>
                                </dd>
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
                                <dd class="query_box"><a href="javascript:" onclick="$('#orderForm').submit();">查询</a></dd>
                            </dl>
                        </form>
                    </div>

                    <div class="edit_box sale_cen mar_right cf">
                        <div class="title_all">
                            <ul class="edit_title bold cf">
                                <li <?php if($tab_class == '' || intval($tab_class) == 0){
                                              echo 'class="curr"';
                                          } ?>>
                                    <a href="<?php echo input::site('admin/tkitem/index/'); ?>">所有商品 <i>（<?php echo $total; ?>）</i>
                                    </a><b></b>
                                </li>
                                <li <?php if($tab_class == '100'){
                                              echo 'class="curr"';
                                          } ?>
                                        >
                                    <a href="<?php echo input::site('admin/tkitem/index/100'); ?>">在售商品 <i>（<?php echo $run;?>）</i>
                                    </a><b></b>
                                </li>
                                <li <?php if($tab_class == '101'){
                                              echo 'class="curr"';
                                          } ?>>
                                    <a href="<?php echo input::site('admin/tkitem/index/101'); ?>">下架商品<i>（<?php  echo $over;?>）</i>
                                    </a>
                                    <b></b>
                                </li>
                            </ul>
                        </div>
                        <!-- 所有订单 -->
                        <div style="display: block" class="box_zlm">
                            <div class="edit_cen order_box " style="overflow-y: auto; height: 700px">
                                <table class="thead">
                                    <tbody>
                                        <tr>
                                            <th width="2%"></th>
                                            <th width="8%">图片<i></i></th>
                                            <th>名称<i></i></th>
                                            <th width="19%">有效期<i></i></th>
                                            <th width="7%">价格<i></i></th>
                                            <th width="6%">库存<i></i></th>
                                            <th width="6%">销量<i></i></th>
                                            <th width="6%">状态<i></i></th>
                                            <th width="10%">操作</th>
                                        </tr>

                                        <?php
                                        foreach($list as$key=> $ors) {
                                        ?>
                                        <tr>
                                            <td>
                                               <input type="checkbox" style="margin-right: -10px;" value="<?php echo $ors->id;?>" />          
                                            </td>
                                            <td class="tbody_img">
                                                <img width="58" height="59" src="<?php echo input::site($ors->img); ?>">
                                            </td>
                                            <td>
                                                <span><?php echo $ors->title; ?></span>
                                            </td>
                                            <td>
                                                <?php
                                            if($ors->timetype == 0){
                                                echo $ors->validtime." 天有效期";
                                            }else{                
                                                echo "开始:".date('Y-m-d H:i:s',$ors->starttime)."<br>结束:".date('Y-m-d H:i:s',$ors->endtime);                
                                            }
                                                ?>
                                            </td>
                                            <td>
                                                <span><?php echo $ors->price; ?></span>
                                            </td>
                                            <td>
                                                <span><?php echo $ors->stock; ?></span>
                                            </td>
                                            <td>
                                                <span><?php echo $ors->sell_num; ?></span>
                                            </td>
                                            <td>
                                                <span onclick="change(this,<?php echo $ors->id; ?>)" style="cursor:pointer;">
                                                    <?php 
                                            if($ors->status == 1){
                                                echo "上架";
                                            }else{
                                                echo "下架";
                                            }; ?>
                                                </span>
                                            </td>
                                            <td class="revise" style="text-align: center;">
                                                <!--不同订单状态会有不同的功能按钮-->
                                                <h1 class="h1_one">
                                                    <a href="<?php echo input::site('admin/tkitem/detail?id='.$ors->id); ?>">查看详情</a>
                                                    <div class="revise_pop" style="display: none">
                                                        <a href="<?php echo input::site('admin/tkitem/add?id='.$ors->id); ?>">修改商品</a>
                                                        <a href="javascript:del_item('<?php echo $ors->id;?>')">删除商品</a>
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
<style type="text/css">
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

    .bor_box .cf .input3 {
        width: 60px;
    }

    .thead td {
        text-align: center;
        color: #000 !important;
    }

    td {
        border: 0px !important;
    }

    #up_box35 .xq_cen dd {
        width: 300px;
    }
</style>

<!--添加备注窗口-->
<div class="up_box" style="display: none; width: 475px;" id="up_box35">
    <h1>查看详情<i class="close"></i></h1>
    <div class="order_xq">
        <h3>订单信息</h3>
        <div class="xq_cen">
            <dl class="cf">
                <dt>标题：</dt>
                <dd id="title"></dd>
            </dl>
            <dl class="cf">
                <dt>内容：</dt>
                <dd id="content"></dd>
            </dl>
            <dl class="cf">
                <dt>价格：</dt>
                <dd id="price"></dd>
            </dl>
            <dl class="cf">
                <dt>状态：</dt>
                <dd id="status"></dd>
            </dl>
            <dl class="cf">
                <dt>分类：</dt>
                <dd id="category"></dd>
            </dl>
            <dl class="cf">
                <dt>活动时间：</dt>
                <dd id="time"></dd>
            </dl>
            <dl class="cf">
                <dt>有效期：</dt>
                <dd id="validtime"></dd>
            </dl>
        </div>
    </div>
    <div class="btn_two btn_width cf">
        <a class="close" href="###">取消</a>
    </div>
</div>


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
    // 详情信息
    function show_detail(id) {
        var str = '';
        $.post('<?php echo input::site('admin/tkitem/show_detail'); ?>', { 'id': id }, function (data) {
        var data = eval("(" + data + ")");
        var info = data.info;
        if (data.success == 1) {
            if (info.status == 1) {
                var str = "进行中";
            } else {
                var str = "结束";
            }
            $("#title").html(info.title);
            $("#content").html(info.content);
            $("#price").html(info.price);
            $("#status").html(str);
            $("#category").html(info.name);
            $("#time").html(info.starttime + '~' + info.endtime);
            $("#validtime").html(info.validtime + '小时');
        }

    })
    open_box('#up_box35');
}
// 删除活动
function del_item(id) {
    if (confirm("确定删除!")) {
        $.post('<?php echo input::site("admin/tkitem/del_item"); ?>',
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
// 更改状态
function change(str, id) {
    var stu = $(str).html().trim();;
    var status = 0;
    if (stu == '下架') {
        status = 1;
        stu = '上架';
    } else {
        status = 0;
        stu = '下架';
    }
    $.post('<?php echo input::site("admin/tkitem/change_status")?>',
        { 'id': id, 'status': status },
        function (data) {
            var data = eval("(" + data + ")");
            if (data.success == 1) {
                $(str).html(stu);
            } else {
                alert(data.msg);
            }
        })
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

// 批量删除商品
function del_more() {
    var id = get_checked();
    if (confirm("确定要批量删除选中商品!")) {
            $.post("<?php echo input::site('admin/tkitem/del_more');?>", { 'id': id }, function (data) {
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
