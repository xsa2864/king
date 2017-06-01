<script type="text/javascript" src="<?php echo input::jsUrl('webuploader.js');?>"></script>
<link type="text/css" href="<?php echo input::cssUrl('webuploader.css');?>" rel="stylesheet" />
<!--<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <h1></h1><legend>商城基本信息</legend>
            <div class="col-sm-6">
                <form id="form1" class="form" method="post" action="/admin/site/save" enctype="multipart/form-data">
                    <table class="table table-hover table-bordered">
                        <tr>
                            <th class="text-center info" width="150">类别</th>
                            <th class="text-center info">内容</th>
                        </tr>
                        <tr>
                            <td>站点名称:</td>
                            <td>
                                <input type="text" name="name" value="<?php echo $row['name'];?>" required="true" class="form-control" /></td>
                        </tr>
                        <tr>
                            <td>网站logo:</td>
                            <td>
                                <img src="<?php echo input::site("upload/".$row['logo']); ?> " height="30" /></td>
                        </tr>
                        <tr>
                            <td>上传Logo:</td>
                            <td>
                                <input type="file" name="userfile" value="上传" /><input type="hidden"  name="logo" value="<?php echo $row['logo'];?>" /></td>
                        </tr>
                        <tr>
                            <td>客服qq:</td>
                            <td>
                                <input type="text" name="qq" value="<?php echo $row['qq'];?>" required="true" class="form-control" /></td>
                        </tr>
                        <tr>
                            <td>客服电话:</td>
                            <td>
                                <input type="text" name="phone" class="form-control" value="<?php echo $row['phone'];?>" /></td>
                        </tr>
                        <tr>
                            <td>网站备案号:</td>
                            <td>
                                <input type="text" name="icp" class="form-control" value="<?php echo $row['icp'];?>" /></td>
                        </tr>
                        <tr>
                            <td>copyright:</td>
                            <td>
                                <input type="text" name="copyright" class="form-control" value="<?php echo $row['copyright'];?>" /></td>
                        </tr>
                        <tr>
                            <td>网站地址</td>
                            <td>
                                <input type="text" name="address" class="form-control" value="<?php echo $row['address'];?>" size="30" /></td>
                        </tr>
                    </table>
                    <div class="col-sm-offset-5">
                        <button id="save" class="btn btn-success" type="submit">保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>-->

<form id="form1" class="form" method="post">
    <div class="back_right">
        <div class="right">
            <h1>商城信息</h1>
            <div class="export">
                <dl class="cf ma20">
                    <dt><em class="asterisk">*</em>商城名称：</dt>
                    <dd>
                        <input class="inp185" type="text" name="shopname" id="shopname" value="<?php echo $row['name'];?>" /></dd>
                </dl>
                <dl class="cf ma20">
                    <dt><em class="asterisk">*</em>联系人：</dt>
                    <dd>
                        <input class="inp185" type="text" name="realName" id="realName" value="<?php echo $row['realName'];?>" /></dd>
                </dl>
                <dl class="cf ma20">
                    <dt><em class="asterisk">*</em>联系电话：</dt>
                    <dd>
                        <input class="inp185" type="text" name="phone" id="phone" placeholder="" value="<?php echo $row['phone'];?>" /></dd>
                </dl>
                <dl class="cf ma20 add_img">
                    <dt><em class="asterisk">*</em>商城Logo：</dt>
                    <!--<dd class="file">
                        <input type="file" /><img src="images/img.png" /><i style="display: none"></i></dd>
                    是logo图片时移动到要显示删除按钮，默认添加按钮不显示--->
                    <img src="<?php echo input::site($row['logo']);?>" width="100" height="100" />
                    <dd id="fileList">
                        <div id="filePicker" class="upload_img">

                            <a class="file" href="Javascript:useImg()">
                                <img src="<?php echo input::imgUrl('img.png');?>" /></a>
                        </div>
                    </dd>


                </dl>
                <dl class="cf ma20  textarea_width">
                    <dt>商城简介：</dt>
                    <dd>
                        <textarea id="itemContent" class="form-control" style="width: 866px; height: 300px" name="content"></textarea>
                    </dd>
                </dl>
                <dl class="cf ma20">
                    <dt>版权所有：</dt>
                    <dd>
                        <input class="inp185" type="text" id="copyright" name="copyright" value="<?php echo $row['copyright'];?>" /></dd>
                </dl>
                <dl class="cf ma20">
                    <dt>备案号：</dt>
                    <dd>
                        <input class="inp185" type="text" name="icp" id="icp" value="<?php echo $row['icp'];?>" /></dd>
                </dl>
            </div>
            <div class="add_mem ma20 "><a class="ma_le" href="javascript:submit();">保存</a></div>
        </div>
</form>

<script type="text/javascript">
    var imgNum = 0;
    //弹出框
    function addCategory() {
        open_box('#addCategory_view');
    }

    function addAttr() {
        open_box('#addAttr_view');
    }

    function useImg() {
        open_box('#useImg_view');
        $('#useImg_view').attr('modid', "1");
    }



    function moveUp(val) {
        var b = $('#' + val);
        var a = b.prev();
        if (a) {
            b.insertBefore(a);
        }
        $('.upload_img').hover(function () {
            $(this).find('.layer_box').show();
            return false;
        }, function () {
            $(this).find('.layer_box').hide();
            return false;
        });
    }

    function moveDown(val) {
        var a = $('#' + val);
        var b = a.next();
        if (b && b.attr('id') != 'filePicker') {
            a.insertAfter(b);
        }
        $('.upload_img').hover(function () {
            $(this).find('.layer_box').show();
            return false;
        }, function () {
            $(this).find('.layer_box').hide();
            return false;
        });
    }

    function deleteImg(val) {
        imgNum--;
        var a = $('#' + val);
        a.remove();
    }

    function getImg() {
        var re = false;
        var modid = $('#useImg_view').attr('modid');
        if (modid == "0") {
            $('.ze_box').each(function () {
                if ($(this).attr('style') == 'display: block;' || $(this).attr('style') == '') {
                    var src = $(this).parents('li:first').find('img').attr('src');
                    var srclist = src.split('_');
                    var nsrc = srclist[0] + '.' + srclist[1].split('.')[1];
                    editor.insertHtml('<img src="' + nsrc + '">');
                    re = true;
                }
            });
        }
        else if (modid = '1') {
            $('.ze_box').each(function () {
                if ($(this).attr('style') == 'display: block;' || $(this).attr('style') == '') {
                    if (imgNum < 5) {
                        imgNum++;
                        var src = $(this).parents('li:first').find('img').attr('src');
                        var picid = $(this).parents('li:first').attr('id');
                        var id = (new Date()).valueOf();
                        var srclist = src.split('_');
                        var nsrc = srclist[0] + '_80x80.' + srclist[1].split('.')[1];
                        $('#fileList').prepend('<div id ="' +
                        id + '" name="' + picid + '" class="upload_img"><a class="file"><img name="picsList" src="' +
                        nsrc + '" /></a><p class="layer_box" style="display: none"><a class="one" href="javascript:moveUp(\'' +
                        id + '\')"></a><a class="two" href="javascript:moveDown(\'' +
                        id + '\')"></a><a class="three" href="javascript:deleteImg(\'' +
                        id + '\')"></a></p></div>')
                        $('.upload_img').hover(function () {
                            $(this).find('.layer_box').show();
                            return false;
                        }, function () {
                            $(this).find('.layer_box').hide();
                            return false;
                        });
                        re = true;
                    }
                }
            });
        }
        if(re)
        {
            alert('添加成功！');
        }
        else
        {
            alert('添加失败！');
        }
    }

    function submit()
    {
        var shopname = $("#shopname").val();
        var realName = $("#realName").val();
        var phone = $("#phone").val();
        var content = $("#itemContent").val();
        var copyright = $("#copyright").val();
        var icp = $("#icp").val();
        var picskey = new Array();
        var picsvalue = new Array();
        var i = 0;
        var face = 1;
        $('img[name=picsList]').each(function () {
            var src = $(this).attr('src');
            var srclist = src.split('_');
            var nsrc = 'upload' + srclist[0].split('upload')[1] + '.' + srclist[1].split('.')[1];
            picsvalue[i] = face;
            picskey[i] = nsrc;
            face = 0;
            i++;
        });
        $.post("<?php echo input::site('admin/site/save') ?>", {
            'realName':realName,
            'shopname':shopname,
            'phone' :phone,
            'content':content,
            'copyright':copyright,
            'icp':icp,
            'picskey': picskey,
            'picsvalue': picsvalue
        }, function (data) {
            var da = JSON.parse(data);
            if(da.success==0)
            {
                alert(da.msg);
            }
            else
            {
                alert('提交成功！');
                javascript: location.reload()
            }
        });
    }

</script>
