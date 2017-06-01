<form>
    <div class="back_right">
        <div class="right">
            <h1>新增组员</h1>
            <div class=" bor_box width_bor pad0 new_mem cf">
                <dl class="cf">
                    <dd>消费额&nbsp;</dd>
                    <dd class="inp">
                        <input class="" type="text" placeholder="￥" /></dd>
                    <dd class="inp">&nbsp;到&nbsp;
                        <input class="" type="text" placeholder="￥" /></dd>
                    <dd class="select_box">
                        <select class="puiSelect" style="width: 120px">
                            <option value="">上次订单时间</option>
                            <option value="">上次订单时间</option>
                            <option value="">上次订单时间</option>
                        </select>
                    </dd>
                    <dd class="select_box">
                        <select class="puiSelect" style="width: 120px">
                            <option value="">等级</option>
                            <option value="">钻石会员</option>
                            <option value="">铂金会员</option>
                            <option value="">优先会员</option>
                        </select>
                    </dd>
                    <dd class="select_box">
                        <select class="puiSelect" style="width: 120px">
                            <option value="">省份</option>
                            <option value="">福州元洪店</option>
                            <option value="">泉州丰泽店</option>
                        </select>
                    </dd>
                    <dd class="select_box">
                        <select class="puiSelect" style="width: 120px">
                            <option value="">城市</option>
                            <option value="">福州元洪店</option>
                            <option value="">泉州丰泽店</option>
                        </select>
                    </dd>

                    <dd class="query_box"><a href="###">查询</a></dd>
                </dl>
            </div>
            <div class="edit_box hy_cen width97 mar0">
                <div class="bq_box">
                    <div class="b5"></div>
                    <div class="sort_table dispa_tab">
                        <table border="0">
                            <tr>
                                <th class="cen" width="5%">
                                    <input name="" type="checkbox" value="" class="check_all"></th>
                                <th class="align_left" width="15%" scope="col">用户名/手机号</th>
                                <th width="13%">会员等级</th>
                                <th width="15%">统计</th>
                                <th width="18%">上次订单时间</th>
                                <th width="18%">地区</th>
                                <th width="16%">操作</th>
                            </tr>
                            <?php
                            foreach($members as $item)
                            {
                                echo '<tr class="back">
                                <td>
                                    <input type="checkbox" /></td>
                                <td class="sort_shop cf align_left">
                                    <p>'.$item->realName.'</p>
                                    <p>'.$item->mobile.'</p>
                                </td>
                                <td>'.$item->levelname.'</td>
                                <td>
                                    <p>消费：'.$item->purchaseAmount.'元</p>
                                    <p>积分：'.$item->points.'</p>
                                </td>

                                <td>
                                    <p>'.substr($item->regTime,0,10).'</p>
                                    <p>'.substr($item->regTime,11,8).'</p>
                                </td>
                                <td>
                                    <p>'.$item->pname.'</p>
                                    <p>'.$item->cname.'</p>
                                </td>
                                <td class="add_mem">
                                    <a href="#">增加</a>
                                </td>
                            </tr>';
                            }
                            ?>

                            <tr class="td3">
                                <td class="" colspan="7">
                                    <span class="sp1 left_sp2">
                                        <input name="" type="checkbox" value="" class="check_all" /><label>全选</label></span>
                                    <span class="sp2"><a href="#">批量删除</a></span>
                                </td>
                            </tr>
                        </table>
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
</form>
<script>
    $(function () {
        //分类标签
        $('.edit_title li').click(function () {
            var index = $('.edit_title li').index(this);
            $('.edit_title li').removeClass('curr');
            $('.edit_title b').show();
            $(this).addClass('curr').find('b').hide();
            $(this).prev().find('b').hide();
            $(".order_box2 ").hide().eq(index).show();
        });
        //全选
        $('.check_all').click(function () {
            var checked = $(this).is(':checked');
            $('.hy_cen input[type=checkbox]').prop('checked', (checked ? 'checked' : false));
        });

        //移动到显示背景颜色
        $('.tbody_cen tr,.hy_cen tr').hover(function () {
            $(this).css('background', '#f5f5f5')
        }, function () {
            $(this).css('background', '#fff')

        });
        //移动到显示背景颜色
        $('.tbody_cen .td3,.hy_cen .td3').hover(function () {
            $(this).css('background', '#fff')
        }, function () {
            $(this).css('background', '#fff')

        });
        //移动到显示
        $('.revise h1').hover(function () {
            $(this).parents('.revise').find('.revise_pop').toggle();
            return false;

        }, function () {
            $(this).parents('.revise').find('.revise_pop').toggle();
            return false;
        });
        //弹出框
        $('.tz_rder').click(function () {
            open_box('#up_hy1')
        });

    });


</script>
