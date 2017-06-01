<script type="text/javascript" src="<?php echo input::jsUrl('webuploader.js');?>"></script>
<link type="text/css" href="<?php echo input::cssUrl('webuploader.css');?>" rel="stylesheet" />

<div class="back_right right_width">
    <div class="right">
        <h1>查看商品</h1>
        <div class="cen_box">
            <div class="back_title bold">基本信息</div>
            <div class="bor_box">
                <dl class="cf">
                    <dt> <em class="asterisk">*</em>商品名称：</dt>
                    <dd>
                        <span><input id="title" type="text" placeholder="商品名称" value="<?php echo $item->title;?>"></span>
                    </dd>
                </dl>
               
                <dl class="cf">
                    <dt><em class="asterisk">*</em>商品主图：</dt>
                    <dd id="fileList">  
                        <?php
                        $picList = unserialize($item->pics);
                        if(is_array($picList))
                        {
                            foreach($picList as $key=>$value)
                            {
                                $pic = input::site($key);
                                $imgId = time().rand(10,99);
                                echo '<div id ="'.
                                $imgId.'" class="upload_img"><a class="file"><img name="picsList" src="'.
                                $pic.'" width="80" height="80" /></a><p class="layer_box" style="display: none"><a class="one" href="javascript:moveUp(\''.
                                $imgId.'\')"></a><a class="two" href="javascript:moveDown(\''.
                                $imgId.'\')"></a><a class="three" href="javascript:deleteImg(\''.
                                $imgId.'\')"></a></p></div>';
                            }
                        }
                        ?>       
                        
                    </dd>
                </dl>               
            </div>
        </div>
        <div class="cen_box mar_15">
            <div class="back_title bold">商品型号</div>
            <div class="edit_box width95 pad15 cf">
                <div class="order_box2 " style="display: block">
                    <div class=" member_cen">
                        <table class="thead tbody_cen">
                            <tr>
                                <th>型号图</th>
                                <th>型号名称</th>
                                <th>价格</th>
                                <th>库存</th>
                                <th>赠送积分</th>
                                <th>赠送金币</th>
                                <th>销量</th>                               
                            </tr>    
                            <?php
                            $default_img = input::site('library/admin/images').'/slt_03.png';              
                            foreach ($itemAttr as $key => $value) {
                               $pic_url =empty($value->attr_pic) ? $default_img:"http://".$_SERVER['SERVER_NAME'].'/'.$value->attr_pic;
                
                               echo '<tr>';
                               echo '    <td>';
                               echo '        <input type="hidden" id="thumb" name="attr_pic[]" value="'.$value->attr_pic.'">  ';
                               echo '        <img id="thumbsrc" src="'.$pic_url.'" style="width:50px;border: 1px solid red;">';
                               echo '    </td>';
                               echo '    <td><input type="text" name="attr_name[]" value="'.$value->attr_name.'"></td>';
                               echo '    <td><input type="text" name="attr_price[]" value="'.$value->attr_price.'"></td>';
                               echo '    <td><input type="text" name="attr_stock[]" value="'.$value->attr_stock.'"></td>';
                               echo '    <td><input type="text" name="attr_jifen[]" value="'.$value->attr_jifen.'"></td>';
                               echo '    <td><input type="text" name="attr_golds[]" value="'.$value->attr_golds.'"></td>';
                               echo '    <td><input type="text" name="sell_num[]" value="'.$value->sell_num.'"></td>';              
                               echo '</tr>     ';
          
                            }
                            if(empty($itemAttr)){
                            ?>
                            <tr>
                                <td>
                                    <input type="hidden" id="thumb" name="attr_pic[]">                  
                                    <img id="thumbsrc" src='<?php echo $default_img;?>' style="width:50px;border: 1px #c0c0c0 solid;">    
                                </td>
                                <td><input type="text" name="attr_name[]"></td>
                                <td><input type="text" name="attr_price[]"></td>
                                <td><input type="text" name="attr_stock[]"></td>
                                <td><input type="text" name="attr_jifen[]"></td>
                                <td><input type="text" name="attr_golds[]"></td>
                                <td><input type="text" name="sell_num[]"></td>
                                <td><a href="javascript:;" onclick="del(this)">删除</a></td>
                            </tr> 
                            <?php
                            }
                            ?>
                        </table>
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
                        <textarea id="itemContent" class="form-control" style="width: 866px; height: 300px" name="content">
                            <?php echo $item->content;?>
                        </textarea>
                    </div>
                </div>
            </div>           
        </div>       
        <div class="cen_box mar_15">            
            <div class="back_title bold">设置分类</div>   
            <div id="css_cate" style="">
                <?php           
                $arr_cate = explode(',', $item->cateId);
     
                foreach($tree as $key=>$value)
                {
                    if(in_array($value['id'], $arr_cate)){
                        $checked = "checked";
                    }
                    echo '<div>
                            <input type="checkbox" id="c'.$key.'" name="cateId[]" value="'.$value['id'].'" '.$checked.'/>
                            <label for="c'.$key.'"><b>'.$value['text'].'</b></label>
                        </div>';
                    if(!empty($value['children'])){
                        foreach($value['children'] as $key=>$values){
                            if(in_array($value['id'], $arr_cate)){
                                $checkeds = "checked";
                            }
                            echo '<p>
                                    <input type="checkbox" id="cs'.$key.'" name="cateId[]" value="'.$values['id'].'" '.$checkeds.'/>
                                    <label for="cs'.$key.'">'.$values['text'].'</label>
                                </p>';
                            $checkeds = "";
                        }
                    }
                    $checked = "";
                }
                ?>                 
            </div>
        </div>    
        <div class="cen_box mar_15">            
            <div class="back_title bold">运费设置</div>
            <div class="bor_box">            
               <input type="radio" name="postage" value="1" <?php if($item->postage==1){echo "checked=true";}?>> 包邮 
               <input type="radio" name="postage" value="0" <?php if($item->postage==0){echo "checked=true";}?>> 不包邮
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
   
// file选择框
$('#thumbsrc').click(function(){    
    $('#file').click();
})    
</script>