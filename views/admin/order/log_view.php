<script src="<?php echo input::jsUrl('date/date.js'); ?>" type="text/javascript"></script>
<link href="<?php echo input::cssUrl('date.css'); ?>" rel="stylesheet" type="text/css" />

<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            
                <div class="back_right">
                    <div class="right">
                        <h1>删除日志管理</h1>
                        <div class=" bor_box stock_box padd0 cf">
                        <form name="orderForm" id="orderForm" method="get" action="?">
                            <dl class="cf">
                                <dd>
                                <div>订单编号:
                                    <input type="text" name="order_sn" value="<?php echo $order_sn; ?>" placeholder="输入订单号" class="input9">
                                </div>                                
                                </dd>
                                <dd class="inp5"><span>
                                    <input type="text" name="startTime" value="<?php echo $startTime; ?>" placeholder="订单日期" class="puiDate date_input"></span>&nbsp;&nbsp;到&nbsp;</dd>
                                <dd class="inp5"><span>
                                    <input type="text" name="endTime" value="<?php echo $endTime; ?>" placeholder="订单日期" class="puiDate date_input"></span></dd>                                
                                <dd class="query_box"><a href="javascript:" onclick="$('#orderForm').submit();">查询</a></dd>
                            </dl>
                        </form>
                        </div>
                        <div class="edit_box sale_cen mar_right cf">                            
                            <!-- 所有订单 -->
                            <div style="display: block" class="box_zlm">
                                <div class="order_box ">
                                    <table class="thead">
                                        <tbody>
                                            <tr>
                                                <th>订单编号</th>
                                                <th>执行人员</th>
                                                <th>删除时间</th> 
                                                <th>备注</th>        
                                                <th>操作</th>
                                            </tr>

<?php
foreach($log as$key=> $ors) {
?>
    <tr style="text-align:center;">
        <td>
            <span><?php echo $ors->order_sn ?></span>
        </td>
        <td >            
            <span><?php echo $ors->username ?></span>
        </td>
        <td>
            <?php echo date('Y-m-d H:i:s',$ors->addtime); ?>
        </td>
        <td>
            <?php echo $ors->note; ?>
        </td>
        <td style="text-align: center;">        
            <!--不同订单状态会有不同的功能按钮-->
            <a href="javaacript:;">查看详情</a>             
            <?php 
            if($ors->status == 0){
                echo "<button onclick=recover($ors->id)>恢复</button>";
            }else{
                echo "<button>已恢复</button>";
            }?>            
        </td>
    </tr>
<?php
}
?>
    </tbody>
</table>

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
    </div>
</div>



<!--遮罩层-->
<div class="mask_box" style="display: none"></div>

<!--发货窗口-->
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
// 恢复操作
function recover(id){
    if(confirm("确认恢复?")){
        $.post('<?php echo input::site('admin/order/recover'); ?>',
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
</script>
