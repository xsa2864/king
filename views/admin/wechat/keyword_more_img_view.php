<link href="<?php echo input::cssUrl('tworel.css');?>" rel="stylesheet" type="text/css" />
<link href="<?php echo input::cssUrl('rqmd.css');?>" rel="stylesheet" type="text/css" />

<script type="text/javascript">
    var nowId = 1;
    var editor_wechat;
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
    var siteUrl = '<?php echo input::site();?>';
</script>




<form name="moreForm" id="moreForm" method="post" action="<?php echo input::site('admin/wechat/saveMoreImgKeyword'); ?>">
<!--隐藏域，post是这里的值-->
    <input type="hidden" name="id" id="id" value="<?php echo $info[0]->id ?>">
    <input type="hidden" name="replyType" id="replyType" value="2">
    <?php
        if(isset($info)){
            foreach($info as $key => $value){
?>
                <input type="hidden" name="hidtitle[]" id="hidtitle_<?php echo $key+1 ?>" value="<?php echo $value->title ?>">
                <input type="hidden" name="hidcoverImg[]" id="hidcoverImg_<?php echo $key+1 ?>" value="<?php echo $value->coverImg; ?>">
                <input type="hidden" name="hiddisplayCover[]" id="hiddisplayCover_<?php echo $key+1 ?>" value="<?php echo $value->displayCover ?>">
                <input type="hidden" name="hidisLink[]" id="hidisLink_<?php echo $key+1 ?>" value="<?php echo $value->isLink ?>">
                <input type="hidden" name="hidcontentLink[]" id="hidcontentLink_<?php echo $key+1 ?>" value="<?php echo $value->contentLink; ?>">
                <input type="hidden" name="hidcontent[]" id="hidcontent_<?php echo $key+1 ?>" value="<?php echo $value->content; ?>">
            <?php
            }
        }else {
            ?>
            <!-- <input type="hidden" name="hidkeyword[]" id="hidkeyword_1" value="">-->
            <input type="hidden" name="hidtitle[]" id="hidtitle_1" value="">
            <input type="hidden" name="hidcoverImg[]" id="hidcoverImg_1" value="">
            <input type="hidden" name="hiddisplayCover[]" id="hiddisplayCover_1" value="0">
            <input type="hidden" name="hidisLink[]" id="hidisLink_1" value="0">
            <input type="hidden" name="hidcontentLink[]" id="hidcontentLink_1" value="">
            <input type="hidden" name="hidcontent[]" id="hidcontent_1" value="">

            <!-- <input type="hidden" name="hidkeyword[]" id="hidkeyword_2" value="">-->
            <input type="hidden" name="hidtitle[]" id="hidtitle_2" value="">
            <input type="hidden" name="hidcoverImg[]" id="hidcoverImg_2" value="">
            <input type="hidden" name="hiddisplayCover[]" id="hiddisplayCover_2" value="0">
            <input type="hidden" name="hidisLink[]" id="hidisLink_2" value="0">
            <input type="hidden" name="hidcontentLink[]" id="hidcontentLink_2" value="">
            <input type="hidden" name="hidcontent[]" id="hidcontent_2" value="">
        <?php
        }
    ?>
            <div class="back_right" style="width:960px; position:relative">
                <div class="gzshf cf">
                    <div class="toubiaoti">编辑单图文回复关键字</div>
                    <div class="hf_input">
                        <label>关键词：</label>
                        &nbsp;&nbsp;<input type="text" name="keyword" id="keyword" value="<?php echo $info[0]->keyword; ?>" placeholder=" 多个关键词请用,隔开，例如：红酒,白酒"/>&nbsp; 多个关键词请用,隔开，例如：红酒,白酒

                    </div>
                    <div class="hf_chekebox xg_chekebox">
                        <label>匹配规则：</label>
                        &nbsp;&nbsp;<input type="checkbox" />&nbsp; 完全匹配，用户输入的和此关键词一样才会匹配！
                    </div>       
                </div>
                
                <div class="gz_radio3">

                    <div class="hx_bottom">

                        <?php
                        if(isset($info)) {
                            foreach ($info as $key => $value) {
                               if($key == 0) {
                                        ?>
                                <div class="opatx_box2">
                                    <p class="gz_radio2_p" id="gz_sltbt_<?php echo $key+1 ?>"><?php echo $value->title; ?></p>
                                    <a href="#"><img style="display:none" src="<?php echo input::imgUrl('fmtp_03.png'); ?>" width="320" height="135"/>

                                        <img id="titleImgSrc_<?php echo $key+1 ?>" src="<?php echo $value->coverImg; ?>" width="320" height="135"/></a>
                                    <div class="tw_opat" style="display:none">
                                        <span class="back_tw"></span>
                                        <i id="siteId_<?php echo $key+1 ?>"></i>
                                    </div>
                                </div>
                               <?php
                               }else {
                                   ?>
                                   <div class="gz_radio3slt" id="gzrad_<?php echo $key + 1 ?>">
                                       <div class="opatx_box2">
                                           <p class="gz_sltbt"
                                              id="gz_sltbt_<?php echo $key + 1 ?>"><?php echo $value->title; ?></p>
                                           <a href="#"><img id="titleImgSrc_<?php echo $key + 1 ?>" class="gz_sltp"
                                                            src="<?php echo $value->coverImg; ?>" width="80"
                                                            height="80"/></a>

                                           <div class="tw_opat tw_opat2" style="display:none">
                                               <span class="back_tw"></span>
                                               <i id="siteId_<?php echo $key + 1 ?>"></i><em
                                                   id="emid_<?php echo $key + 1 ?>"></em>
                                           </div>
                                       </div>
                                   </div>
                               <?php
                               }
                            }
                        }else{
                            ?>
                            <div class="opatx_box2">
                                <p class="gz_radio2_p" id="gz_sltbt_1">标题</p>
                                <a href="#"><img style="display:none" src="<?php echo input::imgUrl('fmtp_03.png'); ?>" width="320" height="135"/>

                                    <img id="titleImgSrc_1" src="<?php echo input::imgUrl('wfxtp_03.png'); ?>" width="320" height="135"/></a>
                                <div class="tw_opat" style="display:none">
                                    <span class="back_tw"></span>
                                    <i id="siteId_1"></i>
                                </div>
                            </div>

                            <div class="gz_radio3slt" id="gzrad_2">
                                <div class="opatx_box2">
                                    <p class="gz_sltbt" id="gz_sltbt_2">标题</p>
                                    <a href="#"><img id="titleImgSrc_2" class="gz_sltp" src="<?php echo input::imgUrl('slt_03.png'); ?>"width="80"height="80"/></a>
                                    <div class="tw_opat tw_opat2" style="display:none">
                                        <span class="back_tw"></span>
                                        <i id="siteId_2"></i><em id="emid_2"></em>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>






                        <div class="tadd_btn"><a href="#"></a></div>
                   </div>
                   <div class="cf">
                        <div class="gz_submit"><a href="javascript:" onclick="checkSubmit();">保存</a></div>
                        <div class="gz_esc"><a href="#">取消</a></div>
                    </div>
               </div>
            </div>
            <div class="radio2_gz1" style="left:342px">
                        <div class="xsjimg"><img src="<?php echo input::imgUrl('xsj_03.png'); ?>" width="11"height="14"/></div>
                        <div><p class="radio2_gz_p">标题</p></div>
                        <div class="radio2_gz_input">
                                <p class="gzppp">0/64</p>
                                <input type="text" name="title" id="title" value="<?php echo $info[0]->title; ?>" oninput="if(this.value == ''){$('#gz_sltbt_'+nowId+'').html('标题');}else{$('#gz_sltbt_'+nowId+'').html(this.value);$('#hidtitle_'+nowId+'').val(this.value);}"/>
                        </div>
                        <div class="radio2_gz3">
                                <label>封面</label><span> ( 大图片建议尺寸：900像素 * 500像素)</span>
                        </div>
                        <div class="radio2_gza"><a href="javascript:" onclick="useImg();">上传图片</a></div>
                        <div class="radio2_gz4">
                                <input type="checkbox" name="displayCover" id="displayCover" value="1" onchange="if(this.checked == true){$('#hiddisplayCover_'+nowId+'').val(1);}else{$('#hiddisplayCover_'+nowId+'').val(0)}">&nbsp; 封面图片显示在正文中</input>
                        </div>
                        <div><p class="radio2_gz_p2">正文</p></div>
                        <div class="radio2_gz5">
                                <input type="radio" name="isLink" onchange="if(this.checked == true){$('#hidisLink_'+nowId+'').val(1);}else{$('#hidisLink_'+nowId+'').val(0);}"  value="1">&nbsp; 连接地址 <span> （设置后链接将指向此地址）</span></input>
                        </div>
                        <div class="radio2_gz_input"><input type="text" name="contentLink" id="contentLink" oninput="$('#hidcontentLink_'+nowId+'').val(this.value);" value="<?php echo $info[0]->contentLink ?>"/></div>
                        <div class="radio2_gz5">
                                <input type="radio" name="isLink" onchange="if(this.checked == true){$('#hidisLink_'+nowId+'').val(0);}else{$('#hidisLink_'+nowId+'').val(1);}" checked value="0">&nbsp; 内容编辑</input>
                        </div>
                        <div class="radio2_gzimg">
                            <textarea id="itemContent" class="form-control" style="width: 579px; height: 300px" name="wechatContent"><?php echo $info[0]->content; ?></textarea>
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
$(function(){
	//分类标签
	$('.edit_title li').click(function(){
		var index=$('.edit_title li').index(this);
		$('.edit_title li').removeClass('curr');
		$('.edit_title b').show();
		$(this).addClass('curr').find('b').hide();
		$(this).prev().find('b').hide();
		$(".table_box table").hide().eq(index).show();	
	});	
	//移动到显示
	$('.revise h1').hover(function(){
		$(this).parents('.revise').find('.revise_pop').toggle();
		return false;
		
	},function(){
		$(this).parents('.revise').find('.revise_pop').toggle();		
		return false;
	});
	//文本框颜色
	$("input").focus(function(){
		$(this).css({'border-color':'#148cd7'})
	});
	$("input").blur(function(){
		$(this).css({'border-color':'#b7b7b7'})
	});
	$("textarea").focus(function(){
		$(this).css({'border-color':'#148cd7'})
	});
	$("textarea").blur(function(){
		$(this).css({'border-color':'#b7b7b7'})
	});
	//移动到显示编辑
	$('.gz_radio3slt').hover(function(){
		$(this).find('.tw_opat').show();	
	},function(){
		$(this).find('.tw_opat').hide();	
	});

    //移动到显示编辑
    $('.opatx_box2').hover(function(){
        $(this).find('.tw_opat').show();
    },function(){
        $(this).find('.tw_opat').hide();
    });


	//编辑点击下去的样式
	$('.tw_opat i').mousedown(function(){
        var stid = this.id.split('_');
        var id = stid[1];
        //在切换到新的信息之前，保存编辑器的信息
        if(confirm('信息已经自动保存')) {
            //关键词
           // $("#hidkeyword_" + nowId + "").val($("#keyword").val());
           // $("#keyword").val($("#hidkeyword_" + id + "").val());
            //标题
        //    $("#hidtitle_" + nowId + "").val($("#title").val());
            $("#title").val($("#hidtitle_" + id + "").val());
            //封面是否显示  复选框
            if($('#hiddisplayCover_'+id+'').val() == 1){
                $("#displayCover").attr("checked",'checked');
            }else{
                $("#displayCover").removeAttr('checked');
            }
            //内容方式  是内容还是跳转地址
            $("input[name='isLink']").each(function() {
                if($(this).val() == $("#hidisLink_"+id+"").val()){
                    $(this).attr("checked",'checked');
                }
            });
            //连接地址
        //    $("#hidcontentLink_" + nowId + "").val($("#contentLink").val());
            $("#contentLink").val($("#hidcontentLink_" + id + "").val());

            //内容
            $("#hidcontent_" + nowId + "").val($("#itemContent").val());
            editor_wechat.html($("#hidcontent_" + id + "").val());

            nowId = id; //切换id
            //复制给当前的id编辑器

            $(this).addClass('i2');
        }
	});
	$('.tw_opat i').mouseup(function(){
		$(this).removeClass('i2');		
	});
	$('.tw_opat2 em').mousedown(function(){
        var stid = this.id.split('_');
        var id = stid[1];
        //删除一条信息
        if(id <= 2){
            alert('默认第一条和第二条信息不允许删除');
            return false;
        }
     //   $("#hidkeyword_"+id+"").remove();
        $("#hidtitle_"+id+"").remove();
        $("#hidcoverImg_"+id+"").remove();
        $("#hiddisplayCover_"+id+"").remove();
        $("#hidbrief_"+id+"").remove();
        $("#hidisLink_"+id+"").remove();
        $("#hidcontentLink_"+id+"").remove();
        $("#hidcontent_"+id+"").remove();
        $("#gzrad_"+id+"").remove();
		$(this).addClass('em2');		
	});
	$('.tw_opat2 em').mouseup(function(){
		$(this).removeClass('em2');		
	});
	// 编辑
	$('.gz_radio3 .opatx_box2').click(function(){
		var el = $(this),
			offset = el.offset();
		offset.left += el.width();
		offset.marginTop = '0px';
		$('.radio2_gz1').css(offset);
	}).eq(0).click();
	
	// 增加
    <?php
        if(isset($info)) {
            echo 'var countId = '.count($info).';';
        }else{
            echo 'var countId = 3;';
        }
    ?>

	$('.tadd_btn').click(function(){
        var length = $("input[name='hidkeyword[]']").length;
        if(length >= 8){
            alert('最多允许8条信息');
            return false;
        }
		var el = $('.gz_radio3 .gz_radio3slt').eq(-1),
        newel = el.clone(true);
        $('#gzrad_'+(countId-1)+'').attr('id','gzrad_'+ countId + ''); //后来添加，
        $('#emid_'+(countId-1)+'').attr('id','emid_'+ countId + ''); //后来添加，
        $('#siteId_'+(countId-1)+'').attr('id','siteId_'+ countId + ''); //后来添加，
        $("#titleImgSrc_"+(countId-1)+"").attr('id','titleImgSrc_'+ countId + ''); //后来添加，
        $("#gz_sltbt_"+(countId-1)+"").attr('id','gz_sltbt_'+ countId + ''); //后来添加，
		el.before(newel);
        //添加隐藏域
      //  $(".back_right").append('<input type="hidden" name="hidkeyword[]" id="hidkeyword_'+countId+'" value="">');
        $(".back_right").append('<input type="hidden" name="hidtitle[]" id="hidtitle_'+countId+'" value="">');
        $(".back_right").append('<input type="hidden" name="hidcoverImg[]" id="hidcoverImg_'+countId+'" value="">');
        $(".back_right").append('<input type="hidden" name="hiddisplayCover[]" id="hiddisplayCover_'+countId+'" value="0">');
      //  $(".back_right").append('<input type="hidden" name="hidbrief[]" id="hidbrief_'+countId+'" value="">');
        $(".back_right").append('<input type="hidden" name="hidisLink[]" id="hidisLink_'+countId+'" value="0">');
        $(".back_right").append('<input type="hidden" name="hidcontentLink[]" id="hidcontentLink_'+countId+'" value="">');
        $(".back_right").append('<input type="hidden" name="hidcontent[]" id="hidcontent_'+countId+'" value="">');
        countId = countId + 1;
		return false;
	});


	
});
//表单验证
function checkSubmit(){
    var flg = true;
    $("input[name='hidkeyword[]']").each(function(){
        var id = $(this).attr('id').split('_');
        id = id[1];
        //判断是否有没有输入的值
       // var keyword = $("#hidkeyword_"+id+"").val();
        var title = $("#hidtitle_"+id+"").val();
        var img = $("#hidcoverImg_"+id+"").val();
        if(title == '' || img == ''){
            flg = false;
            return false;
        }
    });
    if(flg == false){
        alert('标题，图片为必须输入项，请检查');
        return false;
    }
    $("#moreForm").submit();
}


function useImg() {
    open_box('#useImg_view');
    $('#useImg_view').attr('modid', "0");
}
function getImg(){
    var src = $(this).parents('li:first').find('img').attr('src');
    var modid = $('#useImg_view').attr('modid');
    $('.ze_box').each(function () {
        if ($(this).attr('style') == 'display: block;' || $(this).attr('style') == '') {
            var src = $(this).parents('li:first').find('img').attr('src');
            var srclist = src.split('_');
            var nsrc = srclist[0] + '.' + srclist[1].split('.')[1];
            $("#titleImgSrc_"+nowId+"").attr('src',nsrc);
            $("#hidcoverImg_"+nowId+"").val(nsrc);
            //  editor.insertHtml('<img src="' + nsrc + '">');
            //  re = true;
        }
    });
}

</script>

