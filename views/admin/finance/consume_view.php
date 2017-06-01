<script src="<?php echo input::jsUrl('date/date.js'); ?>" type="text/javascript"></script>
<link href="<?php echo input::cssUrl('date.css'); ?>" rel="stylesheet" type="text/css" />
<div class="back_right">
    <div class="right">
        <h1 class="margin_bottom">消费日志列表</h1>
        <div class=" bor_box return_box cf">
            <form id="jifenlogForm" method="get">
            <dl class="cf">
                <dd>
                <input class="input158" name="order_sn" id="order_sn" type="text" placeholder="订单号" value="<?php echo $order_sn;?>" />
                <input class="input158" name="tkb_name" id="tkb_name" type="text" placeholder="店名" value="<?php echo $tkb_name;?>" />
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
                            <th>店铺ID<i></i></th>
                            <th>店名<i></i></th>
                            <th>订单号<i></i></th>
                            <th>订单金额<i></i></th>
                            <th>获得收益<i></i></th>
                            <th>备注<i></i></th>
                            <th>消费时间<i></i></th>        
                            <th>是否需要补发<i></i></th>
                            <!-- <th>操作<i></i></th> -->
                        </tr>
                        <?php
                        if(!empty($list)){
                            foreach($list as $key => $item){
                         ?>
                        <tr>
                            <td>
                                <input type="checkbox" value="<?php echo $item->id;?>" />
                                <?php echo $key+1;?>
                            </td>
                            <td><?php echo $item->tkb_id;?></td>
                            <td><?php echo $item->tkb_name;?></td>
                            <td><?php echo $item->order_sn;?></td>
                            <td><?php echo $item->price;?></td>
                            <td><?php echo $item->get_price;?></td>
                            <td>
                            <?php 
                            $str = $item->note;
                            if($item->status==0){
                                $num = ceil($delay - (time()-$item->addtime)/24/3600);
                                $str .= $num>0 ? "(".$num."天之后)":'';
                            }
                            echo $str;
                            ?>                                
                            </td>
                            <td>
                                <?php echo $item->addtime>0?date('Y-m-d H:i:s',$item->addtime):'';?>    
                            </td>
                            <td>
                            <?php 
                                if($item->status==0){
                                    echo "<a href=javascript:again('".$item->id."')>需要补发</a>";
                                }
                            ?>                                
                            </td>
                            
                        </tr>
                        <?php
                            }
                        }
                        ?>
                        <tr class="td3">
                            <td class="" colspan="9">
                                <span class="sp1">
                                    <input name="" type="checkbox" value="" class="check_all" id="check_all"/>
                                    <label for="check_all">全选</label>
                                </span>
                                <span class="sp2">
                                    <a href="javascript:all_again();">批量发佣金</a>
                                    <a href="javascript:del_more();" style="margin-left:20px;">批量删除</a>
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class=" cf bottom_page">
                <div class="page">
                    <?php
                    echo $pagination->render();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
.page_mun a{
    float: left;
}
.sp1{
    padding-left: 13px;
    float: left;
}
.sp2{
    margin-left: 24px;
    text-align: left !important;
    padding-left: 40px;
}
</style>
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
//全选
$('.check_all').click(function () {
    var checked = $(this).is(':checked');
    $('.tbody_cen input[type=checkbox]').prop('checked', (checked ? 'checked' : false));
});
// 批量发佣金
function all_again(){
    var str = '';
    $('.tbody_cen td>input[type=checkbox]:checked').each(function(n,e){
        if(str!=''){
            str += ',';
        }
        if($(e).val()){
            str += $(e).val();
        }
    })
    if(confirm("确定批量发红包") && str != ''){
        $.post('<?php echo input::site("admin/log/again_all_business");?>',{'str':str},function(data){
            if(data){
                location.reload();
            }
        })
    }
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
    if (confirm("确定要批量删除选中记录!")) {
            $.post("<?php echo input::site('admin/finance/del_more');?>", { 'id': id }, function (data) {
            var data = eval("(" + data + ")");
            if (data.success == 1) {
                window.location.reload();
            } else {
                alert(data.msg);
            }
        })
    }
}
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
function again(id){
    if(confirm("确定重新发送红包！")){
        $.post('<?php echo input::site("admin/log/again_money_business");?>',{'id':id},
            function(data){
                if(data==1){
                    location.reload();
                }else{
                    alert("重新发送失败！");
                }
            })
    }
    
}
</script>