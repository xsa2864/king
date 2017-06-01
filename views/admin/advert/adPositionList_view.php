<div class="back_right right_width">
    <div class="right">
        <h1>广告管理</h1>
        <div class="sale_box">
            <h2><a href="/admin/advert/addPosition">新增广告位</a></h2>
            <div class="edit_box hy_cen width97 mar0">

                <div class="bq_box">

                    <div class="b5"></div>
                    <div class="sort_table dispa_tab">

            <table class="table table-hover table-bordered" width="500px">
                <thead>
                    <tr>
                        <th class="text-center info" style="width:30%">广告位名称</th>
                        <th class="text-center info" style="width:20%">尺寸</th>
                        <th class="text-center info" style="width:30%">绑定广告</th>
                        <th class="text-center info" style="width:20%">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
					$deleteMessage = "'确认删除吗？'";
					foreach($rs as $row)
					{
						$table = '<tr>
							<td class="text-center">'.$row->name.'</td>
							<td class="text-center">'. $row->adSize.'</td>
							<td class="text-center">'. $row->add.'</td>
							<td class="revise">


                            <h1>
                                        <a href="/admin/advert/appendAd/'.$row->id.'">添加广告 ∨</a>
                                        <div class="revise_pop" style="display: none">
                                            <a href="/admin/advert/editPosition/'.$row->id.'">修改</a><a href="/admin/advert/deletePosition/'.$row->id.'" onclick="return confirm('.$deleteMessage.')">删除</a>
                                        </div>
                                    </h1>

							</td>
							</tr>';
						echo $table;
					}
                    ?>
                </tbody>
            </table>
        </div></div></div></div>
    </div>
</div>
<script type="text/javascript">
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
            open_box('#changePoints_view')
            $('#changePoints').val($(this).attr('point'));
            $('#changePoints').attr('itemId', $(this).attr('itemId'));
        });

    });

</script>
