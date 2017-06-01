<script src="<?php echo input::jsUrl('date/date.js'); ?>" type="text/javascript"></script>
<link href="<?php echo input::cssUrl('date.css'); ?>" rel="stylesheet" type="text/css" />
<div class="back_right">
    <div class="right">
        <h1 class="margin_bottom">提现日志列表</h1>
        <div class=" bor_box return_box cf">
            <form id="jifenlogForm" method="get">
            <dl class="cf">
                <dd>
                    <input class="input158" name="order_sn" id="order_sn" type="text" placeholder="订单号" value="<?php echo $order_sn;?>" />
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
                            <th>会员名称<i></i></th>
                            <th>订单号<i></i></th>
                            <th>提现金额<i></i></th>
                            <th>生成时间<i></i></th>
                        </tr>
                        <?php
                        if(!empty($List)){
                            foreach($List as $item){
                         ?>
                        <tr>
                            <td><?php echo $item->name;?></td>
                            <td><?php echo $item->order_sn;?></td>
                            <td><?php echo $item->price;?></td>
                            <td><?php echo date('Y-m-d H:i:s',$item->addtime);?></td>                            
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