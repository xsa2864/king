<header class="header buys pad0">
    <div class="favorites">
        <p><a class="return" href="javascript:history.back();"><i></i>关注伙伴(<?php echo $total?>)</a></p>
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
                        <br>
                        <br>         
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
