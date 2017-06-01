<script type="text/javascript" src="<?php echo input::jsUrl('webuploader.js');?>"></script>
<link type="text/css" href="<?php echo input::cssUrl('webuploader.css');?>" rel="stylesheet" />

<div class="back_right right_width">
    <div class="right">
        <h1>订单详情</h1>
        <div class="cen_box">
        <form>
            <div class="back_title bold">基本信息</div>
            <div class="bor_box">
                <dl class="cf">
                    <dt>订单号：</dt>
                    <dd>
                        <input type="text" name="code" readonly value="<?php echo $coupon->code;?>">
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>快递单号：</dt>
                    <dd>
                        <input type="text" name="express" readonly value="<?php echo $coupon->express;?>">
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>数量：</dt>
                    <dd>
                        <input type="text" name="number" readonly class="input_t" value="<?php echo $coupon->number;?>">
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>商品名称：</dt>
                    <dd>
                        <input type="text" name="item_title" readonly class="input_t" value="<?php echo $coupon->item_title;?>">
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>价格：</dt>
                    <dd>
                        <input type="text" name="price" readonly class="input_t" value="<?php echo $coupon->price;?>">
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>订单状态:</dt>
                    <span style="margin-left:10px;">
                    <?php 
                    if($coupon->paystatus==-1){
                        echo '关闭';
                    }else{
                        if($coupon->paystatus==0){
                            echo '待支付';
                        }else{
                            if($coupon->is_use == 0){
                                echo '待使用';
                            }elseif($coupon->is_use == 1){
                                echo '交易完成';
                            }
                        }
                    }
                    ?>                    
                    </span>
                </dl>
                <dl class="cf">
                    <dt>下单时间：</dt>
                    <dd>
                        <input type="text" name="addtime" readonly class="input_t" value="<?php echo $coupon->addtime>0?date('Y-m-d H:i:s',$coupon->addtime):'';?>">
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>付款时间：</dt>
                    <dd>
                        <input type="text" name="paytime" readonly class="input_t" value="<?php echo $coupon->paytime>0?date('Y-m-d H:i:s',$coupon->paytime):'';?>">
                    </dd>
                </dl>               
                <dl class="cf">
                    <dt>发货时间：</dt>
                    <dd>
                        <input type="text" name="usetime" readonly class="input_t" value="<?php echo $coupon->usetime>0?date('Y-m-d H:i:s',$coupon->usetime):'';?>">
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>收货时间：</dt>
                    <dd>
                        <input type="text" name="overtime" readonly class="input_t" value="<?php echo $coupon->overtime>0?date('Y-m-d H:i:s',$coupon->overtime):'';?>">
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>订单关闭时间：</dt>
                    <dd>
                        <input type="text" name="closetime" readonly class="input_t" value="<?php echo $coupon->closetime>0?date('Y-m-d H:i:s',$coupon->closetime):'';?>">
                    </dd>
                </dl>

                <dl class="cf">
                    <dt>用户获得佣金类别:</dt>
                    <span style="margin-left:10px;">
                    <?php 
                    if($coupon->mem_type==0){
                        echo '固定金额';
                    }else{
                        echo '百分比';
                    }
                    ?>                    
                    </span>
                </dl>
                <dl class="cf" style="padding-left:150px;">
                    <div>一级用户：<label><?php echo $coupon->mem_num1.($coupon->mem_type>0?'%':'元');?></label></div>
                    <div>二级用户：<label><?php echo $coupon->mem_num2.($coupon->mem_type>0?'%':'元');?></label></div>
                    <div>三级用户：<label><?php echo $coupon->mem_num3.($coupon->mem_type>0?'%':'元');?></label></div>
                </dl>
 
                <dl class="cf">
                    <dt>备注：</dt>
                    <dd>
                        <textarea rows="3" cols="65" readonly name="note"><?php echo $coupon->note;?></textarea>
                    </dd>
                </dl>                
            </div>
        </div>
        <div class="cen_box mar_15">            
            <div class="back_title bold">会员信息</div>
            <div class="bor_box"> 
            <?php 
            if(!empty($member)){                
            ?>
                <div>
                    <img src="<?php echo $member->head_img;?>" width=80>
                </div>  
                <div>
                    <label>昵称:</label>
                    <b><?php echo json_decode($member->nickname);?> </b>
                </div>    
                <div>
                    <label>openid:</label>
                    <b><?php echo $member->openId;?> </b>
                </div>      
            <?php  
            }else{
                echo "无";
            }
            ?>                
            </div>
        </div>        
        <div class="cen_box mar_15">            
            <div class="back_title bold">佣金信息</div>
            <div class="bor_box"> 
            <?php 
            if(!empty($commission)){
                foreach ($commission as $key => $value) {
            ?>
                <div>
                    <h3><?php echo  json_decode($value->nickname);?></h3>
                    <label><?php echo date('Y-m-d H:i:s',$value->addtime)."&nbsp;&nbsp;".$value->note.':'.$value->price;?>元</label>
                </div>         
            <?php    
                }  
            }
            ?>      
            <?php 
            if(!empty($bcommission)){                
            ?>
                <div>
                    <h3><?php echo  $bcommission->tkb_name;?></h3>
                    <label><?php echo date('Y-m-d H:i:s',$bcommission->addtime)."&nbsp;&nbsp;该店获得收益：".$bcommission->get_price;?>元</label>
                </div>         
            <?php    
                
            }
            ?>             
            </div>
        </div>
        </form>         
    </div>   
</div>

<style type="text/css">
.cf dt{
    width: 140px;
}
.input_t{
    width: 140px !important;
}
input,textarea{
        border: 0 !important;
}
.bor_box input{
    width: 450px !important;
}
</style>
