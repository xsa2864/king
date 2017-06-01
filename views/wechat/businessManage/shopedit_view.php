    <script type="text/javascript" src="<?php echo input::jsUrl('linkage/linkage.js','wechat');?>"></script>
    <link href="<?php echo input::jsUrl("linkage/linkage.css",'wechat'); ?>" rel="stylesheet" type="text/css" />

    <script type="text/javascript">
        // logo图片上传
        function wx_upload(){   
            $("#save_edit").unbind("click");
            wx.chooseImage({
                count: 1, // 默认9
                sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
                sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
                success: function (res) {
                    var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片  
                    wx.uploadImage({
                        localId: localIds[0], // 需要上传的图片的本地ID，由chooseImage接口获得
                        isShowProgressTips: 1, // 默认为1，显示进度提示
                        success: function (res) {
                            var serverId = res.serverId; // 返回图片的服务器端ID    
                            $("#logo_pic").attr('src',localIds);
                            $.post('<?php echo input::site("wechat/businessManage/get_material")?>',{'serverId':serverId},
                                function(data){
                                    $("input[name=logo_url]").val(data);
                                    $("#save_edit").on("click",function(){save();})
                                })
                        }
                    });  
                }
            });    

        }
        var blick_numl = 0;
        var flag = true;
        // 内容图片上传
        function content_upload(){  
            var content = $("#content").html();
            var index = -1; //定义变量index控制索引值
            var n = 0;
            do {
                index = content.indexOf("<img", index + 1); 
                if (index != -1) { //可以找到字符
                    n++;
                }
            } while (index != -1); 

            if(flag){
                blick_numl = n;
                flag = false;
            }
            
            if(blick_numl>=10){
                alert("图片最多只能上传10张");
                return false;
            }
            var m = (10-blick_numl)>=5?5:(10-blick_numl);
            wx.chooseImage({
                count: m, // 默认9
                sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
                sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
                success: function (res) {
                    var localIds = res.localIds;
                    syncUpload(localIds,0);                     
                    $("#content_upload").unbind("click");
                }
            }); 
        }
        var syncUpload = function(localIds,i){   
                blick_numl++;                       
                wx.uploadImage({
                    localId: localIds[i], // 需要上传的图片的本地ID，由chooseImage接口获得
                    isShowProgressTips: 1, // 默认为1，显示进度提示
                    success: function (res) {
                        var serverId = res.serverId; // 返回图片的服务器端ID  
                        $.post('<?php echo input::site("wechat/businessManage/get_material")?>',{'serverId':serverId},
                            function(data){
                                var fx_prefix   = location.protocol+'//'+location.hostname+'/';
                                var img = "<img src="+fx_prefix+data+" width='100%'>";
                                $("#content").append(img);
                            })
                        if(typeof(localIds[i+1]) != "undefined"){                            
                            syncUpload(localIds,i+1);
                        }else{
                            $("#content_upload").on("click",function(){content_upload();})
                        }
                    }
                }); 
        }

    </script>
    <header class="header buys pad0">
        <div class="favorites">
            <p><a class="return" href="javascript:history.go(-1);"><i></i>返回</a></p>
             <span class="edit" id="save_edit">完成</span>
        </div>
    </header>
    <div class="container pad1">
        <div class="name_cen">
            <div class="name_box back2">
                <dl class="name_h1 tb">
                    <dt>
                        <input type="hidden" name="logo_url" value="<?php echo $shop->pic;?>">
                        <img src="<?php echo $shop->pic==''?input::imgUrl('default.png','wechat'):input::site($shop->pic);?>" id="logo_pic"/>
                        <span><em></em><i onclick="wx_upload()"></i></span>
                        <!-- <form id="form1">                            
                            <input type="file" name="file" accept=".jpe,.jpeg,.jpg,.png,.gif" />
                        </form> -->
                    </dt>
                    <dd class="flex_1">
                        <div class="text_input">
                            <div class="text_hidden">
                                <input type="hidden" name="id" value="<?php echo $shop->id;?>">
                                <span contenteditable="true" data-placeholder="店铺名称还没取" name="name" style="padding-left: 10px;"><?php echo $shop->name;?></span>
                            </div><i></i>
                        </div>
                    </dd>
                </dl>
                <dl class="name_h2 tb">
                    <dt style="width: 26%;"><font>*</font>联系人：</dt>
                    <dd class="flex_1"><input type="text" name="realname" value="<?php echo $shop->realname;?>" /></dd>
                </dl>
                <dl class="name_h2 tb">
                    <dt style="width: 26%;"><font>*</font>联系电话：</dt>
                    <dd class="flex_1"><input type="text" name="mobile" value="<?php echo $shop->mobile;?>" /></dd>
                </dl>
                <dl class="name_h2 tb">
                    <dt style="width: 26%;"><font>*</font>店铺地址：</dt>
                    <dd class="flex_1 linkage_el coord" >
                        <input type="hidden" name="latng" id="latng" value="<?php echo $latng;?>">
                        <a href="javascript:;" style="color:#5053EC;">去定位</a><i style="margin-top:auto !important;top:0px;"></i>
                        <!-- <a href="#" name="city"><?php echo empty($shop->city)?'所在地区':$shop->city;?></a><i></i>
                        <select name="s">
                        <?php 
                        foreach ($provincial as $key => $value) {
                            echo '<option value='.$value->id.'>'.$value->name.'</option>';
                        }
                        ?>
                        </select>
                        <select name="c" id="city">                            
                        </select>
                        <select name="a" id="city2">
                        </select> -->
                    </dd>
                </dl>
                <dl class="name_h2 tb">
                    <dt style="width: 26%;">定位地址：</dt>
                    <dd class="flex_1"><input type="text" name="address" readonly="true" value="<?php echo $address?$address:$shop->address;?>"  style="color:#8e8e8e"/></dd>
                </dl>
                <p class="name_h3">
                    <textarea placeholder="还没说清您的店铺地址吗？请在这里输入  如：9单元102室/19层1925室" name="full_address"><?php echo $shop->full_address;?></textarea>
                </p>
            </div>
            <div class="name_box2 back2">
                <p class="f32">详情介绍</p>
                <div class="text_input">                
                    <div id="content" contenteditable="true" style="font-size: 14px;max-height: 400px;overflow-y: auto;min-height: 300px;width: 100%;"><?php echo $shop->content;?></div>               
                </div>
            </div>   
            <form id="form2">
            <div class="name_box3 back2">
                <p id="content_upload">
                    <!-- <input type="file" name="file" id="pic" accept=".jpe,.jpeg,.jpg,.png,.gif" onchange="uploads()" /> -->
                    <img src="<?php echo input::site('library/wechat/images/add_03.png');?>" />
                </p>
                <font>限10张图片</font>
            </div> 
            </form>       
        </div>
    </div> 

<script>
$(function(){
    $('.text_input i').on('touchstart',function(){
        $(this).parents('.text_input').find('span').html('');   
    });
    
    // $('.linkage_el').linkage(); // 触发选择区域
    
    // $('select[name=a]').on('change',function(){
    //     $('.linkage_el>a').html($('select[name=s] :selected').text() + $('select[name=c] :selected').text() + $('select[name=a] :selected').text());
    // });
    
    // 切换城市示例 // AJAX切换option数据时执行$('select[name=s]').trigger('reset_linkage');
    // $('select[name=s]').on('change',function(){
    //     $(this).closest('div').find('select[name=c]').empty().html('<option value="1">北京市</option><option value="2">上海市</option><option value="3">广州市</option><option value="4">深圳市</option><option value="5">珠海市</option>');
    // });
});

// 保存信息
function save(){
    var id = $("input[name=id]").val();
    var logo_url = $("input[name=logo_url]").val();
    var name = $("span[name=name]").html();
    var realname = $("input[name=realname]").val();
    var mobile = $("input[name=mobile]").val();
    var city = $("a[name=city]").html();
    var address = $("input[name=address]").val();
    var full_address = $("textarea[name=full_address]").val();
    var content = $("#content").html();
    var latng = $("input[name=latng]").val();

    var rule = /^[0-9]{10,12}$/;

    if(name==""||name==null){
        alert('店铺名称不能为空');
        return false;
    }
    if(realname==""||realname==null){
        alert('联系人姓名不能为空');
        return false;
    }
    if(!rule.exec(mobile)){
        alert('联系电话为10~12位的数字');
        return false;
    }
    if(address==""||address==null){
        alert('请定位店铺地址');
        return false;
    }
    // if(full_address==""||full_address==null){
    //     alert('详细地址不能为空');
    //     return false;
    // }
    $.post('<?php echo input::site("wechat/businessManage/save_business");?>',
        {'id':id,'logo_url':logo_url,'name':name,'realname':realname,'mobile':mobile,'city':city,'full_address':full_address,'content':content,'latng':latng,'address':address},
        function(data){
            var data = eval("("+data+")");
            if(data.success == 1){
                location.href = '<?php echo input::site("wechat/businessManage/shopdetail");?>';
            }else{
                alert(data.msg);
            }
    })
}

// 去定位前保存信息保存信息
function temp_save(){
    var id = $("input[name=id]").val();
    var logo_url = $("input[name=logo_url]").val();
    var name = $("span[name=name]").html();
    var realname = $("input[name=realname]").val();
    var mobile = $("input[name=mobile]").val();
    var city = $("a[name=city]").html();
    var address = $("input[name=address]").val();
    var full_address = $("textarea[name=full_address]").val();
    var content = $("#content").html();
    var latng = $("input[name=latng]").val();
    $.post('<?php echo input::site("wechat/businessManage/save_business");?>',
        {'id':id,'logo_url':logo_url,'name':name,'realname':realname,'mobile':mobile,'city':city,'full_address':full_address,'content':content,'latng':latng,'address':address},
        function(data){            
    })
}
// 获取城市列表
$('select[name=s]').on('change',function(){
    var id = $(this).val();
    show_city(id);
});
$('select[name=c]').on('change',function(){
    var id = $(this).val();
    show_city2(id);
});
function show_city(id){
    $.post('<?php echo input::site("wechat/businessManage/get_city")?>',{'id':id},
        function(data){
            var data = eval("("+data+")");
            var op_str = '';
            var li_str = '';
            for(var i=0;i<data.length;i++){                
                op_str += '<option value='+data[i].id+'>'+data[i].name+'</option>';
                li_str += '<li value='+data[i].id+'>'+data[i].name+'</li>';
            }              
            $("#city").html(op_str);
            $(".linkage_list>.linkage_flex:nth-child(3) div>ul").html(li_str);     
            show_city2(data[0].id)
    })
}
function show_city2(id){
    $.post('<?php echo input::site("wechat/businessManage/get_city")?>',{'id':id},
        function(data){
            var data = eval("("+data+")");
            var op_str = '<option></option>';
            var li_str = '<li></li>';
            for(var i=0;i<data.length;i++){
                op_str += '<option value='+data[i].id+'>'+data[i].name+'</option>';
                li_str += '<li value='+data[i].id+'>'+data[i].name+'</li>';
            }              
            $("#city2").html(op_str);
            $(".linkage_list>.linkage_flex:nth-child(4) div>ul").html(li_str);
    })
}
$(function(){
    show_city('110000');
});
$(".coord").click(function(){
    temp_save();
    var url = '<?php echo input::site("wechat/businessManage/shop_edit")?>';
    location.href="http://apis.map.qq.com/tools/locpicker?search=1&type=0&backurl="+url+"&key=NC6BZ-JAO3K-OCOJG-AKHSS-WTZCV-RGF5G&referer=mymobile";

})

$("#content_upload").on("click",function(){
    content_upload();
})
$("#save_edit").on("click",function(){
   save();
})
</script>
