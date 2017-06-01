<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="table-responsive">
                <h1></h1><legend>权限管理</legend>
                <table class="table table-hover table-bordered">
                    <a class="btn btn btn-primary" target="menu" href="/admin/mod/add"><span class="glyphicon glyphicon-plus" aria-hidden="true">增加模块</span></a>
                    <hr />
                    <thead>
                        <tr>
                            <th class="text-center info" width="10%">ID</th>
                            <th class="text-center info" width="40%">权限名称</th>
                            <th class="text-center info" width="20%">排序</th>
                            <th class="text-center info" width="15%">状态</th>
                            <th class="text-center info" width="15%">删除</th>
                        </tr>
                    </thead>

                    <?php
                    $icon = array("icon_red_on.gif", "icon_green_on.gif");
                    foreach($tree as $value)
                    {
                        $table = '<tr>
                                  <td class="text-center">'. $value['id'].'</td>
                                  <td>&nbsp;&nbsp;&nbsp【'. $value['text'].'】</td>
                                  <td class="text-center">'. $value['orderNum'].'</td>
                                  <td class="text-center">'.$value['visible'].'</td>
                                  <td class="text-center">
				                  <a class="btn btn-info btn-xs" target="menu" href="/admin/mod/edit/'.$value['id'].'"><span class="glyphicon glyphicon-edit" aria-hidden="true">修改</span></a>&nbsp;
				                  <a class="btn btn-danger btn-xs" onclick="return checks()" target="menu" href="javascript:btnSubmit('.$value['id'].')"><span class="glyphicon glyphicon-trash" aria-hidden="true">删除</span></a>
				                  </td>
                                </tr>';
                        foreach($value['children'] as $values)
                        {
                            $table .= '<tr>
                                          <td class="text-center">'. $values['id'].'</td>
                                          <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus" aria-hidden="true"><span class="glyphicon glyphicon-menu-right" aria-hidden="true">'. $values['text'].'</span></span></td>
                                          <td class="text-center">'. $values['orderNum'].'</td>
                                          <td class="text-center">'.$values['visible'].'</td>
                                          <td class="text-center">
				                          <a class="btn btn-info btn-xs" target="menu" href="/admin/mod/edit/'.$values['id'].'"><span class="glyphicon glyphicon-edit" aria-hidden="true">修改</span></a>&nbsp;
				                          <a class="btn btn-danger btn-xs" onclick="return checks()" target="menu" href="javascript:btnSubmit('.$values['id'].')"><span class="glyphicon glyphicon-trash" aria-hidden="true">删除</span></a>
				                          </td></tr>';
                            //foreach ($values['children'] as $vals){
                            //$table .= '<tr>
                            //<td>'. $vals['id'].'</td>
                            //<td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;|--- '. $vals['text'].'</td>
                            //<td>'. $vals['orderNum'].'</td>
                            //<td><img border="0" title=" 修改 " alt="修改" src="'.input::site('library/images/admin/'.$icon[$vals['visible']]).'"></td>
                            //<td>
                            //<a  target="menu" href="/admin/mod/edit/'.$vals['id'].'"><img border="0" title=" 修改 " alt="修改" src="'.input::site('library/images/admin/icon_edit.gif').'"></a>&nbsp;
                            //<a onclick="return checks()" target="menu" href="/admin/mod/del/'.$vals['id'].'"><img border="0" title=" 删除 " alt="删除" src="'.input::site('library/images/admin/icon_delete.gif').'"></a>
                            //</td></tr>';
                            //}
                            
                        }
                        echo $table;
                    }    
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    function btnSubmit(id) {
        $.post("<?php echo input::site('admin/mod/del/') ?>"+id, {},
                function (data) {
                    var da = JSON.parse(data);
                    if (da.success == 1) {
                        var url = '/admin/mod/index';
                        location.href = url;
                    }
                    else {
                        alertMsg(da.msg, '', da.msg.length * 40, 40);
                    }
                });
    }
</script>