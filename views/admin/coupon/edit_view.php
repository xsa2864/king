<form>
    <style>
        .sort_table td.revise {
            padding: 5px 0px 5px;
        }
    </style>
    <div class="back_right width_right">
        <div class="right">
            <h1>类别选择商家</h1>
            <div class="sale_box">
                <h3>活动名称：<input type="text" name="name" class="cf" value="<?php echo $list->name;?>"></h3>
            </div>
            <div class="sale_cen attr_box cf">
                <div class="sort_table attr_table">   
                    <table border="0" style="font-size: 12px">
                        <tr>
                            <th>选择商家</th>   
                            <th>选择商家</th>
                            <th>选择商家</th>                         
                        </tr>                        
                        <?php
                        if(!empty($b_list)){
                            $arr = explode(',', $list->business_id);

                            $str = "<tr>";
                            foreach($b_list as $key => $ch1){
                                $checked = in_array($ch1->id, $arr)?'checked':'';
              
                                if($key%3==0){
                                    $str .= "</tr><tr>";
                                }
                                $str .= "<td>
                                            <input type='checkbox' name='business' ".$checked." id=c_$key value=".$ch1->id.">
                                            <label for=c_$key>".$ch1->name."</label>
                                        </td>";                                                     
                            }
                            $str .= "</tr>";
                            echo $str;
                        }
                        ?>
                    </table>               
                    <div style="text-align:center;padding-top:20px;font-size:18px;">
                        <input type="hidden" name="id" value="<?php echo $list->id;?>">
                        <a href="javascript:save_c();">保存</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<!--新增组员 -->
<div class="up_box fz_box " style="display: none; width: 365px;" id="add_view">
    <h1>新增活动<i class="close"></i></h1>
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
// 保存分类
function save_c(){
    var str = save_business();
    var id = $("input[name=id]").val();
    var name = $("input[name=name]").val();
    $.post('<?php echo input::site("admin/coupon/save_business");?>',{'id':id,'name':name,'str':str},
        function(data){
            var data = eval("("+data+")");
            alert(data.msg);
    })
}

function save_business(){
    var str = '';
    $("input[type=checkbox]:checked").each(function(n,e){
        if(str!=''){
            str+=',';
        }
        str += $(e).val();
    })
    return str;
}

</script>

