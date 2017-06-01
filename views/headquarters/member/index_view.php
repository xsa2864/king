<script src="<?php echo input::jsUrl('date/date.js'); ?>" type="text/javascript"></script>
<link href="<?php echo input::cssUrl('date.css'); ?>" rel="stylesheet" type="text/css" />
<form name="memberForm" id="memberForm" method="get">
    <div class="back_right">
        <div class="right">
            <h1>会员列表（<?php echo $total;?>）</h1>
            <form>
            <div class=" bor_box return_box cf">
                <dl class="cf">
                    <dd>
                        <span>姓名/ID：
                            <input class="input158" name="username" id="username" type="text" placeholder="姓名/ID" />
                        </span>
                    </dd>
                    <dd>
                        <span>上级用户：
                            <input class="input158" name="member" id="member" type="text" placeholder="姓名/ID" />
                        </span>
                    </dd>
                    <dd class="select_box">
                        <span>所属等级：</span> 
                        <select class="puiSelect" style="width: 120px">
                            <option value="">所有等级</option>
                            <option value="">1级</option>
                            <option value="">2级</option>
                        </select>
                    </dd>
                    <br>
                    <dd>
                        <span>昵称/手机：
                            <input class="input158" name="mobilename" id="mobilename" type="text" placeholder="昵称/手机" />
                        </span>
                    </dd>
                    <dd class="select_box">
                        <span>排序：</span>
                        <select class="puiSelect" name="puiSelect" style="width: 150px">
                            <option value="">请选择</option>
                            <option value="m.regTime">按注册时间先后<option>
                            <option value="ma.golds">按金币从高至低</option>
                            <option value="ma.points">按积分从高至低</option>
                            <option value="m.levelId">按等级从高至低</option>
                            <option value="ma.amount">按消费金额</option>
                            <option value="ma.member_num">按下级会员数从多至少</option>
                            <option value="ma.commission">按佣金从高至低</option>
                        </select>
                    </dd>
                    <br>
                    <dd class="inp5">
                    <span>注册时间：</span>
                    <span>
                        <input style="width: 122px" type="text" name="startTime" id="startTime" class="puiDate" placeholder="注册日期" /></span>&nbsp;&nbsp;到&nbsp;</dd>
                    <dd class="inp5"><span>
                        <input style="width: 122px" type="text" id="endTime" name="endTime" class="puiDate" placeholder="注册日期" /></span></dd>
                    <dd class="query_box"><a href="javascript:" onclick="document.getElementById('memberForm').submit();">查询</a></dd>
                    <br>
                    <button>Excel导出</button>
                </dl>
            </div>
            </form>
            <div class="edit_box hy_cen width97 mar0">
                <div class="bq_box">
                    <div class="b5"></div>
                    <div class="sort_table dispa_tab">
                        <table border="0">
                            <tr>
                                <th class="cen" width="6%">
                                    <input name="" type="checkbox" value="" class="check_all">
                                </th>
                                <th class="align_left" width="15%" scope="col">会员</th>
                                <th width="15%">统计</th>   
                                <th width="16%">下级会员</th>
                                <th width="20%">操作</th>
                            </tr>
                            <?php
                            foreach($members as $item)
                            {
                                echo '<tr class="back">
                                <td>
                                    <input type="checkbox" value="'.$item->id.'" /></td>
                                <td class="sort_shop cf align_left">
                                    <img src="#" style="float:left;">
                                    <div>
                                        <p>等级:'.$item->levelId.'</p>
                                        <p>注册时间:'.date('Y-m-d',$item->regTime).'</p>                                    
                                    </div>
                                </td>
                                <td>
                                    <p>消费：'.$item->amount.'</p>
                                    <p>金币：'.$item->golds.'</p>
                                    <p>积分：'.$item->points.'</p>
                                </td>
                                <td>
                                '.$item->member_num.'
                                </td>
                                <td class="revise">
                                    <input type="button" value="查看详情">
                                    <input type="button" value="编辑详情">
                                    <input type="button" value="删除会员">
                                    <input type="button" value="设置等级">
                                    <input type="button" value="设置上级">
                                    <input type="button" value="调整金币">
                                    <input type="button" value="调整积分">
                                    <input type="button" value="查看全部下级">
                                    <input type="button" value="重置支付密码">
                                </td>
                            </tr>';
                            }
                            ?>
                            <tr class="td3">
                                <td class="" colspan="7">
                                    <span class="sp1">
                                        <input name="" type="checkbox" value="" class="check_all" /><label>全选</label></span>
                                    <span class="sp2"><a href="javascript:;">取消</a></span>
                                    <span class="sp2"><a href="javascript:;">批量设置等级</a></span>
                                    <span class="sp2"><a href="javascript:;">批量设置上级</a></span>
                                    <span class="sp2"><a href="javascript:del_more();">批量删除</a></span>
                                </td>
                            </tr>

                        </table>
                        <div class="page">
                            <?php
                            echo $pagination->render();
                            ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
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
            open_box('#changePoints_view')
            $('#changePoints').val($(this).attr('point'));
            $('#changePoints').attr('itemId', $(this).attr('itemId'));
        });

    });
    function btnSubmit(n) {
        id = '<?php echo $id; ?>';
        regTime = '<?php echo $regTime; ?>';
        purchaseAmount = '<?php echo $purchaseAmount; ?>';
        if (n == 1) {
            if (id == 'asc') {
                id = 'desc';
            }
            else if (id == 'desc') {
                id = 'asc';
            }
            regTime = 'default';
            purchaseAmount = 'default';
        }
        if (n == 2) {
            if (regTime == 'asc') {
                regTime = 'desc';
            }
            else if (regTime == 'desc' || regTime == 'default') {
                regTime = 'asc';
            }
            purchaseAmount = 'default';
        }
        if (n == 3) {
            if (purchaseAmount == 'asc') {
                purchaseAmount = 'desc';
            }
            else if (purchaseAmount == 'desc' || purchaseAmount == 'default') {
                purchaseAmount = 'asc';
            }
        }
        location.href = "/admin/member/index?id=" + id + "&regTime=" + regTime + "&purchaseAmount=" + purchaseAmount;
    }

    function btnSeach() {
        var mobile = $("#mobile").val();
        location.href = "/admin/member/index?mobile=" + mobile;
    }

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
    // 批量删除会员
    function del_more(){
        var id = get_checked();
        alert(id);
    }
</script>
