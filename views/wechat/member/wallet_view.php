<header class="header buys pad0">
    <div class="favorites">
        <p><a class="return" href="JavaScript:history.back();"><i></i>收入明细</a></p>
    </div>
</header>
<div class="container">
    <div class="top">
        <h1>您的总资产：</h1>
        <h2><font>￥</font><?php echo sprintf('%.2f',$asset);?></h2>
        <dl class="h3">
            <dt>总资产=您所有的推广收入+已分红收入</dt>
        </dl>
    </div>
    <div class="wallet_cen">
        <div class="wallet_tont">
            <h1>上个月团队分红</h1>
            <h2><font>￥</font><?php echo sprintf('%.2f',$beforem);?></h2>
            <dl class="h3">
                <dt>已打款至您的微信钱包，请查收。</dt>
            </dl>
            <a href="<?php echo input::site('wechat/member/get_target');?>">上个月团队业绩达成情况></a>
        </div>
        <div class="wallet_tont">
            <h1>本月团队订单</h1>
            <dl class="h3">
                <dt>
                    <label class="list"><span class="islong" style="width:<?php echo $dividend->complete;?>"></span></label>
                </dt>
                <dt>
                    <label>已达成<?php echo $dividend->filter_num;?></label>
                    <label class="label1">还剩<?php echo $dividend->diff_num;?>台完成</label>
                </dt>
            </dl>
            <a href="<?php echo input::site('wechat/member/get_target/1');?>">本月团队业绩达成情况></a>
        </div>
    </div>
    <div class="wallet_cen b_more">
        <div class="wallet_tont">
            <h1>实时推广收入</h1>
            <h2><font>共计￥</font><?php echo sprintf('%.2f',$commission);?></h2>
            <dl class="h3">
                <dt>您的推广收入将实时以红包的形式发至您的微信，请及时查收!</dt>
            </dl>
            <ul class="content_list">
            <?php 
            foreach ($detail as $key => $value) {
                echo '<li>￥'.$value->price.'.00 ，来自'.json_decode($value->nickname).'的下单。<span class="content_list_right">'.date('m-d',$value->addtime).'</span></li>';
            }
            ?>                                
            </ul>
            <div>
                <?php 
                if(!empty($detail)){                    
                    if($is_more){
                        echo '<div class="more more_pay" ><span onclick="more(1)">查看更多</span></div>';
                    }else{
                        echo '<div class="more more_pay">已到达页面底部</div>';
                    }
                }else{
                    echo '<div class="more more_pay">还没有收入记录</div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
.my_ordercen .order_h3{
    margin-bottom: 8px;
}
.default{
    width: 80px;
    margin: auto;
    padding-top: 100px;
}
.more_all,.more_pay,.more_over,.more_use{
    font-size: 2em;
}
.container{
    padding-top: 0.5rem;
    line-height: 0.5rem;
}
.container dt{
    font-size: 0.25rem;
}
.container .top h1{
    display:inline-table;
    padding:1rem 0 0 0.5rem;
    color:#000;
    font-weight: bold;
    font-size: 0.35rem;
}
.container .top h2{
    font-size: 0.35rem;
    font-weight: bold;
    color:#ec5f1a;
    display:inline-table;
}
.container .top .h3{
    padding:0 0 0 0.5rem;
    color:#000;
    font-size: 0.25rem !important;
}
.container .wallet_cen{
    padding-left: 0.5rem;
}
.container .b_more{
    padding-top: 1rem;
}
.container .wallet_cen .wallet_tont{
    padding-top:0.5rem;
}
.container .wallet_cen .wallet_tont h1{
    display:inline-table;
    color:#000;
    font-weight: bold;
    font-size: 0.30rem;
}
.container .wallet_cen .wallet_tont h2{
    display:inline-table;
    padding-right: 10px;
    float: right;
    color:#ec5f1a;
    font-weight: bold;
    font-size: 0.30rem;
}
.container .wallet_cen .wallet_tont a{
    padding-right: 10px;
    float: right;
}
.container .wallet_cen .label1{
    padding-right: 22px;
    float: right;
}
.container .wallet_cen .list{
    display: block;
    height: 10px;
    width: 93%;
    border: 1px solid #ec5f1a;
    border-radius: 5px;
}
.container .wallet_cen .list .islong{
    background-color: #ec5f1a;
    display: block;
    height: 10px;
    width: 100%;
    border-radius: 3px;
}

.content_list{
    font-size: 0.25rem;    
}
.content_list_right{
    padding-right: 20px;
    float: right;
}
</style>

<script>
function more(n){
    $.post('<?php echo input::site("wechat/member/more_wallet")?>',{'page':n},
        function(data){
            var num = n+1;
            if(data.success == 1){
                $(".content_list").append(data.info);
                if(data.more==1){
                    $(".more_pay span").attr("onclick","more("+num+")");
                }else{
                    $(".more_pay").html("已到达页面底部");
                }
            }else{
                $(".more_pay").html("已到达页面底部");
            }
        },'json')
}

$(function () {
    if (history.length<=1)
    {
        $('.return').css('background-image', 'initial');
    }
    //点击按钮
    $(function () {
        $('.back_none').on('touchstart', function (e) {
            $(this).find('a').addClass('on');
            e.stopPropagation();;
        });
        $(document).on('touchend', function () {
            $('.back_none a.on').removeClass('on');
        });
    });
    //标签
    $('.order_ul li').on('touchstart', function () {
        var ind = $('.order_ul li').index(this);
        $('.order_ul li').removeClass('on');
        $(this).addClass('on');
        $('.detail_box').hide().eq(ind).show();
    });
});
</script>

