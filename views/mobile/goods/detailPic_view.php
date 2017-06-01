<!-- 滚动图片插件 -->
<link href="<?php echo input::jsUrl('touchslideimg/touchslideimg.css','mobile')?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo input::jsUrl('touchslideimg/touchslideimg.js','mobile')?>"></script>


<div class="banner_box banner_full">
    <ul class="banner_img cf">
        <?php
        $pics = unserialize($good->pics);
        foreach($pics as $pic=>$value)
        {
        ?>
        <li><a>
            <img src="<?php echo input::site($pic);?>" /></a></li>
        <?php
        }
        ?>
    </ul>
</div>


<script>
    $(function () {

        // 轮播图
        $('.banner_img').touchslideimg();

    });

</script>
