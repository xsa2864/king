<form>
    <div class="back_right">
        <div class="right">
            <h1>权限管理</h1>
            <h5 class="add_h5"><a href="/admin/group/add" id="grouping">添加组</a></h5>
            <div class="edit_box width97 hy_cen mar0">
                <div class="bq_box">
                    <div class="b5"></div>
                    <div class="sort_table dispa_tab">
                        <table border="0">
                            <tr>
                                <th class="align_left" width="12%" scope="col">&nbsp;&nbsp;&nbsp;&nbsp;序号</th>
                                <th width="20%">组名</th>
                                <th width="23%">说明</th>
                                <th width="20%">创建日期</th>
                                <th width="23%">操作</th>
                            </tr>
                            <?php
                            $deleteMessage = "'确认删除吗？'";
                            foreach($tree as $value)
                            {
                                echo '<tr class="back">
                                <td class="sort_shop cf align_left">&nbsp;&nbsp;&nbsp;&nbsp;'.$value->id.'</td>
                                <td>'. $value->groupName .'</td>
                                <td>'. $value->other .'</td>
                                <td>'.date('Y-m-d',$value->ctime).'<br />
                                    '.date('H:i:s',$value->ctime).'</td>
                                <td class="revise">
                                    <h1 class="h1_one">
                                        <a href="/admin/group/edit/'.$value->id.'" class="hf_rder">修改分组<span style="line-height: 20px">∨</span></a>
                                        <div class="revise_pop" style="display: none">
                                            <a href="/admin/account/index">组员管理</a><a href="/admin/group/del/'.$value->id.'" onclick="return confirm('.$deleteMessage.')">删除分组</a>
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
            $(this).parents('li').find('.next_box input[type=checkbox]').prop('checked', (checked ? 'checked' : false));
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
        //点击显示子类目
        $('.power li .h1 i').click(function () {
            var el = $(this).parents('li:first').find('.next_box').toggle();
            $(this)[el.is(':hidden') ? 'removeClass' : 'addClass']('i2');
        }).click().click();
        //弹出框
        $('.qx_rder').click(function () {
            open_box('#editMod_view');
        });
    });


</script>
