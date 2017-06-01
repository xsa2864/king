<form>
    <div class="back_right">
        <div class="right">
            <h1>会员等级</h1>
            <h5 class="add_h5"><a style="cursor: pointer;" id="add_rder">添加会员等级</a></h5>
            <div class="edit_box width97 hy_cen mar0">
                <div class="bq_box">
                    <div class="b5"></div>
                    <div class="sort_table dispa_tab">
                        <table border="0">
                            <tr>
                                <th class="align_left" width="20%" scope="col">&nbsp;&nbsp;&nbsp;&nbsp;等级名称</th>
                                <th width="20%">交易额</th>
                                <th width="18%">积分倍数</th>
                                <th width="20%">会员数量</th>
                                <th width="20%">操作</th>
                            </tr>
                            <?php
                            foreach($levelList as $item)
                            {
                                echo '<tr class="back">
                                <td class="sort_shop cf align_left">&nbsp;&nbsp;&nbsp;&nbsp;'.$item->name.'</td>
                                <td>'.$item->minExpense.'~'.$item->maxExpense.'</td>
                                <td>'.$item->point.'</td>
                                <td>'.$item->num.'</td>
                                <td class="revise">
                                    <h1 class="h1_one">
                                        <a style="cursor: pointer;" class="hf_rder" itemid="'.$item->id.'" itemname="'.$item->name.'" itemmin="'.$item->minExpense.'" itemmax="'.$item->maxExpense.'" itempoint="'.$item->point.'" itemorder="'.$item->orderNum.'">编辑<span style="line-height: 20px">∨</span></a>
                                        <div class="revise_pop" style="display: none">
                                            <a href="'.input::site('admin/member/deleteLevel/'.$item->id).'">删除</a>
                                        </div>
                                    </h1>
                                </td>
                            </tr>';
                            }
                            ?>                            
                        </table>
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
        $('#add_rder').click(function () {
            open_box('#addLevel_view')
        });
        $('.hf_rder').click(function () {
            $('#editlevelname').attr('itemid', $(this).attr('itemid'));
            $('#editlevelname').val($(this).attr('itemname'));
            $('#editlevelmin').val($(this).attr('itemmin'));
            $('#editlevelmax').val($(this).attr('itemmax'));
            $('#editlevelorder').val($(this).attr('itemorder'));
            $('#editlevelpoint').val($(this).attr('itempoint'));
            open_box('#editLevel_view')
        });

    });


</script>
