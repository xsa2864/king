<script src="<?php echo input::jsUrl('date/date.js'); ?>" type="text/javascript"></script>
<link href="<?php echo input::cssUrl('date.css'); ?>" rel="stylesheet" type="text/css" />
<form name="commentForm" id="commentForm" method="get" action="index">
    <div class="back_right">
        <div class="right">
            <h1>商品评论</h1>
            <div class=" bor_box return_box cf">
                <dl class="cf">
                    <dd><span><input class="input9" type="text" name="username" id="username"  placeholder="名称/用户名" /></span></dd>
                    <dd class="select_box" >
                        <select class="puiSelect" name="opinion" id="opinion" style="width:120px">
                            <option value="">选择等级</option>
                            <?php
                                for($i = 1;$i <= 5;$i++) {
                                    ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?>颗星</option>
                                <?php
                                }
                            ?>
                        </select>
                    </dd>
                    <dd class="inp5"><span><input style="width:122px" name="start_time" id="start_time" type="text" class="puiDate" placeholder="订单日期" /></span>&nbsp;&nbsp;到&nbsp;</dd>
                    <dd class="inp5"><span><input style="width:122px" name="end_time" id="end_time" type="text" class="puiDate" placeholder="订单日期" /></span></dd>
                    <dd class="query_box"><a  href="javascript:" onclick="document.getElementById('commentForm').submit();">查询</a></dd>
                </dl>
            </div>
            <div class="edit_box sale_cen mar0">
                <div class="bq_box">
                    <div class="b5"></div>
                    <div class="sort_table dispa_tab" >
                        <table border="0">
                            <tr>
                                <th class="cen" width="6%" ><input name="" type="checkbox" value=""  class="check_all"></th>
                                <th class="align_left" width="31%" scope="col">商品名称</th>
                                <th width="12%" >用户名</th>
                                <th width="15%">评论内容</th>
                                <th width="10%">评论等级</th>
                                <th width="11%">评论时间</th>

                                <th width="15%">操作</th>
                            </tr>



                            <?php
                                foreach($tree as $t) {
                                    ?>
                                    <tr class="back">
                                        <td><input type="checkbox"/></td>
                                        <td class="sort_shop cf align_left">
                                            <span class=""><img src="<?php echo input::site(output_ext::getCoverImg($t->pics)) ?>" width="58" height="58"/></span>
                                            <span class="sp2"><?php echo $t->title ?></span>
                                        </td>
                                        <td><?php echo $t->realName ?><br/><?php echo $t->mobile ?></td>
                                        <td><i class="bold"><?php echo $t->content ?></i><i><?php if($t->reply != ''){echo $t->reply;}else{echo '暂无回复';} ?></i></td>
                                        <td><?php echo $t->opinion ?>颗星</td>
                                        <td><?php echo date('Y-m-d H:i:s',$t->ctime) ?></td>
                                        <td class="revise">
                                            <h1 class="h1_one">
                                                <a href="###" class="hf_rder">回复<span style="line-height:20px">∨</span></a>

                                                <div class="revise_pop" style="display:none">
                                                    <a href="#">显示</a><a href="#">删除</a>
                                                </div>
                                            </h1>

                                        </td>
                                    </tr>
                                <?php
                                }
                            ?>




                            <tr class="td3">
                                <td class=""  colspan="7">
                                    <span class="sp1"><input name="" type="checkbox" value=""  class="check_all"/><label>全选</label></span>
                                    <span class="sp2"><a href="#">删除</a></span>
                                </td>
                            </tr>

                        </table>
                        <?php
                        echo $pagination->render();
                        ?>
                    </div>
                </div>

            </div>
        </div>
</form>



<!--遮罩层-->
<div class="mask_box" style="display:none"></div>

<!--回复评论--->
<div class="up_box " style="display:none; width:358px;" id="up_box26">
    <h1>回复评论<i class="close"></i></h1>
    <div class="reply">
        <textarea name="" cols="" rows=""></textarea>
    </div>
    <div class="btn_two btn_width cf">
        <a class="a1 close" href="#">保存</a><a class="close" href="#">取消</a>
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
            $(".order_box2 ").hide().eq(index).show();
        });
        //全选
        $('.check_all').click(function(){
            var checked=$(this).is(':checked');
            $('.sort_table input[type=checkbox]').prop('checked',(checked ? 'checked' : false));
        });

        //移动到显示背景颜色
        $('.sort_table tr').hover(function(){
            $(this).css('background','#f5f5f5')
        },function(){
            $(this).css('background','#fff')

        });
        //移动到显示背景颜色
        $('.sort_table .td3').hover(function(){
            $(this).css('background','#fff')
        },function(){
            $(this).css('background','#fff')

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
        $('.hf_rder').click(function(){
            open_box('#up_box26')
        });


    });


</script>