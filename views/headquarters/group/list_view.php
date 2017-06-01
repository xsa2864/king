<div class="container-fluid">
	<div class="row-fluid">
		<div class="span12">
<?php
			echo '<tr><td><a  target="menu" href="/admin/account/add">����û�</a>';
?>
			<table class="table table-hover" width="500px">
				<thead>
					<tr>
						<th>
							���
						</th>
						<th>
							�˺�
						</th>
						<th>
							����
						</th>
						<th>
							�绰
						</th>
						<th>
							����
						</th>
					</tr>
				</thead>
				<tbody>
<?php
				$resetPwdMessage = "'ȷ���������룿'";
				$deleteMessage = "'ȷ��ɾ����'";
				foreach($tree as $value)
				{
					$table = '<tr>
						<td>'. $value->id.'</td>
						<td>'. $value->username.'</td>
						<td>'. $value->project.'</td>
						<td>'. $value->mobile.'</td>
						<td>
						<a  target="menu" href="/admin/account/edit/'.$value->id.'">�޸�</a>&nbsp;
						<a  target="menu" href="/admin/account/resetPwd/'.$value->id.'" onclick="return confirm('.$resetPwdMessage.')">��������</a>&nbsp;
						<a  target="menu" href="/admin/account/del/'.$value->id.'" onclick="return confirm('.$deleteMessage.')">ɾ��</a>
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