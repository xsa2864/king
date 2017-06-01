<!--<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <h1></h1><legend>广告管理</legend>
            <table class="table table-hover table-bordered" width="500px">
                <a class="btn btn-primary" target="menu" href="/admin/advert/add"><span class="glyphicon glyphicon-plus" aria-hidden="true">添加广告</span></a>
                <hr />
                <thead>
                    <tr>
                        <th class="text-center info">广告名称</th>
                        <th class="text-center info">广告图片</th>
                        <th class="text-center info">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
					$deleteMessage = "'确认删除吗？'";
					foreach($adList as $row)
					{
						$pic	= input::site(output_ext::getCoverImg($row->pics,$type="200x50"));
						$table = '<tr>
							<td class="text-center">'. $row->name.'</td>
							<td class="text-center"><img src="'. $pic.'"></td>
							<td class="text-center">
							<a class="btn btn-info btn-xs" target="menu" href="/admin/advert/getAdPosition/'.$row->id.'"><span class="glyphicon glyphicon-edit" aria-hidden="true">投放广告</span></a>&nbsp;
							<a class="btn btn-info btn-xs" target="menu" href="/admin/advert/edit/'.$row->id.'"><span class="glyphicon glyphicon-edit" aria-hidden="true">修改</span></a>&nbsp;
							<a class="btn btn-danger btn-xs" target="menu" href="/admin/advert/delete/'.$row->id.'" onclick="return confirm('.$deleteMessage.')"><span class="glyphicon glyphicon-trash" aria-hidden="true">删除</span></a>
							</td>
							</tr>';
						echo $table;
					}
                    ?>
                </tbody>
            </table>
            <?php
            //echo $pagination->render();
            ?>
        </div>
    </div>
</div>-->
<script type="text/javascript" src="<?php echo input::jsUrl('webuploader.js');?>"></script>
<link type="text/css" href="<?php echo input::cssUrl('webuploader.css');?>" rel="stylesheet" />
<form>
    <div class="back_right">
        <div class="right">
            <h1>广告列表</h1>
            <div class=" adve_box">
                <h2><!--<a href="#">新增广告</a>--></h2>
                <div class=" bor_box stock_box cf">
                    <dl class="cf">
                        <dd><span>
                            <!--<input class="input9" type="text" placeholder="名称 / 频道 / 位置" />--></span></dd>
                        <dd class="select_box">
                            <!--<select class="puiSelect" style="width: 124px">
                                <option value="">类型</option>
                                <option value="">类型</option>
                                <option value="">类型</option>
                            </select>-->

                        </dd>
                        <dd class="select_box">
                            <!--<select class="puiSelect" style="width: 124px">
                                <option value="">终端</option>
                                <option value="">终端</option>
                                <option value="">一级分类3</option>
                            </select>-->

                        </dd>
                        <dd class="query_box"><!--<a href="###">查询</a>--></dd>
                    </dl>
                </div>
                <div class="b6">
                    <div class="bor_box  stock_table  ">
                        <table class="adve_tab" width="100%" border="0">
                            <tr>
                                <th width="5%" scope="col">序号</th>
                                <th class="left" width="27%" scope="col">广告名称</th>
                                <th width="5%" scope="col">类型</th>
                                <th width="10%" scope="col">终端</th>
                                <th width="7%" scope="col">频道</th>
                                <th width="8%" scope="col">位置</th>
                                <th colspan="2" width="22%" scope="col">内容</th>
                                <th width="16%" scope="col">操作</th>
                            </tr>
                            <?php
                            foreach($adList as $ad)
                            {
                                echo '<tr>
                                <td>'.$ad->id.'</td>
                                <td class="left">'.$ad->name.'</td>
                                <td>'.$ad->adType.'</td>
                                <td>'.$ad->terminal.'</td>
                                <td>'.$ad->channel.'</td>
                                <td>'.$ad->site.'</td>
                                <td>
                                    <span class="img">
                                        <img src="'.$ad->pic.'" width="60" height="60" /></span>
                                </td>
                                <td></td>
                                <td class="revise">
                                    <h1>
                                        <a style="cursor: pointer;" adid="'.$ad->id.'" adpicsize="'.$ad->picSize.'" adname="'.$ad->name.'" adtype="'.$ad->adType.'" adter="'.$ad->terminal.'" adpic="'.$ad->pic.'" adurl="'.$ad->url.'" adsite="'.$ad->site.'" adchannel="'.$ad->channel.'" class="fenl_btn">编辑</a>                                        
                                    </h1>
                                </td>
                            </tr>';
                            }
                            ?>
                            <!--<tr>
                                <td>1</td>
                                <td class="left">精选好酒</td>
                                <td>商品</td>
                                <td>PC/移动端</td>
                                <td>首页</td>
                                <td>实例位置1</td>
                                <td>
                                    <span class="img">
                                        <img src="images/galb_03.png" width="60" height="60" />&nbsp;&nbsp;&nbsp;&nbsp;茅台</span>
                                </td>
                                <td>X15</td>
                                <td class="revise mar_cen">
                                    <h1>
                                        <a href="#" class="fenl_btn">编辑&nbsp;&nbsp; ∨</a>
                                        <div class="revise_pop" style="display: none">
                                            <a href="#">删除</a>
                                        </div>
                                    </h1>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td class="left">精选好酒</td>
                                <td>商品</td>
                                <td>PC/移动端</td>
                                <td>首页</td>
                                <td>实例位置1</td>
                                <td>
                                    <span class="img">
                                        <img src="images/galb_06.png" width="136" height="38" /></span>
                                </td>
                                <td>X15</td>
                                <td class="revise mar_cen">
                                    <h1>
                                        <a href="#" class="fen1_btn2">编辑&nbsp;&nbsp; ∨</a>
                                        <div class="revise_pop" style="display: none">
                                            <a href="#">删除</a>
                                        </div>
                                    </h1>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td class="left">精选好酒</td>
                                <td>商品</td>
                                <td>PC/移动端</td>
                                <td>首页</td>
                                <td>实例位置1</td>
                                <td>
                                    <span class="img">七夕小礼物七夕小礼物七夕</span>
                                </td>
                                <td>X15</td>
                                <td class="revise mar_cen">
                                    <h1>
                                        <a href="#" class="fenl_btn3">编辑&nbsp;&nbsp;  ∨</a>
                                        <div class="revise_pop" style="display: none">
                                            <a href="#">删除</a>
                                        </div>
                                    </h1>
                                </td>
                            </tr>-->
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
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
	
	$('.fenl_btn').click(function () {
	    $('#adname').attr('adid',$(this).attr('adid'));
	    $('#adname').html($(this).attr('adname'));
	    $('#adtype').html($(this).attr('adtype'));
	    $('#adter').html($(this).attr('adter'));
	    $('#adpic').attr('src', $(this).attr('adpic'));
	    $('#adurl').val($(this).attr('adurl'));
	    $('#adsite').html($(this).attr('adsite'));
	    $('#adchannel').html($(this).attr('adchannel'));
	    $('#adpicsize').html($(this).attr('adpicsize')+'（请按分辨率选择图片）');
	    open_box('#edit_view');
		return false;	
	});
	
	$('tbody_cen select').trigger('resetStyle')

});


</script>