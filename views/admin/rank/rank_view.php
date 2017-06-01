<script src="<?php echo input::jsUrl('date/date.js'); ?>" type="text/javascript"></script>
<link href="<?php echo input::cssUrl('date.css'); ?>" rel="stylesheet" type="text/css" />
<form name="memberForm" id="memberForm" method="get">
    <div class="back_right">
        <div class="right">
            <h1>会员列表</h1>
            <div class=" bor_box return_box cf">
                <dl class="cf">                    
                    <button id="add">+添加会员等级</button>
                </dl>
            </div>
            <div class="edit_box hy_cen width97 mar0">
                <div class="bq_box">
                    <div class="b5"></div>
                    <div class="sort_table dispa_tab">
                        <table border="0">
                            <tr>                                
                                <th width="15%" scope="col">等级名称</th>
                                <th width="15%">交易额</th>   
                                <th width="16%">会员折扣</th>
                                <th width="16%">会员数量</th>
                                <th width="20%">操作</th>
                            </tr>
                            <?php
                            if(!empty($list)){
                                foreach($list as $item){
                                    echo '<tr class="back">                               
                                    <td class="sort_shop cf">                                    
                                        '.$item->name.'
                                    </td>
                                    <td>'.$item->amount.'</td>
                                    <td>'.$item->discount.' 折</td>
                                    <td>'.$item->number.'</td>
                                    <td class="revise">
                                        <input type="button" value="编辑">
                                        <a href="javascript:del('.$item->id.')">删除</a>
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
    </div>
</form>
<!-- 弹出框添加分类 -->
<div class="up_box" style="display: none" id="addCategory_view">
    <h1>添加会员等级<i class="close"></i></h1>
    <div class="bor_box box_pop ">
        <dl class="cf">
            <dt><em class="asterisk">*</em> 分类名称：</dt>
            <dd><span><input id="name" type="text" /></span></dd>
        </dl>
        <dl class="cf">
            <dt><em class="asterisk">*</em>上级分类：</dt>
            <dd><span><input id="name" type="text" /></span></dd>
        </dl>
        <dl class="cf">
            <dt>分类排序：</dt>
            <dd><span><input id="orderNum" type="text" /></span></dd>
        </dl>
    </div>
    <div class="btn_two btn_width cf">
        <a class="a1" href="javascript:btnSubmit()">保存</a><a style="cursor:pointer;" class="close">取消</a>
    </div>
</div>
<script type="text/javascript">
    //添加分类弹出框
    $("#add").click(function () {
        open_box('#addCategory_view');
    });

    function btnSubmit() {
        var name = $("#name").val();
        var pid = $("#pid").val();
        var orderNum = $("#orderNum").val();
        if (!orderNum)
        {
            orderNum = 0;
        }
        $.post("<?php echo input::site('admin/category/save');?>", { 'name': name, 'pid': pid, 'orderNum': orderNum, 'visible': 1 },
                function (data)
                {
                    var da = eval('('+data+')');
                    if (da.success == 1)
                    {
                        location.href = '<?php echo input::site('admin/category/index'); ?>';
                    }
                    else
                    {
                        alert(da.msg);
                    }
                });
    }
</script>

<script type="text/javascript">
   
    function resetPwd(n) {
        var lName = $('#lName').val();
        var lHref = $('#lHref').val();

        $.post("<?php echo input::site('admin/member/resetPwd/') ?>", {'id': n},
                function (data) {
                    var da = JSON.parse(data);
                    alert(da.msg);

                });
    }
    // 选中会员的id
    function get_checked(){
        var id = '';
        $('td>input[type=checkbox]').filter(function() {
            return this.checked;
        }).each(function(i, e) {
            if (id != '') {
                id += ','
            }
            id += e.value;
        })
        return id;
    }
    // 删除会员等级
    function del(id){
        if(confirm("确定要删除？")){
            alert(id);
        }
    }
</script>
