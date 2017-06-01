<header class="header buys pad0">
    <div class="favorites">
        <p><a class="return" href="JavaScript:history.back();"><i></i><?php echo $day;?>团队业绩达成情况</a></p>
    </div>
</header>
<div class="container">
    <?php
    if(!empty($list)){
    ?>
    <div class="top">        
        <dl class="h3">
            <dt>您的团队伙伴<?php echo $day;?>业绩达成率<?php echo $rate;?>，其中</dt>
        </dl>
    </div>
    <div class="wallet_cen">
    <?php     
    foreach ($list as $key => $value) {       
    ?>
        <div class="wallet_tont">
            <h1><?php echo json_decode($value->nickname);?>团队  </h1>
            <dl class="h3">
                <dt>
                    <label class="list"><span class="islong" style="width:<?php echo $value->complete;?>"></span></label>
                </dt>
                <dt>
                    <label>已达成<?php echo $value->filter_num;?></label>
                    <label class="label1">还剩<?php echo $value->diff_num;?>台完成</label>
                </dt>
            </dl>            
        </div>
    <?php
    }    
    ?>
    </div>
    <?php
    }else{
        echo "<div style='text-align: center;font-size:0.3rem;'>您还没有团队完成记录</div>";
    }
    ?>
</div>
<style type="text/css">
.container{
    padding-top: 1.35rem;
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
.container .top .h3{
    padding:0 0 0 0.5rem;
    color:#000;
    font-size: 0.25rem !important;
}
.container .wallet_cen{
    padding-left: 0.5rem;
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


