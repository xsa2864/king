<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <h1></h1><legend>文章管理</legend>
            <table class="table table-hover table-bordered" width="500px">
                <a class="btn btn btn-primary" target="menu" href="/admin/article/addDictItem"><span class="glyphicon glyphicon-cog" aria-hidden="true">分类管理</span></a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a class="btn btn btn-primary" target="menu" href="/admin/article/add"><span class="glyphicon glyphicon-plus" aria-hidden="true">添加文章</span></a>
                <hr />
                <thead>
                    <tr>
                        <th class="text-center info" style="width: 200px">编号
                        </th>
                        <th class="text-center info" style="width: 200px">分类
                        </th>
                        <th class="text-center info">标题
                        </th>
                        <th class="text-center info" style="width: 400px">操作
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $deleteMessage = "'确认删除吗？'";
                    foreach($tree as $value)
                    {
                        $table = '<tr>
			<td class="text-center" >'. $value->id.'</td>
			<td class="text-center" >'. $value->dict.'</td>
			<td class="text-left">'. $value->title.'</td>
			<td class="text-center">
			<a class="btn btn-info btn-xs" target="menu" href="/admin/article/edit/'.$value->id.'"><span class="glyphicon glyphicon-edit" aria-hidden="true">修改</span></a>&nbsp;
			<a class="btn btn-danger btn-xs" target="menu" href="/admin/article/delete/'.$value->id.'" onclick="return confirm('.$deleteMessage.')"><span class="glyphicon glyphicon-trash" aria-hidden="true">删除</span></a>
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
