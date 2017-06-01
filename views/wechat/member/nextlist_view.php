<header class="header buys pad0">
    <div class="favorites">     
        <a class="return" href="javascript:history.back();" style="width:100%">
            <i></i><?php if(!empty($nickname)){echo $nickname.'的';}else{echo '团队';}?>伙伴(<?php echo $total?>)
        </a>     
    </div>
</header>
<div class="container pad1">
    <div class="order_box">
        <div class="toker_store">
            <div class="edit_cen">
                <div class="edit_shop" style="height:auto">
                    <?php 
                    foreach($list as $bus){ 
                    ?>
                    <dl class="edit_list" id="<?php echo $bus->id;?>">
                        <dt>
                            <img src="<?php echo $bus->head_img?$bus->head_img:input::imgUrl('default_bheader.png','wechat'); ?>" /></dt>
                        <dd>
                            <h2><?php echo json_decode($bus->nickname); ?></h2>                            
                        </dd>
                        <dd>
                            <h1 class="tb" style="float:right;">                                
                                <font>
                                <?php
                                if($level == 1){
                                ?>
                                <a href="<?php echo input::site('wechat/member/next_list')."?id=".$bus->id;?>">查看TA的伙伴 > </a>
                                <?php
                                }else{
                                    echo "<br>";
                                }
                                ?>
                                </font>
                            </h1>
                        </dd>
                        <div style="clear: both;"></div>
                    </dl>                    
                    <?php 
                    }                    
                    ?>
                </div>                
                <!---交易完成时隐藏-->
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

<script type="text/javascript">
    function back(){
        location.href=document.referrer;
    }
</script>
