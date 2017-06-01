<div class="share_top">
    <div class="share_h1" style="background: initial;">
        <p>拓客共享商城</p>
        <h2>
            <a style="display: none" href="http://www.tpy10.net/create.php?name=hzcs168" class="gotosee">进入拓客</a>
        </h2>
        <img src="<?php echo input::imgUrl('fenxiang_03.png','wechat');?>" style="width:100%;height:100%;left:0px;top:0px;z-index:-1;" />
        <img src="<?php echo input::imgUrl('fenxiang_03.png','wechat');?>" style="width:100%;height:100%;left:0px;top:0px;opacity:0.0;"/>
    </div>
</div>
<div class="box">
    <div class="toker">
        <div class="toker_h1">
            <i></i>
            <span><?php echo $higher;?></span>            
        </div>
        <div class="toker_h3" style="position: inherit;">
            <?php
            if(count($goodsList)==0){
                echo '<img itemId="'.$item->id.'" src="'.input::imgUrl("tokef.gif",'wechat').'" />';
            }else{
                foreach($goodsList as $key => $item)
                {            
                    if($item->index_img != ''){
                        $index_img = input::site($item->index_img);
                    }
                    echo '<img itemId="'.$item->id.'" src="'.$index_img.'" />';
                }
            }
            ?>           
            <span class="min_img" <?php if($message==''){echo 'style="display:none;"';};?>">
                <?php echo $message;?>                
            </span>
       </div>    
    </div> 
    <footer class="footer foot_bottom">
        <ul class="tb">
            <li class="flex_1 on">
                <a href="<?php echo input::site('wechat/main/index')?>"><em></em><i>首页</i></a>
            </li>
            <li class="flex_1">
                <a href="<?php echo input::site('wechat/member/wallet')?>"><em></em><i>收入明细</i></a>
            </li>
            <li class="flex_1">
                <a href="<?php echo input::site('wechat/order/index')?>"><em></em><i>我的订单</i></a>
            </li>
            <li class="flex_1">
                <a href="<?php echo input::site('wechat/member/index')?>"><em></em><i>个人中心</i></a>
            </li>
        </ul>
    </footer>
 </div>
<div class="share_top" style="margin-bottom:50px">
    <div class="share_h1" style="background: initial;">
        <p>拓客共享商城</p>
        <h2>
            <a style="display: none" href="http://www.tpy10.net/create.php?name=hzcs168" class="gotosee">进入拓客</a>
        </h2>
        <img src="<?php echo input::imgUrl('fenxiang_03.png','wechat');?>" style="width:100%;height:100%;left:0px;top:0px;z-index:-1;" />
        <img src="<?php echo input::imgUrl('fenxiang_03.png','wechat');?>" style="width:100%;height:100%;left:0px;top:0px;opacity:0.0;"/>
    </div>
</div>
<script>
    $(function () {
        $('div.box').css('z-index', 1);
        if ((navigator.userAgent.match(/(Android)/i))) {
            //$('.gotosee').show();
        }
    })
</script>