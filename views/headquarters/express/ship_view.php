<?php
$url = input::site("admin/express/install");
?>
<div class="back_right right_width">
    <div class="right">
        <h1>商品配送设置</h1>
        <div class="cen_box">
            <div class="bq_box hy_cen width97 mar0">
                <form action="<?php echo $url; ?>" method="post" name="theForm">
                    <div class="b5"></div>
                    <div class="sort_table dispa_tab">
                        <table border="0">
                            <tr>
                                <th class="text-center info" width="20%">配送方式名称</th>
                                <th class="text-center info" width="40%">配送方式描述</th>
                                <th class="text-center info" width="10%">排序</th>
                                <th class="text-center info" width="30%">操作</th>
                            </tr>
                            <?php
                            if(is_array($data['shipping']) && sizeof($data['shipping'])>0){
                                $tr    = "";
                                foreach ($data['shipping'] as $value){
                                    $tr .= "<tr><td class=\"text-center\">$value->name</td><td>$value->brief</td><td class=\"text-center\">$value->orderNum</td><td class=\"text-center\">$value->enabled</td></tr>";
                                }
                                echo $tr;
                            }
                            ?>
                            <tr>
                                <td>
                                    <input type="text" name="shipping_name" class="form-control" placeholder="配送方式名称" /></td>
                                <td>
                                    <input type="text" name="shipping_desc" class="form-control" placeholder="配送方式描述" /></td>
                                <td>
                                    <input type="text" name="shipping_order" class="form-control" placeholder="排序" /></td>
                                <td class="text-center">
                                    <button type="submit" class="btn btn-success" onclick="return checks()">保存</button></td>
                            </tr>
                        </table>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
