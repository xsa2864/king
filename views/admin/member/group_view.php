<form>
    <div class="back_right">
        <div class="right hy_cen">
            <h1>会员分组</h1>
            <h3 class="hy_h1 mar20"><a class="xj_rder" style="cursor: pointer;">新建分组</a></h3>
            <div class="b5" style="width: 100%;"></div>
            <div class="sort_table dispa_tab">
                <table class="fz_tab" width="100%" border="0">
                    <tr>
                        <th class="cen" width="5%" scope="col">
                            <input name="" type="checkbox" value="" class="check_all" id="check_all"></th>
                        <th class="align_left" width="25%" scope="col">分组名称</th>
                        <th width="25%" scope="col">会员数量</th>
                        <th class="cen" width="15%" scope="col">操作</th>
                        <th width="35%"></th>
                    </tr>
                    <?php
                    foreach($memberGroups as $item)
                    {
                        echo '<tr>
                        <td class="cen" width="5%">
                            <input type="checkbox" /></td>
                        <td class="align_left" width="25%">'.$item->name.'</td>
                        <td width="25%">'.$item->num.'</td>
                        <td width="15%" class="revise">
                            <h1 class="h1_one">
                                <a style="cursor: pointer;" class="one_rder">一键关怀<span style="line-height: 20px">∨</span></a>
                                <div class="revise_pop" style="display: none">
                                    <a style="cursor: pointer;" itemname="'.$item->name.'" itemid="'.$item->id.'" class="bj_rder">编辑</a><a href="'.input::site('admin/member/groupMembers/'.$item->id).'">组员管理</a><a href="'.input::site('admin/member/deleteGroup/'.$item->id).'">删除</a>
                                </div>
                            </h1>
                        </td>
                        <td width="35%">&nbsp;</td>
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
        $('.one_rder').click(function () {
            //open_box('#ceareAbout_view');
        });
        $('.bj_rder').click(function () {
            open_box('#editGroup_view');
            $('#editgroup').val($(this).attr('itemname'));
            $('#editgroup').attr('itemid', $(this).attr('itemid'));
        });
        $('.xj_rder').click(function () {
            open_box('#addGroup_view');
        });

    })


</script>