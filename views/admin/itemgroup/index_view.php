<div class="back_right right_width">
    <div class="right">
        <h1>商品组合</h1>
        <div class="cen_box">

            <div class="sale_box">
                <h2><a style="cursor:pointer;" href="/admin/itemgroup/add" class="addcate">添加分类</a></h2>
            </div>
            <div class="sale_cen attr_box cf">
                <div class="sort_table attr_table">
                    <table width="942" border="0" style="font-size: 12px">

                    <tr>
                        <th width="10%" scope="col">编号
                        </th>
                        <th width="25%" scope="col" style="width:400px">名称
                        </th>
                        <th width="25%" scope="col">专题页
                        </th>
                        <th width="25%" scope="col">排序
                        </th>
                        <th width="15%" scope="col">操作
                        </th>
                    </tr>


                    <?php
                    $deleteMessage = "'确认删除吗？'";
                    foreach($tree as $value)
                    {
                        $table = '<tr class="back level1">
						<td class="text-center">'. $value->id.'</td>
						<td class="text-center">'. $value->name.'</td>
						<td class="text-center">'. $value->page.'</td>
						<td class="text-center">'. $value->order.'</td>
						<td class="revise">

						<h1>
                                    <a href="/admin/itemgroup/addItem/'.$value->id.'" name="cate" class="cate">添加商品 ∨</a>
                                    <div class="revise_pop" style="display: none">
                                        <a style="cursor:pointer;" href="/admin/itemgroup/edit/'.$value->id.'">修改</a>
                                        <a href="/admin/itemgroup/del/'.$value->id.'" onclick="return confirm('.$deleteMessage.')"><span class="glyphicon glyphicon-trash" aria-hidden="true">删除</span></a>
                                    </div>
                                </h1>


						</td>
						</tr>';
                        echo $table;
                    }
                    ?>

            </table>
            <?php
            echo $pagination->render();
            ?>
                    </div></div>
        </div>
    </div>
</div>
<script>
    $(function () {

        //移动到样式
        $('.sort_table tr td:not(.revise)').hover(function () {
            $(this).parents('tr:first').css({ 'background': '#f5f5f5' });
            return false;
        }, function () {
            $(this).parents('tr:first').css({ 'background': 'none' });
            return false;
        });
        //移动到显示
        $('.revise h1').hover(function () {
            $(this).parents('.revise').find('.revise_pop').toggle();
            return false;

        }, function () {
            $(this).parents('.revise').find('.revise_pop').toggle();
            return false;
        });
        //分类弹出框
        //$(".cate").click(function () {
        //    open_box('#up_box1');
        //    $('#ename').val('1');
        //    $('#epid').val('31');
        //    var thiz = $('#epid');
        //    var text = thiz.find('option:selected').text();
        //    var ul = thiz.parents('div.jqTransformSelectWrapper:first ul');
        //    ul.find('a').removeClass('selected');
        //    ul.find('a:contains("' + text + '")').addClass('selected');
        //    ul.prev().find('span').text(text);
        //    $('#eorderNum').val(1);
        //    return false;
        //});

        //添加分类弹出框
        $(".addcate").click(function () {
            open_box('#addCategory_view');
        });

        // 分类
        $('.attr_table a.plus').click(function () {
            var t = $(this),
                tr = t.parents('tr:first'),
                className = tr.attr('class'),
                arr = className.match(/level(\d+)/),
                level = parseInt(arr && arr[1] ? arr[1] : 1),
                fn = function (tr) {
                    var nexttr = tr.next();
                    if (!nexttr.is('tr') || nexttr.hasClass('level' + level) || nexttr.hasClass('level' + (level - 1))) { // 当不是TR或同级元素时退出
                        tr.find('.plus').addClass('nosubs');
                        return;
                    }
                    if (t.hasClass('coll')) { // 显示
                        if (nexttr.hasClass('level' + (level + 1))) {
                            nexttr.show();
                        }
                    } else { // 隐藏
                        nexttr.hide();
                        nexttr.find('.coll').removeClass('coll');
                    }
                    fn(nexttr);
                };
            if (t.is('.nosubs')) return; // 没子子元素时返回
            t.toggleClass('coll');  // 加减号图标切换
            fn(tr); // 展示子元素
        }).click().filter('.level1 .coll:not(.nosubs)').click();
    });

    function fix_select(selector) {
        var i = $(selector).parent().find('div,ul').remove().css('zIndex');
        $(selector).unwrap().removeClass('jqTransformHidden').jqTransSelect();
        $(selector).parent().css('zIndex', i);
    }

    function editCategory(ename,epid,eorderNum,eid) {
        open_box('#editCategory_view');
        $('#ename').val(ename);
        $('#epid').val(epid);
        $('#eorderNum').val(eorderNum);
        $('#eid').val(eid);
        fix_select('select#epid')
    }

    function updateOrder(id){
        var v = $("#orderNum_"+id+"").val();
        var te= /^[0-9]*[1-9][0-9]*$/;
        if(!te.test(v)){
            alert("请输入正确的数字");
            $("#orderNum_"+id+"").val("0");
            return false;
        }
        $.ajax({
            type: 'post',
            url: '<?php echo input::site('admin/category/updateOrder') ?>'+'/' + id + '/' + v,
            cache: false,
            dataType: 'json',
            success: function (data) {
                alert(data['msg'])
            },
            error: function () {
            }
        });
    }
</script>