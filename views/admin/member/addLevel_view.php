<!-- 添加会员等级 -->
<div class="up_box" style="display: none; width: 520px;" id="addLevel_view">
    <h1>添加会员等级<i class="close"></i></h1>
    <div class="add_hy ma20 pad30">
        <dl class="cf">
            <dt>等级权重：</dt>
            <dd><input id="power" class="inp1" type="text" /></dd>
            <dd class="ff">（会员等级权重，值越大也重要）</dd>
        </dl>
        <dl class="cf">
            <dt><em class="asterisk">*</em>等级名称：</dt>
            <dd><input id="name" class="inp1" type="text" /></dd>
        </dl>
        <dl class="cf ma20">
            <dt><em class="asterisk">*</em>交易金额：</dt>
            <dd><input id="amount" class="inp2" type="text" /></dd>
        </dl>
        <dl class="cf ma20">
            <dt>开启等级条件限制：</dt>
            <dd><input id="status1" name="status1" class="inp2" type="radio" value="1" /><label for="status1">是</label></dd>
            <dd><input id="status2" name="status1" class="inp2" type="radio" value="0" checked="checked" /><label for="status2">否</label></dd>
        </dl>
        <dl class="cf ma20 is_show1" style="display:none;">
            <dt>等级有效条件：</dt>
            <dd><input id="months" class="inp2" type="text" value="" /><dd>
            <dd> 几个月内，交易额达到 <input id="m_amount" class="inp3" type="text" value="" /></dd>
        </dl>
        <dl class="cf ma20">
            <dt>会员折扣：</dt>
            <dd><input id="discount" class="inp2" type="text" /> 折</dd>
            <dd class="ff">（请输入0.1~10之间的数，值为空代办不设置折扣）</dd>
        </dl>
    </div>
    <div class="btn_two btn_width cf">
        <a class="a1 close" style="cursor: pointer;" onclick="javascript:addlevel()">确定</a>
        <a class="close" style="cursor: pointer;">取消</a>
    </div>
</div>
<script type="text/javascript">
function addlevel(){
    var power = $('#addLevel_view #power').val();
    var name = $('#addLevel_view #name').val();
    var amount = $('#addLevel_view #amount').val();
    var months = $('#addLevel_view #months').val();
    var m_amount = $('#addLevel_view #m_amount').val();
    var discount = $('#addLevel_view #discount').val();
    var status = $("#addLevel_view input[name=status1]:checked").val();
    $.post("<?php echo input::site('admin/member/addLevel') ?>",
        {'power':power,'name':name,'amount':amount,'months':months,'m_amount':m_amount,'discount':discount,'status':status},
        function (data) {
            var data = eval("("+data+")");
            if (data.success == 1) {
                location.reload();
            }else {
                alert(data.msg);
            }
        });
}
$("#addLevel_view input[name=status1]").click(function(){
    if($(this).attr('id')=='status2'){
        $('#addLevel_view .is_show1').attr('style',"display:none");
    }else if($(this).attr('id')=='status1'){
        $('#addLevel_view .is_show1').attr('style',"display:block");
    }
})
</script>