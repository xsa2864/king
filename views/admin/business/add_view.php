<script type="text/javascript" src="<?php echo input::jsUrl('webuploader.js');?>"></script>
<link type="text/css" href="<?php echo input::cssUrl('webuploader.css');?>" rel="stylesheet" />
<script src="<?php echo input::jsUrl('date/date.js'); ?>" type="text/javascript"></script>
<link href="<?php echo input::cssUrl('date.css'); ?>" rel="stylesheet" type="text/css" />
<script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp"></script>
<style type="text/css">
#container{
    width:auto;
    min-height:367px;
}
.right_save{
    float: right;
    background: #148cd7;
    width: 50px !important;
    height: 25px !important;
    line-height: 25px;
    text-align: center;
    color: #fff !important;
}
</style>

<div class="back_right right_width" >
    <div class="right">
        <h1>
        <?php if($list->id){echo "修改";}else{echo "新增";};?>拓客商家</h1>
        <div class="cen_box">
            <div class="back_title bold">基本信息<a class="right_save" href="javascript:submit();">保存</a></div>

            <div class="bor_box">
                <dl class="cf">
                    <dt><em class="asterisk">*</em>店铺名称：</dt>
                    <dd>
                        <input type="hidden" id="id" name="id" value="<?php echo $list->id;?>">
                        <input id="name" type="text" placeholder="店铺名称" value="<?php echo $list->name;?>">
                    </dd>
                </dl>                
                <dl class="cf">
                    <dt><em class="asterisk">*</em>真实姓名：</dt>
                    <dd>
                        <input id="realname" type="text" placeholder="姓名" value="<?php echo $list->realname;?>"> 
                    </dd>
                </dl>
                <dl class="cf">
                    <dt><em class="asterisk">*</em>手机号：</dt>
                    <dd>
                        <input id="mobile" type="text" placeholder="手机号" value="<?php echo $list->mobile;?>">
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>众合账号：</dt>
                    <dd>
                        <input id="zh_name" type="text" placeholder="众合账号" value="<?php echo $list->zh_name;?>"> 
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>销售量：</dt>
                    <dd>
                        <input id="sell_num" type="text" placeholder="销售量" value="<?php echo $list->sell_num;?>">
                    </dd>
                </dl>    
                <dl class="cf">
                    <dt>销售金额：</dt>
                    <dd>
                        <input id="amount" type="text" placeholder="销售金额" value="<?php echo $list->amount;?>">
                    </dd>
                </dl>    
                <dl class="cf">
                    <dt><em class="asterisk">*</em>城市：</dt>
                    <dd>
                        <input id="city" type="text" placeholder="城市" value="<?php echo $list->city;?>">
                    </dd>
                </dl>    
                <dl class="cf">
                    <dt><em class="asterisk">*</em>openid：</dt>
                    <dd>
                        <input id="openid" type="text" placeholder="跟会员绑定的码" value="<?php echo $list->openId;?>">
                    </dd>
                </dl>      
                <dl class="cf">
                    <dt><em class="asterisk">*</em>定位地址：</dt>
                    <dd>
                        <input id="address" type="text" placeholder="定位地址" value="<?php echo $list->address;?>">
                        经纬度：<label id="loc"><?php echo $list->lat.','.$list->lng;?></label>
                    </dd>
                </dl>
                <dl class="cf">
                    <dt>详细地址：</dt>
                    <dd>
                        <input id="full_address" type="text" placeholder="详细地址" value="<?php echo $list->full_address;?>">
                    </dd>
                </dl>      
                <dl class="cf" style="height:500px;">
                    <div class="back_title bold">地址信息</div> 
<iframe id="mapPage" width="100%" height="100%" frameborder=0 
    src="http://apis.map.qq.com/tools/locpicker?search=1&type=1&key=JBXBZ-NBDRP-HQADR-LLJ5C-GI7MF-MFFO7&referer=myapp">
</iframe>     
                </dl>      
                <dl class="cf">
                    <div class="back_title bold"></div>
                    <br>
                    <dt>店铺LOGO：</dt>
                    <dd id="fileList">  
                        <?php   
                        if(!empty($list->pic)){
                            $pic = input::site($list->pic);
                            $imgId = time().rand(10,99);
                            echo '<div id ="'.$imgId.'" class="upload_img"><a class="file"><img name="picsList" src="'.
                            $pic.'" width="80" height="80" /></a><p class="layer_box" style="display: none"><a class="one" href="javascript:moveUp(\''.$imgId.'\')"></a><a class="two" href="javascript:moveDown(\''.
                            $imgId.'\')"></a><a class="three" href="javascript:deleteImg(\''.$imgId.'\')"></a></p></div>';
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
            <div class="back_title bold">详情介绍</div>
            <div class="bor_box cf">
                <textarea id="content" class="form-control" style="width: 566px; height: 250px" name="content">
                <?php echo $list->content;?>                    
                </textarea>
            </div>           
        </div> 
        <div class="cen_box mar_15">            
            <div class="back_title bold">参与分类</div>
            <div class="bor_box">
                <?php
                    if(!empty($clist)){
                        $arr = explode(',', $list->business_id);
                        $str = "<tr>";
                        foreach($clist as $key => $ch1){
                            $checked = in_array($ch1->id, $arr)?'checked':'';                 
                            if($key%3==0){
                                $str .= "</tr><tr>";
                            }
                            $str .= "<td>
                                        <input type='checkbox' name='business' ".$checked." id=c_$key value=".$ch1->id.">
                                        <label for=c_$key>".$ch1->name."</label>
                                    </td>";
                        }
                        $str .= "</tr>";
                        echo $str;
                    }
                ?>
            </div>
        </div> 
        <div class="cen_box mar_15">            
            <div class="back_title bold">状态设置</div>
            <div class="bor_box">
               <input type="radio" name="status" <?php if($list->status == 1){echo "checked=true";}?> value="1"> 正常
               <input type="radio" name="status" <?php if($list->status == 2){echo "checked=true";}?> value="2"> 申请开店
               <input type="radio" name="status" <?php if($list->status == 0){echo "checked=true";}?> value="0"> 关闭
            </div>
        </div> 
    </div>
    <div class="btn_two cf">
        <input type="hidden" name="suretime" id="suretime">
        <a class="a1" href="javascript:submit();">保存</a>
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

var loc_str = '';
window.addEventListener('message', function(event) {
    // 接收位置信息，用户选择确认位置点后选点组件会触发该事件，回传用户的位置信息
    var loc = event.data;
    if (loc && loc.module == 'locationPicker') {//防止其他应用也会向该页面post信息，需判断module是否为'locationPicker'
        loc_str = loc.latlng;  
        $("#address").val(loc.poiaddress+'('+loc.poiname+')');
        $("#city").val(loc.cityname);
        $("#loc").html(loc_str.lat+','+loc_str.lng);
    }                                
}, false); 

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

function submit()
{
    var id          = $('#id').val();  
    var name        = $('#name').val();  
    var realname    = $('#realname').val();  
    var mobile      = $('#mobile').val();  
    var zh_name     = $('#zh_name').val();
    var sell_num    = $('#sell_num').val();  
    var amount      = $('#amount').val();  
    var city        = $('#city').val();  
    var openid      = $('#openid').val();  
    var address     = $('#address').val();
    var full_address     = $('#full_address').val();
    var suretime    = $('#suretime').val();
    var status      = $("input[name=status]:checked").val();
    var content     = editor.html();
    if(name == '' || name == null){
        alert("店铺名称不能为空!");
        return false;
    }
    if(realname == '' || realname == null){
        alert("真实姓名不能为空!");
        return false;
    }
    if(openid == '' || openid == null){
        alert("openid不能为空!");
        return false;
    }
    var rule = /^[0-9]{10,12}$/;
    if(!rule.exec(mobile)){
        alert('联系电话为10~12位的数字');
        return false;
    }
    if(city == '' || city == null){
        alert("城市不能为空!");
        return false;
    }
    // if(full_address == '' || full_address == null){
    //     alert("地址不能为空!");
    //     return false;
    // }
    if(loc_str != ''){
        var lat     = loc_str.lat;
        var lng     = loc_str.lng;
    }

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

    $.post("<?php echo input::site('admin/business/save') ?>", {
        'id' : id,
        'name' : name,
        'realname' : realname,
        'status' : status,
        'mobile' : mobile,
        'zh_name':zh_name,
        'sell_num': sell_num,
        'amount': amount,
        'city': city,
        'openid':openid,
        'suretime':suretime,
        'address':address,
        'full_address' : full_address,
        'content' : content,
        'lat':lat,
        'lng':lng,
        'picskey': picskey,
        'picsvalue': picsvalue
    }, function (data) {          
        var data = eval('('+data+')');
        if(data.success==1){
            history.go(-1);
        }
        alert(data.msg);
    });
}
    function getImg() {
        imgNum = $("img[name=picsList]").length;
        var modid = $('#useImg_view').attr('modid');
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
        else if (modid = '1') {
            $('.ze_box').each(function () {
                if ($(this).attr('style') == 'display: block;' || $(this).attr('style') == '') {
                    if (imgNum < 2) {
                        imgNum++;
                        if(imgNum<=1){                            
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
                        }
                    }
                }
            });
            if(imgNum>1){
                alert('最多只能添加1张！');
            }else{
                alert("图片已经上传成功");
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

</script>