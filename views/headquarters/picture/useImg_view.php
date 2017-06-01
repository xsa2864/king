<!-- 我的图库 -->
<div class="up_box gallery_box" id="useImg_view" style="display: none; width: 790px;" modid="0">
    <h1 class="bold">我的图库<i class="close"></i></h1>
    <div class="gallery cf">
        <div class="gall_left">
            <div class="gall_h1 cf">
                <span class="sp1">添加</span>
                <span class="sp2">重命名</span>
                <span class="sp3">删除</span>
            </div>
            <div class="gall_h2 left_nav adve_list">
                <ul id="picCategory" class="middle_menus">
                    <?php
                    foreach($picCategory as $item)
                    {
                        echo '<li>
                                <a';
                        if($item->id==$fid)
                        {
                            echo ' class="open on"';
                        }
                        else if($item->id==$sid || $item->id==$tid)
                        {
                            echo ' class="open"';
                        }
                        echo ' style="cursor:pointer;" name="'.$item->id.'">';
                        if($item->child) echo '<em></em>';
                        $ca = array();
                        if(strstr($item->childList, ','))
                        {
                            $ca = array_filter(explode(",",$item->childList));
                        }
                        else if($item->childList)
                        {
                            $ca[] = $item->childList;
                        }
                        $ca[] = $item->id;
                        $wh = array('cid in'=>$ca);
                        $total = M('picture')->getAllCount($wh);
                        echo $item->name.'（'.$total.'）</a>';
                        if($item->child)
                        {
                            echo '<ul class="left_sum" style="display: ';
                            if($item->id==$fid || $item->id==$sid || $item->id==$tid)
                            {
                                echo 'block';
                            }
                            else
                            {
                                echo 'none';
                            }
                            echo '">';
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
                                else if($ch1->childList)
                                {
                                    $ca[] = $ch1->childList;
                                }
                                $ca[] = $ch1->id;
                                $wh = array('cid in'=>$ca);
                                $total = M('picture')->getAllCount($wh);
                                echo $ch1->name.'（'.$total.'）</a>';
                                if($ch1->child)
                                {
                                    echo '<ul class="left_sum2" style="display: ';
                                    if($ch1->id==$fid || $ch1->id==$sid || $item->id==$tid)
                                    {
                                        echo 'block';
                                    }
                                    else
                                    {
                                        echo 'none';
                                    }
                                    echo '">';
                                    foreach($ch1->child as $ch2)
                                    {
                                        $ca = array();
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
        <div class="gall_right">
            <div class="gall_rh1 cf">
                <p>
                    <input type="checkbox" />全选
                </p>
                <p class="p2"><a id="upLoadImg">上传图片</a></p>
                <p class="p4">
                    <span>
                        <input id="selectText" type="text" /><i></i></span>
                    <span><a href="javascript:selectImg()">搜索</a></span>
                </p>
                <p class="p5"><a href="javascript:getImg()">使用所选图片</a></p>
            </div>
            <div class="gall_rh2 cf">
                <ul id="piclist" class="gall_list cf">
                    <?php
                    foreach($picList as $item)
                    {
                        if($item->pid)
                        {
                            echo '<li>
                                    	<div class="c1" ondblclick="javascript:openFile('.$item->id.')">
                                            <img src="'.input::imgUrl('imgs_03.png').'" width="88" height="83" />
                                            <span class="span_see">'.$item->name.'</span>
                                            <dl class="dl_see " style="display:none" >
                                                <dd class="wbk" style="display:none"><input type="text" /></dd>
                                            </dl>
                                         </div>
                                         
                                    </li>';
                        }
                        else
                        {
                            echo '<li id="'.$item->id.'">
                                <div class="c1">
                                    <img src="'.$item->pic.'" width="88" height="83" />
                                    <span class="span_see">'.$item->name.'</span>
                                    <dl class="dl_see " style="display: none">
                                        <dt><a class="a2" style="cursor:pointer;"></a><a class="a1" style="cursor:pointer;"></a></dt>
                                        <dd class="wbk" style="display: none">
                                            <input type="text" /></dd>
                                    </dl>
                                </div>
                                <div id="'.$item->id.'" class="ze_box" style="display: none">
                                    <span></span>

                                    <i></i>
                                </div>
                            </li>';
                        }
                    }
                    ?>

                </ul>
            </div>
            <div class=" cf bottom_page">
            </div>

        </div>

    </div>
</div>
<script type="text/javascript">
    var catFn;
    var reNameFn;
    $(function () {
        // 添加分类
        $('.gall_h1 .sp1').click(function () {
            var selEl = $(this).parents('.gall_left:first').find('.middle_menus li a.on');
            var id = 0;
            if (selEl.length > 0) {
                id = selEl.attr('name');
            }
            $.post("<?php echo input::site('admin/picture/addCategory') ?>", { 'id': id },
                function (data) {
                    var da = eval('('+data+')');
                    if (da.success == 1) {
                        $('#picCategory').html(da.html);
                        $('.middle_menus li a').click(catFn);
                        $('.middle_menus li a').dblclick(function () {
                            $(this).parents('li:first').trigger('rename'); // 双击重命名	
                        });
                        $('.middle_menus li').bind('rename', reNameFn);

                        $.post("<?php echo input::site('admin/picture/getPic') ?>", { 'id': id }, function (data) {
                            var da = eval('('+data+')');
                            if (da.success == 1) {
                                $('.gall_list').html(da.ht);

                                //图片选择效果
                                $('.gall_list li img').click(function () {
                                    if ($(this).parents('.gall_list li').find('.ze_box').is(":hidden ")) {
                                        $(this).parents('.gall_list li').find('.ze_box').show();
                                    }
                                    else {
                                        $(this).parents('.gall_list li').find('.ze_box').hide();
                                    }
                                });
                                //图片选择效果
                                $('.ze_box').click(function () {
                                    $(this).hide();
                                });
                                $('.gall_rh1 input[type=checkbox]').attr('checked', false);
                                $('#selectText').val('');
                            }
                            else {
                            }
                        });
                    }
                    else {
                        alert(da.msg);
                    }
                });
        });

        // 删除
        $('.gall_h1 .sp3').click(function () {
            var selEl = $(this).parents('.gall_left:first').find('.middle_menus li a.on');
            var nid = 0;
            if (selEl.length <= 0) {
                alert('请先选择需要删除的分类');
            } else {
                confirm('该类别下的所有图片将会被删除，确认删除吗？')
                var id = selEl.attr('name');
                $.post("<?php echo input::site('admin/picture/deleteCategory') ?>", { 'id': id },
                function (data) {
                    var da = eval('('+data+')');
                    if (da.success == 1) {
                        $('#picCategory').html(da.html);
                        $('.middle_menus li a').click(catFn);
                        $('.middle_menus li a').dblclick(function () {
                            $(this).parents('li:first').trigger('rename'); // 双击重命名	
                        });
                        $('.middle_menus li').bind('rename', reNameFn);

                        $.post("<?php echo input::site('admin/picture/getPic') ?>", { 'id': da.nid }, function (data) {
                            var da = eval('('+data+')');
                            if (da.success == 1) {
                                $('.gall_list').html(da.ht);

                                //图片选择效果
                                $('.gall_list li img').click(function () {
                                    if ($(this).parents('.gall_list li').find('.ze_box').is(":hidden ")) {
                                        $(this).parents('.gall_list li').find('.ze_box').show();
                                    }
                                    else {
                                        $(this).parents('.gall_list li').find('.ze_box').hide();
                                    }
                                });
                                //图片选择效果
                                $('.ze_box').click(function () {
                                    $(this).hide();
                                });
                                $('.gall_rh1 input[type=checkbox]').attr('checked', false);
                                $('#selectText').val('');
                            }
                            else {
                            }
                        });
                    }
                    else {
                        alert(da.msg);
                    }
                });
            }
        });
        //图片选择效果
        $('.gall_list li img').click(function () {
            if ($(this).parents('.gall_list li').find('.ze_box').is(":hidden ")) {
                $(this).parents('.gall_list li').find('.ze_box').show();
            }
            else {
                $(this).parents('.gall_list li').find('.ze_box').hide();
            }
        });
        //图片选择效果
        $('.ze_box').click(function () {
            $(this).hide();
        });
        //点击全选
        $('.gall_rh1 input[type=checkbox]').click(function () {
            $('.ze_box').toggle();
        })
        //中间分类树
        catFn = function () {
            var el = $(this).next(); // 获取子级容器
            if (el.is('ul')) {
                el.toggle();
                $(this)[el.is(':hidden') ? 'removeClass' : 'addClass']('open');
            } else {
                $(this).toggleClass('open');
            }
            $('.middle_menus li a').removeClass('on');
            $(this).addClass('on');
            var id = $(this).attr('name');
            $.post("<?php echo input::site('admin/picture/getPic') ?>", { 'id': id },
                function (data) {
                    var da = eval('('+data+')');
                    if (da.success == 1) {
                        $('.gall_list').html(da.ht);

                        //图片选择效果
                        $('.gall_list li img').click(function () {
                            if ($(this).parents('.gall_list li').find('.ze_box').is(":hidden ")) {
                                $(this).parents('.gall_list li').find('.ze_box').show();
                            }
                            else {
                                $(this).parents('.gall_list li').find('.ze_box').hide();
                            }
                        });
                        //图片选择效果
                        $('.ze_box').click(function () {
                            $(this).hide();
                        });
                        $('.gall_rh1 input[type=checkbox]').attr('checked', false);
                        $('#selectText').val('');
                    }
                    else {
                    }
                });
        };
        $('.middle_menus li a').click(catFn);
        $('.middle_menus li a').dblclick(function () {
            $(this).parents('li:first').trigger('rename'); // 双击重命名	
        });
        // 重命名
        reNameFn = function () {
            var el = $(this),
                a = el.find('>a'),
                em = a.find('em').length ? '<em></em>' : '';
            var input = $('<input type="text">');
            var num = a.text().match(/（\d+）/);
            var id = a.attr('name');
            input.width(a.width() - 2).height(a.height() - 2).css({
                'position': 'absolute',
                'border': '1px solid #dcdcdc',
                'left': parseInt(a.css('padding-left') || 50),
                'z-index': '2'
            }).val(a.text().replace(/（\d+）/, ''))
            input.blur(function () {
                var that = this;
                var value = $(that).val();
                if (!value) {
                    alert('必须填写分类名称');
                    setTimeout(function () { $(that).focus(); }, 100);
                    return false;
                } else {
                    $.post("<?php echo input::site('admin/picture/renameCategory') ?>", { 'id': id, 'name': value }, function (data) {
                    var da = eval('('+data+')');
                    if (da.success == 1) {
                        a.html(em + value + num);
                        $(that).remove();
                    }
                    else {
                        alert(da.msg);
                        $(that).focus();
                        return false;
                    }
                });
            }
            });
            el.prepend(input);
            input.focus();
            return false;
        };
        $('.middle_menus li').bind('rename', reNameFn);
        $('.gall_h1 .sp2').click(function () {
            var selEl = $(this).parents('.gall_left:first').find('.middle_menus li a.on');
            if (selEl.length <= 0) {
                alert('请先选择需要重命名的分类');
            } else {
                selEl.parents('li:first').trigger('rename');
            }
        });
        var uploader = WebUploader.create({

            // 选完文件后，是否自动上传。
            auto: true,

            // swf文件路径
            swf: '<?php echo input::jsUrl('Uploader.swf')?>',

            // 文件接收服务端。
            server: '<?php echo input::site('admin/swfupd/saveUploadImg');?>',

            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: '#upLoadImg',

            fileSingleSizeLimit: 1048576,

            // 只允许选择图片文件。
            accept: {
                title: 'Images',
                extensions: 'jpg,jpeg,png',
                mimeTypes: 'image/*'
            }
        });

        //上传
        uploader.on('uploadAccept', function (a, b, c) {
            var da = JSON.parse(b._raw);
            if (da.success == 1) {
                var selEl = $('#picCategory').find('li a.on');
                var id = 0;
                if (selEl.length <= 0) {
                } else {
                    id = selEl.attr('name');
                }
                $.post("<?php echo input::site('admin/picture/savePic') ?>", { 'id': id, 'img': da.url },
                function (data) {
                });
                return true;
            }
            else {
                return false;
            }
        });

        uploader.on('uploadFinished', function () {
            var id = 0;
            var selEl = $('#picCategory').find('li a.on');
            if (selEl.length <= 0) {
            } else {
                id = selEl.attr('name');
            }
            $.post("<?php echo input::site('admin/picture/getPic') ?>", { 'id': id },
                function (data) {
                    var da = eval('('+data+')');
                    if (da.success == 1) {
                        $('.gall_list').html(da.ht);

                        //图片选择效果
                        $('.gall_list li img').click(function () {
                            if ($(this).parents('.gall_list li').find('.ze_box').is(":hidden ")) {
                                $(this).parents('.gall_list li').find('.ze_box').show();
                            }
                            else {
                                $(this).parents('.gall_list li').find('.ze_box').hide();
                            }
                        });
                        //图片选择效果
                        $('.ze_box').click(function () {
                            $(this).hide();
                        });
                        $('.gall_rh1 input[type=checkbox]').attr('checked', false);
                        $('#selectText').val('');
                    }
                    else {
                    }
                });
        });
    });

    function selectImg() {
        var name = $('#selectText').val();
        if (name) {
            var id = 0;
            var selEl = $('#picCategory').find('li a.on');
            if (selEl.length <= 0) {
            } else {
                id = selEl.attr('name');
            }
            $.post("<?php echo input::site('admin/picture/getPic') ?>", { 'id': id, 'select': name },
                function (data) {
                    var da = eval('('+data+')');
                    if (da.success == 1) {
                        $('.gall_list').html(da.ht);

                        //图片选择效果
                        $('.gall_list li img').click(function () {
                            if ($(this).parents('.gall_list li').find('.ze_box').is(":hidden ")) {
                                $(this).parents('.gall_list li').find('.ze_box').show();
                            }
                            else {
                                $(this).parents('.gall_list li').find('.ze_box').hide();
                            }
                        });
                        //图片选择效果
                        $('.ze_box').click(function () {
                            $(this).hide();
                        });
                        $('.gall_rh1 input[type=checkbox]').attr('checked', false);
                    }
                });
        }
    }

    function openFile(id) {
        $.post("<?php echo input::site('admin/picture/getCategory') ?>", { 'id': id }, function (data) {
            var da = eval('('+data+')');
            if (da.success == 1) {
                $('#picCategory').html(da.html);
                $('.middle_menus li a').click(catFn);
                $('.middle_menus li a').dblclick(function () {
                    $(this).parents('li:first').trigger('rename'); // 双击重命名	
                });
                $('.middle_menus li').bind('rename', reNameFn);
            }
        });

        $.post("<?php echo input::site('admin/picture/getPic') ?>", { 'id': id },
                function (data) {
                    var da = eval('('+data+')');
                    if (da.success == 1) {
                        $('.gall_list').html(da.ht);

                        //图片选择效果
                        $('.gall_list li img').click(function () {
                            if ($(this).parents('.gall_list li').find('.ze_box').is(":hidden ")) {
                                $(this).parents('.gall_list li').find('.ze_box').show();
                            }
                            else {
                                $(this).parents('.gall_list li').find('.ze_box').hide();
                            }
                        });
                        //图片选择效果
                        $('.ze_box').click(function () {
                            $(this).hide();
                        });
                        $('.gall_rh1 input[type=checkbox]').attr('checked', false);
                        $('#selectText').val('');
                    }
                    else {
                    }
                });
    }
</script>
