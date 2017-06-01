<script src="<?php echo input::jsUrl('date/date.js'); ?>" type="text/javascript"></script>
<link href="<?php echo input::cssUrl('date.css'); ?>" rel="stylesheet" type="text/css" />
<div class="back_right">
    <div class="right">
        <h1 class="margin_bottom">佣金日志</h1>
        <div class=" bor_box return_box cf">
            <form name="jifenlogForm" id="jifenlogForm" method="get">
            <dl class="cf" style="line-height:37px;">
                <dd>
                    <input class="input158" name="nickname" id="nickname" type="text" placeholder="购买者昵称" />
                    <input class="input158" name="mobile" id="mobile" type="text" placeholder="购买者手机号" />
                    <input class="input158" name="gnickname" id="gnickname" type="text" placeholder="获得者昵称" />
                    <input class="input158" name="gmobile" id="gmobile" type="text" placeholder="获得者手机号" />
                </dd>
                <br>
                <dd>                    
                    <input class="input158" name="code" id="code" type="text" placeholder="订单号" />
                    <input class="input158" name="title" id="title" type="text" placeholder="商品名称" />
                    <input class="input158" name="price" id="price" type="text" placeholder="佣金金额" />
                    <input class="input158" name="order_price" id="order_price" type="text" placeholder="订单金额" />
                </dd>
                <br>
                <dd class="select_box">
                    <select name="status" class="puiSelect" style="width: 120px">
                        <option value="">是否发送成功</option>
                        <option value="0">发送失败</option>
                        <option value="1">发送成功</option>
                    </select>
                </dd>
                <dd class="inp5"><span>
                        <input style="width: 122px" type="text" name="startTime" id="startTime" class="puiDate" placeholder="获得起始时间" /></span>&nbsp;&nbsp;到&nbsp;</dd>
                <dd class="inp5"><span>
                        <input style="width: 122px" type="text" id="endTime" name="endTime" class="puiDate" placeholder="获得结束时间" /></span></dd>
                <dd class="query_box"><a href="javascript:" onclick="document.getElementById('jifenlogForm').submit();">查询</a></dd>
            </dl>
            </form>
        </div>
        <div class="edit_box width95 pad15 cf">
            <div class="order_box2 " style="display: block">
                <div class=" member_cen">
                    <table class="thead tbody_cen">
                        <tr>
                            <th class="cen" width="6%">序号<i></i></th>
                            <th>购买者<i></i></th>
                            <th>订单名称：订单号<i></i></th>
                            <th>获得者<i></i></th>                            
                            <th>佣金金额<i></i></th>
                            <th>内容<i></i></th>
                            <th>获得时间<i></i></th>                            
                            <th>是否需要补发<i></i></th>
                        </tr>
                        <?php
                        foreach($List as $key => $item)
                        { ?>
                        <tr>
                            <td>
                                <input type="checkbox" value="<?php echo $item['lcid'];?>" />
                                <?php echo $key+1;?>
                            </td>
                            <td><?php echo json_decode($item['purchaser']);?></td>
                            <td><?php echo $item['title']."<br><span onclick='turn_to(this)'>".$item['code']."</span>";?></td>
                            <td><?php echo json_decode($item['gainer']);?></td>                            
                            <td><?php echo $item['price']>0?sprintf("%.2f",floor($item['price']*100)/100):sprintf("%.2f",ceil($item['price']*100)/100);?></td>
                            <td>
                            <?php 
                            $str = $item['content'];
                            if($item['status'] == 0){
                                $num = ceil($delay - (time()-$item->addtime)/24/3600);
                                $str .= $num>0 ? "(".$num."天之后)":'';
                            }
                            echo $str;
                            ?>                                
                            </td>
                            <td><?php echo date('Y-m-d H:i:s',$item['addtime']);?></td>                            
                            <td>
                            <?php 
                            if($item['status']==0){
                                echo "<a href=javascript:again('".$item['lcid']."')>需要补发</a>";
                            }
                            ?>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                        <tr class="td3">
                            <td class="" colspan="8">
                                <span class="sp1">
                                    <input name="" type="checkbox" value="" class="check_all" id="check_all"/>
                                    <label for="check_all">全选</label>
                                </span>
                                <span class="sp2">
                                    <a href="javascript:all_again();">批量发佣金</a>
                                    <a href="javascript:del_more();" style="margin-left:20px;">批量删除</a>
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class=" cf bottom_page">
                <div class="bottom_btn cf">
                </div>
                <div class="page">
                    <?php
                    echo $pagination->render();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
.tbody_cen span{
    cursor: pointer;
}
.sp1{
    padding-left: 13px;
    float: left;
}
.sp2{
    margin-left: 24px;
    text-align: left !important;
    padding-left: 40px;
}
</style>
<script type="text/javascript">
//全选
$('.check_all').click(function () {
    var checked = $(this).is(':checked');
    $('.tbody_cen input[type=checkbox]').prop('checked', (checked ? 'checked' : false));
});
// 批量发佣金
function all_again(){
    var str = '';
    $('.tbody_cen td>input[type=checkbox]:checked').each(function(n,e){
        if(str!=''){
            str += ',';
        }
        if($(e).val()){
            str += $(e).val();
        }
    })
    if(confirm("确定批量发红包") && str != ''){
        $.post('<?php echo input::site("admin/log/again_all_member");?>',{'str':str},function(data){
            if(data){
                location.reload();
            }
        })
    }
}
// 选中用户的id
function get_checked() {
    var id = '';
    $('td>input[type=checkbox]').filter(function () {
        return this.checked;
    }).each(function (i, e) {
        if (id != '') {
            id += ','
        }
        id += e.value;
    })

    return id;
}

// 批量删除店铺
function del_more() {
    var id = get_checked();
    if (confirm("确定要批量删除选中记录!")) {
            $.post("<?php echo input::site('admin/log/del_more');?>", { 'id': id }, function (data) {
            var data = eval("(" + data + ")");
            if (data.success == 1) {
                window.location.reload();
            } else {
                alert(data.msg);
            }
        })
    }
}
function turn_to(str){
    var code = $(str).html();
    location.href = '<?php echo input::site("admin/coupon/detail")?>'+'?code='+code;
}
function again(id){
    if(confirm("确定重新发送红包！")){
        $.post('<?php echo input::site("admin/log/again_money_member");?>',{'id':id},
            function(data){
                if(data==1){
                    location.reload();
                }else{
                    alert("重新发送失败！");
                }
            })
    }
}
</script>