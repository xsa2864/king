<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <h1></h1>
            <legend>投放广告</legend>

            <table class="table table-hover table-bordered" width="500px">
                <thead>
                    <tr>
                        <th class="text-center info" style="width: 30%">
                            <input type="checkbox" onclick="selects(this)" /></th>
                        <th class="text-center info" style="width: 30%">广告位名称</th>
                        <th class="text-center info" style="width: 20%">尺寸</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
					$deleteMessage = "'确认删除吗？'";
					foreach($rs as $row)
					{
                        $checked = $row->adId==$id?'checked':'';
						$table = '<tr>
							<td class="text-center"><input type="checkbox" name="checkboxes[]" '.$checked.' value="'.$row->id.'" /></td>
							<td class="text-center">'.$row->name.'</td>
							<td class="text-center">'. $row->adSize.'</td>
							</tr>';
						echo $table;
					}
                    ?>
                </tbody>
            </table>
            <div class="col-sm-offset-5 col-sm-7 controls">
                <button type="button" class="btn btn-success" onclick="javascript:btnSubmit()">保存</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<button type="button" class="btn btn-danger" onclick="location.href='javascript:history.back()'">返回</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    function btnSubmit() {
        var id_array=new Array();  
        $('input[name="checkboxes[]"]:checked').each(function(){ id_array.push($(this).val()); }); 

        $.post("<?php echo input::site('admin/advert/saveAllAdPosition/') ?><?php echo $id; ?>", { 'ids': id_array },
                function (data) {
                    var da = JSON.parse(data);
                    if (da.success == 1) {
                        var url = '/admin/advert/index';
                        location.href = url;
                    }
                    else {
                        alertMsg(da.msg, '', da.msg.length * 40, 40);
                    }
                });
    }

</script>