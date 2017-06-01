<form name="listForm" id="listForm" method="get" action="listItem">
    <div class="back_right">
        <div class="right right_mar">
            <h1>在售商品管理</h1>
            <div class="sale_box">
                <h2><a href="<?php echo input::site('admin/item/add');?>">新增商品</a></h2>
                <div class="bor_box bor_none cf">
                    <dl class="cf">
                        <dd class="select_box">
                            <select id="categroy1" class="puiSelect" onchange="javascript:loadCategory(1,this.value)" size="10">
                                <option value="0">全部</option>
                                <?php
                                foreach($tree as $value)
                                {
                                    echo '<option value="'.$value->id.'">'.$value->name.'</option>';
                                }
                                ?>
                            </select>
                            <select id="categroy2" class="puiSelect" onchange="javascript:loadCategory(2,this.value)" size="12">
                            </select>
                            <select id="categroy3" class="puiSelect" size="12">
                            </select>
                        </dd>
                    </dl>
                    <dl class=" bor_box stock_box cf">
                        <dl class="cf">
                            <dd class="inp5"><span>
                                <input id="itemTitle" type="text" placeholder="商品名称" /></span></dd>
                        </dl>
                        <dl class="cf">
                            <dd class="inp5"><span>
                                <input id="itemCode" type="text" placeholder="商品条码" /></span></dd>
                            <dd class="query_box"><a href="javascript:selectItem()">查询</a></dd>
                        </dl>
                    </dl>
                </div>
            </div>
            <div class="edit_box sale_cen">
                <div class="title_all">
                    <ul class="edit_title bold cf">
                        <li>
                            <a style="cursor:pointer;" href="<?php echo input::site('admin/item/onsellItemList');?>
                                ">在售 <i>（<?php echo $sales;?>）</i>
                            </a> <b></b>
                        </li>
                        <li class="curr">
                            <a>下架 <i>（<?php echo $downNum;?>）</i></a> <b></b>
                        </li>
                        <li>
                            <a style="cursor:pointer;" href="<?php echo input::site('admin/item/downItemList');?>
                                ">已售罄 <i>（<?php echo $downNum;?>）</i></a> <b></b>
                        </li>
                        <li>
                            <a style="cursor:pointer;" href="<?php echo input::site('admin/item/downItemList');?>
                                ">警戒中 <i>（<?php echo $downNum;?>）</i></a> <b></b>
                        </li>
                    </ul>

                </div>
                <div class="bq_box">
                    <div class="edit_cen sort_table">
                        <table width="200" border="0">
                            <tr>
                                <th class="cen" width="8%" scope="col">
                                    <input name="" type="checkbox" value="" class="check_all" id="check_all"></th>
                                <th class="align_left" width="31%" scope="col">商品</th>                                
                                <th width="10%" scope="col">销量</th>                                
                                <th width="10%" scope="col">创建时间</th>
                                <th width="15%" scope="col">操作</th>
                            </tr>
                            <?php
                            foreach($itemList as $item)
                            {
                                echo '<tr class="back">
                                <td>
                                    <input name="checkbox" itemid="'.$item->id.'" type="checkbox" /></td>
                                <td class="sort_shop cf align_left">
                                    <span class="">
                                        <img src="'.input::site(output_ext::getCoverImg($item->pics)).'" width="58" height="58" />
                                    </span>
                                    <span class="sp2" style="padding-left: 10px;">'.$item->title.'<br>'.$item->price.'<br>'.$item->points.'<br>'.$item->store.'</span>
                                </td> 
                                <td>'.$item->sales.'</td>
                                <td>'.date('Y-m-d H:i:s',$item->addtime).'</td>
                                <td class="revise">
                                    <h1>
                                        <a href="'.input::site('admin/item/edit/'.$item->id).'">修改商品 ∨</a>
                                        <div class="revise_pop" style="display: none">
                                            <a href="javascript:upItem('.$item->id.')">上架商品</a><a href="javascript:deleteItem('.$item->id.')">删除</a>
                                        </div>
                                    </h1>
                                </td>
                            </tr>';
                            }
                            ?>
                            <tr>
                                <th class="left" colspan="8" class="cen" width="8%" scope="col">
                                    <input name="" id="box" type="checkbox" value="" class="check_all" id="check_all"><label for="box">&nbsp;&nbsp;&nbsp;全选</label></th>

                            </tr>

                        </table>

                    </div>
                    <div class=" cf bottom_page">
                        <div class="bottom_btn cf">
                            <a class="bottom" href="javascript:upCheckedItem()">上架</a><a href="javascript:deleteCheckedItem()">删除</a>
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

    </div>
</form>
<script type="text/javascript">

    $(function () {
        //全选
        $('.check_all').click(function () {
            var checked = $(this).is(':checked');
            $('.sort_table input[type=checkbox]').prop('checked', (checked ? 'checked' : false));
        });
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
    });

    function upCheckedItem() {
        $("input:checkbox[name='checkbox']:checked").each(function () {
            var id = $(this).attr('itemid');
            $.post("<?php echo input::site('admin/item/listUp') ?>", { 'id': id }, function (data) {
            });
        });
        setTimeout(function () {
            location.replace(location.href);
        }, 1000);
    }

    function upItem(id) {
        $.post("<?php echo input::site('admin/item/listUp') ?>", { 'id': id }, function (data) {
            var da = JSON.parse(data);
            if (da.success == 1) {
                location.replace(location.href);
            }
            else {
                alert(da.msg);
            }
        });
    }

    function deleteItem(id) {
        if (confirm("确认要删除？")) {
            $.post("<?php echo input::site('admin/item/delete') ?>", { 'id': id }, function (data) {
                var da = JSON.parse(data);
                if (da.success == 1) {
                    location.replace(location.href);
                }
                else {
                    alert(da.msg);
                }
            });
        }
    }

    function deleteCheckedItem() {        
        if (confirm("确认要删除？")) {
            $("input:checkbox[name='checkbox']:checked").each(function () {
                var id = $(this).attr('itemid');
                $.post("<?php echo input::site('admin/item/delete') ?>", { 'id': id }, function (data) {
                });
            });
            setTimeout(function () {
                location.replace(location.href);
            }, 1000);
        }
    }

    function fix_select(selector) {
        var i = $(selector).parent().find('div,ul').remove().css('zIndex');
        $(selector).unwrap().removeClass('jqTransformHidden').jqTransSelect();
        $(selector).parent().css('zIndex', i + 1);
    }

    function loadCategory(id, val) {
        $.post("<?php echo input::site('admin/category/getCategoryOption') ?>", { 'id': val },
                        function (data) {
                            if (id == 1) {
                                $('#categroy2').html(data);
                                fix_select('select#categroy2');
                                $('#itemAttr').html('');
                            }
                            else if (id == 2) {
                                if (val > 0) {
                                    $('#categroy3').html(data);
                                }
                                else {
                                    $('#categroy3').html($('#categroy2').html());
                                }
                                fix_select('select#categroy3');
                            }
                        });
    }


    function selectItem() {
        /*
        var itemTitle = $('#itemTitle').val();
        var itemCode = $('#itemCode').val();
        var categroy1 = $('#categroy1').val();
        var categroy2 = $('#categroy2').val();
        var categroy3 = $('#categroy3').val();
        location.href = '<?php echo input::site('admin/item/onsellItemList?')?>' + 'itemTitle=' + itemTitle + '&itemCode=' + itemCode + '&categroy1=' + categroy1 + '&categroy2=' + categroy2 + '&categroy3=' + categroy3;*/
        $("#listForm").submit();
    }
    //设置排序
    function orderSite(type,field){
        $("#orderField").val(field);
        $("#orderType").val(type)
        $("#listForm").submit();
    }
</script>
