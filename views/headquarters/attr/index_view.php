<div class="back_right">
    <div class="right">
        <h1>编辑属性</h1>
        <div class="cen_box classify">
            <dl class="classify_box cf">
                <dt>分类：</dt>
                <dd>
                    <input type="text" value="<?php echo $cName;?>" disabled="disabled"></dd>
                <dd><a style="cursor:pointer;" onclick="javascript:addAttr();">新增属性</a></dd>
            </dl>
            <div class="edit_box cf">
                <ul class="edit_title cf">
                    <?php
                    $first = true;
                    $btnName = '';
                    $btnId = 0;
                    foreach($tree as $item)
                    {
                        if($first)
                        {
                            echo '<li class="curr"><a style="cursor: pointer;">'.$item->name.'</a><input value="'.$item->id.'" style="display: none"/><b>|</b></li>';
                            $btnName = $item->name;
                            $btnId = $item->id;
                            $first = false;
                        }
                        else
                        {
                            echo '<li><a style="cursor: pointer;">'.$item->name.'</a><input value="'.$item->id.'" style="display: none"/><b>|</b></li>';
                        }
                    }
                    ?>
                </ul>
                <div class="table_box">
                    <?php
                    $first = true;
                    foreach($tree as $item)
                    {
                        if($first)
                        {
                            echo '<table width="780px" border="0">
                        <tr>
                            <th width="10%" scope="col">&nbsp;</th>
                            <th width="30%" scope="col">内容</th>
                            <th width="10%" scope="col">在首页显示</th>
                            <th width="10%" scope="col">排序</th>
                            <th width="40%" scope="col">操作</th>
                        </tr>';
                            foreach($item->childs as $ch)
                            {
                                $show = $ch->show==1?'显示':'隐藏';
                                $hide = $ch->show==0?'显示':'隐藏';
                                echo '<tr>
                            <td></td>
                            <td class="align_left">'.$ch->name.'</td>
                            <td>'.$show.'</td>
                            <td>'.$ch->orderNum.'</td>
                            <td><a style="cursor:pointer;" onclick="javascript:editAttr(\''.$ch->id.'\',\''.$ch->name.'\',\''.$item->id.'\');">编辑</a><a href="'.input::site('admin/attr/deleteItem/'.$ch->id).'">删除</a><a href="'.input::site('admin/attr/changeVisible/'.$ch->id).'">首页'.$hide.'</a></td>
                        </tr>';
                            }
                        
                            echo '</table>';
                            $first = false;
                        }
                        else
                        {
                            echo '<table width="780px" border="0" style="display: none">
                        <tr>
                            <th width="10%" scope="col">&nbsp;</th>
                            <th width="30%" scope="col">内容</th>
                            <th width="10%" scope="col">在首页显示</th>
                            <th width="10%" scope="col">排序</th>
                            <th width="40%" scope="col">操作</th>
                        </tr>';
                            foreach($item->childs as $ch)
                            {
                                $show = $ch->show==1?'显示':'隐藏';
                                $hide = $ch->show==0?'显示':'隐藏';
                                echo '<tr>
                            <td></td>
                            <td class="align_left">'.$ch->name.'</td>
                            <td>'.$show.'</td>
                            <td>'.$ch->orderNum.'</td>
                            <td><a style="cursor:pointer;" onclick="javascript:editAttr(\''.$ch->id.'\',\''.$ch->name.'\',\''.$item->id.'\');">编辑</a><a href="'.input::site('admin/attr/deleteItem/'.$ch->id).'">删除</a><a href="'.input::site('admin/attr/changeVisible/'.$ch->id).'">首页'.$hide.'</a></td>
                        </tr>';
                            }
                            
                            echo '</table>';
                        }
                    }
                    ?>
                </div>

                <div class="bottom_btn cf">
                    <a id="addAttrItmeBtn" style="cursor: pointer; display:<?php if($btnName) echo 'block'; else echo 'none';?>" onclick="javascript:addAttrItem();" class="a1">新增<?php echo $btnName;?></a>
                
                    <a id="deleteAttrItmeBtn" style="cursor: pointer; display:<?php if($btnName) echo 'block'; else echo 'none';?>" onclick="javascript:deleteAttr();" class="a1">删除<?php echo $btnName;?></a>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    $(function () {

        $('#attrNameDis').val('<?php echo $btnName;?>');
        $('#attrId').val('<?php echo $btnId;?>');

        //分类标签
        $('.edit_title li').click(function () {
            var index = $('.edit_title li').index(this);
            $('.edit_title li').removeClass('curr');
            $('.edit_title b').show();
            $(this).addClass('curr').find('b').hide();
            $(this).prev().find('b').hide();
            $(".table_box table").hide().eq(index).show();
            var text = '新增' + $(this).find('a').html();
            var text1 = '删除' + $(this).find('a').html();
            $('#attrNameDis').val($(this).find('a').html());
            $('#attrId').val($(this).find('input').val());
            $('#addAttrItmeBtn').html(text);
            $('#deleteAttrItmeBtn').html(text1);
        });

    });

    //新增属性弹出框
    function addAttr() {
        open_box('#addAttr_view');
        $('#categoryName').val('<?php echo $cName;?>');
        $('#categoryId').val('<?php echo $id;?>');
    }

    //编辑弹出框
    function editAttr(id,name,cid) {
        open_box('#editAttr_view');
        $('#cId').val(cid);
        $('#attrItemId').val(id);
        $('#eAttrItemName').val(name);
    }

    //内容弹出框
    function addAttrItem() {
        open_box('#addAttrItem_view');
    }

    //删除属性
    function deleteAttr() {
        var id = $('#attrId').val();
        var cid = <?php echo $id?>;
        $.post("<?php echo input::site('admin/attr/delete');?>", { 'id': id, 'cid': cid },
                function (data) {
                    var da = eval('('+data+')');
                    if (da.success == 1) {
                        location.reload();
                    }
                    else {
                        alert(da.msg);
                    }
                });
    }

</script>
