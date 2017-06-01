<header class="header buys pad0">
    <div class="favorites">
        <p><a class="return" href="JavaScript:history.back();"><i></i>收入明细</a></p>
    </div>
</header>
<div class="container">
    <div class="top">
        <div class="top_img">
            <img src="<?php echo $pic;?>">
            <div class="top_img_b"></div>
            <span><?php echo $number;?>件商品</span>
        </div>
        <div class="top_label">
            <label>物流状态 <?php echo $status;?></label><br>
            <label>承运公司 <?php echo $express['expTextName'];?></label><br>
            <label>运单编号 <?php echo $express['mailNo'];?></label><br>
            <label>官方电话 <span style="color:#369ebf"><?php echo $express['tel'];?></span></label>
        </div>
    </div>
    <div class="wallet_cen">
        <div class="wallet_tont">
        <?php
        if(!empty($express['data'])){
            $array = $express['data'];
            krsort($array);
            echo "<ul>";
            foreach ($array as $key => $value) {
                $str = '';
                $icon = " class='icon'";
                if($key == count($array)-1){
                    $icon = " class='icon_on'";
                    $str = " class='icon_ons'";
                }
                if($key == 0){
                    $str = " class='icon_none'";
                }                
                echo "<i $icon></i><li $str>".$value['context']."<br>".$value['time']."</li>";
            }
            echo "</ul>";
        }else{

        }        
        ?>
            
        </div>
    </div>
   
</div>
<style type="text/css">
.container{
    padding-top: 0.5rem;
    line-height: 0.5rem;
}
.container dt{
    font-size: 0.25rem;
}
.container .top{
    text-align: center;
    width: 95%;
    display:inline-table;
    padding:1rem 0 0.3rem 0.25rem;
    color:#000;
    border-bottom: 1px solid #d6cece;
    font-size: 0.26rem;
}
.container .top .top_img{
    height: 100px;
    float: left;
    width: 110px;
}
.container .top .top_img .top_img_b{
    height: 30px;
    display: block;
    top: -30px;
    background-color: #000;
    opacity: 0.2;
    position: relative;
}
.container .top .top_img span{
    position: relative;
    top: -60px;
    color: #FFFFFF;
}

.container .top .top_label{
    text-align: left;
    float: left;
    padding-left: 0.3rem;
}

.container .wallet_cen{
    padding-left: 0.5rem;
}
.container .b_more{
    padding-top: 1rem;
}
.container .wallet_cen .wallet_tont{
    padding-top:0.25rem;
}
.container .wallet_cen .wallet_tont ul{
    padding: 0 10px 0 0;
    font-size: 0.25rem;
}
.container .wallet_cen .wallet_tont ul li{
    color:#9c9c9c;
    padding: 0 10px 0.2rem 20px;
    font-size: 0.25rem;
    border-left: 0.05rem solid #d9d9d9;
    line-height: 0.4rem;
}    
.container .wallet_cen .wallet_tont ul i{
    position: absolute;
    left: 0.4rem;
    /*margin-top: 0.3rem;*/
    border-radius: 1rem;
}
.container .wallet_cen .wallet_tont ul .icon{
    display: block;
    height: 0.25rem;
    width: 0.25rem;
    background-color: #d9d9d9;
}
.container .wallet_cen .wallet_tont ul .icon_on{
    display: block;
    height: 0.3rem;
    width: 0.3rem;
    background-color: #369ebf;
    left: 0.37rem;
}
.container .wallet_cen .wallet_tont ul .icon_ons{
    color:#369ebf;
    border-left: 0.05rem solid #369ebf;
}
.container .wallet_cen .wallet_tont ul .icon_none{
    border:none;
}
</style>