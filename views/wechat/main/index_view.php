
    <div class="toker">
        <div class="toker_h1">
            <i></i>
            <span><?php echo $higher;?></span>            
        </div>
        <div class="toker_h3">
            <?php
            if($listCount==0)
            {
            ?>
            <img itemId="0" class="max_img" src="<?php echo input::imgUrl("main_default.png",'wechat'); ?>" />
            <?php
            }
            foreach($goodsList as $item)
            {
            ?>
            <img itemId="<?php echo $item->id;?>" class="max_img"  <?php if($listCount>1) echo 'style="position:static"'?> src="<?php echo $item->index_img?input::site($item->index_img):input::imgUrl("default_image.png",'wechat'); ?>" />
            <?php
            }
            ?>
            <span class="min_img" <?php if($message==''){echo 'style="display:none;"';};?>">
                <?php echo $message;?>                
            </span>
       </div>
    
    </div>
    <footer class="footer foot_bottom">
        <ul class="tb">
            <li class="flex_1 on">
                <a href="javascript:;"><em></em><i>首页</i></a>
            </li>
            <li class="flex_1">
                <a href="<?php echo input::site('wechat/member/wallet')?>"><em></em><i>收入明细</i></a>
            </li>
            <li class="flex_1">
                <a href="<?php echo input::site('wechat/order/index')?>"><em></em><i>我的订单</i></a>
            </li>
            <li class="flex_1">
                <a href="<?php echo input::site('wechat/member/index')?>"><em></em><i>个人中心</i></a>
            </li>
        </ul>
    </footer>

<script>
    $('.toker_h3 img').click(function () {
        var id = $(this).attr('itemId');
        if (id>0) {
            location.href = '<?php echo input::site('wechat/goods/index/');?>' + id;
        }        
    });

    var i = setInterval(function () {
        $.post("<?php echo input::site('wechat/main/msgInfo');?>", function (data) {
            var da = eval("("+data+")");
            if(da.success == 1){
                $('.min_img').html(da.msg); 
                if(da.msg==''){
                    $(".min_img").hide();
                }else{
                    $(".min_img").show();
                }
            }else{
                $(".min_img").hide();
            }           
        });
    }, 3000);

    function goto() {
        location.href = '<?php echo input::site('wechat/member/index/');?>';
    }
</script>
