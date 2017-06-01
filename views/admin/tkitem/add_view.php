<script type="text/javascript" src="<?php echo input::jsUrl('webuploader.js');?>"></script>
<link type="text/css" href="<?php echo input::cssUrl('webuploader.css');?>" rel="stylesheet" />
<script src="<?php echo input::jsUrl('date/date.js'); ?>" type="text/javascript"></script>
<link href="<?php echo input::cssUrl('date.css'); ?>" rel="stylesheet" type="text/css" />

<div class="back_right right_width">
    <div class="right">
        <h1>发布拓客商品</h1>
        <div class="cen_box">
            <div class="back_title bold">基本信息</div>
            <div class="bor_box">
                <dl class="cf">
                    <dt><em class="asterisk">*</em>商品名称：</dt>
                    <dd>
                        <input type="hidden" id="id" name="id" value="<?php echo $list->id;?>">
                        <input id="title" type="text" placeholder="商品名称" value="<?php echo $list->title;?>">
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>状态：</dt>
                    <dd>
                        <?php 
                            if($list->status == 1){ 
                                echo "上架";                                                               
                            }else{
                                echo "下架";
                            }
                        ?>
                    </dd>
                </dl>
                
                <dl class="cf">
                    <dt>商品分类：</dt>
                    <dd class="select_box">
                        <select id="category" name="category" class="puiSelect" size="10">
                            <?php           
                            foreach($tree as $key=>$value){
                                $selected = '';
                                if($list->type == $value->id){
                                    $selected = "selected";
                                }
                                echo '<option value="'.$value->id.'" '.$selected.'>'.$value->name.'</option>';
                            }
                            ?>      
                            <option value="">请选择</option>               
                        </select> 
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>价格：</dt>
                    <dd>
                        <input id="price" type="text" placeholder="价格" value="<?php echo $list->price;?>"> 元
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>PV值：</dt>
                    <dd>
                        <input id="pv" type="text" placeholder="PV值" value="<?php echo $list->pv;?>">
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>库存：</dt>
                    <dd>
                        <input id="stock" type="text" placeholder="库存" value="<?php echo $list->stock;?>">
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>销量：</dt>
                    <dd>
                        <input id="sell_num" type="text" placeholder="销量" value="<?php echo $list->sell_num;?>">
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>限制购买量：</dt>
                    <dd>
                        <input id="limit_num" type="text" placeholder="限制购买数量" value="<?php echo $list->limit_num;?>">
                    </dd>
                </dl>  
                <dl class="cf">
                    <dt></dt>
                    <dd>(按从左到右,第一张是主图，后面的是轮播图)</dd>
                </dl>
                <dl class="cf">
                    <dt>首页图片：</dt>
                    <dd id="fileLists">  
                        <?php   
                        if(!empty($list->index_img)){
                            $pic = input::site($list->index_img);
                            $imgId = time().rand(10,99);
                            echo '<div id ="'.$imgId.'" class="upload_img"><a class="file"><img name="picsLists" src="'.
                            $pic.'" width="80" height="80" /></a><p class="layer_box" style="display: none"><a class="three" href="javascript:deleteImgs(\''.$imgId.'\')"></a></p></div>';
                        }                       
                        ?> 
                        <div id="filePicker" class="upload_img">
                            <a class="file" href="Javascript:useImg('index')">
                                <img src="<?php echo input::imgUrl('img.png');?>" />
                            </a>
                        </div>
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>商品图片：</dt>
                    <dd id="fileList">  
                        <?php       
                        $pic_arr = json_decode($list->pics);         
                        if(!empty($pic_arr)){
                            foreach ($pic_arr as $key => $value) {                               
                                $pics = input::site($value);
                                $imgId = time().rand(10,99);
                                echo '<div id ="'.$imgId.'" class="upload_img"><a class="file"><img name="picsList" src="'.
                                $pics.'" width="80" height="80" /></a><p class="layer_box" style="display: none"><a class="one" href="javascript:moveUp(\''.$imgId.'\')"></a><a class="two" href="javascript:moveDown(\''.
                                $imgId.'\')"></a><a class="three" href="javascript:deleteImg(\''.$imgId.'\')"></a></p></div>';
                            }
                        }
                        ?> 
                        <div id="filePicker" class="upload_img">
                            <a class="file" href="Javascript:useImg()">
                                <img src="<?php echo input::imgUrl('img.png');?>" />
                            </a>
                        </div>
                    </dd>
                </dl>               
            </div>
        </div>

        <div class="cen_box mar_15">
            <div class="back_title bold">商品详情</div>
            <div class="bor_box cf">
                <textarea id="content" class="form-control" style="width: 566px; height: 250px" name="content">
                <?php echo $list->content;?>                    
                </textarea>
            </div>           
        </div>        
        <div class="cen_box mar_15">
            <div class="back_title bold">用户佣金设置：</div>
            <div class="bor_box cf">
                <dl class="cf">
                    <dt>佣金形式：</dt>
                    <dd>
                        <input type="radio" name="mem_type" id="mem_type0" value="0" <?php if($list->mem_type == 0){echo 'checked="true"';}?> style="width:14px;"><label for="mem_type0">a.固定金额</label>
                        <input type="radio" name="mem_type" id="mem_type1" value="1" <?php if($list->mem_type == 1){echo 'checked="true"';}?> style="width:14px;margin-left:25px;"><label for="mem_type1">b.百分比金额</label>
                    </dd>
                </dl>
                <dl class="cf">
                    <dt style="width:150px;">一级用户佣金形式：</dt>
                    <dd>
                        <input type="text" name="mem_num1" id="mem_num1" value="<?php echo $list->mem_num1;?>" style="width:60px;">
                    </dd>
                        <span class="ms"> 元</span><span class="mp"> %</span>
                </dl>
                <dl class="cf">
                    <dt style="width:150px;">二级用户佣金形式：</dt>
                    <dd>
                        <input type="text" name="mem_num2" id="mem_num2" value="<?php echo $list->mem_num2;?>" style="width:60px;">
                    </dd>
                        <span class="ms"> 元</span><span class="mp"> %</span>
                </dl>
                <dl class="cf">
                    <dt style="width:150px;">三级用户佣金形式：</dt>
                    <dd>
                        <input type="text" name="mem_num3" id="mem_num3" value="<?php echo $list->mem_num3;?>" style="width:60px;">
                    </dd>
                        <span class="ms"> 元</span><span class="mp"> %</span>
                </dl>
            </div>           
        </div>
    </div>
    <?php 
    if($type != 'see'){
    ?>
    <div class="btn_two cf">
        <a class="a1" href="javascript:submit(1);">立即上架</a>
        <a class="a1" href="javascript:submit(0);">加入库存</a>
    </div>
    <?php
    }
    ?>
 
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
.bor_box tr,th{
    line-height: 20px;
    text-align: left;
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

var imgNum = 0;
var imgNums = 0;
//弹出框
function useImg(str) {
    open_box('#useImg_view');
    if(str == 'index'){
        $('#useImg_view').attr('modid', "2");
    }else{
        $('#useImg_view').attr('modid', "1");    
    }
}


function deleteImg(val) {
    imgNum--;
    var a = $('#' + val);
    a.remove();
}
function deleteImgs(val) {
    imgNums--;
    var a = $('#' + val);
    a.remove();
}

function submit(status)
{
    var id          = $('#id').val();  
    var title       = $('#title').val();  
    var stock       = $("#stock").val();
    var sell_num       = $("#sell_num").val();
    var type        = $('#category').val();  
    var pv        = $('#pv').val();  
    var limit_num   = $("#limit_num").val();
    var mem_type    = $("input[name=mem_type]:checked").val();
    var mem_num1    = $("#mem_num1").val();
    var mem_num2    = $("#mem_num2").val();
    var mem_num3    = $("#mem_num3").val();
    if(limit_num==''){
        alert("请填写限购数量!");
        return false;
    }

    var content     = editor.html();
    var price       = $("#price").val();
    var picskey     = new Array();
    var picsvalue   = new Array();
    var picskeys    = '';
    var i = 0;
    var face = 1;

    $('img[name=picsList]').each(function (n,e) {
        if(n<5){            
            var src = $(this).attr('src');
            var srclist = src.split('_');
            if(srclist.length==1){
                var nsrc = 'upload' + srclist[0].split('upload')[1];   
            }else{
                var nsrc = 'upload' + srclist[0].split('upload')[1] + '.' + srclist[1].split('.')[1];
            }
            picsvalue[i] = face;
            picskey[i] = nsrc;
            face = 0;
            i++;
        }
    });
    $('img[name=picsLists]').each(function (n,e) {
        if(n<1){            
            var src = $(this).attr('src');
            var srclist = src.split('_');
            if(srclist.length==1){
                var nsrc = 'upload' + srclist[0].split('upload')[1];   
            }else{
                var nsrc = 'upload' + srclist[0].split('upload')[1] + '.' + srclist[1].split('.')[1];
            }
            picskeys = nsrc;
        }
    });
    var business_id = '';
    $("input[name=cateId]:checked").each(
        function(n,e){
            if(business_id != ''){
                business_id += ',';
            }
            business_id += $(e).val();
        }
    )
    var str = save_business();
    $.post("<?php echo input::site('admin/tkitem/save') ?>", {
        'id' : id,
        'title' : title,
        'type' : type,
        'sell_num':sell_num,
        'status' : status,
        'limit_num':limit_num,
        'content' : content,
        'picskey': picskey,
        'picsvalue': picsvalue,
        'picskeys': picskeys,
        'price': price,
        'pv':pv,
        'stock':stock,
        'mem_type' :mem_type,
        'mem_num1' :mem_num1,
        'mem_num2' :mem_num2,
        'mem_num3' :mem_num3,
        'business_id':str
    }, function (data) {          
        var data = eval('('+data+')');
        if(data.success==1){
            var str = status==0?'加入库存':'上架成功';
            alert(str);
            window.location.reload();
        }else{
            alert(data.msg);
        }
    });
}
    function getImg() {
        var modid = $('#useImg_view').attr('modid');
        if(modid == 1){
            imgNum = $("img[name=picsList]").length;
        }else{
            imgNums = $("img[name=picsLists]").length;
        }
        
        if (modid == "0") {
            $('.ze_box').each(function () {
                if ($(this).attr('style') == 'display: block;' || $(this).attr('style') == '') {
                    var src = $(this).parents('li:first').find('img').attr('src');
                    var srclist = src.split('_');
                    var nsrc = srclist[0] + '.' + srclist[1].split('.')[1];
                    editor.insertHtml('<img src="' + nsrc + '">');
                }
            });
        }
        else if (modid == '1' || modid == '2') {
            $('.ze_box').each(function () {
                if ($(this).attr('style') == 'display: block;' || $(this).attr('style') == '') {                     
                    var src = $(this).parents('li:first').find('img').attr('src');
                    var picid = $(this).parents('li:first').attr('id');
                    var id = (new Date()).valueOf();
                    var srclist = src.split('_');
                    var nsrc = srclist[0] + '_80x80.' + srclist[1].split('.')[1];
                    if(modid == '1'  && imgNum<6){
                        imgNum++;
                        if(imgNum<=5){
                        $('#fileList #filePicker').before('<div id ="' +
                        id + '" name="' + picid + '" class="upload_img"><a class="file"><img name="picsList" src="' +
                        nsrc + '" /></a><p class="layer_box" style="display: none"><a class="one" href="javascript:moveUp(\'' +
                        id + '\')"></a><a class="two" href="javascript:moveDown(\'' +
                        id + '\')"></a><a class="three" href="javascript:deleteImg(\'' +
                        id + '\')"></a></p></div>')
                        }
                    }
                    if(modid == '2' && imgNums<2){
                        imgNums++;
                        if(imgNums<=1){
                        $('#fileLists #filePicker').before('<div id ="' +
                        id + '" name="' + picid + '" class="upload_img"><a class="file"><img name="picsLists" src="' +
                        nsrc + '" /></a><p class="layer_box" style="display: none"><a class="three" href="javascript:deleteImgs(\'' +
                        id + '\')"></a></p></div>')
                        }
                    }
                    $('.upload_img').hover(function () {
                        $(this).find('.layer_box').show();
                        return false;
                    }, function () {
                        $(this).find('.layer_box').hide();
                        return false;
                    });  
                }
            });
        }
        if(imgNum>5 && modid == '1'){
            alert('最多只能添加5张！');
        }else if(imgNums>1 && modid == '2'){
            alert('最多只能添加1张！');
        }else{
            alert("图片已经上传成功");
        } 
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
// 获取选中商家id列表
function save_business(){
    var str = '';
    $("input[type=checkbox]:checked").each(function(n,e){
        if(str!=''){
            str+=',';
        }
        str += $(e).val();
    })
    return str;
}


// 用户佣金类型
$("input[name=mem_type]").click(function(){
    var n = $(this).val();
    if(n == 0){
        $(".ms").show();
        $(".mp").hide();
    }else{
        $(".mp").show();
        $(".ms").hide();
    }
    $("#mem_num1").val('');
    $("#mem_num2").val('');
    $("#mem_num3").val('');
})
$(function(){   
    var bus_type = $("input[name=bus_type]:checked").val();
    if(bus_type==0){
        $(".bs").show();
        $(".bp").hide();
    }else{
        $(".bp").show();
        $(".bs").hide();
    }
    var mem_type = $("input[name=mem_type]:checked").val();
    if(mem_type==0){
        $(".ms").show();
        $(".mp").hide();
    }else{
        $(".mp").show();
        $(".ms").hide();
    }
})
</script>