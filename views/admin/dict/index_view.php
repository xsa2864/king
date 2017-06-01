<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <h1></h1><legend><?php echo $name;?></legend>
            <table class="table table-hover table-bordered" width="500px">
                <a class="btn btn btn-primary" target="menu" href="/admin/dict/add/<?php echo $property;?>"><span class="glyphicon glyphicon-plus" aria-hidden="true"><?php echo $button; ?></span></a>
                <hr />
                <thead>
                    <tr>
                        <th class="text-center info" style="width: 100px">编号
                        </th>
                        <th class="text-center info" style="width: 600px">名称
                        </th>
                        <th class="text-center info">是否属性
                        </th>
                        <th class="text-center info">是否显示
                        </th>
                        <th class="text-center info">内容
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
                        $propert = $value->property==0?"是":"否";
                        $show = $value->show==0?"是":"否";
                        $table = '<tr>
						<td class="text-center">'. $value->id.'</td>
						<td class="text-center">'. $value->name.'</td>
						<td class="text-center">'. $propert.'</td>
						<td class="text-center">'. $show.'</td>
						<td class="text-center"><a class="btn btn-info btn-xs" target="menu" href="/admin/dict/showItem?id='.$value->id.'&name='.$value->name.'"><span class="glyphicon glyphicon-search" aria-hidden="true">查看</span></a></td>
						<td class="text-center">
						<a class="btn btn-info btn-xs" target="menu" href="/admin/dict/edit/'.$value->id.'?property='.$property.'"><span class="glyphicon glyphicon-edit" aria-hidden="true">修改</span></a>&nbsp;
						<a class="btn btn-danger btn-xs" target="menu" href="/admin/dict/del/'.$value->id.'?property='.$property.'" onclick="return confirm('.$deleteMessage.')"><span class="glyphicon glyphicon-trash" aria-hidden="true">删除</span></a>
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
