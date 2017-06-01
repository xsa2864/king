<form>
    <div class="back_right">
        <div class="right hy_cen">
            <h1>组员管理（<?php echo $groupName;?>）</h1>
            <h3 class="hy_h1 mar20"><a class="xj_rder" href="<?php echo input::site('admin/member/addGroupMembers/'.$groupId);?>">新增组员</a></h3>
            <div class="b5"></div>
            <div class="sort_table dispa_tab">
                <table border="0" class="pad10">
                    <tr>
                        <th class="cen" width="6%">
                            <input name="" type="checkbox" value="" class="check_all"></th>
                        <th class="align_left" width="15%" scope="col">用户名/手机号</th>
                        <th width="25%">统计</th>
                        <th width="25%">注册时间</th>
                        <th width="29%"></th>
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
                        <td>
                            <p>消费：'.$item->purchaseAmount.'元</p>
                            <p>积分：'.$item->points.'</p>
                        </td>
                        <td>
                            <p>'.substr($item->regTime,0,10).'</p>
                            <p>'.substr($item->regTime,11,8).'</p>
                        </td>
                        <td width="29%"></td>
                    </tr>';
                    }
                    ?>
                    <tr class="td3">
                        <td class="" colspan="7">
                            <span class="sp1">
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
            $(".table_box table").hide().eq(index).show();
        });
        //全选
        $('.check_all').click(function () {
            var checked = $(this).is(':checked');
            $('.sort_table input[type=checkbox]').prop('checked', (checked ? 'checked' : false));
        });
        //移动到样式
        $('.sort_table tr').hover(function () {
            $(this).css({ 'background': '#f5f5f5' })
        }, function () {
            $(this).css({ 'background': 'none' })

        });
        //移动到显示
        $('.revise h1').hover(function () {
            $(this).parents('.revise').find('.revise_pop').toggle();
            return false;

        }, function () {
            $(this).parents('.revise').find('.revise_pop').toggle();
            return false;
        });
    })


</script>
