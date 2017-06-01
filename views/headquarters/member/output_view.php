<link href="<?php echo input::jsUrl('date/date.css');?>" rel="stylesheet" type="text/css" />
<script src="<?php echo input::jsUrl('date/date.js');?>"></script>
<form name="outputForm" id="outPutForm" method="post" action="outputSave">
    <div class="back_right">
        <div class="right">
            <h1>会员导出</h1>
            <div class="export">
                <dl class="cf ma20">
                    <dt>导出条件：</dt>
                    <dd class="select_box ">
                        <select class="puiSelect" style="width: 120px">
                            <option value="">所有分组</option>
                            <option value="">指定等级会员</option>
                            <option value="">无成交会员</option>
                            <option value="">已成交会员</option>
                            <option value="">核心会员</option>
                        </select>
                    </dd>
                    <dd class="select_box">
                        <select class="puiSelect" style="width: 120px">
                            <option value="">所有等级</option>
                            <option value="">指定等级会员</option>
                            <option value="">无成交会员</option>
                            <option value="">已成交会员</option>
                            <option value="">核心会员</option>
                        </select>
                    </dd>
                    <dd class="select_box">
                        <select class="puiSelect" style="width: 120px">
                            <option value="">所有门店</option>
                            <option value="">指定等级会员</option>
                            <option value="">无成交会员</option>
                            <option value="">已成交会员</option>
                            <option value="">核心会员</option>
                        </select>
                    </dd>
                </dl>
                <dl class="cf ma20">
                    <dt>&nbsp;</dt>
                    <dd class="select_box">
                        <select class="puiSelect" style="width: 120px">
                            <option value="">所有省份</option>
                            <option value="">指定等级会员</option>
                            <option value="">无成交会员</option>
                            <option value="">已成交会员</option>
                            <option value="">核心会员</option>
                        </select>
                    </dd>
                    <dd class="select_box">
                        <select class="puiSelect" style="width: 120px">
                            <option value="">城市</option>
                            <option value="">指定等级会员</option>
                            <option value="">无成交会员</option>
                            <option value="">已成交会员</option>
                            <option value="">核心会员</option>
                        </select>
                    </dd>
                </dl>
                <dl class="cf ma20">
                    <dt>积分：</dt>
                    <dd>
                        <input class="inp10" name="startpoints" id="startpoints" type="text" /></dd>
                    <dd>&nbsp; 到 &nbsp;<input class="inp10" name="endpoints" id="endpoints" type="text" /></dd>
                </dl>
                <dl class="cf ma20">
                    <dt>消费：</dt>
                    <dd>
                        <input class="inp10" name="starttotalPay" id="starttotalPay" type="text" /></dd>
                    <dd>&nbsp; 到 &nbsp;<input class="inp10" name="endtotalPay" id="endtotalPay" type="text" /></dd>
                </dl>
                <dl class="cf ma20">
                    <dt>注册时间：</dt>
                    <dd>
                        <input type="text" class="puiDate" name="startRegTime" id="startRegTime" placeholder="" /></dd>
                    <dd>&nbsp; 到 &nbsp;<input type="text" name="endRegTime" id="endRegTime" class="puiDate" placeholder="" /></dd>
                </dl>
                <dl class="cf ma20">
                    <dt>上次订单时间：</dt>
                    <dd>
                        <input type="text" class="puiDate date_input" name="startlastOrder" id="startlastOrder" placeholder="" /></dd>
                    <dd>&nbsp; 到 &nbsp;<input type="text" name="endlastOrder" id="endlastOrder" class="puiDate date_input" placeholder="" /></dd>
                </dl>
                <dl class="cf ma20">
                    <dt>导出格式：</dt>
                    <dd>
                        <input type="radio" />Excel</dd>
                </dl>
            </div>
            <div class="add_mem ma20 "><a class="mabl0" href="javascript:$('#outPutForm').submit();">确认导出</a></div>
        </div>
    </div>
</form>
<script>
    $(function () {
        //分类标签
        $('.edit_title li').click(function () {
            var index = $('.edit_title li').index(this);
            $('.edit_title li').removeClass('curr');
            $('.edit_title b').show();
            $(this).addClass('curr').find('b').hide();
            $(this).prev().find('b').hide();
            $(".order_box2 ").hide().eq(index).show();
        });
        //全选
        $('.check_all').click(function () {
            var checked = $(this).is(':checked');
            $('.hy_cen input[type=checkbox]').prop('checked', (checked ? 'checked' : false));
        });

        //移动到显示背景颜色
        $('.tbody_cen tr,.hy_cen tr').hover(function () {
            $(this).css('background', '#f5f5f5')
        }, function () {
            $(this).css('background', '#fff')

        });
        //移动到显示背景颜色
        $('.tbody_cen .td3,.hy_cen .td3').hover(function () {
            $(this).css('background', '#fff')
        }, function () {
            $(this).css('background', '#fff')

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
        $('.tz_rder').click(function () {
            open_box('#up_hy1')
        });

    });


</script>
