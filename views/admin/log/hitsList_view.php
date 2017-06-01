<script src="<?php echo input::jsUrl('date/date.js'); ?>" type="text/javascript"></script>
<link href="<?php echo input::cssUrl('date.css'); ?>" rel="stylesheet" type="text/css" />
<div class="back_right">
    <div class="right">
        <h1 class="margin_bottom">流量统计</h1>
        <!-- <div class=" bor_box return_box cf">
            <form name="jifenlogForm" id="jifenlogForm" method="get">
            <dl class="cf">
                <dd>
                    <span><input class="input158" name="username" id="username" type="text" placeholder="用户名/手机号" /></span>
                </dd>                
                <dd class="inp5"><span>
                        <input style="width: 122px" type="text" name="startTime" id="startTime" class="puiDate" placeholder="起始时间" /></span>&nbsp;&nbsp;到&nbsp;</dd>
              
                <dd class="query_box"><a href="javascript:" onclick="document.getElementById('jifenlogForm').submit();">查询</a></dd>
            </dl>
            </form>
        </div> -->
        <div class="edit_box width95 pad15 cf">
            <div class="order_box2 " style="display: block">
                <div class=" member_cen">
                    <table class="thead tbody_cen">
                        <tr>
                            <th width="">店铺名<i></i></th>
                            <th width="">商城名<i></i></th>
                            <th width="">流量<i></i></th>
                            <th width="">访客数量<i></i></th>
                            <th width="">收藏数量<i></i></th>
                            <th width="">取消收藏数量<i></i></th>
                            <th width="">订单数量<i></i></th>
                            <th width="">订单金额<i></i></th>
                            <th width="">分享数量<i></i></th>
                            <th width="">加入购物车数量<i></i></th>
                            <th width="">时间<i></i></th>
                        </tr>
                        <?php
                        foreach($hitsList as $item)         
                        { ?>
                        <tr>
                            <td><?php echo $item->shop_name;?></td>
                            <td><?php echo $item->name;?></td>
                            <td><?php echo $item->pv;?></td>
                            <td><?php echo $item->uv;?></td>
                            <td><?php echo $item->fav;?></td>
                            <td><?php echo $item->delfav;?></td>
                            <td><?php echo $item->sales_num;?></td>
                            <td><?php echo $item->sales_money;?></td>
                            <td><?php echo $item->share;?></td>
                            <td><?php echo $item->cart_num;?></td>
                            <td><?php echo $item->pdate;?></td>
                        </tr>
                        <?php
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
<script type="text/javascript">

</script>