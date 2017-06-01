<script type="text/javascript">
// 会员详情
function member_detail(id){
   if(id>0){
       var str = '<?php echo input::site("wechat/businessManage/member_detail");?>';
       location.href = str+"/"+id;
   }
}
</script>
    <header class="header buys pad0">
        <div class="favorites">
            <p><a class="return" href="javascript:history.go(-1);"><i></i>会员列表（<?php echo $total;?>）</a></p>
        </div>
    </header>
    <div class="container pad1">
        <div class="order_box">
            <ul class="search_nav member2_list tb">
                <li class="flex_1 on">
                    <a href="javascript:;" onclick="orderby(this,'amount','asc')"><em class="iosn"></em>收益高低<i class="i2"></i></a></li>
                <li class="flex_1">
                    <a href="javascript:;" onclick="orderby(this,'loginTime','desc')"><em class="iosn"></em>使用时间<i class="i2"></i></a></li>
                <li class="flex_1">
                    <a href="javascript:;" onclick="orderby(this,'nickname','asc')"><em class="iosn"></em>昵称<i class="i2"></i></a></li>
            </ul>
            <div class="member2_cen">
                <?php 
                if(!empty($list)){
                    foreach ($list as $key => $value) { 
                        $hs = tuoke_ext::get_ms_info($value->id,$tkb_id);   
                        $lasttime = tuoke_ext::lasttime($tkb_id,$value->id);           
                    ?>
                    <div class="toker_order member2_box" onclick="member_detail(<?php echo $value->id;?>)">
                        <dl class="toker_dl">
                            <dt><img src="<?php echo $value->head_img;?>" width="100%" height="100%" /></dt>
                            <dd>
                                <span class="f32"><?php echo (empty($value->nickname)?'佚名':json_decode($value->nickname));?></span>
                                <a href="#" style="display:none;">微信联系</a>
                            </dd>
                        </dl>
                        <h1>
                            Ta已经在店里消费了<?php echo $hs['total'];?>笔订单，
                            共计¥<?php echo $hs['sum'];?>，为您带来收益<font>¥<?php echo $hs['amount'];?>。</font>
                        </h1>
                        <h2 class="f28">最近使用时间：<?php echo $lasttime>0?date('Y-m-d H:i:s',$lasttime):'';?></h2>
                    </div>
                <?php 
                    }                    
                }else{
                    echo "<img class='default' src=".input::imgUrl('list_default.png','wechat').">
                    <p style='width: 100%;text-align: center;font-size:2em;'>会员列表为空</p>";
                }
                ?>
            </div>   
            <?php
            if(!empty($list)){
                if($total>10){
                    echo '<div class="more more2"><span onclick="more(1)">查看更多</span></div>';
                
                }else{        
                    echo '<div class="more more3">已到达页面底部</div>';
                }
            }
            ?>       
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
        // $('.member2_cen').hide().eq(ind).show();
        
    });
});
// 查看更多
function more(n,name,key){
    $.post('<?php echo input::site("wechat/businessManage/more_memberlist");?>',{'name':name,'key':key,'page':n},
        function(data){            
            if(data != ""){    
                var num = n+1;
                $(".member2_cen").append(data);
                $(".more>span").attr("onclick","more("+num+",'"+name+"','"+key+"')")
            }
            if((n*10+10)>=<?php echo $total;?>){
                $(".more2").html("已到达页面底部");
            }
        })
}
// 排序
function orderby(str,name,key){    
    if(key == 'desc'){
        key = 'asc';
    }else{
        key = 'desc';
    }
    $(str).attr('onclick',"orderby(this,'"+name+"','"+key+"')");
    $.post('<?php echo input::site("wechat/businessManage/more_memberlist");?>',{'name':name,'key':key,'page':0},
        function(data){            
            if(data != ""){    
                $(".member2_cen").html(data);
                $(".more>span").attr("onclick","more(1,'"+name+"','"+key+"')");
            }   
            if(10 > <?php echo $total;?>){
                $(".more2").html("已到达页面底部");
            }         
        })
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