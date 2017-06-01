<form name="gcountForm" id="gcountForm" method="get" action="gcount">
    <div class="back_right">
        <div class="right">
            <h1>库存管理</h1>
            <div class="cen_box ">
                <dl class=" bor_box stock_box cf">
                    <dl class="cf">
                        <dt>商品条码：</dt>
                        <dd class="inp5"><span>
                            <input type="text" name="itemCode" id="itemCode" value="<?php echo $itemCode; ?>" /></span></dd>
                    </dl>
                    <dl class="cf">
                        <dt>库存总数：</dt>
                        <dd class="inp6"><span>
                            <input type="text" name="countMin" id="countMin" value="<?php echo $countMin ?>" /></span><span>&nbsp;到&nbsp;</span><span><input type="text" name="countMax" id="countMax" value="<?php echo $countMax ?>" /></span></dd>
                        <dd class="query_box"><a href="javascript:" onclick="document.getElementById('gcountForm').submit();">查询</a></dd>
                    </dl>
                </dl>
            </div>
            <div class="b5" style="width: 944px;"></div>
            <div class="bor_box stock_table">
                <table class="" width="100%" border="0">
                    <tr>
                        <!--
                        <th class="cen" width="8%" scope="col">
                            <input name="" type="checkbox" value="" class="check_all" id="check_all"></th>
                            -->
                        <th width="20%" scope="col">商品条码</th>
                        <th width="40%" scope="col">商品名称</th>
                        <th width="32%" scope="col">库存总数</th>
                    </tr>
                    <?php
                    foreach($items as $item)
                    {
                        echo '<tr>
                    <!--    <td class="cen">
                            <input type="checkbox" /></td>-->
                        <td>'.$item->barcode.'</td>
                        <td>'.$item->title.'</td>
                        <td>
                            <input class="" type="text" name="count_'.$item->id.'" id="count_'.$item->id.'" onblur="updateCount('.$item->id.')" value="'.$item->store.'"/></td>
                    </tr>';
                    }
                    ?>
                    <!--
                    <tr>
                        <th class="align_left" colspan="4" class="cen" width="8%" scope="col">
                            <input name="" id="box" type="checkbox" value="" class="check_all" id="check_all"><label for="box">&nbsp;全选</label></th>

                    </tr>-->
                </table>
            </div>
        </div>
        <div class=" cf">
            <div class="page">
                <?php
                echo $pagination->render();
                ?>
            </div>
        </div>
        <div class="btn_two cf">
            <!--<a class="a1" href="#">保存</a><a href="#">取消</a>-->
        </div>
    </div>
</form>
<script>
    function updateCount(id){
        var v = $("#count_"+id+"").val();
        var te= /^[0-9]*[1-9][0-9]*$/;
        if(!te.test(v)){
            alert("请输入正确的数字");
            $("#count_"+id+"").val("0");
            return false;
        }
        $.ajax({
            type: 'post',
            url: '<?php echo input::site('admin/item/updateCount') ?>'+'/' + id + '/' + v,
            cache: false,
            dataType: 'json',
            success: function (data) {
               // alert(data['msg'])
            },
            error: function () {
            }
        });
    }
</script>