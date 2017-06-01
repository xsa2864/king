<?php 
$config  =  C('siteConfig') or die("找不到站点配置文件"); 
?>
<!DOCTYPE html>
<html lang="cn">
<head>
    <title><?php echo $config['name']; ?> - 后台管理系统</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=9" />

    <link href="<?php echo input::cssUrl('home.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo input::cssUrl('backstage.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo input::cssUrl('public.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo input::jsUrl('form/form.css');?>" rel="stylesheet" type="text/css" />
    <style>
         #left_menus span>a{
            margin-left: 10px;
         }      
    </style>
</head>
<body class="back_cc">
    <div class="back_cc">
        <div class="top_back">
            <div class="q">
                <div class="backstage_top cf">
                    <div class="back_logo">
                        <a href="<?php echo input::site('admin/index');?>">
                            <img src="<?php echo input::imgUrl('zhzh_logo.png');?>" width="120" />
                        </a>
                    </div>
                    <div class="back_nav_pott">
                        <ul class="back_nav cf">
                            <?php
                            if(!empty($leftMenu)){
                                $class = "class='on'";
                                foreach ($leftMenu as $key => $value) {
                                    echo '<li '.$class.'><a href="'.input::site($value['app'].'/'.$value['child'][0]['url']).'" target="_self">'.$value['modName'].'</a><span>|</span></li>';
                                    $class ='';
                                }
                            }                         
                            ?>
                        </ul>
                        <div class="out_btn"><a href="<?php echo input::site('admin/logout');?>">退出</a></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="q">
            <div class="backstage_mian cf">
                <div class="back_left">
                    <h1 class="title"><span class="iosn"></span><span><?php echo $titleName;?></span></h1>
                   
                    <ul id="left_menus" class="left_nav adve_list">
                        <?php
                        if(!empty($leftMenu)){
                            foreach($leftMenu as $key=>$item) {
                                if($key>0){
                                    $second .= '<li>';
                                    $second .=  '<a href="#" class="title_list"><em class=""></em>'.$item['modName'].'</a>';
                                    $second .=  '<p '.$item['display'].' class="list_sum">';
                                    foreach($item['child'] as $sec){
                                        
                                        if(!empty($sec['child'])){
                                            $second .=  '<a href="#" style="font-weight: bolder;">'.$sec['modName'].'</a>'; 
                                            $second .=  '<span>'; 
                                            foreach($sec['child'] as $secs){
                                                $second .=  '<a href="'.input::site($secs['app'].'/'.$secs['url']).'">'.$secs['modName'].'<i>&gt;</i></a>';
                                            }
                                            $second .=  '</span>';
                                        }else{
                                            $second .=  '<a href="'.input::site($sec['app'].'/'.$sec['url']).'">'.$sec['modName'].'<i>&gt;</i></a>';
                                        }
                                    }
                                    $second .=  '</p>';
                                    $second .=  '</li>';
                                }
                            }
                            echo $second;
                        }

                        ?>
                    </ul>
                </div>
                    <!--页面主体-->
<div class="back_right">
    <div class="right">
        <h1><?php echo $userName.",欢迎您!";?></h1>
        <div class="cen_box classify">            
            <div class="edit_box cf">
            <div class="edit_box width95 pad15 cf">
            <div class="order_box2 " style="display: block">
                <div class=" member_cen">
                    <?php 
                    if(!empty($loc)){
                    ?>
                    <table class="thead tbody_cen">
                        <tr>
                            <th>未定位店铺<i></i></th>
                            <th>时间<i></i></th>                                                        
                        </tr>
                        <?php                        
                            foreach($loc as $key => $item){ 
                        ?>
                        <tr>
                            <td>
                                <?php echo $item->id.':'.$item->name." 的店  导航未设置，请及时设置导航地址。"?>
                                <a href="<?php echo input::site('admin/business/add').'?id='.$item->id;?>">去设置</a>
                            </td>
                            <td><?php echo date("Y-m-d H:i:s",$item->addtime);?></td>                           
                        </tr>
                        <?php
                            }                        
                        ?>
                    </table>
                    <?php 
                    }
                    ?>

                    <?php 
                    if(!empty($member)){
                    ?>
                    <table class="thead tbody_cen">
                        <tr>
                            <th>会员佣金补发异常<i></i></th>
                            <th>时间<i></i></th>                                                        
                        </tr>
                        <?php                        
                            foreach($member as $key => $item){ 
                        ?>
                        <tr>
                            <td>
                                <?php echo $item->id.':'.json_decode($item->nickname)." 佣金补发异常,请处理。"?>
                                <a href="<?php echo input::site('admin/log/commission');?>">去处理</a>
                            </td>
                            <td><?php echo date("Y-m-d H:i:s",$item->addtime);?></td>                           
                        </tr>
                        <?php
                            }                        
                        ?>
                    </table>
                    <?php 
                    }
                    ?>

                    <?php 
                    if(!empty($business)){
                    ?>
                    <table class="thead tbody_cen">
                        <tr>
                            <th>店铺红包补发异常<i></i></th>
                            <th>时间<i></i></th>                                                        
                        </tr>
                        <?php                        
                            foreach($business as $key => $item){ 
                        ?>
                        <tr>
                            <td>
                                <?php echo $item->id.':'.$item->tkb_name." 店铺红包补发异常,请处理。"?>
                                <a href="<?php echo input::site('admin/finance/show_consume').'?id='.$item->id;?>">去处理</a>
                            </td>
                            <td><?php echo date("Y-m-d H:i:s",$item->addtime);?></td>                           
                        </tr>
                        <?php
                            }                        
                        ?>
                    </table>
                    <?php 
                    }
                    ?>
                </div>
            </div>
            </div>
        </div>
    </div>

</div>                   
                    <!--页面主体end-->
            </div>
        </div>
    </div>
<style type="text/css">
.tbody_cen a{
    color:#072990;
    font-weight: bold;
}
</style>   
</body>
</html>
