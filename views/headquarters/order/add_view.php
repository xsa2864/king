<?php
$url        = input::site("admin/order/update/".$data['row']->order_id);
$goods_info = "";
if (is_array($data['goods'])){
    foreach($data['goods'] as $val){
        $goods_info .= "<tr>
				   <td> $val->goods_name </td>
			<td> $val->goods_sn </td>
			<td> - </td>
			<td align='center'>￥ $val->goods_price 元 </td>
			<td align='center'> $val->goods_count</td>
				</tr>
			  <tr>";
    }
}
?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <h1></h1><legend>订单详情</legend>
            <div class="col-sm-9">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                    </div>
                    <div class="panel-body">
                        <form method="post" action="<?php echo $url; ?>" class="form-inline">
                            <table class="table table-hover">
                                <tr class="hidden">
                                    <th width="15%"></th>
                                    <th width="30%"></th>
                                    <th width="15%"></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td align="right">订单号:</td>
                                    <td align="left"><?php echo $data['row']->order_sn; ?></td>
                                    <td align="right">订单状态:</td>
                                    <td align="left"><?php echo $data['row']->order_status; ?></td>
                                </tr>
                                <tr>
                                    <td align="right">购货人:</td>
                                    <td align="left"><?php echo $data['row']->consignee; ?></td>
                                    <td align="right">下单时间:</td>
                                    <td align="left"><?php echo $data['row']->add_time; ?></td>
                                </tr>
                                <tr>
                                    <td align="right">支付方式:</td>
                                    <td align="left"><?php echo $data['row']->pay_way; ?></td>
                                    <td align="right">付款时间:</td>
                                    <td align="left"><?php echo date("Y-m-d H:i:s", $data['row']->pay_time); ?></td>
                                </tr>
                                <tr>
                                    <td align="right">配送方式:</td>
                                    <td align="left"><?php echo $data["shipping"]; ?></td>
                                    <td align="right">发货时间:</td>
                                    <td align="left"><?php echo date("Y-m-d H:i:s", $data['row']->shipping_time); ?></td>
                                </tr>
                                <tr>
                                    <td align="right">发货单号:</td>
                                    <td align="left">
                                        <input type="text" value="<?php echo $data['row']->shipping_id; ?>" name="shipping_id"/></td>
                                    <td align="right">配送费用:</td>
                                    <td align="left">
                                        <input <?php echo $data['row']->order_status=="未支付"?"":"disabled=\"disabled\"" ?> type="text" value="<?php echo $data['row']->shipping_total; ?>" name="shipping_total"/></td>
                                </tr>
                                <tr>
                                    <td align="right">当前可执行操作:</td>
                                    <td>
                                        <?php echo $data['button']; ?>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <div class="col-sm-12">
                                            <table width='100%' class="table table-hover">
                                                <tr>
                                                    <th width="50%">商品名称</th>
                                                    <th width="10%">货号</th>
                                                    <th width="10%">属性</th>
                                                    <th width="20%">单价</th>
                                                    <th width="10%">数量</th>
                                                </tr>
                                                <?php echo $goods_info; ?>
                                                <tr>
                                                    <td colspan='4'></td>
                                                    <td align='right' colspan='2'>商品总金额：￥ <?php echo $data['row']->goods_total; ?> 元</td>
                                                </tr>
                                            </table>
                                            <table width='100%' border='0'>
                                                <tbody>
                                                    <tr align='right'>
                                                        <td width='75%'>&nbsp;</td>
                                                        <td>+ 配送费用：</td>
                                                        <td>
                                                            <!-- 配送费用 -->
                                                            ￥ <?php echo $data['row']->shipping_total; ?> 元         
                                                        </td>
                                                    </tr>
                                                    <tr align='right'>
                                                        <td>&nbsp;</td>
                                                        <td>- 优惠金额：
                                                        </td>

                                                        <td>
                                                            <!-- 如果已付了部分款项, 减去已付款金额 -->

                                                            <!-- 如果使用了余额支付, 减去已使用的余额 -->
                                                            ￥ <?php echo $data['row']->discount; ?> 元
				  
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <td>
                                </tr>
                            </table>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
