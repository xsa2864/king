<script src="<?php echo input::jsUrl('date/date.js'); ?>" type="text/javascript"></script>
<link href="<?php echo input::cssUrl('date.css'); ?>" rel="stylesheet" type="text/css" />
<div class="back_right">
    <div class="right">
        <h1 class="margin_bottom">商品浏览分享统计列表</h1>
        <div class=" bor_box return_box cf">
            <form name="jifenlogForm" id="jifenlogForm" method="get">
            <dl class="cf">
                <dd><span>
                        <input class="input158" name="name" id="name" type="text" placeholder="名称" value="<?php echo $name;?>" />
                    </span>
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
                            <th>商品id<i></i></th>
                            <th>商品名称<i></i></th>
                            <th>浏览量<i></i></th>
                            <th>分享量<i></i></th>
                        </tr>
                        <?php
                        foreach($List as $item)
                        { ?>
                        <tr>
                            <td><?php echo $item->item_id;?></td>
                            <td><?php echo $item->item_name;?></td>
                            <td><?php echo $item->see_num;?></td>
                            <td><?php echo $item->share_num;?></td>                            
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