<link href="<?php echo input::cssUrl('tworel.css');?>" rel="stylesheet" type="text/css" />
<link href="<?php echo input::cssUrl('rqmd.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo input::jsUrl('webuploader.js');?>"></script>
<link type="text/css" href="<?php echo input::cssUrl('webuploader.css');?>" rel="stylesheet" />

<script type="text/javascript">
    var nowId = 1;
    var editor_wechat;
    $(function () {
        KindEditor.ready(function (K) {
            editor_wechat = K.create('textarea[name="wechatContent"]', {
                resizeType: 1,
                minWidth: 500,
                allowPreviewEmoticons: false,
                allowImageUpload: true,
                uploadJson: '<?php echo input::site('admin/swfupd/saveUploadImg');?>',
                afterBlur:function(){this.sync();},
                items: [
                    'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
                    'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
                    'insertunorderedlist', '|', 'emoticons', 'multiimage', 'link']
            });
        });
    });
</script>
<form>

    <div class="back_right" style="width:960px; position:relative">
        <div class="toubiaoti">关注时回复</div>
        <div class="gz_radio">
            <label>启动设置：</label>
            <input  type="radio" name="radio" class="gz_radio_a" <?php if($att == 1){echo 'checked';} ?> onchange="window.location.href='<?php echo input::site('admin/wechat/attention/1'); ?>'" />&nbsp;&nbsp;文字模式：用户关注时会以文字模式向用户回复<br/>
            <input type="radio" name="radio" class="gz_radio_b gz_radio_bb" <?php if($att == 2){echo 'checked';} ?> onchange="window.location.href='<?php echo input::site('admin/wechat/attention/2'); ?>'" /> &nbsp;&nbsp;单图文模式：用户关注时会以单图文模式向用户回复<br/>
            <input type="radio" name="radio" class="gz_radio_c" <?php if($att == 3){echo 'checked';} ?> onchange="window.location.href='<?php echo input::site('admin/wechat/attention/3'); ?>'" /> &nbsp;&nbsp;多图文模式：用户关注时会以多图文模式向用户回复
        </div>

        <div class="gz_radio3">

            <div class="hx_bottom">
                <div id="infos">
                </div>
                <div class="tadd_btn" onclick="adddata()"><a style="cursor:pointer"></a></div>
            </div>
            <div class="cf">
                <div class="gz_submit"><a href="javascript:" onclick="checkSubmit();">提交</a></div>
                <div class="gz_esc"><a style="cursor:pointer" onclick="location.reload();">重置</a></div>
            </div>
        </div>
    </div>
    <div class="radio2_gz1" style="left:342px">
        <div class="xsjimg"><img src="<?php echo input::imgUrl('xsj_03.png'); ?>" width="11"height="14"/></div>
        <div class="radio2_gz3">
            <div class="gz_submit"><a href="javascript:" onclick="savedata()">预览</a></div>
            <div class="gz_esc"><a style="cursor:pointer" onclick="deletedata()">删除</a></div>
            <span>提示：预览只是临时保存，需要永久保存请点击预览下方的提交按钮</span>
        </div>
        <div><p class="radio2_gz_p">标题</p></div>
        <div class="radio2_gz_input">
            <input type="text" id="title" value="" onchange=""/>
        </div>
        <div class="radio2_gz3">
            <label>封面</label><span> ( 大图片建议尺寸：900像素 * 500像素)</span>
        </div>
        <div class="radio2_gza"><a href="javascript:" onclick="useImg();">上传图片</a></div>
        <div class="radio2_gz4">
            <input type="checkbox" name="displayCover" id="displayCover">&nbsp; 封面图片显示在正文中</input>
        </div>
        <div><p class="radio2_gz_p2">正文</p></div>
        <div class="radio2_gz5">
            <input type="radio" name="isLink" id="radio1" value="1">&nbsp; 连接地址 <span> （设置后链接将指向此地址）</span></input>
        </div>
        <div class="radio2_gz_input"><input type="text" id="contentLink"/></div>
        <div class="radio2_gz5">
            <input type="radio" name="isLink" id="radio2" value="0">&nbsp; 内容编辑</input>
        </div>
        <div class="radio2_gzimg">
            <textarea id="itemContent" class="form-control" style="width: 579px; height: 300px" name="wechatContent"></textarea>
        </div>
    </div>

</form>
<style>
    .gz_radio3{ border:0; width:322px}
    .hx_bottom{ border:1px solid #b7b7b7; width:320px}
    .tadd_btn a{ margin-bottom:20px}
    .back_right{ padding-bottom:400px }

</style>

<script>

    var data = JSON.parse('<?php echo $info;?>');
    if (data.length < 2) {
        data = JSON.parse('[{"id":"0,"title":"标题","coverImg":"","displayCover":"0","brief":"","isDefault":"0","isLink":"0","contentLink":"","content":"","model":"3","replyType":"1","keyword":"","matchRule":"1","modelList":"38","ctime":"<?php echo time();?>"},{"id":"0","title":"标题","coverImg":"","displayCover":"0","brief":"","isDefault":"0","isLink":"0","contentLink":"","content":"","model":"3","replyType":"1","keyword":"","matchRule":"1","modelList":"38","ctime":"<?php echo time();?>"}]');
    }
    //var data = JSON.parse('[{"id":"38","title":"\u8fd9\u662f\u4e2a\u591a\u56fe\u6587\u54c8abcd","coverImg":"http:\/\/mall.local\/upload\/201510\/10\/144446998071.jpg","displayCover":"1","brief":"","isDefault":"0","isLink":"1","contentLink":"","content":"\u5475\u5475\u5475\u5475\u5475\u5475","model":"3","replyType":"1","keyword":"","matchRule":"1","modelList":"38","ctime":"1445568024"},{"id":"43","title":"\u8be5\u662f\u7684\u4e30\u76db\u7684","coverImg":"","displayCover":"0","brief":"","isDefault":"0","isLink":"0","contentLink":"","content":"\u8fc7\u6c34\u7535\u8d39\u8be5\u662f\u7684\u4e30\u76db\u7684\u5730\u65b9","model":"3","replyType":"1","keyword":"","matchRule":"1","modelList":"38","ctime":"1445568024"},{"id":"44","title":"\u8fd9\u662f\u4e2a\u591a\u56fe\u6587\u54c8\u5566\u5566\u5566\u5566\u5566\u554a","coverImg":"http:\/\/mall.local\/upload\/201510\/10\/144446998071.jpg","displayCover":"0","brief":"","isDefault":"0","isLink":"0","contentLink":"","content":"\u8fc7\u6c34\u7535\u8d39\u8be5\u662f\u7684\u4e30\u76db\u7684\u5730\u65b9\u53d1\u7684\u8f85\u5bfc\u8d39\u53d1","model":"3","replyType":"1","keyword":"","matchRule":"1","modelList":"38","ctime":"1445568024"}]');

    function getlist() {
        $('#infos').html('');
        for (var item in data) {
            var ht = '';
            if (item == 0) {
                ht += '<div class="opatx_box2" dataId="' + item + '"><p class="gz_radio2_p">' + data[item].title + '</p><a style="cursor:pointer"><img id="img'+item+'" src="' + data[item].coverImg + '" width="320" height="135"/></a><div class="tw_opat" style="display:none"><span class="back_tw"></span></div></div>'
            } else {
                ht += '<div class="gz_radio3slt"><div class="opatx_box2" dataId="' + item + '"><p class="gz_sltbt">' + data[item].title + '</p><a style="cursor:pointer"><img id="img' + item + '" class="gz_sltp" src="' + data[item].coverImg + '" width="80" height="80"/></a><div class="tw_opat tw_opat2" style="display:none"><span class="back_tw"></span></div></div></div>';
            }            
            $('#infos').append(ht);
        }
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
        //移动到显示编辑
        $('.gz_radio3slt').hover(function () {
            $(this).find('.tw_opat').show();
        }, function () {
            $(this).find('.tw_opat').hide();
        });

        //移动到显示编辑
        $('.opatx_box2').hover(function () {
            $(this).find('.tw_opat').show();
        }, function () {
            $(this).find('.tw_opat').hide();
        });
        // 编辑
        $('.gz_radio3 .opatx_box2').click(function () {
            if (ischange()) {
                if (confirm('是否保存当前')) {
                    var el = $(this),
                        offset = el.offset();
                    offset.left += el.width();
                    offset.marginTop = '0px';
                    $('.radio2_gz1').css(offset);
                    var id = $(this).attr('dataId');
                    savedata();
                    initradio2(id);
                    return;
                } else {
                    var id = $('.radio2_gz1').attr('curId');
                    $("#img" + id).attr('src', data[id].coverImg);
                }
            }
            var el = $(this),
                offset = el.offset();
            offset.left += el.width();
            offset.marginTop = '0px';
            $('.radio2_gz1').css(offset);
            initradio2($(this).attr('dataId'));
        })
    }

    function initradio2(id) {
        $('.radio2_gz1').attr('curId', id);
        $('#title').val(data[id].title);
        if (data[id].displayCover==1) {
            $('#displayCover').prop('checked', true);
        } else {
            $('#displayCover').prop('checked', false);
        }
        $('#contentLink').val(data[id].contentLink);
        $('#itemContent').val(data[id].content);
        if (editor_wechat) {
            editor_wechat.html(data[id].content);
        }
        if (data[id].isLink == 1) {
            $('input[name=isLink]').eq(0).click();
        } else {
            $('input[name=isLink]').eq(1).click();
        }
    }

    function savedata() {
        var id = $('.radio2_gz1').attr('curId');
        data[id].title = $('#title').val();
        var displayCover = $('#displayCover').prop('checked') ? 1 : 0;
        data[id].displayCover = displayCover;
        data[id].coverImg = $("#img" + id).attr('src');
        var islink = $('input[name=isLink]:checked').val();
        data[id].isLink = islink;
        data[id].contentLink = $('#contentLink').val();
        data[id].content = editor_wechat.html();
        getlist();
    }

    function deletedata() {
        var id = $('.radio2_gz1').attr('curId');
        if(id<=1){
            alert('第一条和第二条不允许删除');
            return;
        }
        if (confirm('是否确认删除')) {
            data.splice(id, 1);
            getlist();
            $('.gz_radio3 .opatx_box2').eq(0).click();
        }
    }

    function ischange() {
        var id = $('.radio2_gz1').attr('curId');
        if (id == null || data[id] == null) {
            return false;
        }
        if ($('#title').val() != data[id].title) {
            return true;
        }
        var displayCover = $('#displayCover').prop('checked') ? 1 : 0;
        if (displayCover != data[id].displayCover) {
            return true;
        }
        if ($("#img" + id).attr('src') != data[id].coverImg) {
            return true;
        }
        var islink = $('input[name=isLink]:checked').val();
        if (data[id].isLink != islink) {
            return true;
        }
        if ($('#contentLink').val() != data[id].contentLink) {
            return true;
        }
        if (editor_wechat.html() != data[id].content) {
            return true;
        }
        return false;
    }

    function adddata() {
        var a = data[data.length - 1];
        data[data.length] = a;
        getlist();
    }
    
    $(function () {
        getlist();
        $('.gz_radio3 .opatx_box2').eq(0).click();
    });

    //表单验证
    function checkSubmit() {
        savedata();
        $.post("<?php echo input::site('admin/wechat/saveAttention') ?>", { 'att': 3, 'menu': JSON.stringify(data) }, function (da) {
            var msg = JSON.parse(da);
            alert(msg.msg);
        });
    }

    function useImg() {
        open_box('#useImg_view');
    }
    function getImg() {
        var id = $('.radio2_gz1').attr('curId');
        $('.ze_box').each(function () {
            if ($(this).attr('style') == 'display: block;' || $(this).attr('style') == '') {
                var src = $(this).parents('li:first').find('img').attr('src');
                var srclist = src.split('_');
                var nsrc = srclist[0] + '.' + srclist[1].split('.')[1];
                $("#img"+id).attr('src',nsrc);
            }
        });
    }

</script>
