
<div class="back_right">
    <div class="right hy_cen">
        <h1>查看信息</h1>           
        <div class="b5" style="width: 100%;"></div>
        <div class="sort_table dispa_tab">
            <div class="add_hy ma20 pad30">                
                <dl class="cf">
                    <dt>真实姓名：</dt>
                    <dd><label><?php echo $member->realName;?></label></dd>
                </dl>
                <dl class="cf">
                    <dt>性别：</dt>
                    <dd><label><?php if($member->sex == 1){echo '女';}else{echo '男';}?></label></dd>
                </dl>
                <dl class="cf">
                    <dt>昵称：</dt>
                    <dd><label><?php echo json_decode($member->nickname);?></label></dd>
                </dl>
                <dl class="cf">
                    <dt>手机号：</dt>
                    <dd><?php echo $member->mobile;?></dd>
                </dl>
                <dl class="cf">
                    <dt>地址：</dt>
                    <dd><?php echo $member->address;?></dd>
                </dl>
                <dl class="cf">
                    <dt>注册时间：</dt>
                    <dd><?php echo date('Y-m-d H:i:s',$member->regTime);?></dd>
                </dl>
                <dl class="cf">
                    <dt>消费金额：</dt>
                    <dd><?php echo $member->amount;?></dd>
                </dl>
                <dl class="cf">
                    <dt>佣金：</dt>
                    <dd><?php echo $member->commission;?></dd>
                </dl>
                <dl class="cf">
                    <dt>订单量：</dt>
                    <dd><a href="javascript:show_list(<?php echo $member->id;?>)"><?php echo $member->order_num;?></a></dd>
                </dl>
                <dl class="cf">
                    <dt>下级会员数量：</dt>
                    <dd><?php echo M("member")->getAllCount("pid=".$member->id);?></dd>
                </dl>
                <dl class="cf">
                    <dt>openid：</dt>
                    <dd><?php echo $member->openId;?></dd>
                </dl>
                <dl class="cf">
                    <dt>冻结资金：</dt>
                    <dd><?php echo tuoke_ext::get_freeze_money($member->id);?></dd>
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

function show_list(id){
    location.href = '<?php echo input::site("admin/coupon/index")?>'+'?member_id='+id;
}
</script>