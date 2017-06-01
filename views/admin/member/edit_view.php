
<div class="back_right">
    <div class="right hy_cen">
        <h1>编辑信息</h1>           
        <div class="b5" style="width: 100%;"></div>
        <div class="sort_table dispa_tab">
            <div class="add_hy ma20 pad30">
            <form>
                <dl class="cf">
                    <dt>真实姓名：</dt>
                    <dd><input name="realName" class="inp1" type="text" value="<?php echo $member->realName;?>" /></dd>
                </dl>
                <dl class="cf">
                    <dt>性别：</dt>
                    <dd>
                        <input type="radio" name="sex" id="man" <?php if($member->sex == 0){echo 'checked="true"';}?> value="0"> <label for="man">男</label>
                        <input type="radio" name="sex" id="woman" <?php if($member->sex == 1){echo 'checked="true"';}?> value="1"> <label for="woman">女</label>
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>昵称：</dt>
                    <dd><input name="nickname" class="inp1" type="text" value="<?php echo json_decode($member->nickname);?>" /></dd>
                </dl>
                <dl class="cf">
                    <dt>手机号：</dt>
                    <dd><input name="mobile" class="inp1" type="text" value="<?php echo $member->mobile;?>" /></dd>
                </dl>
                 <dl class="cf">
                    <dt>地址：</dt>
                    <dd><input name="address" class="inp1" type="text" value="<?php echo $member->address;?>" /></dd>
                </dl>
                <dl class="cf">
                    <dt>消费金额：</dt>
                    <dd><input name="amount" class="inp1" type="text" value="<?php echo $member->amount;?>" /></dd>
                </dl>
                <dl class="cf">
                    <dt>佣金：</dt>
                    <dd><input name="commission" class="inp1" type="text" value="<?php echo $member->commission;?>" /></dd>
                </dl>   
                <dl class="cf">
                    <dt>上级用户id：</dt>
                    <dd><input name="pid" class="inp1" type="text" value="<?php echo $member->pid;?>" /></dd>
                </dl>        
                <input type="hidden" name="member_id" id="member_id" value="<?php echo $member->id;?>">           
            </form>
                <dl class="cf ma20">                    
                    <dt><input type='button' id="save" value='保存'></dt>                        
                </dl>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
.sort_table dt{width: 100px;}
</style>
<script>
    $(function () {
        //分类标签
        $('.edit_title li').click(function () {
            var index = $('.edit_title li').index(this);
            $('.edit_title li').removeClass('curr');
            $('.edit_title b').show();
            $(this).addClass('curr').find('b').hide();
            $(this).prev().find('b').hide();
            $(".table_box table").hide().eq(index).show();
        });
        //全选
        $('.check_all').click(function () {
            var checked = $(this).is(':checked');
            $('.stock_table input[type=checkbox]').prop('checked', (checked ? 'checked' : false));
        });
        //移动到样式
        $('.sort_table tr').hover(function () {
            $(this).css({ 'background': '#f5f5f5' })
        }, function () {
            $(this).css({ 'background': 'none' })

        });
        //移动到显示
        $('.revise h1').hover(function () {
            $(this).parents('.revise').find('.revise_pop').toggle();
            return false;

        }, function () {
            $(this).parents('.revise').find('.revise_pop').toggle();
            return false;
        });
        //弹出框
        $('.one_rder').click(function () {
            //open_box('#ceareAbout_view');
        });
        $('.bj_rder').click(function () {
            open_box('#editGroup_view');
            $('#editgroup').val($(this).attr('itemname'));
            $('#editgroup').attr('itemid', $(this).attr('itemid'));
        });
        $('.xj_rder').click(function () {
            open_box('#addGroup_view');
        });

    })

// 保存编辑后信息
$("#save").click(function(){
    $.post('<?php echo input::site("admin/member/save")?>',$('form').serialize(),
        function(data){
            var data=eval("("+data+")");
            alert(data.msg);
    })
})
</script>