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
    <link rel="stylesheet" href="<?php echo input::cssUrl('after.css');?>" />
    <link rel="stylesheet" href="<?php echo input::cssUrl('default.css');?>" />
    <link rel="stylesheet" href="<?php echo input::cssUrl('admins.css');?>" />
    <link rel="stylesheet" href="<?php echo input::cssUrl('pagebutton.css');?>" />
    <script src="<?php echo input::jsUrl('jquery-1.11.3.min.js');?>"></script>
    <script src="<?php echo input::jsUrl('form/form.js');?>" type="text/javascript"></script>
    <script src="<?php echo input::jsUrl('home.js');?>" type="text/javascript"></script>
    <script src="<?php echo input::jsUrl('jquery.ztree.all-3.5.js');?>"></script>
    <script src="<?php echo input::jsUrl('bootstrap.min.js');?>"></script>
    <script src="<?php echo input::jsUrl('jquery.form.js');?>"></script>
    <script src="<?php echo input::jsUrl('main.js');?>" type="text/javascript"></script>
    <script type="text/javascript">
        var siteUrl = '<?php echo input::site();?>';
    </script>
    <script charset="utf-8" src="<?php echo input::jsUrl('kindeditor/kindeditor-all.js');?>"></script>
    <script type="text/javascript">
        var editor;
        KindEditor.ready(function (K) {
            editor = K.create('textarea[name="content"]', {
                resizeType: 1,
                minWidth: 500,
                allowPreviewEmoticons: false,
                allowImageUpload: true,
                uploadJson: '<?php echo input::site('admin/swfupd/saveUploadImg');?>',
             //   afterBlur:function(){this.sync();},
                items: [
                    'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
                    'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
                    'insertunorderedlist', '|', 'emoticons', 'multiimage', 'link']
            });
        });
        var siteUrl = '<?php echo input::site();?>';
    </script>
</head>
<body class="back_cc">
    <div class="back_cc">
        <div class="top_back">
            <div class="q">
                <div class="backstage_top cf">
                    <div class="back_logo">
                        <a href="<?php echo input::site('admin/display');?>">
                            <img src="<?php echo input::imgUrl('zhzh_logo.png');?>" width="120" />
                        </a>
                    </div>
                    <div class="back_nav_pott">
                        <ul class="back_nav cf">
                            <?php
                            foreach($menuList as $item)
                            {
                                echo '<li'.$item->classon.'><a href="'.input::site($item->app.'/'.$item->url).'" target="_self">'.$item->modName.'</a><span>|</span></li>';
                            }
                            ?>
                        </ul>
                        <div class="out_btn"><a href="<?php echo input::site('admin/logout');?>">退出</a></div>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .back_nav_pott{ position:relative;}
            .out_btn a{ font-size:14px; color:#ff0000; position:absolute; right:15px; top:0; line-height:47px; margin-top:5px;}
        
        
        </style>
        <div class="q">
            <div class="backstage_mian cf">
                <div class="back_left">
                    <h1 class="title"><span class="iosn"></span><span><?php echo $titleName;?></span></h1>
   
                    <ul id="left_menus" class="left_nav adve_list">
                        <?php
                        foreach($leftList as $item) {
                            if (!isset($item['second'])) {
                                $parent .=  '<li><a' . $item['classon'] . ' href="' . input::site($item['app'] . '/' . $item['url']) . '">' . $item['modName'] . '<i>></i></a></li>';
                            } else {
                                $second .= '<li>';
                                $second .=  '<a href="#" class="title_list"><em class=""></em>'.$item['modName'].'</a>';
                                $second .=  '<p '.$item['display'].' class="list_sum">';
                                foreach($item['second'] as $sec){
                                    $second .=  '<a href="'.input::site($sec['app'] . '/' . $sec['url']).'" '.$sec['classon'].'>'.$sec['modName'].'<i>&gt;</i></a>';
                                }
                                $second .=  '</p>';
                                $second .=  '</li>';
                            }
                        }
                        echo $parent;
                        echo $second;
                            ?>
                    </ul>
                </div>
                    <!--页面主体-->
                    <?php if (isset($content)) echo $content;?>
                    <!--页面主体end-->
            </div>
        </div>
    </div>
    <!--遮罩层-->
    <div class="mask_box" style="display: none"></div>
    <!--弹出框-->
    <?php if (isset($tipBoxContent1)) echo $tipBoxContent1;?>
    <?php if (isset($tipBoxContent2)) echo $tipBoxContent2;?>
    <?php if (isset($tipBoxContent3)) echo $tipBoxContent3;?>
    <!--弹出框end-->    
</body>
</html>
