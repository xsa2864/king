<header class="header buys pad0">
        <div class="favorites">
            <p><a class="return" href="javascript:history.go(-1);"><i></i>订单详情</a></p>
        </div>
    </header>
    <div class="container pad1">
    	<div class="order_box">
        	<div class="order_h1">
            	<img src="<?php echo input::site('library/wechat/images/ioang6_02.png');?>"/>                
            </div>
            <div class="toker_order">
            	<p>购买账号</p>
                <dl class="toker_dl ">
                	<dt><img src="<?php echo $order->head_img;?>" width="100%" height="100%" /></dt>
                    <dd>
                    	<span class="f32"><?php echo json_decode($order->nickname);?></span>
                        <br>
                        <span class="f28" style="display:none;">微信号：<?php echo $order->wxname;?></span>
                        <a class="WeChat" href="#" style="display:none;">微信联系</a>
                    </dd>
                
                </dl>
            </div>
            <div class="order_h3">
                <div class="order_p1">
                	<div class="commodity_list">
                        <dl class="list_dl order_dl tb">
                            <dt ><img src="<?php echo input::site($order->pic);?>"/></dt>
                            <dd class="flex_1">
                                <h1><?php echo $order->title;?></h1>
                                <div class="list_text pad">
                                    <h3><font>￥</font><?php echo $order->price;?></h3> 
                                </div>
                            </dd>
                        </dl>
                        <h4 class="toker_text bor_bott2">
                        	<span class="f28">有效期：至
                            <?php
                            if($order->timetype == 0){
                                echo date('Y-m-d',strtotime("+$order->validtime day"));
                            }else{
                                echo $order->endtime?date('Y-m-d',$order->endtime):'';
                            }
                            ?>
                            </span>
                        </h4>
                    </div>
                </div>
                <div class="toker_number back2 bor_none">
                    <p>订单编号:<?php echo $order->code;?></p>
                    <p>创建时间:<?php echo $order->addtime>0 ? date('Y-m-d H:i:s',$order->addtime):'';?></p>
                    <p>付款时间:<?php echo $order->paytime>0 ? date('Y-m-d H:i:s',$order->paytime):'';?></p>
                    <p>消费时间:<?php echo $order->usetime>0 ? date('Y-m-d H:i:s',$order->usetime):'';?></p>
                </div>
            </div> 

            
        </div>
    </div> 

<!-- 遮罩层 -->
<div  class="mask_box" style="display:none"></div>
<!-- 弹出框 -->
<div  class="up up_box" id="up_box1" style="display:none">
    <div class="up_cen ">
        <p class="h3">电话咨询</p>
        <h1 class="two">福州经络通理疗馆工业路1号店<span>12345678901</span></h1>
        <h3 class="back_none">
            <a href="tel:13955555701" class="mask_confirm">确认</a>
        </h3>
    </div>
</div>
<div  class="up up_box" id="up_box3" style="display:none">
 	<div class="up_cen">
    	<h1>您确定要取消订单吗？</h1>
        <h2 class="up_btn tb">
        	<a class="flex_1 close" href="#">确认</a><a class="flex_1 close" href="#">取消</a>
        </h2>
    </div>
 
 </div>


<script>
 	$(function(){
		//点击按钮
		$(function(){
			$('.back_none').on('touchstart',function(e){
				$(this).find('a').addClass('on');
				e.stopPropagation();;
			});
			$(document).on('touchend',function(){
				$('.back_none a.on').removeClass('on');
			});
		})
		//查看更多
		$('.more span').on('touchstart',function(){
			$(this).parents('.edit_cen').find('.edit_shop').css('height','auto')	
		})
		//电话咨询浮框
		$('.edit_list a.tel').on('touchstart',function(){
			open_box('#up_box1')	
		});
		//取消订单
		$('#cancel').on('touchstart',function(){
			open_box('#up_box3')	
		});
	});
 
 </script>