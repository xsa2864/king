<footer class="footer">
    <ul class="tb">
        <li class="flex_1">
            <a href="<?php echo input::site();?>" <?php echo $currentCount=='1'?'class="on" ':'';?>><em></em><i>首页</i></a>
        </li>
        <li class="flex_1">
            <a href="<?php echo input::site('mobile/order/show_cart');?>" <?php echo $currentCount=='2'?'class="on" ':'';?>><em></em><i>购物车</i></a>
        </li>
        <li class="flex_1">
            <a href="#" <?php echo $currentCount=='3'?'class="on" ':'';?>><em></em><i>订单</i></a>
        </li>
        <li class="flex_1">
            <a href="<?php echo input::site('mobile/member/member_center');?>" <?php echo $currentCount=='4'?'class="on" ':'';?>><em></em><i>我的</i></a>
        </li>
    </ul>
</footer>
