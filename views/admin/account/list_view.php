<form>
    <div class="back_right">
        <div class="right hy_cen width97">
            <h1>组员管理</h1>
            <h3 class="hy_h1 mar20"><a class="xz_rder" style="cursor: pointer;">新增组员</a></h3>
            <div class="edit_box width97 pad_le mar0">
                <div class="bq_box">
                    <div class="b5"></div>
                    <div class="sort_table dispa_tab">
                        <table border="0">
                            <tr>
                                <th class="align_left" width="12%" scope="col">&nbsp;&nbsp;&nbsp;&nbsp;编号</th>
                                <th width="20%">账号</th>
                                <th width="23%">电话</th>
                                <th width="20%">用户组</th>
                                <th width="23%">操作</th>
                            </tr>
                            <?php
                            $deleteMessage = "'确认删除吗？'";
                            foreach($tree as $value)
                            {                                
                                echo '<tr class="back">
                                <td class="sort_shop cf align_left">&nbsp;&nbsp;&nbsp;&nbsp;'. $value->id.'</td>
                                <td>'. $value->username.'</td>
                                <td>'. $value->mobile.'</td>
                                <td>'. $value->groupName.'</td>
                                <td class="revise">
                                    <h1 class="h1_one">
                                        <a style="cursor: pointer;" class="hxg_rder" itemid="'.$value->id.'" itemname="'.$value->username.'" itemmobile="'.$value->mobile.'" itemreal="'.$value->project.'" itemgid="'.$value->gid.'">修改<span style="line-height: 20px">∨</span></a>
                                        <div class="revise_pop" style="display: none">
                                            <a href="/admin/account/del/'.$value->id.'" onclick="return confirm('.$deleteMessage.')">删除组员</a>
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
            $(".table_box table").hide().eq(index).show();
        });
        //全选
        $('.check_all').click(function () {
            var checked = $(this).is(':checked');
            $('.stock_table input[type=checkbox]').prop('checked', (checked ? 'checked' : false));
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
        //弹出框
        $('.xz_rder').click(function () {
            open_box('#add_view');
        });
        $('.hxg_rder').click(function () {
            $('#edituserName').attr('itemid', $(this).attr('itemid'));
            $('#edituserName').val($(this).attr('itemname'));
            $('#editmobile').val($(this).attr('itemmobile'));
            $('#editgId').val($(this).attr('itemgid'));
            $('#editrealName').val($(this).attr('itemreal'));
            fix_select('#editgId');
            open_box('#edit_view');
        });

    });

    function fix_select(selector) {
        var i = $(selector).parent().find('div,ul').remove().css('zIndex');
        $(selector).unwrap().removeClass('jqTransformHidden').jqTransSelect();
        $(selector).parent().css('zIndex', i + 1);
    }


</script>
