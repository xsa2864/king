<style type='text/css'>
body,td {font-size:13px;}
</style>
<?php
    $prints     = '';
	$now        = date("Y-m-d H:i:s", time());
    foreach ($data as $value){
	   $totlat         = $value->shipping_total - $value->discount;
	   $add_time       = date("Y-m-d H:i", $value->add_time);
	   $pay_time       = date("Y-m-d H:i", $value->pay_time);
	   $shipping_time  = date("Y-m-d H:i", $value->shipping_time);
	   $goods_tot      = 0;
	   $goods_info    = "";
	   foreach ($value->goods as $val){
		   $good_tot   = $val->goods_price * $val->goods_count;
		   $goods_tot  += $good_tot;
		   $totlat     += $good_tot;
           $goods_info .= "<tr>
				   <td> $val->goods_name </td>
			<td> $val->goods_sn </td>
			<td> - </td>
			<td align='center'>￥ $val->goods_price 元 </td>
			<td align='center'> $val->goods_count</td>
			<td align='right'>￥ $good_tot 元 </td>
				</tr>
			  <tr>";
	   }
       $prints .= "<h1 align='center'>订单信息</h1>
			<table width='95%' align='center' cellpadding='1'>
				<tr>
					<td width='10%'>购 货 人：</td>
					<td>$value->consignee</td>
					<td align='right'>下单时间：</td>
					<td>$add_time</td>
					<td align='right'>支付方式：</td>
					<td>$value->pay_way</td>
					<td align='right'>订单编号：</td>
					<td>$value->order_sn</td>
				</tr>
				<tr>
				   <td>付款时间：</td>
			<td>$pay_time</td>
			<td align='right'>发货时间：</td>
			<td>$shipping_time</td>
			<td align='right'>配送方式：</td>
			<td>$value->expressName</td>
			<td align='right'>发货单号：</td>
			<td>$value->shipping_id </td>
				</tr>
				<tr>
				  <td>收货地址：</td>
			<td colspan='7'> $value->consignee_book  收货人：$value->consignee   手机：$value->consignee_tel </td>
				</tr>
				<tr>
				   <td>留言信息: </td>
			       <td colspan='7'> $value->user_note </td>
				</tr>
			</table>
			<table width='95%' align='center' border='1' style='border-collapse:collapse;border-color:#000;'>
				<tr align='center'>
				  <th width='40%' bgcolor='#cccccc'>商品名称 </th>
			      <th width='20' bgcolor='#cccccc'>货号 </th>
			     <th width='5%' bgcolor='#cccccc'>属性 </th>
			<th width='15%' bgcolor='#cccccc'>价格 </th>
			<th width='5%' bgcolor='#cccccc'>数量</th>
			<th width='15%' bgcolor='#cccccc'>小计 </th>
				</tr>

				$goods_info

				<tr>
				  
			<td align='right' colspan='6'>商品总金额：￥ $goods_tot 元</td>
				</tr>
			</table>
			<table width='95%' align='center' border='0'>
				<tbody><tr align='right'>
					<td width='75%'>&nbsp;</td>
					<td> + 配送费用：</td>
					<td>                        <!-- 配送费用 -->
				   ￥ $value->shipping_total 元         
				   </td>
				</tr>
				<tr align='right'>
				<td>&nbsp;</td>
					<td>
					- 优惠金额：
					</td>

					<td>
					<!-- 如果已付了部分款项, 减去已付款金额 -->
					
					<!-- 如果使用了余额支付, 减去已使用的余额 -->
					￥ $value->discount 元
				  
					 </td>
				</tr>
					<tr align='right'>
					<td>&nbsp;</td>
					<td>实付金额：</td>
					<td>
					<!-- 如果已付了部分款项, 减去已付款金额 -->
					
					<!-- 如果使用了余额支付, 减去已使用的余额 -->
					￥ $totlat 元
				  
					 </td>
				</tr>
			</tbody></table>
			<table width='95%' align='center' border='0'>
						
				<tbody><tr><!-- 网店名称, 网店地址, 网店URL以及联系电话 -->
					<td>
					
					 </td>
				</tr>
				<tr align='right'><!-- 订单操作员以及订单打印的日期 -->
					<td>打印时间：$now &nbsp;&nbsp;&nbsp;操作者：$_SESSION[userName] </td>
				</tr>
			</tbody></table>
			<div style='PAGE-BREAK-AFTER:always'></div>";
    }
	echo $prints;
?>

