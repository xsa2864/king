<form>
    <div class="back_right photo_right">
        <div class="right">
            <h1>我的图库</h1>
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
                                    echo '<ul class="left_sum" style="display: block">';
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
                        <p class="p3"><a style="cursor: pointer;" class="a1">移动图片到</a>|<a style="cursor: pointer;" onclick="JavaScript:deleteImg()">删除所选</a></p>
                        <p class="p4">
                            <span>
                                <input id="selectText" type="text" /><i></i></span>
                            <span><a href="JavaScript:selectImg()">搜索</a></span>
                        </p>
                        <!--<p class="p5"><a href="#">使用所选图片</a></p>-->
                    </div>
                    <div class="gall_rh2 cf">
                        <ul class="gall_list cf">
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
                        <div class="page">
                            <?php
                            echo $pagination->render();
                            ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</form>
<script type="text/javascript" src="<?php echo input::jsUrl('webuploader.js');?>"></script>
<link type="text/css" href="<?php echo input::cssUrl('webuploader.css');?>" rel="stylesheet" />
<script>
    $(function () {
        //分类标签
        $('.edit_title li').click(function () {
            var index = $('.edit_title li').index(this);
            $('.edit_title li').removeClass('curr');
            $('.edit_title b').show();
            $(this).addClass('curr').find('b').hide();
            $(this).prev().find('b').hide();
            $(".table_box table").hide().eq(index).show();
        });
        //全选
        $('.check_all,.check_all2').click(function () {
            var checked = $(this).is(':checked');
            $(this).parents('.add_cenz,.add_ceny').find('.add_list input[type=checkbox]').prop('checked', (checked ? 'checked' : false));
        });
        //弹出框
        $('.gall_rh1 .p3 .a1').click(function () {
            open_box('#moveImg_view')
        });
        //预览大图弹出框
        $('.dl_see .a1').click(function () {
            var src = $(this).parents('.c1:first').find('img').attr('src');
            var srclist = src.split("_");
            var src1 = srclist[1].split(".");
            var src = srclist[0] + '.' + src1[1];
            $('#showBig_view').find('img').attr('src', src);
            open_box('#showBig_view')
        });

        //图片上传
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
                var selEl = $('#picCategory').parents('.gall_left:first').find('.middle_menus li a.on');
                var id = 0;
                if (selEl.length <= 0) {
                } else {
                    id = selEl.attr('name');
                }
                $.post("<?php echo input::site('admin/picture/savePic') ?>", { 'id': id, 'img': da.url },
                function (data) {
                    var da = JSON.parse(data);
                    if (da.success == 1) {
                        //location.href = "<?php echo input::site('admin/picture/index/1/on/') ?>" + id;
                    }
                    else {
                        //alert(da.msg);
                    }
                });
                return true;
            }
            else {
                return false;
            }
        });

        uploader.on('uploadFinished', function () {

            location.replace(location.href);
        });

        //中间分类树
        var catFn = function () {
            var el = $(this).next(); // 获取子级容器
            if (el.is('ul')) {
                el.toggle();
                $(this)[el.is(':hidden') ? 'removeClass' : 'addClass']('open');
            } else {
                $(this).toggleClass('open');
            }
            if ($(this).parents('#moveImg_view:first').length) {
                $('.middle_menus li a').removeClass('on');
                $(this).addClass('on');
                return false;
            }
            if ($(this).hasClass('on')) {

            }
            else {
                var id = $(this).attr('name');
                location.href = "<?php echo input::site('admin/picture/index/1/on/') ?>" + id;
                //$('.middle_menus li a').removeClass('on');
                //$(this).addClass('on');                
            }
        };
        $('.middle_menus li a').click(catFn);
        $('.middle_menus li a').dblclick(function () {
            $(this).parents('li:first').trigger('rename'); // 双击重命名	
        });
        // 重命名
        var reNameFn = function () {
            if ($(this).parents('#moveImg_view:first').length) return false
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
                    $.post("<?php echo input::site('admin/picture/renameCategory') ?>", { 'id': id, 'name': value },
    function (data) {
        var da = JSON.parse(data);
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

        // 添加分类
        $('.gall_h1 .sp1').click(function () {
            var selEl = $(this).parents('.gall_left:first').find('.middle_menus li a.on');
            var id = 0;
            if (selEl.length > 0) {
                id = selEl.attr('name');
            }
            $.post("<?php echo input::site('admin/picture/addCategory') ?>", { 'id': id },
                function (data) {
                    var da = JSON.parse(data);
                    if (da.success == 1) {
                        location.reload();
                    }
                    else {
                        alert(da.msg);
                    }
                });
        });

        // 删除
        $('.gall_h1 .sp3').click(function () {
            var selEl = $(this).parents('.gall_left:first').find('.middle_menus li a.on');
            if (selEl.length <= 0) {
                alert('请先选择需要删除的分类');
            } else {
                confirm('该类别下的所有图片将会被删除，确认删除吗？')
                var id = selEl.attr('name');
                $.post("<?php echo input::site('admin/picture/deleteCategory') ?>", { 'id': id },
                function (data) {
                    var da = JSON.parse(data);
                    if (da.success == 1) {
                        location.href = da.url;
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

        //点击修改的效果
        $('.gall_list .a2').click(function () {
            var name = $(this).parents('li:first').find('.span_see').text();
            name = name.split('.')[0];
            $(this).parents('.dl_see').find('.wbk').show().find('input').val(name).focus();
            return false;
        });
        // 修改图片名称效果
        $('.gall_list .wbk input').blur(function () {
            var that = this;
            var value = $(this).val(),
                el = $(this).parents('li:first').find('.span_see');
            if (!value) {
                alert('必须填写名称');
                setTimeout(function () { $(that).focus(); }, 100);
                return false;
            } else {

                var id = $(this).parents('li:first').attr('id');

                $.post("<?php echo input::site('admin/picture/renameImg') ?>", { 'id': id, 'name': value },
                function (data) {
                    var da = JSON.parse(data);
                    if (da.success == 1) {
                        location.replace(location.href);
                    }
                    else {
                        alert(da.msg);
                        $(that).focus();
                    }
                });
                //el.text(value);
                //$(this).parents('.wbk:first').hide().parents('.dl_see:first').hide();
            }
        });
        //点击全选
        $('.gall_rh1 input[type=checkbox]').click(function () {
            $('.ze_box').toggle();
        })
        $('.gall_list li').hover(function () {
            $(this).find('.dl_see').show();
        }, function () {
            if ($(this).find('.dl_see .wbk').is(':hidden')) {
                $(this).find('.dl_see').hide();
            }
        })
    });

    function deleteImg() {
        $('.ze_box').each(function () {
            if ($(this).attr('style') == 'display: block;' || $(this).attr('style') == '') {
                var id = $(this).attr('id');
                $.post("<?php echo input::site('admin/picture/deleteImg') ?>", { 'id': id }, function (data) {
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

    function selectImg() {
        var name = $('#selectText').val();
        if (name) {
            if (location.href.indexOf('select') < 0)
                location.replace(location.href + '/select/' + name);
            else {
                location.href = location.href.split('/select')[0] + '/select/' + name;
            }
        }
    }

    function openFile(id)
    {
        location.href = '<?php echo input::site('admin/picture/index/1/on/')?>' + id;
    }

</script>
