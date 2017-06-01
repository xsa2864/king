<script type="text/javascript" src="<?php echo input::jsUrl('webuploader.js');?>"></script>
<link type="text/css" href="<?php echo input::cssUrl('webuploader.css');?>" rel="stylesheet" />
<script src="<?php echo input::jsUrl('date/date.js'); ?>" type="text/javascript"></script>
<link href="<?php echo input::cssUrl('date.css'); ?>" rel="stylesheet" type="text/css" />

<div class="back_right right_width">
    <div class="right">
        <h1>拓客商品详情</h1>
        <div class="cen_box">
            <div class="back_title bold">基本信息</div>
            <div class="bor_box">
                <dl class="cf">
                    <dt><em class="asterisk">*</em>商品名称：</dt>
                    <dd>                        
                        <label><?php echo $list->title;?></label>
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>状态：</dt>
                    <dd>
                        <?php if($list->status == 1){echo "上架";}else{echo "下架";}?>
                    </dd>
                </dl>
                
                <dl class="cf">
                    <dt>商品分类：</dt>
                    <dd class="select_box">
                            <?php           
                            foreach($tree as $key=>$value){
                                $selected = '';
                                if($list->type == $value->id){
                                    echo '<label>'.$value->name.'</label>';
                                }
                            }
                            ?> 
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>价格：</dt>
                    <dd>
                        <label><?php echo $list->price;?></label>
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>库存：</dt>
                    <dd>
                        <label><?php echo $list->stock;?></label>
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>销量：</dt>
                    <dd>
                        <label><?php echo $list->sell_num;?></label>
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>限制购买量：</dt>
                    <dd>
                        <label><?php echo $list->limit_num;?></label>
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>有效期类型：</dt>
                    <dd>
                    <?php 
                    if($list->timetype == 0){
                        echo '可选择自购买之日起，N天有效。显示格式为：有效期：付款后X天内有效';
                    }else{
                        echo '自然日XXX年XX月XX日前有效。显示格式为：有效期：至2017-12-31';
                    }
                    ?>
                    </dd>
                </dl>
                <?php 
                if($list->timetype == 0){
                ?>
                <dl class="cf">
                    <dt>有效期：</dt>
                    <dd>
                        <label><?php echo $list->validtime;?>天</label>
                    </dd>
                </dl>
                <?php    
                }else{
                ?>                
                <dl class="cf">
                    <dt>开始时间：</dt>
                    <dd><label><?php echo $list->starttime == 0 ? '' : date('Y-m-d H:i:s',$list->starttime);?></label></dd>
                </dl>
                <dl class="cf">
                    <dt>结束时间：</dt>
                    <dd><label><?php echo $list->endtime == 0 ? '' : date('Y-m-d H:i:s',$list->endtime);?></label></dd>
                </dl>
                <?php
                }
                ?>
                <dl class="cf">
                    <dt>首页图片：</dt>
                    <dd id="fileList">  
                        <?php   
                        if(!empty($list->index_img)){
                            $pic = input::site($list->index_img);
                            $imgId = time().rand(10,99);
                            echo '<div id ="'.$imgId.'" class="upload_img"><a class="file"><img name="picsList" src="'.
                            $pic.'" width="80" height="80" /></a></div>';
                        }                        
                        ?> 
                    </dd>
                </dl>       
                <dl class="cf">
                    <dt>商品LOGO：</dt>
                    <dd id="fileList">  
                        <?php  
                        $pic_arr = json_decode($list->pics);         
                        if(!empty($pic_arr)){
                            foreach ($pic_arr as $key => $value) {                               
                                $pics = input::site($value);
                                $imgId = time().rand(10,99);
                                echo '<div id ="'.$imgId.'" class="upload_img"><a class="file"><img name="picsList" src="'.
                                $pics.'" width="80" height="80" /></a></div>';
                            }
                        }
                        ?> 
                    </dd>
                </dl>               
            </div>
        </div>

        <div class="cen_box mar_15">
            <div class="back_title bold">商品详情</div>
            <div class="bor_box cf">
                <div style="overflow-y:auto;max-height:300px;"><?php echo $list->content;?></div>            
            </div>           
        </div>
        <div class="cen_box mar_15">
            <div class="back_title bold">商家收益设置：</div>
            <div class="bor_box cf">
                <dl class="cf">
                    <dt>收益形式：</dt>
                    <dd>
                        <?php 
                        if($list->bus_type == 0){
                            echo 'a.固定金额';
                        }else{
                            echo 'b.百分比金额';
                        }
                        ?> 
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>收益金额：</dt>
                    <dd>
                        <?php 
                        if($list->bus_type == 0){
                            echo $list->bus_num.' 元';
                        }else{
                            echo $list->bus_num.' %';
                        }
                        ?>                         
                    </dd>                        
                </dl>
            </div>           
        </div>
        <div class="cen_box mar_15">
            <div class="back_title bold">用户佣金设置：</div>
            <div class="bor_box cf">
                <dl class="cf">
                    <dt>佣金形式：</dt>
                    <dd>
                        <?php 
                        if($list->mem_type == 0){
                            echo 'a.固定金额';
                        }else{
                            echo 'b.百分比金额';
                        }
                        ?>                        
                    </dd>
                </dl>
                <dl class="cf">
                    <dt style="width:150px;">一级用户佣金形式：</dt>
                    <dd>                        
                        <?php 
                        if($list->mem_type == 0){
                            echo $list->mem_num1.' 元';
                        }else{
                            echo $list->mem_num1.' %';
                        }
                        ?>
                    </dd>
                </dl>
                <dl class="cf">
                    <dt style="width:150px;">二级用户佣金形式：</dt>
                    <dd>
                        <?php 
                        if($list->mem_type == 0){
                            echo $list->mem_num2.' 元';
                        }else{
                            echo $list->mem_num2.' %';
                        }
                        ?>
                    </dd>
                </dl>
                <dl class="cf">
                    <dt style="width:150px;">三级用户佣金形式：</dt>
                    <dd>                        
                        <?php 
                        if($list->mem_type == 0){
                            echo $list->mem_num3.' 元';
                        }else{
                            echo $list->mem_num3.' %';
                        }
                        ?>
                    </dd>
                </dl>
            </div>           
        </div>
        <div class="cen_box mar_15">            
            <div class="back_title bold">选择商家列表(请勾选参与的商家)</div>
            <div class="bor_box" style="overflow-y:auto;height:130px">
                <table border="0" style="font-size: 12px">
                        <tr>
                            <th>选择商家</th>   
                            <th>选择商家</th>
                            <th>选择商家</th>                         
                        </tr>                        
                        <?php
                        if(!empty($category)){
                            $arr = explode(',', $list->business_id);

                            $str = "<tr>";
                            $n = 0;
                            foreach($category as $key => $ch1){
                                if(in_array($ch1->id, $arr)){                                    
                                    if($n%3==0){
                                        $str .= "</tr><tr>";
                                    }
                                    $str .= "<td>                                            
                                            <label for=c_$key>".$ch1->name."</label>
                                        </td>";  
                                    $n ++;                                                   
                                }
                            }
                            $str .= "</tr>";
                            echo $str;
                        }
                        ?>
                    </table>
            </div>
        </div> 
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

var imgNum = 0;
//弹出框
function useImg() {
    open_box('#useImg_view');
    $('#useImg_view').attr('modid', "1");
}
function deleteImg(val) {
    imgNum--;
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
    var limit_num   = $("#limit_num").val();
    var validtime   = $('#validtime').val();  
    var starttime   = $('#starttime').val();  
    var endtime     = $('#endtime').val();  
    var addtime     = $('#addtime').val();

    if(validtime == '' && starttime == '' && endtime  == ''){
        alert("有效期时间和开始时间、结束时间至少要填一个!");
        return false;
    }
    var content     = editor.html();
    var price       = $("#price").val();
    var picskey     = new Array();
    var picsvalue   = new Array();
    var i = 0;
    var face = 1;
    $('img[name=picsList]').each(function () {
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
        'validtime' : validtime,
        'starttime' : starttime,
        'endtime' : endtime,
        'addtime' : addtime,
        'content' : content,
        'picskey': picskey,
        'picsvalue': picsvalue,
        'price': price,
        'stock':stock,
        'business_id':str
    }, function (data) {          
        var data = eval('('+data+')');
        if(data.success==1){
            window.location.reload();
        }else{
            alert(data.msg);
        }
    });
}
    function getImg() {
        imgNum = $("img[name=picsList]").length;
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
                        $('#fileList').append('<div id ="' +
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
            alert("图片已经上传成功");
        }
        if(!re){
            if(imgNum>=5){
                alert('最多只能添加5张！');
            }else{
                alert('添加失败！');
            } 
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
</script>