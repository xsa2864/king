<form>
    <div class="back_right">
        <div class="right">
            <h1 class="margin_bottom">会员详情<a class="return_btn" href="<?php echo input::site('admin/member/index')?>">返回列表</a></h1>
            <h4 class="hy_xq cf">
                <dl class="v1_xq cf">
                    <dt>收货地址：</dt>
                    <dd><?php echo $add?></dd>
                </dl>
                <div class="v2_xq cf">
                    <dl class="cf">
                        <dt>ID：</dt>
                        <dd><?php echo $row->id?></dd>
                    </dl>
                    <dl class="cf">
                        <dt>用户名：</dt>
                        <dd><?php echo $row->nickname.'（'.$row->realName.'）'?></dd>
                    </dl>
                    <dl class="cf">
                        <dt>手机号：</dt>
                        <dd><?php echo $row->mobile?></dd>
                    </dl>
                </div>
                <div class="v2_xq cf">
                    <dl class="cf">
                        <dt>注册时间：</dt>
                        <dd><?php echo $row->regTime?></dd>
                    </dl>
                    <dl class="cf">
                        <dt>所属门店：</dt>
                        <dd>酒泉网</dd>
                    </dl>
                </div>
                <dl class="v1_xq cf">
                    <dt>来源链接：</dt>
                    <dd>无</dd>
                </dl>
            </h4>
            <div class="edit_box width95 pad15 cf">
                <ul class="edit_title bold cf">
                    <li class="curr"><a href="###">消费明细</a><b></b></li>
                    <li><a href="###">积分明细</a></li>
                </ul>
                <!---消费明细-->
                <div class="order_box2 " style="display: block">
                    <div class=" member_cen">
                        <table class="thead tbody_cen">
                            <tr>
                                <th width="25%" class="align_left">&nbsp;&nbsp;&nbsp;&nbsp;总计订单（笔）<i></i></th>
                                <th width="25%">总消费金额（元）<i></i></th>
                                <th width="25%">本月订单（笔）<i></i></th>
                                <th width="25%">本月消费金额（元）</th>
                            </tr>
                            <tr class="tr_two">
                                <td width="25%" class="align_left">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $orderCount?></td>
                                <td width="25%"><?php echo $goodsTotal?></td>
                                <td width="25%"><?php echo $orderCountThismonth?></td>
                                <td width="25%"><?php echo $goodsTotalThismonth?></td>
                            </tr>
                            <tr>
                                <th class="align_left">&nbsp;&nbsp;&nbsp;&nbsp;订单编号</th>
                                <th>商品总价</th>
                                <th>实付金额</th>
                                <th>交易完成时间</th>
                            </tr>                           
                            <?php
                            foreach($orderList as $item)
                            {
                                echo '<tr>
                                <td class="align_left">&nbsp;&nbsp;&nbsp;&nbsp;'.$item->sn.'</td>
                                <td>'.$item->amount.'</td>
                                <td>'.$item->amount.'</td>
                                <td>'.date('Y-m-d',$item->expressTime).'</td>
                            </tr>';
                            }
                            ?>

                        </table>
                    </div>
                </div>
                <!---积分明细-->
                <div class="order_box2 " style="display: none">
                    <div class=" member_cen">
                        <table class="thead tbody_cen">
                            <tr>
                                <th width="20%" class="align_left">&nbsp;&nbsp;&nbsp;&nbsp;来源/用途<i></i></th>
                                <th width="20%">积分变化前<i></i></th>
                                <th width="20%">积分变化<i></i></th>
                                <th width="20%">积分变化后</th>
                                <th width="20%">日期</th>
                            </tr>
                            
                        </table>
                    </div>
                </div>
                <div>
                    <!--分页--->
                </div>
            </div>
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
        $('.tbody_cen .tr_two').hover(function () {
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
