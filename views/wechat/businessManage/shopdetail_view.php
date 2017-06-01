<link href="<?php echo input::jsUrl("linkage/linkage.css",'wechat'); ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo input::jsUrl("linkage/linkage.js",'wechat'); ?>"></script>

<header class="header buys pad0">
    <div class="favorites">
        <p style="width:100%;">
            <a class="return" href="JavaScript:history.back();"><i></i>返回</a>
            <a href="<?php echo input::site('wechat/businessManage/shop_edit');?>" style="float: right;font-size: 17px;margin-right: 12px;margin-top: 12px;"><i></i>编辑</a>
        </p>        
    </div>
    
</header>
<div class="container pad1">
    <div class="name_cen name2">
        <div class="name_box back2">
            <dl class="name_h1 tb">
                <dt>
                    <img src="<?php echo $bus->pic==''?input::imgUrl('default.png','wechat'):input::site($bus->pic);?>" /></dt>
                <dd class="flex_1">
                    <div class="text_input">
                        <div class="text_hidden"><span><?php echo $bus->name;?></span></div>
                    </div>
                </dd>
            </dl>
            <div class="bor_de"></div>
            <div class="name2_text" style="min-height:104px">
                <dl class="name_h2 tb ">
                    <dt>联系人：</dt>
                    <dd class="flex_1"><?php echo $bus->realname;?></dd>
                </dl>
                <dl class="name_h2 tb">
                    <dt>联系电话：</dt>
                    <dd class="flex_1"><?php echo $bus->mobile;?></dd>
                </dl>
                <dl class="name_h2 tb">
                    <dt>定位地址：</dt>
                    <dd class="flex_1"><?php echo $bus->address;?>
                    </dd>
                </dl>
                <dl class="name_h2 tb">
                    <dt>详细地址：</dt>
                    <dd class="flex_1"><?php echo $bus->full_address;?><p class="nav" onclick="location.href='<?php echo $gpsUrl;?>'"><span></span><em></em><font>导航</font></p>
                    </dd>
                </dl>
            </div>
        </div>
        <div class="name_box2 back2">
            <p class="f32">详情介绍</p>
            <div class="introduce" style="font-size: 15px;">
                <?php echo $bus->content;?>
            </div>
        </div>
    </div>
</div>


<script>
    $(function () {
        $('.text_input i').on('touchstart', function () {
            $(this).parents('.text_input').find('span').html('');
        });

        $('.linkage_el').linkage(); // 触发选择区域

        $('select[name=a]').on('change', function () {
            $('.linkage_el>a').html($('select[name=s] :selected').text() + $('select[name=c] :selected').text() + $('select[name=a] :selected').text() + '<i></i>');
        });

        // 切换城市示例 // AJAX切换option数据时执行$('select[name=s]').trigger('reset_linkage');
        $('select[name=s]').on('change', function () {
            $(this).closest('div').find('select[name=c]').empty().html('<option value="1">北京市</option><option value="2">上海市</option><option value="3">广州市</option><option value="4">深圳市</option><option value="5">珠海市</option>');
        });
    });

</script>
