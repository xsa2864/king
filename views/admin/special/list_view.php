<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <h1></h1><legend>特卖管理</legend>
            <table class="table table-hover table-bordered" width="500px">
                <a class="btn btn btn-primary" target="menu" href="/admin/special/add"><span class="glyphicon glyphicon-plus" aria-hidden="true">添加特卖</span></a>
                <hr />
                <thead>
                    <tr>
                        <th class="text-center info">编号
                        </th>
                        <th class="text-center info" style="width: 800px">商品名
                        </th>
                        <th class="text-center info">开始时间
                        </th>
                        <th class="text-center info">结束时间
                        </th>
                        <th class="text-center info">创建时间
                        </th>
                        <th class="text-center info">操作
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php	
                    $resetPwdMessage = "'确认删除该商品？'";
                    foreach($list as $value)
                    {
                        $table = '  <tr>
			                        <td class="text-center">'. $value->id.'</td>
			                        <td>'.$value->title.'</td>
			                        <td class="text-center">'. date('Y-m-d H:i:s',$value->beginTime).'</td>
			                        <td class="text-center">'. date('Y-m-d H:i:s',$value->endTime).'</td>			
			                        <td class="text-center">'. date('Y-m-d H:i:s',$value->createTime).'</td>
			                        <td class="text-center">
			                        <a class="btn btn-info btn-xs" target="menu" href="/admin/special/edit/'.$value->id.'"><span class="glyphicon glyphicon-edit" aria-hidden="true">修改</span></a>&nbsp;		    
			                        <a class="btn btn-danger btn-xs" target="menu" href="/admin/special/delete/'.$value->id.'" onclick="return confirm('.$resetPwdMessage.')"><span class="glyphicon glyphicon-trash" aria-hidden="true">删除</span></a>&nbsp;
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
