<form>
    <style>
        .sort_table td.revise {
            padding: 5px 0px 5px;
        }
    </style>
    <div class="back_right width_right">
        <div class="right">
            <h1>类别属性</h1>
            <div class="sale_box">
                <h2><a style="cursor:pointer;" class="addcate">添加分类</a></h2>
            </div>
            <div class="sale_cen attr_box cf">
                <div class="sort_table attr_table">
                    <table width="942" border="0" style="font-size: 12px">
                        <tr>
                            <th class="align_left" scope="col">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;分类</th>
                            <th width="10%" scope="col">排序</th>
                            <th width="15%" scope="col">创建时间</th>
                            <th width="15%" scope="col">分类操作</th>
                            <th width="15%" scope="col">属性管理</th>
                        </tr>
                        <?php
                        if(!empty($tree)){
                        foreach($tree as $ch1)
                        {
                            echo '  <tr class="back level1">
                            <td class="align_left">
                                <a style="cursor:pointer;" class="plus"></a>
                                '.$ch1['text'].'（'.($ch1['visible']==1?'显示':'隐藏').'）'.'
                            </td>
                            <td><input type="text" name="orderNum_'.$ch1['id'].'" onblur="updateOrder('.$ch1['id'].');" id="orderNum_'.$ch1['id'].'" value="'.$ch1['orderNum'].'"></td>
                            <td>'.substr($ch1['createTime'],0,10).'<br />
                                '.substr($ch1['createTime'],10,6).'</td>
                            <td class="revise">
                                <h1>
                                    <a href="javascript:editCategory(\''.$ch1['text'].'\',\''.$ch1['pid'].'\',\''.$ch1['orderNum'].'\',\''.$ch1['id'].'\')" name="cate" class="cate">编辑分类 ∨</a>
                                    <div class="revise_pop" style="display: none">
                                        <a style="cursor:pointer;" href="'.input::site('admin/category/visible/'.$ch1['id']).'">显示/隐藏</a>
                                        <a href="'.input::site('admin/category/deleteParent/'.$ch1['id']).'" onclick="confirm(\'确认该分类下无商品与子类别方可删除\');">删除分类</a>
                                    </div>
                                </h1>
                            </td>
                            <td class="revise">';
                            if($ch1['children'])
                            {
                                echo '
                            </td>
                        </tr>';
                                foreach($ch1['children'] as $ch2)
                                {                                    
                                    echo '<tr class="back level2">
                            <td class="align_left">
                                <a style="cursor:pointer;" class="plus"></a>
                                '.$ch2['text'].'（'.($ch2['visible']==1?'显示':'隐藏').'）'.'
                            </td>
                            <td><input type="text" name="orderNum_'.$ch2['id'].'" onblur="updateOrder('.$ch2['id'].');" id="orderNum_'.$ch2['id'].'" value="'.$ch2['orderNum'].'"></td>
                            <td>'.substr($ch2['createTime'],0,10).'<br />
                                '.substr($ch2['createTime'],10,6).'</td>
                            <td class="revise">
                                <h1>
                                    <a href="javascript:editCategory(\''.$ch2['text'].'\',\''.$ch2['pid'].'\',\''.$ch2['orderNum'].'\',\''.$ch2['id'].'\')" name="cate" class="cate" >编辑分类 ∨</a>
                                    <div class="revise_pop" style="display: none">
                                        <a style="cursor:pointer;" href="'.input::site('admin/category/visible/'.$ch2['id']).'">显示/隐藏</a>
                                        <a href="'.input::site('admin/category/deleteCate/'.$ch2['id']).'" onclick="confirm(\'确认该分类下无商品与子类别方可删除\');">删除分类</a>
                                    </div>
                                </h1>
                            </td>
                            <td class="revise">';
                                    if($ch2['children'])
                                    {
                                        echo '
                            </td>
                        </tr>';
                                        foreach($ch2['children'] as $ch3)
                                        {
                                            echo '<tr class="back level3">
                            <td class="align_left">
                                <a style="cursor:pointer;" class="plus"></a>
                                '.$ch3['text'].'（'.($ch3['visible']==1?'显示':'隐藏').'）'.'
                            </td>
                            <td><input type="text" name="orderNum_'.$ch3['id'].'" id="orderNum_'.$ch3['id'].'" onblur="updateOrder('.$ch3['id'].');" value="'.$ch3['orderNum'].'"></td>
                            <td>'.substr($ch3['createTime'],0,10).'<br />
                                '.substr($ch3['createTime'],10,6).'</td>
                            <td class="revise">
                                <h1>
                                    <a href="javascript:editCategory(\''.$ch3['text'].'\',\''.$ch3['pid'].'\',\''.$ch3['orderNum'].'\',\''.$ch3['id'].'\')" name="cate" class="cate" >编辑分类 ∨</a>
                                    <div class="revise_pop" style="display: none">
                                        <a style="cursor:pointer;" href="'.input::site('admin/category/visible/'.$ch3['id']).'">显示/隐藏</a>
                                        <a href="'.input::site('admin/category/deleteChild/'.$ch3['id']).'" onclick="confirm(\'确认该分类下无商品与子类别方可删除\');">删除分类</a>
                                    </div>
                                </h1>
                            </td>
                            <td class="revise">
                                <h1>
                                    <a style="cursor:pointer;" href="'.input::site('admin/attr/index/'.$ch3['id']).'" name="attr" class="attr">编辑属性 ∨</a>
                                </h1>
                            </td>
                        </tr>';
                                        }
                                    }
                                    else
                                    {
                                        echo '
                                <h1>
                                    <a style="cursor:pointer;" href="'.input::site('admin/attr/index/'.$ch2['id']).'" name="attr" class="attr">编辑属性 ∨</a>
                                </h1>';
                                    }
                                }
                            }
                            else
                            {
                                echo '
                                <h1>
                                    <a style="cursor:pointer;" href="'.input::site('admin/attr/index/'.$ch1['id']).'" name="attr" class="attr">编辑属性 ∨</a>
                                </h1>';
                            }
                        }
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
