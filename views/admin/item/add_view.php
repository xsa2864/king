<script type="text/javascript" src="<?php echo input::jsUrl('webuploader.js');?>"></script>
<link type="text/css" href="<?php echo input::cssUrl('webuploader.css');?>" rel="stylesheet" />

<div class="back_right right_width">
    <div class="right">
        <h1>发布商品</h1>
        <div class="cen_box">
            <div class="back_title bold">基本信息</div>
            <div class="bor_box">
                <dl class="cf">
                    <dt> <em class="asterisk">*</em>
                        商品名称：
                    </dt>
                    <dd>
                        <span><input id="title" type="text" placeholder="商品名称"></span>
                    </dd>
                </dl>
                
                <dl class="cf">
                    <dt><em class="asterisk">*</em>商品主图：</dt>
                    <dd id="fileList">                        
                        <div id="filePicker" class="upload_img">
                            <a class="file" href="Javascript:useImg()">
                                <img src="<?php echo input::imgUrl('img.png');?>" /></a>
                        </div>
                    </dd>
                </dl>               
            </div>
        </div>
        <div class="cen_box mar_15">
            <div class="back_title bold">商品型号</div>
            <div class="edit_box width95 pad15 cf">
                <div class="order_box2 " style="display: block">
                    <div class=" member_cen">
                    <form>
                        <table class="thead tbody_cen">
                            <tr>
                                <th>型号图</th>
                                <th>型号名称</th>
                                <th>价格</th>
                                <th>库存</th>
                                <th>赠送积分</th>
                                <th>赠送金币</th>
                                <th>销量</th>
                                <th width="6%">操作</th>
                            </tr>    

                            <tr>
                                <td>
<input type="hidden" id="thumb" name="attr_pic[]" >                  
<img id="thumbsrc" src='http://www.fenxiao.com/library/admin/images/slt_03.png' style="width:50px;height: 50px; border: 1px #c0c0c0 solid;">
<div id="uploadForm" style="display: inline;">
    <input id="file" type="file" style="width:200px;border:0;"/>
    <button id="upload" type="button" onclick="upload_img(this)" style="padding: 3px 13px;">上传</button>
</div>
                                </td>
                                <td><input type="text" name="attr_name[]"></td>
                                <td><input type="text" name="attr_price[]"></td>
                                <td><input type="text" name="attr_stock[]"></td>
                                <td><input type="text" name="attr_jifen[]"></td>
                                <td><input type="text" name="attr_golds[]"></td>
                                <td><input type="text" name="sell_num[]"></td>
                                <td><a href="javascript:;" onclick="del(this)">删除</a></td>
                            </tr> 
                        </table>
                    </form>
                    </div>
                </div>
                <div class=" cf bottom_page">
                    <div class="bottom_btn cf">
                    </div>
                    <div class="page">
                        
                    </div>
                </div>
            </div>
            <div style="text-align:center;">                
                <input type="button" id="add_tr" value="+添加商品型号">
            </div> 
        </div>
   
        <div class="cen_box mar_15">
            <div class="back_title bold">商品详情</div>
            <div class="bor_box cf">
                <div class="edit_box cf">
                    <div class="edit_cen">
                        <textarea id="itemContent" class="form-control" style="width: 866px; height: 300px" name="content"></textarea>
                    </div>
                </div>
            </div>           
        </div>   
        <div class="cen_box mar_15">            
            <div class="back_title bold">设置分类</div>   
            <div id="css_cate" style="">
                <?php           
                foreach($tree as $key=>$value)
                {
                    echo '<div>
                            <input type="checkbox" id="c'.$key.'" name="cateId[]" value="'.$value['id'].'" />
                            <label for="c'.$key.'"><b>'.$value['text'].'</b></label>
                        </div>';
                    if(!empty($value['children'])){
                        foreach($value['children'] as $key=>$values){
                            echo '<p>
                                    <input type="checkbox" id="cs'.$key.'" name="cateId[]" value="'.$values['id'].'" />
                                    <label for="cs'.$key.'">'.$values['text'].'</label>
                                </p>';
                        }
                    }
                }
                ?>                 
            </div>
        </div>
        <div class="cen_box mar_15">            
            <div class="back_title bold">运费设置</div>
            <div class="bor_box">
               <input type="radio" name="postage" value="1"> 包邮
               <input type="radio" name="postage" checked="true" value="0"> 不包邮
            </div>
        </div>
    </div>
    <div class="btn_two cf">
        <a class="a1" href="javascript:submit(0);">加入仓库</a>
        <a class="a1" href="javascript:;">仅预览</a>
        <a class="a1" href="javascript:submit(1);">直接上架</a>
    </div>
</div>

<style type="text/css">
#css_cate{
    height:180px;overflow-y: auto;
}
#css_cate>div{
    padding: 10px 0px 0px 20px;
}
#css_cate>p{
    padding: 10px 0px 0px 40px;
}
.tbody_cen tr{line-height: 10px;}
.tbody_cen td{border: 0;}
.tbody_cen input{
    border: 1px solid #000;
    width: 70%;
    height: 30px;
    border-radius: 10px;}
</style>

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

    function fix_select(selector) {
        var i = $(selector).parent().find('div,ul').remove().css('zIndex');
        $(selector).unwrap().removeClass('jqTransformHidden').jqTransSelect();
        $(selector).parent().css('zIndex', i+1);
    }

    function loadCategory(id, val) {
        $.post("<?php echo input::site('admin/category/getCategoryOption') ?>", { 'id': val },
                        function (data) {
                            if (id == 1) {
                                $('#categroy2').html(data);
                                fix_select('select#categroy2');
                                $('#itemAttr').html('');                                
                                loadItemAttr(val);
                            }
                            else if (id == 2) {
                                if (val > 0) {
                                    $('#categroy3').html(data);
                                }
                                else {
                                    $('#categroy3').html($('#categroy2').html());
                                }
                                fix_select('select#categroy3');
                            }
                        });
    }

    function loadItemAttr(val) {
        $.post("<?php echo input::site('admin/attr/getItemAttr') ?>", { 'id': val },
                        function (data) {
                            var da = eval('('+data+')');
                            $('#itemAttr').html(da.page);
                            for (var i = 0; i < da.script.length; i++) {
                                $('select#' + da.script[i]).jqTransSelect();
                            }
                        });
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
        if(!re){
            if(imgNum>4){
                alert('最多只能添加5张！');
            }else{
                alert('添加失败！');
            } 
        }
    }

    function submit(status)
    {
        var title       = $('#title').val();
        var cateId      = '';    
        var status      = status; 
        var picskey     = new Array();
        var picsvalue   = new Array();
        var i           = 0;
        var face        = 1;
        $('img[name=picsList]').each(function () {
            var src = $(this).attr('src');
            var srclist = src.split('_');
            var nsrc = 'upload' + srclist[0].split('upload')[1] + '.' + srclist[1].split('.')[1];
            picsvalue[i] = face;
            picskey[i] = nsrc;
            face = 0;
            i++;
        });

        var attr_pic      = new Array();
        var attr_name     = new Array();
        var attr_price    = new Array();
        var attr_stock    = new Array();
        var attr_jifen    = new Array();
        var attr_golds    = new Array();
        var sell_num      = new Array();
        $("input[name='cateId[]']:checked").each(function(){
            if(cateId!=''){
                cateId+=',';
            }
            cateId+=$(this).val();
        });
        i = 0;
        $("input[name='attr_pic[]']").each(function () {
            attr_pic[i] = $(this).val();
            i++;
        });
        i = 0;
        $("input[name='attr_name[]']").each(function () {
            attr_name[i] = $(this).val();
            i++;
        });
        i = 0;
        $("input[name='attr_price[]']").each(function () {
            attr_price[i] = $(this).val();
            i++;
        });     
        i = 0;
        $("input[name='attr_stock[]']").each(function () {
            attr_stock[i] = $(this).val();
            i++;
        });
         i = 0;
        $("input[name='attr_jifen[]']").each(function () {
            attr_jifen[i] = $(this).val();
            i++;
        });
        i = 0;
        $("input[name='attr_golds[]']").each(function () {
            attr_golds[i] = $(this).val();
            i++;
        });
        i = 0;
        $("input[name='sell_num[]']").each(function () {
            sell_num[i] = $(this).val();
            i++;
        });

        var content = editor.html();
        var postage = $("input[name=postage]:checked").val();
        $.post("<?php echo input::site('admin/item/save') ?>", {
            'title': title,
            'picskey': picskey,
            'picsvalue': picsvalue,
            'content': content,
            'postage': postage,   
            'cateId': cateId,  
            'status': status,   
            'attr_pic':attr_pic,
            'attr_name':attr_name,
            'attr_price':attr_price,
            'attr_stock':attr_stock,
            'attr_jifen':attr_jifen,
            'attr_golds':attr_golds,
            'sell_num':sell_num
        }, function (data) {          
            var da = eval('('+data+')');
            if(da.success==1){
                window.location.reload();
            }else{
                alert(da.msg);
            }
        });
    }
    // 添加属性栏
    $("#add_tr").click(function (){
        $('.tbody_cen').append($($('.tbody_cen tr')[1]).clone());
        $('.tbody_cen tr:last input').val('');
        $('.tbody_cen tr:last td:first img').attr('src','');
    })
    // 删除属性栏
    function del(tr){
        if($('.tbody_cen tr')[1] == tr.parentNode.parentNode){
            $('.tbody_cen tr:nth-child(2) input').val('');
            $('.tbody_cen tr:nth-child(2) td:first img').attr('src','');
            return false;
        }
        $(tr.parentNode.parentNode).remove();
    }
function upload_img(str){   
    var strplan=str.parentNode.parentNode;                         
    var formData = new FormData();
    formData.append('file', str.parentNode.childNodes[1].files[0]);
    $.ajax({
        url: '/admin/swfupd/saveUploadImg',
        type: 'POST',
        cache: false,
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(data) {
            if (data.success == '1') {
                $(strplan.childNodes[1]).val(data.url);
                $(strplan.childNodes[3]).attr('src',location.origin+'/'+data.url);
            } else {
                alertMsg('上传图片失败!', '', 300, 40);
            }
        },
        error: function() {
            alertMsg('上传图片失败!!', '', 300, 40);
            return false;
        }
    })
}    
// file选择框
$('#thumbsrc').click(function(){    
    $('#file').click();
})
// 上传文件
// function uploadimgs(str){
//     console.log(str);
// }
</script>