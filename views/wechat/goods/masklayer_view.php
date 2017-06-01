<!--遮罩层--->
<div class="mask_box" style="display: none"></div>
<!--弹出框--->
<div class="up up_box2" id="up_box2" style="display: none">
    <div class="close"></div>
    <div class="up_cen">
        <div class="shop_h1">
            <span class="img">
                <img id="attrpic" src="<?php echo input::site($goodAttr[0]->attr_pic);?>" /></span>
            <div class="shop_text">
                <p id="attrprice"><font>￥</font><?php echo $goodAttr[0]->attr_price;?></p>
                <p>
                    <span id="attrgolds"><i></i><?php echo $goodAttr[0]->attr_golds;?></span>
                    <span id="attrjifen"><i></i><?php echo $goodAttr[0]->attr_jifen;?></span>
                </p>
                <p class="Stock" id="attrstock">库存<?php echo $goodAttr[0]->attr_stock;?>件</p>
            </div>
        </div>
        <div class="shop_h2">
            <dl class="colour">
                <dt>颜色分类</dt>
                <dd>
                    <?php
                    foreach($goodAttr as $item)
                    {
                    ?>
                    <a imgsrc="<?php echo input::site($item->attr_pic);?>" price="<?php echo $item->attr_price;?>" golds="<?php echo $item->attr_golds;?>" jifen="<?php echo $item->attr_jifen;?>" stock="<?php echo $item->attr_stock;?>"><?php echo $item->attr_name;?></a>
                    <?php
                    }
                    ?>
                </dd>
            </dl>
        </div>
        <!-- <div class="shop_h3">
            <dl class="tb">
                <dt class="flex_1">购买数量</dt>
                <dd class="edit_num ">
                    <p class="tb">
                        <span class="flex_1" touchevent="on">-</span>
                        <input type="text" value="100" />
                        <span class="flex_1" touchevent="on">+</span>
                    </p>
                </dd>
            </dl>
        </div>-->
        <div class="determine"><a href="#">确定</a></div>
    </div>

</div>
<script>
    $(function () {
        // 选择
        $('#classify a').on('touchstart', function () {
            $('.commodity_foot').addClass('commodity_fiex'); // 加入购物车行显示在顶层
            $('.mask_box').fadeIn('fast', function () {
                $('#up_box2').slideDown();
            });
            $('html,body').css({ overflow: 'hidden' });
        });

        // 取消选择
        $('#up_box2 .close').on('touchstart', function () {
            $('#up_box2').slideUp(function () {
                $('.mask_box').fadeOut('fast');
            });
            $('html,body').css({ overflow: 'auto' });
        });

        // 选择颜色分类
        $('#up_box2 .shop_h2 dd a').on('touchstart', function () {
            $(this).toggleClass('on').closest('dd').find('a').not(this).removeClass('on');
            $('#attrpic').attr('src', $(this).attr('imgsrc'));
            $('#attrprice').html('<font>￥</font>' + $(this).attr('price'));
            $('#attrgolds').html('<i></i>' + $(this).attr('golds'));
            $('#attrjifen').html('<i></i>' + $(this).attr('jifen'));
            $('#attrstock').html('库存' + $(this).attr('stock') + '件');
            $('#mainprice').html('<font>￥</font>' + $(this).attr('price'));
            $('#maingolds').html('<i></i>' + $(this).attr('golds'));
            $('#mainjifen').html('<i></i>' + $(this).attr('jifen'));
            return false;
        });

        // 数字
        $('.edit_num span').on('touchstart', function () {
            var value = parseInt($('.edit_num input').val());
            $(this).text() == '1' ? value-- : value++;
            $('.edit_num input').val(value).blur();
        });

        // 轮播图
        $('.banner_img').touchslideimg();

        // 收藏
        $('.commodity_foot dt a:eq(1)').on('touchstart', function () {
            if ($(this).hasClass('on')) { // 取消收藏
                $(this).removeClass('on');
                $.bottomTips('取消收藏成功！');
            } else { // 收藏
                $(this).addClass('on');
                $.bottomTips('添加收藏成功！');
            }
        });

        // 加入购物车
        $('.commodity_foot dd a:eq(0)').on('touchstart', function () {
            $.centerTips('添加成功~');
        });
    });

</script>

