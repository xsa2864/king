<!--编辑广告 图片--->
<div class="up_box img_box" style="display: none; width: 657px" id="edit_view">
    <h1>编辑广告<i class="close"></i></h1>
    <div class="bor_box box_pop">
        <dl class="cf">
            <dt>广告名称：</dt>
            <dd id="adname">七夕小特别</dd>
        </dl>
        <dl class="cf">
            <dt>适配终端：</dt>
            <dd id="adter">网站</dd>
        </dl>
        <dl class="cf">
            <dt>归属频道：</dt>
            <dd id="adchannel">首页</dd>
        </dl>
        <dl class="cf">
            <dt>位置：</dt>
            <dd id="adsite">首页</dd>
        </dl>
        <dl class="cf color_red">
            <dt>图片尺寸：</dt>
            <dd id="adpicsize"></dd>
        </dl>
        <dl class="cf  pull_box">
            <dt>内容：</dt>
            <dd>
                <font>图片</font>
                <div class="style_box3">
                    <p class="cf hover">
                        <span class="p2">
                            <img id="adpic" src="images/gsle_10.png" style="height: 81px; width: 81px" /><span class="delete" style="display: none" onclick="javascript:changePic()"><i></i></span></span>
                        <span>
                            <input id="adurl" type="text" value="http://mp.wxfenxiao.com/System/shopInfo"></span>
                    </p>
                </div>
            </dd>
        </dl>
    </div>
    <div class="btn_two btn_width cf">
        <a class="a1 close" href="javascript:saveAd()">保存</a><a class="close" style="cursor: pointer;">取消</a>
    </div>
</div>
<script type="text/javascript">
    function changePic() {
        open_box('#useImg_view');
    }

    function getImg() {
        var re = false;
        $('.ze_box').each(function () {
            if ($(this).attr('style') == 'display: block;' || $(this).attr('style') == '') {
                var src = $(this).parents('li:first').find('img').attr('src');
                var srclist = src.split('_');
                var nsrc = srclist[0] + '.' + srclist[1].split('.')[1];
                $('#adpic').attr('src', nsrc);
                re = true;
                return;
            }
        });
        if (re) {
            alert('添加成功！');
        }
        else {
            alert('添加失败！');
        }
    }

    function saveAd()
    {
        var id = $('#adname').attr('adid');
        var pic = $('#adpic').attr('src');
        var url = $('#adurl').val();
        $.post("<?php echo input::site('admin/advert/update');?>", { 'id': id, 'url': url, 'pic': pic },
                function (data) {
                    location.reload();
                });
    }
</script>
