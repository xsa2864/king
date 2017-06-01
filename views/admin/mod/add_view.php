<?php 
if (isset($row))//编辑 时
{
    if ($row->url != '')
    {
        $fcs		= explode('/', $row->url);
        $class		= isset($fcs[0]) ? $fcs[0]:'';
        $function	= isset($fcs[1]) ? $fcs[1]:'';
    }
    $url		= input::site('admin/mod/update/'.$row->id);
    if ($row->size)
    {
        $sizes		= unserialize($row->size);
        $width		= $sizes['width'];
        $height		= $sizes['height'];
    }
}
else 
{
    $url	= input::site('admin/mod/save');
}
?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <h1></h1>
            <legend>添加模块</legend>
            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                    </div>
                    <div class="panel-body">
                        <form id="form1" method="post" action="<?php echo $url; ?>">
                            <table id="tabwin" class>
                                <tr>
                                    <td>上级模块:</td>
                                    <td>
                                        <select id="bid" name="bid" class="form-control">
                                            <option value="0">作为一级类别</option>
                                            <?php
                                            /*
                                            foreach ($tree as $value){
                                                if ( $value['id'] == $row->bid ){
                                                    $selects = "selected";
                                                }else{
                                                    $selects = '';
                                                }
                                                
                                                if ($value['id'] != $row->id){
                                                    $option.= "<option $selects value=".$value['id'].">".$value['text']."</opiton>";
                                                }
                                            }
                                            echo $option;*/
                                            foreach($tree as $value){
                                                $option.= "<option $selects value=".$value->id.">".$value->modName."</opiton>";
                                            }
                                            echo $option;
                                            ?>
                                        </select>
                                        <span id="secondSpan">
                                            <select id="secondSelect" name="secondSelect" class="form-control">
                                            </select>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h1></h1>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>模块名称:</td>
                                    <td>
                                        <input type="text"  class="form-control input-sm" name="modName"  required="true" value="<?php echo $row->modName;?>" /></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h1></h1>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>模块类:</td>
                                    <td>
                                        <input type="text" name="class" class="form-control input-sm" value="<?php echo $class;?>" /></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h1></h1>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>模块方法:</td>
                                    <td>
                                        <input type="text" name="function" class="form-control input-sm"  value="<?php echo $function;?>" /></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h1></h1>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>排序:</td>
                                    <td>
                                        <label>
                                            <input name="orderNum" type="text" id="orderNum" value="<?php echo $row->orderNum ? $row->orderNum :0;?>"></label></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h1></h1>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>是否显示:</td>
                                    <td>显示:<input type="radio" name="visible" value="1" <?php echo comm_ext::setChecked(1,1,$row->visible);?> />&nbsp;隐藏:<input type="radio" name="visible" value="0" <?php echo comm_ext::setChecked(0,0,$row->visible);?>/></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h1></h1>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>所属文件夹:</td>
                                    <td>
                                        <input class="form-control input-sm" value="<?php echo $row->app ? $row->app :'admin';?>" name="app" url="<?php echo input::site('admin/mod/getApp');?>" valueField="id" textField="app" panelHeight="auto"></td>
                                </tr>
                                <tr>
                                    <td>
                                        <h1></h1>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <button class="btn btn-success btn-sm" type="submit">确定修改</button>&nbsp&nbsp&nbsp
                                        <button class="btn btn-success btn-sm" type="button" onclick="location.href='javascript:history.back()'">返回</button></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $("#bid").change(function(){
        var pid = this.value;
        var option = '';
        $("#secondSelect").empty();
        if(pid > 0){
            $("#secondSelect").append('<option value="0">作为二级分类</option>');
            $.ajax({
                type: 'post',
                url: '<?php echo input::site('admin/mod/getSecondary') ?>'+'/' + pid,
                cache: false,
                dataType: 'json',
                success: function (data) {
                    if(isNaN(data)){
                        for(var i = 0;i < data.length;i++){
                            option = option + '<option value="'+data[i]['id']+'">'+data[i]['modName']+'</option>';
                        }
                        $("#secondSelect").append(option);
                    }
                },
                error: function () {
                }
            });
        }

    });
</script>