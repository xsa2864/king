<script src="<?php echo input::jsUrl('date/date.js'); ?>" type="text/javascript"></script>
<link href="<?php echo input::cssUrl('date.css'); ?>" rel="stylesheet" type="text/css" />
<div class="back_right">
    <div class="right">
        <h1 class="margin_bottom">退款日志列表</h1>
        <div class=" bor_box return_box cf">
            <form id="jifenlogForm" method="get">
            <dl class="cf">
                <dd>
                <input class="input158" name="order_sn" id="order_sn" type="text" placeholder="退款订单号" value="<?php echo $order_sn;?>" />
                </dd>
                
                <dd class="query_box"><a href="javascript:" onclick="document.getElementById('jifenlogForm').submit();">查询</a></dd>
            </dl>
            </form>
        </div>
        <div class="edit_box width95 pad15 cf">
            <div class="order_box2 " style="display: block">
                <div class=" member_cen">
                    <table class="thead tbody_cen">
                        <tr>
                            <th>序号<i></i></th>
                            <th>会员ID<i></i></th>
                            <th>头像<i></i></th>
                            <th>会员名称<i></i></th>
                            <th>退款订单号<i></i></th>
                            <th>商品价格<i></i></th>
                            <th>退款价格<i></i></th>
                            <th>状态<i></i></th>
                            <th>申请退款时间<i></i></th>
                            <th>完成时间<i></i></th>        
                            <th>操作<i></i></th>
                        </tr>
                        <?php
                        if(!empty($List)){
                            foreach($List as $key => $item){
                         ?>
                        <tr>
                            <td><?php echo $key+1;?></td>
                            <td><?php echo $item->member_id;?></td>
                            <td><img src="<?php echo $item->head_img;?>" width=40><i></i></td>
                            <td><?php echo json_decode($item->nickname);?></td>
                            <td><?php echo $item->code;?></td>
                            <td><?php echo $item->price;?></td>
                            <td><?php echo $item->re_price;?></td>
                            <td><?php
                                if($item->type_status == 1){
                                    echo "申请退款";
                                }else{
                                    echo "退款完成";
                                }
                                ?>
                            </td>
                            <td><?php echo $item->returntime>0?date('Y-m-d H:i:s',$item->returntime):'';?></td>
                            <td>
                                <?php
                                if($item->type_status > 1){
                                    echo $item->addtime>0?date('Y-m-d H:i:s',$item->addtime):'';
                                }
                                ?>    
                            <td>
                                <a href="javascript:show_details(<?php echo $item->code.','.$item->type_status;?>)">查看详情</a>
                                <a style="display:none;" href="javascript:show_detail(<?php echo $item->code.','.$item->type_status;?>)">退款情况</a>
                            </td>
                        </tr>
                        <?php
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>
            <div class=" cf bottom_page">
                <div class="bottom_btn cf">
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

<!-- 查看退款接口信息 -->
<div class="up_box fz_box " style="display: none; width: 365px;" id="show_detail">
    <h1>退款款接口信息<i class="close"></i></h1>
    <div class="export weix">
        <div id="content" style="margin-left: 20px;line-height: 22px;"></div>    
    </div>
    <div class="btn_two btn_width cf">
        <a class="close" style="cursor: pointer;">取消</a>
    </div>
</div>

<!-- 查看退款详情 -->
<div class="up_box fz_box " style="display: none; width: 365px;" id="show_details">
    <h1>退款详情<i class="close"></i></h1>
    <div class="export weix">
        <div id="contents" style="margin-left: 20px;line-height: 22px;"></div>    
    </div>
    <div class="btn_two btn_width cf">
        <a class="close" style="cursor: pointer;">取消</a>
    </div>
</div>

<script type="text/javascript">
// 退款订单详情
function show_details(code,type_status){
    var type = type_status==1?1:0;
    $.post('<?php echo input::site("admin/finance/get_more_info")?>',{'code':code,'type':type},
        function(data){
            $("#contents").html(data);
    })
    open_box('#show_details');
}
// 退款情况
function show_detail(code,type_status){
    var type = type_status==1?1:0;
    $.post('<?php echo input::site("admin/finance/get_detail")?>',{'code':code,'type':type},
        function(data){
            $("#content").html(data);
    })
    open_box('#show_detail');
}
</script>