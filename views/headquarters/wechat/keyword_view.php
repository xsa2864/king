<link href="<?php echo input::cssUrl('tworel.css');?>" rel="stylesheet" type="text/css" />
<link href="<?php echo input::cssUrl('rqmd.css');?>" rel="stylesheet" type="text/css" />

            <div class="back_right" style="width:960px">
                <div class="zdyhy">
                    <div class="toubiaoti">自定义回复内容</div>
                    <div class="fubiaoti">提示：设置关键词自动回复，未匹配关键词时默认回复设置。</div>
                    <div class="cf">
                 <!--   <div><a href="#" class="bsbutton" style="color:#FFF">添加默认回复设置</a></div>-->
                    <div><a href="addTextKeyword" class="bsbutton" style="color:#FFF">添加文本回复关键字</a></div>
                        <div><a href="addSingleImgKeyword" class="bsbutton" style="color:#FFF">添加单图文回复关键字</a></div>
                    <div><a href="addMoreImgKeyword" class="bsbutton" style="color:#FFF">添加多图文回复关键字</a></div>
                    </div>
                    <div class="zdy_table  right">
                            <table class="zdy_table_a">
                                    <tr class="zdy_tableth">
                                        <th width="14%" style="text-align:left;">&nbsp;&nbsp; 类型</th>
                                        <th width="27%">关键词</th>
                                        <th width="46%">回答</th>
                                        <th width="13%">操作</th>
                                    </tr>





                                <?php
                                    foreach($result as $value) {
                                            if($value['mod'] == 1) {
                                                ?>
                                                <tr class="bdbottom">
                                                    <td width="14%" style="text-align:left">&nbsp;&nbsp; 文本回复</td>
                                                    <td width="27%"><?php echo $value['keyword'] ?></td>
                                                    <td width="46%"><?php echo $value['content'] ?></td>
                                                    <td width="13%" class="revise">
                                                        <h1 class="h1_one">
                                                            <a href="addTextKeyword/<?php echo $ml['manId'] ?>">修改<span style="margin-top:-5px;">∨</span></a>

                                                            <div class="revise_pop" style="display:none">
                                                                <a href="javascript:" onclick="if(confirm('确认删除?')){window.location.href='deleteReply/<?php echo $value['id'] ?>';}">删除</a>
                                                            </div>
                                                        </h1>
                                                    </td>
                                                </tr>
                                            <?php
                                            }elseif($value['mod'] == 2) {
                                                ?>
                                                <tr class="bdbottom">
                                                    <td width="14%" style="text-align:left">&nbsp;&nbsp; 单图文回复</td>
                                                    <td width="27%"><?php echo $value['keyword'] ?></td>
                                                    <td width="46%">
                                                        <a><img class="table_img" src="<?php echo $value['coverImg'] ?>" width="80"
                                                                height="80"/></a>

                                                        <p class="table_bt"><?php echo $value['keyword'] ?></p>

                                                        <p class="table_wb"><?php echo $value['brief'] ?></p>

                                                    </td>
                                                    <td width="13%" class="revise">
                                                        <h1 class="h1_one">
                                                            <a href="addSingleImgKeyword/<?php echo $ml['manId'] ?>">修改<span style="margin-top:-5px;">∨</span></a>

                                                            <div class="revise_pop" style="display:none">
                                                                <a href="javascript:" onclick="if(confirm('确认删除?')){window.location.href='deleteReply/<?php echo $value['id'] ?>';}">删除</a>
                                                            </div>
                                                        </h1>
                                                    </td>
                                                </tr>
                                            <?php
                                            }elseif(is_array($value['modelList'])) {
                                                ?>
                                                <tr height="310">
                                                    <td width="14%" style="text-align:left">&nbsp;&nbsp; 多图文回复</td>
                                                    <td width="27%">hello</td>
                                                    <td width="46%">
                                                        <?php
                                                            foreach($value['modelList'] as $k => $ml) {
                                                                ?>
                                                                <div class="cf">
                                                                    <a><img class="table_img" src="<?php echo $ml['coverImg'] ?>"
                                                                            width="80"
                                                                            height="80"/></a>

                                                                    <p class="table_bt"><?php echo $ml['keyword'] ?></p>
                                                                    </p>
                                                                </div>
                                                            <?php
                                                            }
                                                                ?>
                                                    </td>
                                                    <td width="13%" class="revise">
                                                        <h1 class="h1_one">
                                                            <a href="addMoreImgKeyword/<?php echo $ml['manId'] ?>">修改<span style="margin-top:-5px;">∨</span></a>

                                                            <div class="revise_pop" style="display:none">
                                                                <a href="javascript:" onclick="if(confirm('确认删除?')){window.location.href='deleteReply/<?php echo $ml['manId'] ?>';}">删除</a>
                                                            </div>
                                                        </h1>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                    }
                                    ?>



                            
                            </table>
                    </div>
                    <?php
                        echo $pagination->render();
                        ?>
                </div>

            </div>



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
	//弹出框
		$('.odd_gz').click(function(){
		open_box('#new_gz')		
	});

	
	
	
});
	$("input").focus(function(){
		$(this).css({'border-color':'#148cd7'})
	});
	$("input").blur(function(){
		$(this).css({'border-color':'#b7b7b7'})
	});



</script>


</body>
</html>
