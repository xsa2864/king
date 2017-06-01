<?php
$url = input::site("admin/express/install");
?>
<div class="back_right right_width">
    <div class="right">
        <h1>快递信息管理</h1>
        <div class="cen_box">
        <button id="express_add">新增快递</button>
            <div class="bq_box hy_cen width97 mar0">
                <div class="b5"></div>
                <div class="sort_table dispa_tab">
                    <table>
                        <tr>
                            <th class="text-center info" width="20%">快递名称</th>
                            <th class="text-center info" width="10%">快递编码</th>
                            <th class="text-center info" width="30%">操作</th>
                        </tr>
                        <?php
                        if(!empty($shipping)){                                
                            foreach ($shipping as $value){
                        ?>
                        <tr>
                            <td>
                                <label><?php echo $value->name;?></label>
                            </td>
                            <td>
                                <label><?php echo $value->code;?></label>
                            </td>                                
                            <td class="text-center">
                                <button type="submit" class="btn btn-success" onclick="del(this,<?php echo $value->id;?>)">删除</button>
                            </td>
                        </tr>
                        <?php      
                            }
                        }
                        ?>                        
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!--发货窗口-->
<div class="up_box" style="display: none; width: 475px;" id="up_box38">
    <form id="shipping_express">
        <h1>发货标记<i class="close"></i></h1>
        <div class="bor_box modify_box">            
            <dl class="cf">
                <dt>物流公司：</dt>
                <dd class="inp4">
                    <input type="text" name="name" id="name" style="width:172px;"/>
                </dd>
            </dl>
            <dl class="cf" >
                <dt>物流编号：</dt>
                <dd class="inp4">
                    <input type="text" name="code" id="code" style="width:172px;"/>
                </dd>
            </dl>            
        </div>
        <div class="btn_two btn_width cf">
            <a class="a1" href="javascript:" onclick="save()">保存</a><a class="close" href="###">取消</a>
        </div>
    </form>
</div>

<script type="text/javascript">
    function del(str,id){
        if(confirm("确定删除？")){
            $.post('<?php echo input::site("admin/express/del")?>',
                {'id':id},function(data){
                    var data = eval("("+data+")");
                    if(data.success == 1){
                        $(str.parentNode.parentNode).hide();
                    }else{
                        alert(data.msg);
                    }
                })
        }
    }
    // 弹出添加框
    $('#express_add').click(function(){
        open_box('#up_box38');
    })
    function save(){
        var name = $("#name").val();
        var code = $("#code").val();
        $.post('<?php echo input::site("admin/express/save")?>',
            {'name':name,'code':code},function(data){
                var data = eval("("+data+")");
                if(data.success == 1){
                    window.location.reload();
                }else{
                    alert(data.msg);
                }
            })
    }
</script>