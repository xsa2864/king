<header class="header buys pad0">
    <div class="favorites">
        <p><a class="return" href="JavaScript:history.back();"><i></i>商家列表</a></p>
    </div>
</header>
<div class="container pad1">
    <div class="order_box">
        <div class="toker_store">
            <h1 class="two">为您提供<?php echo $total?>家店铺，供您挑选</h1>
            <div class="edit_cen">
                <div class="edit_shop" style="height:auto">
                    <?php 
                    foreach($business as $bus){ 
                    ?>
                    <dl class="edit_list" busId="<?php echo $bus['id'];?>" onclick="location.href='<?php echo input::site('wechat/business/detail/'.$bus['id'])?>'">
                        <dt>
                            <img src="<?php echo $bus['pic']?input::site($bus['pic']):input::imgUrl('default_bheader.png','wechat'); ?>" /></dt>
                        <dd>
                            <h2><?php echo $bus['name']; ?></h2>
                            <h1 class="tb">
                                <span class="flex_1 distancs" id="<?php echo $bus['id']; ?>" loc="<?php echo $bus['lat'].','.$bus['lng']; ?>">
                                    <img style="width: 18px;" src="<?php echo input::imgUrl('wait.gif','wechat'); ?>">
                                </span>
                                <font><a class="tel" butitle="<?php echo $bus['name']; ?>" butel="<?php echo $bus['mobile']; ?>">电话咨询</a></font>
                            </h1>
                            <p>定位地址：<?php echo $bus['address']; ?></p>
                            <p>详细地址：<?php echo $bus['full_address']; ?></p>
                        </dd>
                    </dl>                    
                    <?php 
                    }                    
                    ?>
                </div>
                <?php 
                if(empty($business)){
                    echo "<img class='default' src=".input::imgUrl('list_default.png','wechat')."><p style='width: 100%;text-align: center;font-size:2em;'>商家列表为空</p>";
                }else{
                    if($total>10){
                        echo '<div class="more more2"><span onclick="more(1)">查看更多</span></div>';
                    
                    }else{        
                        echo '<div class="more more3">已到达页面底部</div>';
                    }
                }
                ?>
                <!---交易完成时隐藏-->
                <input type="hidden" name="itemId" id="itemId" value="<?php echo $itemId;?>">
            </div>            
            <div class="top_iosn"><a href="JavaScript:topIosn();"></a></div>
        </div>

    </div>
</div>
<style type="text/css">
.default{
    width: 70px;
    margin: auto;
    padding-top: 100px;
}
.more2,.more3{
    font-size: 2em;
}
</style>
<!--遮罩层-->
<div class="mask_box mask_box6" style="display: none"></div>
<!--弹出框-->
<div class="up up_box" id="up_box1" style="display: none">
    <div class="up_cen ">
        <p class="h3">电话咨询</p>
        <h1 class="two" id="butitle">福州经络通理疗馆工业路1号店<span>12345678901</span></h1>
        <h3 class="back_none">
            <a id="butel" href="tel:13955555701" class="mask_confirm">确认</a>
        </h3>
    </div>
</div>

<script>
    $(function () {
        //电话咨询浮框
        $('.edit_list a.tel').on('touchstart', function () {
            $('#butitle').html($(this).attr('butitle') + '<span>' + $(this).attr('butel') + '</span>');
            $('#butel').attr('href', 'tel:' + $(this).attr('butel'));
            open_box('#up_box1')
        });
    });
$(function(){
    get_range();
})
function get_range(){
    $("span[class='flex_1 distancs']").each(function(n,e){
        var str = $(e).attr('loc');
        $.post("<?php echo input::site('wechat/goods/get_range')?>",{'str':str},
            function(data){
                $(e).html(data);
            })
    })
}
// 查看更多
function more(n){
    var id = $("#itemId").val();

    $.post('<?php echo input::site("wechat/business/get_more");?>',{'page':n,'id':id},
        function(data){            
            if(data != ""){
                $(".edit_shop").append(data);
                $(".more>span").attr("onclick","more("+(n+1)+")");
                get_range();
            }
            if((n*10+10)>=<?php echo $total;?>){
                $(".more2").html("已到达页面底部");
            }
        })
}
</script>
