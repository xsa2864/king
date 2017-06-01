    <header class="header buys pad0">
        <div class="favorites">
            <p><a class="return" href="javascript:history.go(-1);"><i></i>订单列表(<?php echo $total;?>笔)</a></p>
        </div>
    </header>
    <div class="container pad1">
    	<div class="order_box member2_details">
            <div class="toker_store back3">
                <div class="commodity_list pad_none" style="height:auto;">
                <?php
                if(!empty($orderlist)){
                    foreach ($orderlist as $key => $value) {
                ?>
                	<div class="business order_h3 ">
                    	<h5 class="tb">
                            <span class="flex_1">订单编号:<?php echo $value->code;?></span>
                            <span>
                            <?php 
                            if($value->paystatus == -1){
                                echo "关闭";
                            }else if($value->paystatus == 0){
                                echo "待支付";
                            }else{
                                if($value->is_use == 0){
                                    echo "待使用";
                                }elseif($value->is_use == 1){
                                    echo "交易完成";
                                }elseif($value->is_use == -1){
                                    echo "申请退款";
                                }elseif($value->is_use == -2){
                                    echo "完成退款";
                                }
                            }
                            ?>
                            </span>
                        </h5>
                        <dl class="list_dl order_dl tb" onclick="show_detail(<?php echo "$value->id";?>)">
                            <dt ><img src="<?php echo input::site($value->pic);?>"/></dt>
                            <dd class="flex_1">
                                <h1><?php echo $value->title;?></h1>
                                <div class="list_text pad">
                                    <h3><font>￥</font><?php echo $value->price;?></h3> 
                                </div>
                            </dd>
                        </dl>
                        <div class="toker_order member2_box">
                        	<h2 class="f28">消费时间：<?php echo date('Y-m-d H:i:s',$value->addtime);?></h2>
                            <dl class="toker_dl pad_20">
                                <dt><img src="<?php echo $value->head_img;?>" width="100%" height="100%" /></dt>
                                <dd>
                                    <span class="f32"><?php echo json_decode($value->nickname);?></span>
                                    <a href="#" style="display:none;">微信联系</a>
                                </dd>
                            </dl>

                        </div>
                    </div>
                <?php
                    }

                    if($total>10){
                        echo '<div class="more more2" style="display:none;"><span onclick="more(1)">查看更多</span></div>';
                    
                    }else{        
                        echo '<div class="more more3">已到达页面底部</div>';
                    }
                }else{
                    echo "<img class='default' src=".input::imgUrl('list_default.png','wechat')."><p style='width: 100%;text-align: center;font-size:2em;'>订单列表为空</p>";
                }
                ?>
                </div>
                
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
<script>
$(function(){
	//标签
	$('.search_nav li').on('touchstart',function(){
		var ind=$('.search_nav li').index(this);
		$('.search_nav li').removeClass('on');
		$(this).addClass('on');
		$('.member2_cen').hide().eq(ind).show();
		
	});
	//查看更多
	// $('.commodity_list').height($(window).height()*0.78);
	// $('.more span').on('touchstart',function(){
	// 	$(this).parents('.toker_store').find('.pad_none').css('height','auto')	
	// });

});
// 查看更多
function more(n){
    $.post('<?php echo input::site("wechat/businessManage/more_orderlist");?>',{'page':n},
        function(data){            
            if(data != ""){
                $(".commodity_list").append(data);
                $(".more>span").attr("onclick","more("+(n+1)+")")
            }
            if((n*10+10)>=<?php echo $total;?>){
                $(".more2").html("已到达页面底部");
            }
        })
}
// 查看详情
function show_detail(id){
    var str = '<?php echo input::site("wechat/businessManage/show_detail");?>';
    if(id>0){
        location.href = str+'/'+id;
    }
}
$(window).scroll(function(){
　　var scrollTop = $(this).scrollTop();
　　var scrollHeight = $(document).height();
　　var windowHeight = $(this).height();

    if(scrollTop > 0){
    　　$(".more2").attr("style","display:block;");
    }else{
        $(".more2").attr("style","display:none;");
    }    
});
</script>