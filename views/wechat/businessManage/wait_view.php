<header class="header buys pad0">
        <div class="favorites">
            <?php 
            if($type != 'apply'){
            ?>
            <p><a class="return" href="<?php echo input::site("wechat/businessManage/apply_view")."?type=again";?>">
            <i></i>申请加入拓客</a>
            </p>
            <?php 
            }
            ?>            
        </div>
    </header>
    <div class="container pad1">
        <div class="order_box">
            <div class="add_box">
            <?php 
            if($type == 'apply'){
            ?>
                <div class="success">
                    <p class="suc"><span></span></p>
                    <font class="text">您已提交申请，请耐心等待。</font>
                </div><!--加入成功-->
            <?php 
            }
            ?>
            <?php 
            if($type == 'refuse'){  //
            ?>
                <div class="ailure">
                    <p class="suc"><span></span></p>
                    <font class="text">您申请审核不通过，原因：<?php echo $reason;?>。请重新提交申请或者联系客服<a href="tel:<?php echo $tel;?>"><?php echo $tel;?></a>。</font>
                    <div class="ck_btn"><!---加入失败时显示-->
                        <h3 class="back_none btn_red2">
                            <a class="mask_confirm" href="<?php echo input::site("wechat/businessManage/apply_view")."?type=again";?>">重新申请</a>
                        </h3>
                    </div>
                
                </div>
                <!--加入失败-->
            <?php 
            }
            ?>   
            <?php 
            if($type == 'close'){
            ?>
                <div class="ailure">
                    <p class="suc"><span></span></p>
                    <font class="text">您的店铺被关闭了，原因：<?php echo $reason;?>。请重新提交申请或者联系客服<a href="tel:<?php echo $tel;?>"><?php echo $tel;?></a>。</font>
                    <div class="ck_btn"><!---加入失败时显示-->
                        <h3 class="back_none btn_red2">
                            <a class="mask_confirm" href="<?php echo input::site("wechat/businessManage/apply_view")."?type=again";?>">重新申请</a>
                        </h3>
                    </div>
                
                </div>
                <!--加入失败-->
            <?php 
            }
            ?>
            </div>
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
        });
    });
 
 </script>