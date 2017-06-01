<?php 
if (isset($row))//编辑 时
{
    $url		= input::site('admin/category/update/'.$row->id);
}
else 
{
    $url	    = input::site('admin/category/save');
}
if ($data['row']->pid == 0 ){
    $hide = "";
}else{
    $hide = "display:none;";
}
?>
<script>
    function arrt() {
        if ($("#pid").val() == 0) {
            $("#attr").show();
        } else {
            $("#attr").hide();
        }
    }
    $("#form1")
</script>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <h1></h1><legend>商品类别</legend>
            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                    </div>
                    <div class="panel-body">
                        <form id="form1" method="post" action="<?php echo $url; ?>" >
                            <div class="form-group">
                                <div class="col-sm-offset-1 controls">
                                    <table id="table table-striped">
                                        <tr>
                                            <td>分类名称:</td>
                                            <td>
                                                <input type="text" class="form-control input-sm" value="<?php echo $row->name;?>" size="20" id="name" name="name" required="required" /></td>
                                        </tr>
                                        <tr>
                                            <td>上级分类:</td>
                                            <td>
                                                <select id="pid" name="pid" onchange="arrt();" class="form-control">
                                                    <option value="0">一级类别</option>
                                                    <?php
                                                    foreach ($data['tree'] as $value){
                                                        if ( $value['id'] == $row->pid ){
                                                            $selects = "selected";
                                                        }else{
                                                            $selects = '';
                                                        }
                                                        
                                                        if ($value['id'] != $row->id){
                                                            $option.= "<option $selects  value=".$value['id'].">".$value['text']."</opiton>";
                                                        }
                                                        foreach ($value['children'] as $val){
                                                            if ($val['id'] == $row->pid){
                                                                $selects = "selected";
                                                            }else{
                                                                $selects = '';
                                                            }
                                                            if ($val['id'] != $row->id){
                                                                $option.= "<option $selects value=".$val['id'].">&nbsp;&nbsp;&nbsp;".$val['text']."</opiton>";
                                                            }
                                                        }
                                                    }
                                                    echo $option;
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>是否显示:</td>
                                            <td>隐藏:<input type="radio"  name="visible" value="0" <?php echo comm_ext::setChecked(0,0,$row->visible);?> />&nbsp;显示:<input type="radio" name="visible"  value="1" <?php echo comm_ext::setChecked(1,1,$row->visible);?> /></td>
                                        </tr>
                                        <tr>
                                            <td>排序:</td>
                                            <td>
                                                <label>
                                                    <input name="orderNum" class="form-control input-sm" type="text" id="orderNum" value="<?php echo $row->orderNum ? $row->orderNum :0;?>"></label></td>
                                        </tr>
                                    </table>
                                    <input type="hidden" name="nid" value="<?php echo $row->id;?>" />
                                    <br />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 controls">
                                    <button type="button" class="btn btn-success btn-md" onclick="javascript:btnSubmit()">保存</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<button type="button" class="btn" onclick="location.href='javascript:history.back()'">返回</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    function btnSubmit() {
        var name = $("#name").val();
        var pid = $("#pid").val();
        var orderNum = $("#orderNum").val();
        var visible = $('input[name="visible"]:checked').val();
        $.post("<?php echo $url; ?>", { 'name': name, 'pid': pid, 'orderNum': orderNum, 'visible': visible },
                function (data) {
                    var da = eval('('+data+')');
                    if (da.success == 1) {
                        location.href = '<?php echo input::site('admin/category/index'); ?>';
                    }
                    else {
                        alertMsg(da.msg, '', da.msg.length * 40, 40);
                    }
                });
            }
</script>