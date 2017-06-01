<!-- 滚动图片插件 -->
<link href="<?php echo input::jsUrl('touchslideimg/touchslideimg.css','mobile')?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo input::jsUrl('touchslideimg/touchslideimg.js','mobile')?>"></script>


<div class="banner_box">
    <ul class="banner_img cf">
        <?php
        $pics = unserialize($good->pics);
        foreach($pics as $pic=>$value)
        {
        ?>
        <li><a href="<?php echo input::site('mobile/goods/goodPic/'.$goodId);?>">
            <img src="<?php echo input::site($pic);?>" /></a></li>
        <?php
        }
        ?>
    </ul>
    <div class="iosn_box">
        <a class="back" href="JavaScript:history.back();"></a><a class="car" href="<?php echo input::site('mobile/order/show_cart');?>"></a>
    </div>
</div>
<div class="commodity_box">
    <p class="commodity_title"><?php echo $good->title;?></p>
    <dl class="commodity_h2 tb">
        <dt id="mainprice"><font>￥</font><?php echo $goodAttr[0]->attr_price;?></dt>
        <dd class="flex_1">
            <span id="maingolds"><i></i><?php echo $goodAttr[0]->attr_golds;?></span>
            <span id="mainjifen"><i></i><?php echo $goodAttr[0]->attr_jifen;?></span>
        </dd>
    </dl>
    <dl class="commodity_h3 tb">
        <dd class="flex_1"></dd>
        <dt class="flex_1"></dt>
        <dd class="flex_1">月销<?php echo $good->sales;?>笔</dd>
    </dl>
    <dl class="commodity_h4 tb">
        <dd class="flex_1">担保交易</dd>
        <dd class="flex_1">7天退换</dd>
        <dd class="flex_1">企业认证</dd>
    </dl>
</div>
<div class="commodity_box2 mar8">
    <h1 id="classify"><a href="###">选择颜色分类、尺码<i></i></a></h1>
    <div class="edit_text">
        <?php echo $good->content;?>
        <!--<img src="images/shop_18.png" width="100%" height="100%" />
        <img src="images/shop_20.png" width="100%" height="100%" />-->
    </div>
</div>
<div class="commodity_foot">
    <!-- 添加class=commodity_fiex强制浮在顶层 -->
    <dl class="tb commodity_footer">
        <dt>
            <p class="tb">
                <a class="flex_1 on" href="<?php echo input::site();?>"><i></i>首页</a><a class="flex_1" href="#"><i></i>收藏</a>
            </p>
        </dt>
        <dd class="flex_1">
            <p class="tb">
                <a class="flex_1" href="#">加入购物车</a><a class="flex_1" href="#">立即下单</a>
            </p>
        </dd>
    </dl>
</div>

