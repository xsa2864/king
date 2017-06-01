<!--请选择移动的文件夹--->
<div class="up_box add_box" id="moveImg_view" style="display: none; width: 290px;">
    <h1 class="bold">请选择移动的文件夹<i class="close"></i></h1>
    <div class="list_content">
        <div class="gall_h2 left_nav adve_list">
            <ul class="middle_menus">
                <?php
                foreach($picCategory as $item)
                {
                    echo '<li>
                                <a';
                    echo ' style="cursor:pointer;" name="'.$item->id.'">';
                    if($item->child) echo '<em></em>';
                    $ca = array();
                    if(strstr($item->childList, ','))
                    {
                        $ca = array_filter(explode(",",$item->childList));
                    }
                    $ca[] = $item->id;
                    $wh = array('cid in'=>$ca);
                    $total = M('picture')->getAllCount($wh);
                    echo $item->name.'（'.$total.'）</a>';
                    if($item->child)
                    {
                        echo '<ul class="left_sum" style="display: none">';
                        foreach($item->child as $ch1)
                        {
                            echo '<li>
                                        <a';
                            if($ch1->id==$fid)
                            {
                                echo ' class="open on"';
                            }
                            else if($ch1->id==$sid || $item->id==$tid)
                            {
                                echo ' class="open"';
                            }
                            echo ' style="cursor:pointer;" name="'.$ch1->id.'">';
                            if($ch1->child) echo '<em></em>';
                            $ca = array();
                            if(strstr($ch1->childList, ','))
                            {
                                $ca = array_filter(explode(",",$ch1->childList));
                            }
                            $ca[] = $ch1->id;
                            $wh = array('cid in'=>$ca);
                            $total = M('picture')->getAllCount($wh);
                            echo $ch1->name.'（'.$total.'）</a>';
                            if($ch1->child)
                            {
                                echo '<ul class="left_sum2" style="display: none">';
                                foreach($ch1->child as $ch2)
                                {
                                    $ca = array();
                                    if(strstr($ch2->childList, ','))
                                    {
                                        $ca = array_filter(explode(",",$ch2->childList));
                                    }
                                    $ca[] = $ch2->id;
                                    $wh = array('cid in'=>$ca);
                                    $total = M('picture')->getAllCount($wh);
                                    $cl = '';
                                    if($ch2->id==$fid)
                                    {
                                        $cl = ' class="on"';
                                    }
                                    echo '<li><a'.$cl.' style="cursor:pointer;" name="'.$ch2->id.'">'.$ch2->name.'（'.$total.'）</a></li>';
                                }
                                echo '</ul>';
                            }
                            echo '</li>';
                        }
                        echo '</ul>';
                    }
                    echo '</li>';
                }
                ?>
            </ul>
        </div>
    </div>
    <div class="btn_two btn_width cf">
        <a class="a1 close" style="cursor: pointer;" onclick="moveImg()">保存</a><a class="close" style="cursor: pointer;">取消</a>
    </div>

</div>
<script>
    function moveImg() {
        var on = $('#moveImg_view').find('.middle_menus li a.on').attr('name');
        $('.ze_box').each(function () {
            if ($(this).attr('style') == 'display: block;' || $(this).attr('style') == '') {
                var id = $(this).attr('id');                
                $.post("<?php echo input::site('admin/picture/moveImg') ?>", { 'id': id, 'on': on }, function (data) {
                    var da = JSON.parse(data);
                    if (da.success == 1) {
                        location.replace(location.href);
                    }
                    else {
                        alert(da.msg);
                    }
                });
            }
        });
    }
</script>
