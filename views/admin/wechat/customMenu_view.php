<link href="<?php echo input::cssUrl('tworel.css');?>" rel="stylesheet" type="text/css" />
<link href="<?php echo input::cssUrl('rqmd.css');?>" rel="stylesheet" type="text/css" />

<div class="back_right" style="width: 960px">
    <div class="zdycd">
        <div class="toubiaoti">自定义菜单</div>
        <div class="fubiaoti">提示：可创建最多3个一级菜单，每个一级菜单下可创建最多5个二级菜单。</div>
        <div class="fubiaoti">提示：设置完成后，请点击最下面的保存按钮提交设置。</div>
        <div class="zdcbnr">
            <div class="zdcbnr_bkg">
                <div class="zdcbnr_btn">
                    <div class="cf">
                        <a class="btn_tj" style="cursor: pointer; color: #000;">添加</a>
                        <a class="btn_cmm" style="cursor: pointer; color: #000;">重命名</a>
                        <a class="btn_sc" style="cursor: pointer; color: #000;">删除</a>
                    </div>
                    <div class="gall_h2 left_nav adve_list" style="min-height: 530px;">
                        <ul class="middle_menus nub">
                        </ul>
                    </div>
                </div>
            </div>

            <!--选择不同，显示不同的内容-->
            <span id="defaultBig" style="display: block">
                <div class="zdcdnr_ts">
                    <img src="<?php echo input::imgUrl('gth_03.png'); ?>" width="80" height="80"/>
                </div>
                <div class="zdcdnr_p tip1">
                    <p>
                        您可以点击左侧菜单或添加一个新菜单，<br />
                        然后设置菜单内容
                    </p>
                </div>
                <div class="zdcdnr_p tip2" style="display: none;">
                    <p>
                        该菜单下已经存在5个二级菜单
                    </p>
                </div>
            </span>
            <span id="parentBig" style="display: none">
                <p class="cdnr_right_p">请设置一级菜单的内容</p>
                <div class="cdnr_right_img"><a style="cursor: pointer; color: #FFF">添加二级菜单</a></div>
                <div class="cdnr_right_imgs"><a onclick="openLink()" style="color: #FFF; cursor: pointer">跳转到页面</a></div>
            </span>
            <span id="parentBig2" style="display: none">
                <p class="cdnr_right_p">
                    请设置一级菜单的内容<br />
                    提示：该分类下存在二级菜单，无法设置跳转！
                </p>
                <div class="cdnr_right_img"><a style="cursor: pointer; color: #FFF">添加二级菜单</a></div>
            </span>
            <span id="secondBig" style="display: none">
                <p class="huiyuanpp">请设置二级菜单的内容</p>
                <div class="cdnr_right_imgs"><a onclick="openLink()" style="color: #FFF; cursor: pointer">跳转到页面</a></div>
            </span>

            <span id="linkBig" style="display: none;">
                <form>
                    <input type="hidden" name="id" id="updateId" value="">
                    <p class="tzdppp">订阅者点击该子菜单会跳到以下链接</p>
                    <div class="tzdinput">
                        <label>页面地址：</label><input type="text" name="link" id="link" value="" />
                    </div>
                    <div class="cdnr_right_imgs">
                        <a onclick="checkMenu()" style="color: #FFF; cursor: pointer">返回上级</a>
                    </div>
                    <div class="cdnr_right_imgs">
                        <a style="color: #FFF; cursor: pointer" onclick="changeUrl()">确定修改</a>
                    </div>
                </form>
            </span>
        </div>
        <div class="gz_submit"><a style="cursor: pointer;" onclick="savedata()">保存</a></div>
    </div>
</div>

<!--遮罩层-->
<div class="mask_box" style="display: none"></div>
<!--点击添加弹出   一级菜单-->
<form>
    <div class="tjyjcd" id="tjyjcd" style="display: none">
        <div class="tck_title">
            添加一级菜单
        <div class="tck_img">
            <a class="close" style="cursor: pointer">
                <img src="<?php echo input::imgUrl('close_03.png'); ?>" width="21px" height="21px"/></a>
        </div>
        </div>
        <div class="tjyjcd_nr">
            <div class="nr_ppp">
                <p>最多能添加3个一级菜单，请输入名称（4个汉字或8个字母以内）</p>
            </div>
            <div class="nr_input">
                <input type="text" name="name" id="name" value="" />
            </div>
        </div>
        <div class="tck_btn">
            <a class="tck_btn_b close" style="cursor: pointer; color: #000">取消</a>
            <a href="javascript:addfmenu();" class="tck_btn_a close" style="color: #FFF">确定</a>
        </div>
    </div>
</form>

<!--点击删除弹出-->
<div class="scqr" id="scqr" style="display: none">
    <form>
        <input type="hidden" name="deleteId" id="deleteId" value="0">
        <div class="tck_title">
            删除确认
    	<div class="tck_img">
            <a class="close" style="cursor: pointer;">
                <img src="<?php echo input::imgUrl('close_03.png'); ?>" width="21px" height="21px"/></a>
        </div>
        </div>
        <div>
            <div class="scqr_ts">
                <img src="<?php echo input::imgUrl('hts_03.png'); ?>" width="50" height="50"/>
            </div>
            <p class="scqr_wz">删除后该菜单下设置的消息将不会被保存</p>
        </div>
        <div class="tck_btn">
            <a class="tck_btn_b close" style="color: #000; cursor: pointer">取消</a>
            <a href="JavaScript:delmenu();" class="tck_btn_a close" style="color: #FFF">确定</a>
        </div>
    </form>
</div>
<!--点击添加二级菜单按钮弹出-->
<div class="tjyjcd" id="tjejcd" style="display: none">
    <form>
        <input type="hidden" name="pid" id="secondPid" value="0">
        <div class="tck_title">
            添加二级菜单
        <div class="tck_img">
            <a class="close" style="cursor: pointer">
                <img src="<?php echo input::imgUrl('close_03.png'); ?>" width="21px" height="21px"/></a>
        </div>
        </div>
        <div class="tjyjcd_nr">
            <div class="nr_ppp">
                <p>最多添加5个二级菜单，请输入名称（8个汉字或16个字母以内）</p>
            </div>
            <div class="nr_input">
                <input type="text" name="name" id="secondName" />
            </div>
        </div>
        <div class="tck_btn">
            <a class="tck_btn_b close" style="cursor: pointer; color: #000">取消</a>
            <a href="javascript:addsmenu();" class="tck_btn_a close" style="color: #FFF">确定</a>
        </div>
    </form>
</div>
<!--点击重命名按钮弹出-->
<div class="tjyjcd" id="cmm" style="display: none">
    <form>
        <input type="hidden" name="id" id="cmmId" value="0">
        <div class="tck_title">
            重命名菜单
            <div class="tck_img">
                <a class="close" style="cursor: pointer;">
                    <img src="<?php echo input::imgUrl('close_03.png'); ?>" width="21px" height="21px"/></a>
            </div>
        </div>
        <div class="tjyjcd_nr">
            <div class="nr_ppp">
                <p>请输入名称（8个汉字或16个字母以内）</p>
            </div>
            <div class="nr_input">
                <input type="text" name="name" id="cmmName" />
            </div>
        </div>
        <div class="tck_btn">
            <a class="tck_btn_b close" style="cursor: pointer; color: #000">取消</a>
            <a href="javascript:changename()" class="tck_btn_a close" style="color: #FFF">确定</a>
        </div>
    </form>
</div>
<script>
    var data = JSON.parse('<?php echo $menustr;?>');
    //var data = JSON.parse('[{"type":"view","name":"\u638c\u4e0a\u5546\u57ce","url":"http:\/\/www.aijq.com.cn\/wechat","sub_button":[]},{"type":"view","name":"\u516c\u53f8\u7b80\u4ecb","url":"http:\/\/www.aijq.com.cn\/wechat","sub_button":[]},{"type":"view","name":"\u4e2a\u4eba\u4e2d\u5fc3","url":"http:\/\/www.aijq.com.cn\/wechat\/member","sub_button":[]}]');

    $(function () {
        getlist();
        //文本框颜色
        $("input").focus(function () {
            $(this).css({ 'border-color': '#148cd7' })
        });
        $("input").blur(function () {
            $(this).css({ 'border-color': '#b7b7b7' })
        });
        $("textarea").focus(function () {
            $(this).css({ 'border-color': '#148cd7' })
        });
        $("textarea").blur(function () {
            $(this).css({ 'border-color': '#b7b7b7' })
        });
    });

    function getlist(fid, sid) {
        $('.middle_menus').html('');
        for (var item in data) {
            var ht = '<li><a href="javascript:" onclick="checkMenu(' + item + ')" fid="' + item + '" ';
            var sh = 'none';
            if (fid && fid == item) {
                if (sid) {
                    ht += 'class="open"';
                    sh = 'block'
                } else {
                    ht += 'class="on"';
                }
            }
            ht += '>';
            if (data[item].sub_button.length > 0) {
                ht += '<em></em>';
            }
            ht += data[item].name + '<span><i class="jt_iis" onclick="sortSend(\'up\',' + item + ')"><img src="<?php echo input::imgUrl('jts_03.png'); ?>"/></i><i class="jt_iix" onclick="sortSend(\'down\',' + item + ')"><img src="<?php echo input::imgUrl('jtx_03.png'); ?>"/></i></span></a><ul class="left_sum" style="display: ' + sh + '">';
            if (data[item].sub_button) {
                for (var i in data[item].sub_button) {
                    ht += '<li><a href="javascript:" onclick="checkMenu(' + item + ',' + i + ')" fid="' + item + '" sid="' + i + '" ';
                    if (sid && sid == i) {
                        ht += 'class="on"';
                    }
                    ht += '>' + data[item].sub_button[i].name + '<span><i class="jt_iis" onclick="sortSend(\'up\',' + item + ',' + i + ')" ><img src="<?php echo input::imgUrl('jts_03.png'); ?>"/></i><i class="jt_iix" onclick="sortSend(\'down\',' + item + ',' + i + ')"><img src="<?php echo input::imgUrl('jtx_03.png'); ?>"/></i></span></a></li>'
                }
            }
            ht += '</ul></li>';
            $('.middle_menus').append(ht);
        }
        $('.middle_menus li a').click(catFn);
    }

    //url保存
    function changeUrl() {
        var selEl = $('.middle_menus').find('.on');
        var fid = selEl.attr('fid');
        var sid = selEl.attr('sid');
        if (sid) {
            data[fid].sub_button[sid].url = $('#link').val();;
        } else {
            data[fid].url = $('#link').val();
        }
        checkMenu();
    }

    //保存按钮
    function savedata() {
        $.post("<?php echo input::site('admin/wechat/saveMenu') ?>", { 'menu': data }, function (da) {
            var msg = JSON.parse(da);
            alert(msg.msg);
        });
    }

    //url设置页面
    function openLink() {
        $("#defaultBig").hide();
        $("#parentBig").hide();
        $("#parentBig2").hide();
        $("#secondBig").hide();
        $("#linkBig").show();
        var selEl = $('.middle_menus').find('.on');
        var fid = selEl.attr('fid');
        var sid = selEl.attr('sid');
        if (sid) {
            $('#link').val(data[fid].sub_button[sid].url);
        } else {
            $('#link').val(data[fid].url);
        }
    }

    //排序
    function sortSend(str, fid, sid) {
        if (str == 'up') {
            if (sid == null) {
                if (data[fid] && data[fid - 1]) {
                    var it = data[fid];
                    data[fid] = data[fid - 1];
                    data[fid - 1] = it;
                    getlist();
                }
            } else {
                if (data[fid].sub_button[sid] && data[fid].sub_button[sid - 1]) {
                    var it = data[fid].sub_button[sid];
                    data[fid].sub_button[sid] = data[fid].sub_button[sid - 1];
                    data[fid].sub_button[sid - 1] = it;
                    getlist();
                }
            }
        } else if (str == 'down') {
            if (sid == null) {
                if (data[fid] && data[fid + 1]) {
                    var it = data[fid];
                    data[fid] = data[fid + 1];
                    data[fid + 1] = it;
                    getlist();
                }
            } else {
                if (data[fid].sub_button[sid] && data[fid].sub_button[sid + 1]) {
                    var it = data[fid].sub_button[sid];
                    data[fid].sub_button[sid] = data[fid].sub_button[sid + 1];
                    data[fid].sub_button[sid + 1] = it;
                    getlist();
                }
            }
        }
    }

    //选择菜单
    function checkMenu(id1, id2) {
        if (id1 == null) {
            var selEl = $('.middle_menus').find('.on');
            var id1 = selEl.attr('fid');
            var id2 = selEl.attr('sid');
        }
        $("#defaultBig").hide();
        $(".tip1").hide();
        $(".tip2").hide();
        $("#parentBig").hide();
        $('#parentBig2').hide();
        $("#secondBig").hide();
        $("#linkBig").hide();
        if (id1 == null) {
            $("#defaultBig").show();
            $(".tip1").show();
        } else {
            if (id2 == null) {
                if (data[id1].sub_button.length >= 5) {
                    $("#defaultBig").show();
                    $(".tip2").show();
                } else if (data[id1].sub_button.length > 0) {
                    $("#parentBig2").show();
                } else {
                    $("#parentBig").show();
                }
            } else {
                $("#secondBig").show();
            }
        }
    }

    //删除
    function delmenu() {
        var selEl = $('.middle_menus').find('.on');
        var fid = selEl.attr('fid');
        var sid = selEl.attr('sid');
        if (sid) {
            data[fid].sub_button.splice(sid, 1);
        } else if (fid) {
            data.splice(fid, 1);
        }
        getlist();
    }

    //重命名
    function changename() {
        var selEl = $('.middle_menus').find('.on');
        var fid = selEl.attr('fid');
        var sid = selEl.attr('sid');
        var name = $('#cmmName').val();
        if (sid) {
            data[fid].sub_button[sid].name = name;
        } else if (fid) {
            data[fid].name = name;
        }
        getlist(fid, sid);
    }

    //添加二级菜单
    function addsmenu() {
        var selEl = $('.middle_menus').find('.on');
        var fid = selEl.attr('fid');
        var sid = selEl.attr('sid');
        if (sid == null && fid) {
            if (data[fid].sub_button.length >= 5) {
                alert('最多只能添加5个二级分类');
            } else {
                var name = $('#secondName').val()
                if (name) {
                    var newData = JSON.parse('{"type":"view","name":"' + name + '","url":""}');
                    data[fid].sub_button.push(newData);
                    getlist(fid, sid);
                } else {
                    alert('请输入名称');
                }
            }
        }
    }

    //添加一级菜单
    function addfmenu() {
        if (data.length >= 3) {
            alert('最多只能添加3个一级分类');
        } else {
            var name = $('#name').val()
            if (name) {
                var newData = JSON.parse('{"type":"view","name":"' + name + '","url":"","sub_button":[]}');
                data.push(newData);
                getlist();
            } else {
                alert('请输入名称');
            }
        }

    }

    //添加一级菜单弹出框
    $('.btn_tj').click(function () {
        open_box('#tjyjcd')
    });

    //删除确认弹出框
    $('.btn_sc').click(function () {
        var selEl = $('.middle_menus').find('.on');
        if (selEl.length <= 0) {
            alert('请先选择需要删除的分类');
            return false;
        }
        open_box('#scqr')
    });

    //重命名弹出框设置
    $('.btn_cmm').click(function () {
        var selEl = $('.middle_menus').find('.on');
        if (selEl.length <= 0) {
            alert('请先选择需要重命名的分类');
            return false;
        }
        var fid = selEl.attr('fid');
        var sid = selEl.attr('sid');
        if (sid) {
            $('#cmmName').val(data[fid].sub_button[sid].name);
        } else if (fid) {
            $('#cmmName').val(data[fid].name);
        }
        open_box('#cmm')
    });

    //添加二级菜单弹出框
    $('.cdnr_right_img').click(function () {
        open_box('#tjejcd')
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
        $('.middle_menus li a').removeClass('on');
        $(this).addClass('on');
    };

    // 添加分类
    $('.gall_h1 .sp1').click(function () {
        var selEl = $(this).parents('.gall_left:first').find('.middle_menus li a.on');
        if (selEl.length <= 0) {
            alert('请先选择需要添加子类的上级分类');
        } else if (selEl.find('em').length <= 0) {
            alert('分类最多只允许添加二级，请重新选择分类');
        } else {
            var ul = selEl.next();
            if (!ul.is('ul')) {
                ul = $('<ul></ul>');
                selEl.after(selEl);
            }
            var li = $('<li><a href="#" class="">' + (ul.parents('ul:first').is('.middle_menus') ? '<em></em>' : '') + '分类名称</a></li>');
            ul.append(li);
            li.bind('rename', reNameFn).find('a').click(catFn);
            li.trigger('rename');
        }
    });

</script>
