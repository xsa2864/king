<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <h1></h1><legend><?php echo $name; ?></legend>
            <table class="table table-hover table-bordered" width="500px">
                <a class="btn btn btn-primary" target="menu" href="/admin/dict/addItem/<?php echo $did.'?name='.$name;?>"><span class="glyphicon glyphicon-plus" aria-hidden="true">添加项</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a class="btn btn btn-primary" target="menu" href="javascript:history.back()"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true">返回</span></a>
                <hr />
                <thead>
                    <tr>
                        <th class="text-center info" style="width:100px">编号
                        </th>
                        <th class="text-center info" style="width:400px">名称
                        </th>
                        <th class="text-center info" style="width:400px">值
                        </th>
                        <th class="text-center info">排序
                        </th>
                        <th class="text-center info">操作
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $deleteMessage = "'确认删除吗？'";
                    foreach($tree as $value)
                    {
                        $table = '<tr>
						<td class="text-center">'. $value->id.'</td>
						<td class="text-center">'. $value->name.'</td>
						<td class="text-center">'. $value->data.'</td>
						<td class="text-center">'. $value->orderNum.'</td>
						<td class="text-center">
						<a class="btn btn-info btn-xs" target="menu" href="/admin/dict/editItem?id='.$value->id."&did=".$value->did."&name=".$name.'"><span class="glyphicon glyphicon-edit" aria-hidden="true">修改</span></a>&nbsp;
						<a class="btn btn-danger btn-xs" target="menu" href="/admin/dict/delItem?id='.$value->id."&did=".$value->did."&name=".$name.'" onclick="return confirm('.$deleteMessage.')"><span class="glyphicon glyphicon-trash" aria-hidden="true">删除</span></a>
						</td>
						</tr>';
                        echo $table;
                    }
                    ?>
                </tbody>
            </table>
            <?php
            echo $pagination->render();
            ?>
        </div>
    </div>
</div>
