<script src="<?php echo input::jsUrl('date/date.js'); ?>" type="text/javascript"></script>
<link href="<?php echo input::cssUrl('date.css'); ?>" rel="stylesheet" type="text/css" />

<div class="back_right">
    <div class="right">
        <h1><?php echo json_decode($p_member->nickname);?>：的下级用户列表（<?php echo $total;?>）</h1>
        <div class=" bor_box return_box cf">            
            <div>
                <!-- <button onclick="exports()">Excel导出</button> -->
            </div>
        </div>
        <div class="edit_box sale_cen mar_right cf">
        <div class="title_all">
            <ul class="edit_title bold cf">
                <li <?php if($levelId == 99){echo 'class="curr"';} ?>>
                    <a href="<?php echo input::site('admin/member/next_member/').$lv_url; ?>">
                        所有用户<i>（<?php echo $total; ?>）</i></a>
                    <b></b></li>
                <li <?php if($levelId == 1){echo 'class="curr"';} ?>>
                    <a href="<?php echo input::site('admin/member/next_member').$lv1_url; ?>">会员<i>（<?php echo $levelId1; ?>）</i></a>
                    <b></b></li>
                <li <?php if($levelId == 0){echo 'class="curr"';} ?>>
                    <a href="<?php echo input::site('admin/member/next_member').$lv0_url; ?>">普通用户<i>（<?php echo $levelId0; ?>）</i></a>
                    <b></b></li>  
            </ul>
        </div>
        <div class="edit_box hy_cen width97 mar0">
            <div class="bq_box">
                <div class="b5"></div>
                <div class="sort_table dispa_tab">
                    <table border="0">
                        <tr>
                            <th class="cen" width="3%">
                                <input name="" type="checkbox" value="" class="check_all">
                            </th>
                            <th class="align_left" width="4%" >ID</th> 
                            <th class="align_left" width="15%" scope="col">用户</th>
                            <th width="15%">统计</th>   
                            <th width="16%">下级用户</th>
                            <th width="20%">操作</th>
                        </tr>
                        <?php
                        foreach($members as $item)
                        {
                            $m_info = $item->levelId==1?"支付过":"没支付过";
                            echo '<tr class="back">
                            <td>
                                <input type="checkbox" value="'.$item->id.'" /></td>
                            <td class="align_left">
                                <label>'.$item->id.'</label>
                            </td>
                            <td class="sort_shop cf align_left">
                                <img src="'.$item->head_img.'" style="float:left;width:60px;margin-right:2px;">
                                <div>
                                    <p>'.json_decode($item->nickname).'</p>
                                    <p>支付情况:'.$m_info.'</p>
                                    <p>注册时间:'.date('Y-m-d',$item->regTime).'</p>                                    
                                </div>
                            </td>
                            <td>
                                <p>消费：'.$item->amount.'</p>   
                                <p>佣金：'.$item->commission.'</p>         
                            </td>
                            <td>
                                <label id="next" onclick="go_next(this,'.$item->id.')">'. M("member")->getAllCount("pid='$item->id'").'</label>
                            </td>
                            <td class="revise">
                                <input type="button" onclick="see('.$item->id.')" value="查看详情">
                                <input type="button" onclick="edit('.$item->id.')" value="编辑详情">
                                <input type="button" onclick="del('.$item->id.')" value="删除用户">
                            </td>
                        </tr>';
                        }
                        ?>
                        <tr class="td3">
                            <td class="" colspan="7">
                                <span class="sp1">
                                    <input name="" type="checkbox" value="" class="check_all" /><label>全选</label></span>
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


<style type="text/css">
tr .revise input{
 color:#000 !important;
 background-color: #fff;
 }
.bor_box dd .input3{
    width: 60px;
}
#next{
    cursor: pointer;
}
</style>
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
    // 编辑用户信息
    function see(id){
        location.href='<?php echo input::site("admin/member/show_see")?>'+'?id='+id;
    }
    // 编辑用户信息
    function edit(id){
        location.href='<?php echo input::site("admin/member/show_edit")?>'+'?id='+id;
    }
    // 选中用户的id
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

    // 批量删除用户
    function del_more(){
        var id = get_checked();
        alert(id);
    }
    // 删除用户
    function del(id){
        if(confirm("确定删除？")){            
            $.post("<?php echo input::site('admin/member/delete_member');?>",{'id':id},
                function(data){
                    var data = eval("("+data+")");
                    if(data.success == 1){
                        window.location.reload();
                    }else{
                        alert(data.msg);
                    }

            })
        }
    }
    //验证是否要到用户excel
    function exports(){
        if(confirm("确认要导出用户信息!")){
            var levelId = $($("select option:selected")[0]).val();
            window.location.href='<?php echo input::site("admin/member/member_excel?levelId=")?>'+levelId;

        }
    }
// 跳转下级会员列表
function go_next(str,id){
    var n = parseInt($(str).html());
    if(n>0){
        location.href = '<?php echo input::site("admin/member/next_member")?>?pid='+id;
    }else{
        alert("没有下级会员!");
    }   
}

</script>
