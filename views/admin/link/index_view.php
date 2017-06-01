<div class="container-fluid">
	<div class="row-fluid">
		<div class="span12">
			<h1></h1><legend>友情链接</legend>
			<table class="table table-hover table-bordered" width="500px">
                <a class="btn btn btn-primary" target="menu" href="/admin/link/add"><span class="glyphicon glyphicon-plus" aria-hidden="true">添加链接</span></a>
                <hr />
				<thead>
					<tr>
						<th class="text-center info">
							编号
						</th>
						<th class="text-center info">
							名称
						</th>
						<th class="text-center info">
							链接地址
						</th>
						<th class="text-center info">
							操作
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
						<td class="text-center">'. $value->href.'</td>
						<td class="text-center">
						<a class="btn btn-info btn-xs" target="menu" href="/admin/link/edit/'.$value->id.'"><span class="glyphicon glyphicon-edit" aria-hidden="true">修改</span></a>&nbsp;
						<a class="btn btn-info btn-xs" target="menu" href="/admin/link/delete/'.$value->id.'" onclick="return confirm('.$deleteMessage.')"><span class="glyphicon glyphicon-trash" aria-hidden="true">删除</span></a>
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