    <header class="header buys pad0">
        <div class="favorites">
            <p><a class="return" href="javascript:history.go(-1);"><i></i>会员详情</a></p>
        </div>
    </header>
    <div class="container pad1">
    	<div class="order_box member2_details">
            <div class="toker_order member2_box">
                <dl class="toker_dl">
                	<dt><img src="<?php echo $member->head_img;?>" width="100%" height="100%" /></dt>
                    <dd>
                    	<span class="f32"><?php echo empty($member->nickname)?'佚名':json_decode($member->nickname)?></span>
                       	<a href="#" style="display:none;">微信联系</a>
                    </dd>
                </dl>
                <h1>Ta已经在店里消费了<?php echo $hs['total'];?>笔订单，
                    共计¥<?php echo $hs['sum'];?>，
                    为您带来收益<font>¥<?php echo $hs['amount'];?>。</font>
                </h1>
            </div>
            <div class="toker_store back3">
            	<p class="h1 f362"><span class="iosn"></span>TA在本店的购买记录</p>
                <div class="commodity_list pad_none ">
                <?php 
                if(!empty($list)){
                    $num = count($list);
                    foreach ($list as $key => $value) {
                ?>
                	<div class="toker_details order_h3"  onclick="show_detail(<?php echo "$value->id";?>)">
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
                        <dl class="list_dl order_dl tb">
                            <dt ><img src="<?php echo input::site($value->pic);?>"/></dt>
                            <dd class="flex_1">
                                <h1><?php echo $value->title;?></h1>
                                <div class="list_text pad">
                                    <h3><font>￥</font><?php echo $value->price;?></h3> 
                                </div>
                            </dd>
                        </dl>
                        <h2 class="f28">最近使用时间：<?php echo $value->usetime?date('Y-m-d H:i:s',$value->usetime):'';?></h2>
                    </div>
                <?php 
                    }

                    if($total>10){
                        echo '<div class="more more2"><span onclick="more(1,'.$value->member_id.')">查看更多</span></div>';
                    
                    }else{        
                        echo '<div class="more more2">已到达页面底部</div>';
                    }
                }else{
                    echo "<img class='default' src=".input::imgUrl('list_default.png','wechat')."><p style='width: 100%;text-align: center;font-size:2em;'>会员列表为空</p>";
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
.more2{
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
	});

function show_detail(id){
    var str = '<?php echo input::site("wechat/businessManage/show_detail");?>';
    if(id>0){
        location.href = str+'/'+id;
    }
    return false;
}
// 查看更多
function more(n,id){
    $.post('<?php echo input::site("wechat/businessManage/get_more");?>',{'page':n,'id':id},
        function(data){            
            if(data != ""){   
                $(".more2").before(data);
                $(".more>span").attr("onclick","more("+(n+1)+","+id+")");               
            }
            if((n*10+10)>=<?php echo $total;?>){
                $(".more2").html("已到达页面底部");
            }
        })
}
</script>