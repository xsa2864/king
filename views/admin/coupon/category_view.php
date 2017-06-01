<form>
    <style>
        .sort_table td.revise {
            padding: 5px 0px 5px;
        }
    </style>
    <div class="back_right width_right">
        <div class="right">
            <h1>类别属性</h1>
            <div class="sale_box">
                <h2><a style="cursor:pointer;" class="addcate">添加活动</a></h2>
            </div>
            <div class="sale_cen attr_box cf">
                <div class="sort_table attr_table">
                    <table width="942" border="0" style="font-size: 12px">
                        <tr>
                            <th>名称</th>
                            <th>创建时间</th>          
                            <th>操作</th>
                        </tr>
                        <?php
                        if(!empty($list)){
                            foreach($list as $ch1){
                                echo '<tr class="back level1">
                                        <td class="align_left"> '.$ch1->name.'</td>
                                        <td>'.date('Y-m-d H:i:s',$ch1->addtime).'</td>                            
                                        <td class="revise">
                                            <a href="javascript:edit_category('.$ch1->id.');">编辑</a>
                                            <a href=""></a>
                                            <a href="javascript:del_category('.$ch1->id.');">删除</a>
                                        </td>
                                     </tr>';                            
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</form>
<!--新增组员 -->
<div class="up_box fz_box " style="display: none; width: 365px;" id="add_view">
    <h1>新增分类<i class="close"></i></h1>
    <div class="export weix">
        <dl class="cf mab15 ma20">
            <dt><em class="asterisk">*</em>名称：</dt>
            <dd>
               <input id="name" class="inp185" type="text" />
            </dd>
        </dl>        
    </div>
    <div class="btn_two btn_width cf">
        <a class="a1 close" href="javascript:btnSubmits()">确定</a><a class="close" style="cursor: pointer;">取消</a>
    </div>
</div>
<script type="text/javascript">
// 弹窗
$(".addcate").click(function(){
    open_box('#add_view');
})
// 保存分类
function btnSubmits() {
    var name = $("#name").val();    
    if(name=='' || name == null){
        alert('名称不能为空');
        return false;
    }
    $.post("<?php echo input::site('admin/coupon/save'); ?>", 
        {'name': name},
        function (data) {
            var data = eval("("+data+")");
            if (data.success == 1) {
                location.reload();
            }else {
                alert(data.msg);
            }
        });
}
function edit_category(id){
    if(id != ''){
        window.location.href='<?php echo input::site("admin/coupon/edit_category")?>'+'?id='+id;
    }
}
// 删除分类
function del_category(id){
    if(confirm("确定删除!")){
        $.post('<?php echo input::site("admin/coupon/del_category")?>',{'id':id},function(data){
            var data = eval("("+data+")");
            if(data.success==1){
                window.location.reload();
            }else{
                alert(data.msg);
            }
        })
    }
}
</script>

