<script type="text/javascript" src="<?php echo input::jsUrl('webuploader.js');?>"></script>
<link type="text/css" href="<?php echo input::cssUrl('webuploader.css');?>" rel="stylesheet" />

<div class="back_right right_width">
    <div class="right">
        <h1>查看订单详情</h1>
        <div class="cen_box">
            <div class="back_title bold">基本信息</div>
            <div class="bor_box">
                <dl class="cf">
                    <b>订单编号：</b>
                    <span><?php echo empty($orderInfo->order_sn)?'':$orderInfo->order_sn;?></span>
                </dl>
                <dl class="cf">
                    <dt>1 创建订单：</dt>
                    <dd>
                        <span><?php echo empty($orderInfo->addtime)?'':date('Y-m-d H:i:s',$orderInfo->addtime);?></span>
                    </dd>
                </dl>
               <dl class="cf">
                    <dt>2 买家付款：</dt>
                    <dd>
                        <span><?php echo empty($orderInfo->paytime)?'':date('Y-m-d H:i:s',$orderInfo->paytime);?></span>
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>3 卖家发货：</dt>
                    <dd>
                        <span><?php echo empty($orderInfo->send_time)?'':date('Y-m-d H:i:s',$orderInfo->send_time);?></span>
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>4 交易完成：</dt>
                    <dd>
                        <span><?php echo empty($orderInfo->overtime)?'':date('Y-m-d H:i:s',$orderInfo->overtime);?></span>
                    </dd>
                </dl>           
            </div>
        </div>
        <div class="cen_box mar_15">            
            <div class="back_title bold">设置分类</div>   
            <div class="bor_box">
                <dl class="cf">
                    <dt>订单状态：</dt>
                    <dd style="color:red;"><?php echo empty($orderStatus)?'':$orderStatus;?></dd>
                </dl>
                <dl class="cf">
                    <dt>付款方式：</dt>
                    <dd>
                        <?php echo $orderInfo->payWay;?>
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>余额抵扣：</dt>
                    <dd>
                        <?php echo $orderInfo->order_sn;?>
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>配送方式：</dt>
                    <dd>
                        <?php echo $orderInfo->order_sn;?>
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>收货信息：</dt>
                    <dd>
                        <?php 
                        $infos = $orderInfo->address." &nbsp;".$orderInfo->consignee." &nbsp;".$orderInfo->mobile;
                        echo $infos;?>
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>会员信息：</dt>
                    <dd>
                        <?php echo $member_info->realName." ID:".$member_info->id." ".$member_info->mobile;?>
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>备注：</dt>
                    <dd>
                        <?php echo $orderInfo->note;?>
                    </dd>
                </dl>
            </div>
        </div>    
        <div class="cen_box mar_15">            
            <div class="back_title bold">佣金信息</div>
            <div class="bor_box"> 
            <?php 
            foreach ($log_info as $key => $value) {
            ?>
                <div>
                    <label><?php echo $value->resource_real_name;?>的上<?php echo $key+1;?>级会员</label>
                    <b><?php echo $value->real_name;?> </b>
                </div>         
            <?php    
            }  
            ?>                
            </div>
        </div>
        <div class="cen_box mar_15">            
            <div class="back_title bold">订单商品</div>
            <div>    
                <table>
                    <tr>
                        <th>商品</th>
                        <th>商品编号</th>
                        <th>价格(元)</th>
                        <th>数量</th>                        
                        <th>小计</th>                               
                    </tr>
                    <?php                    
                    if(!empty($arrList)){
                        foreach ($arrList as $key => $value) {
                    ?>
                    <tr style="text-align:center;">
                        <td>
                            <div>                                
                            <img src="<?php echo input::site($value->pic);?>">
                            <?php echo $value->name;?>
                            </div>
                        </td>
                        <td></td>
                        <td><?php echo $value->price;?></td>
                        <td><?php echo $value->num;?></td>
                        <td><?php echo $value->price*$value->num;?></td>
                    </tr>
                    <?php
                        }
                    }
                    ?>    
                    <tr>
                        <td colspan="5" style="text-align:right;">
                            <div>总共:<?php echo $orderInfo->number;?>   合计：<?php echo ($orderInfo->amount-$orderInfo->postage);?></div>
                            <div>运费：<?php echo $orderInfo->postage;?></div>
                            <div>实际支付：<?php echo $orderInfo->amount;?></div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="cen_box mar_15">            
            <div class="back_title bold">物流信息</div>
            <div class="bor_box" style="font-size: 20px;">   
                <div style="padding-bottom: 10px;">
                    <label>快递公司：</label><b><?php echo $orderInfo->name;?> </b>
                </div>         
                <div>
                    <label>快递单号：</label><?php echo $orderInfo->code;?>
                </div> 
            </div>
        </div>
    </div>   
</div>


<script type="text/javascript">


  
</script>