<!--Header-part-->

<script>
    $(document).ready(function () {
        $(".left-side, .wrapper").css("height", $(window).height() - 50);
        $("#menu").attr("height", $(window).height() - 50);
        $(window).resize(function () {
            $(".left-side, .wrapper").css("height", $(window).height() - 50);
            $("#menu").attr("height", $(window).height() - 50);
        });
        $(".submenu .suba").click(function () {
            $(this).siblings("ul").stop();
            $(this).siblings("ul").slideToggle();
        });
    });
</script>

<div class="wrapper row-offcanvas row-offcanvas-left" style="overflow: hidden;">
    <div class="left-side sidebar-offcanvas" style="overflow: scroll; overflow-x: hidden">
        <div class="user-panel">
            <div class="pull-left image">
                <img alt="User Image" class="img-circle" src="<?php echo input::imgUrl("avatar2.png"); ?>">
            </div>
            <div class="pull-left info">
                <p>你好, <?php echo $_SESSION['userName'] ; ?></p>

                <a href="javascript:void(0)"><?php  echo date("Y-m-d H:i:s",time()); ?></a>
            </div>
        </div>
        <ul class="leftmenu list-group">
            <li class="list-group-item"><a target="menu" href="/admin/display/get_main/"><span>首页</span></a> </li>
            <?php
            foreach($data['tree'] as $key => $value){
                $listview = $classname = "";
                if (sizeof($value['child']) > 0) {
                    echo '<li class="submenu list-group-item"><a class="suba" href="javascript:void(0);"><span>'.$value['title'].'</span></a>';
                    foreach ( $value['child'] as $val ){
                        $target = 'menu';
                        if($val['title']=='退出系统')
                            $target = '_self';
                        $listview .= "<li><a target='".$target."' href='".$val['frameurl']."'><span>".$val['title']."</span></a></li>";
                    }
                    echo '<ul>'.$listview.'</ul>';
                }else{
                    echo '<li class="list-group-item"><a target="menu" href="'.$value['frameurl'].'"><span>'.$value['title'].'</span></a>';
                }
                echo '</li>';
            }
            ?>
        </ul>
    </div>
    <div class="right-side">
        <iframe src="/admin/display/get_main/" id="menu" name="menu" frameborder="0" scrolling="yes" style="visibility: inherit; width: 100%; z-index: 1; overflow: auto;"></iframe>
    </div>

</div>




