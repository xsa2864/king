<div class="container">
    <div class="index_img">
        <p>
            <img src="<?php echo input::site("library/mobile/images/index_02.png"); ?>" />
        </p>
        <div class="index_text">
            <i></i>您的朋友[独孤求败]完成订单，您获得佣金<font> ¥2365.22</font>。
        </div>
    </div>
    <div class="comment">
        
    </div>
</div>
<script>
    $(function () {
        $.post('<?php echo input::site('mobile/goods/getGoods');?>', function (data) {
            console.log(data);
            $('.comment').html(data);
        });
    });
</script>