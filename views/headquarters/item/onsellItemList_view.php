<div class="back_right">
    <div class="right right_mar">
        <h1>在售商品管理</h1>
        <div class="sale_box">
            <h2><a href="<?php echo input::site('admin/item/add');?>">新增商品</a></h2>
            <form>
            <div class="bor_box bor_none cf">
                <dl class="cf">
                    <dd class="select_box">
                        <select id="categroy1" name="categroy1" class="puiSelect" size="10">
                            <option value="0" selected>全部</option>
                            <?php   
                            foreach($tree as $value){
                                $selected = '';
                                if($value['id'] == $cateId){
                                    $selected="selected";
                                }
                                echo '<option value="'.$value['id'].'"'.$selected.'>'.$value['text'].'</option>';                            
                                 if($value['children']){
                                     foreach($value['children'] as $value2){
                                        $selected = '';
                                        if($value2['id'] == $cateId){
                                            $selected="selected";
                                        }
                                        echo '<option value="'.$value2['id'].'"'.$selected.'>&nbsp;&nbsp;&nbsp;'.$value2['text'].'</option>';
                                     }
                                 }
                            }
                            ?>                            
                        </select> 
                    </dd>
                </dl>
                <dl class=" bor_box stock_box cf">
                    <dl class="cf">
                        <dd class="inp5">                                            
                            <input id="itemId" name="itemId" value="<?php echo $itemId; ?>" type="text" placeholder="商品ID" />
                        </dd>
                    </dl>
                    <dl class="cf">
                        <dd class="inp5">   
                            <input id="keyword" type="text" name="keyword" placeholder="输入关键字" value="<?php echo $keyword; ?>" />
                        </dd>
                        <dd><button>查询</button></dd>
                    </dl>
                </dl>
            </div>
            </form>
        </div>
        <div class="edit_box sale_cen">
            <div class="title_all" style="width: 970px;">
                <ul class="edit_title bold cf">
                    <li <?php if($status == 1){echo 'class="curr"';}?>>
                        <a style="cursor:pointer;" href="<?php echo input::site('admin/item/onsellItem');?>
                            ">在售中 <i>（<?php echo $sales;?>）</i>
                        </a> <b></b>
                    </li>
                    <li <?php if($status == 0){echo 'class="curr"';}?>>
                        <a style="cursor:pointer;" href="<?php echo input::site('admin/item/downItem');?>
                            ">仓库中 <i>（<?php echo $downNum;?>）</i></a> <b></b>
                    </li>
                    <li <?php if($status == 2){echo 'class="curr"';}?>>
                        <a style="cursor:pointer;" href="<?php echo input::site('admin/item/sellOut');?>
                            ">已售罄 <i>（<?php echo $sellOut;?>）</i></a> <b></b>
                    </li>
                    <li <?php if($status == 3){echo 'class="curr"';}?>>
                        <a style="cursor:pointer;" href="<?php echo input::site('admin/item/warmItem');?>
                            ">警戒中 <i>（<?php echo $warm;?>）</i></a> <b></b>
                    </li>
                </ul>

            </div>
            <div class="bq_box" style="width: 970px;">
                <div class="edit_cen sort_table">
                    <table border="0">
                        <tr>
                            <th class="cen" width="5%" scope="col">
                                <input name="" type="checkbox" value="" class="check_all" id="check_all">
                            </th>
                            <th class="align_left" width="35%" scope="col">商品</th>
                            <th width="6%" scope="col">销量</th>                                
                            <th width="18%" scope="col">创建时间</th>
                            <th scope="col">操作</th>
                        </tr>
                        <?php
                        foreach($itemList as $item)
                        {
                            echo '<tr class="back">
                            <td>
                                <input name="checkbox" itemid="'.$item->id.'" type="checkbox"/></td>
                            <td class="sort_shop cf align_left" style="text-align:left;">
                                <span class="">
                                    <img src="'.input::site(output_ext::getCoverImg($item->pics)).'" width="80" height="80" />
                                </span>
                                <span class="sp2" style="padding-left: 10px;">'.$item->title.'<br><label id="price">'.$item->price.'</label><br>'.$item->points.'<br>'.$item->store.'</span>
                            </td>                              
                            <td>'.$item->sales.'</td>
                            <td>'.date('Y-m-d H:i:s',$item->addtime).'</td>
                            <td class="revise">
                                <a href="'.input::site('admin/item/edit/'.$item->id).'">修改</a>
                                <a href="javascript:;" onclick="delItem('.$item->id.',this)">删除</a>
                                <a href="'.input::site('admin/item/edit/'.$item->id).'">查看</a>
                                <a href="'.input::site('admin/item/edit/'.$item->id).'">复制地址</a>
                                <a href="'.input::site('admin/item/edit/'.$item->id).'">二维码</a>
                            </td>
                        </tr>';
                        }
                        ?>
                        <tr>
                            <th class="left" colspan="8" class="cen" width="8%" scope="col">
                                <input name="" id="box" type="checkbox" class="check_all" id="check_all" style="margin-left:20px;">
                                <label for="box">&nbsp;&nbsp;&nbsp;全选</label>
                            </th>
                        </tr>
                    </table>
                </div>
                <div class=" cf bottom_page">
                    <div class="bottom_btn cf"> 
                        <a class="bottom" href="javascript:downCheckedItem()">加入仓库</a>
                        <a class="bottom" href="javascript:upCheckedItem()">商品上架</a>                        
                        <a class="bottom" href="javascript:delItems()">删除</a>
                        <a class="bottom" href="javascript:changePrices()">修改价格</a>
                        <a class="bottom" href="javascript:downCheckedItem()">修改分类</a>
                    </div>
                    <div class="page">
                        <?php echo $pagination->render();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- 调整积分 -->
<div class="up_box up_hy" style="display: none; width: 358px;" id="changePoints_view">
    <h1>调整价格<i class="close"></i></h1>
    <div class="par_bottom">
        <div class="inspection" style="margin-top: 10px;padding-left: 22px;">
            <dl class="cf up_hy_dl padd_a">
                <dt class="bold">调整价格：</dt>
                <dd class="input1">
                    <input id="changeprice" type="text">
                </dd>
            </dl>            
        </div>
    </div>
    <div class="btn_two btn_width cf">
        <a class="a1 close" style="cursor: pointer;" onclick="javascript:savePrices()">确定</a>
        <a class="close" style="cursor: pointer;">取消</a>
    </div>
</div>
<style type="text/css">
#changePoints_view .up_hy_dl>dt{width: 80px;}
#changePoints_view .inspection>.padd_a{padding-bottom: 10px;}
</style>

<script type="text/javascript">
    $(function () {
        //全选
        $('.check_all').click(function () {
            var checked = $(this).is(':checked');
            $('.sort_table input[type=checkbox]').prop('checked', (checked ? 'checked' : false));
        });
        //移动到样式
        $('.sort_table tr td:not(.revise)').hover(function () {
            $(this).parents('tr:first').css({ 'background': '#f5f5f5' });
            return false;
        }, function () {
            $(this).parents('tr:first').css({ 'background': 'none' });
            return false;

        });
        //移动到显示
        $('.revise h1').hover(function () {
            $(this).parents('.revise').find('.revise_pop').toggle();
            return false;

        }, function () {
            $(this).parents('.revise').find('.revise_pop').toggle();
            return false;
        });
    });
    // 批量上架
    function upCheckedItem() {
        $("input:checkbox[name='checkbox']:checked").each(function () {
            var id = $(this).attr('itemid');
            var note = $(this.parentNode.parentNode);
            $.post(
                "<?php echo input::site('admin/item/opItem') ?>", 
                {'id':id,'status':1}, 
                function (data) {
                    var data = eval('('+data+')');
                    if(data.success == 1){
                        note.slideUp();           
                    }else{
                        alert(data.msg);
                    }
                }
            );
        });        
    }
    // 批量下架
    function downCheckedItem() {
        $("input:checkbox[name='checkbox']:checked").each(function () {
            var id = $(this).attr('itemid');
            var note = $(this.parentNode.parentNode);
            $.post(
                "<?php echo input::site('admin/item/opItem') ?>", 
                {'id':id,'status':0}, 
                function (data) {
                    var data = eval('('+data+')');
                    if(data.success == 1){
                        note.slideUp();           
                    }else{
                        alert(data.msg);
                    }
                }
            );
        });               
    }

    function downItem(id) {
        $.post("<?php echo input::site('admin/item/listDown') ?>", { 'id': id }, function (data) {
            var da = JSON.parse(data);
            if(da.success==1)
            {
                location.replace(location.href);
            }else{
                alert(da.msg);
            }
        });
    }

    function fix_select(selector) {
        var i = $(selector).parent().find('div,ul').remove().css('zIndex');
        $(selector).unwrap().removeClass('jqTransformHidden').jqTransSelect();
        $(selector).parent().css('zIndex', i + 1);
    }

    // function loadCategory(id, val) {
    //     $.post("<?php echo input::site('admin/category/getCategoryOption') ?>", { 'id': val },
    //                     function (data) {
    //                         if (id == 1) {
    //                             $('#categroy2').html(data);
    //                             fix_select('select#categroy2');
    //                             $('#itemAttr').html('');
    //                         }
    //                         else if (id == 2) {
    //                             if (val > 0) {
    //                                 $('#categroy3').html(data);
    //                             }
    //                             else {
    //                                 $('#categroy3').html($('#categroy2').html());
    //                             }
    //                             fix_select('select#categroy3');
    //                         }
    //                     });
    // }

    function selectItem()
    {
        /*
        var itemTitle = $('#itemTitle').val();
        var itemCode = $('#itemCode').val();
        var categroy1 = $('#categroy1').val();
        var categroy2 = $('#categroy2').val();
        var categroy3 = $('#categroy3').val();*/
        //location.href = '<?php echo input::site('admin/item/onsellItemList?')?>' + 'itemTitle=' + itemTitle + '&itemCode=' + itemCode + '&categroy1=' + categroy1 + '&categroy2=' + categroy2 + '&categroy3=' + categroy3;
        $("#listForm").submit();
    }

    //设置排序
    function orderSite(type,field){
        $("#orderField").val(field);
        $("#orderType").val(type)
        $("#listForm").submit();
    }
    // 删除单个
    function delItem(id,tr){
        if(confirm("确定删除!")){           
            var note = $(tr.parentNode.parentNode);
            $.post(
                "<?php echo input::site('admin/item/delete') ?>", 
                {'id':id}, 
                function (data) {
                    var data = eval('('+data+')');
                    if(data.success == 1){
                        note.fadeOut("slow");
                    }else{
                        alert(data.msg);
                    }
                }
            );      
        }
    }
    // 批量删除
    function delItems(){
        if(confirm("确定删除!")){
            $("input:checkbox[name='checkbox']:checked").each(function () {
                var id = $(this).attr('itemid');
                var note = $(this.parentNode.parentNode);
                $.post(
                    "<?php echo input::site('admin/item/delete') ?>", 
                    {'id':id}, 
                    function (data) {
                        var data = eval('('+data+')');
                        if(data.success == 1){
                            note.slideUp();           
                        }else{
                            alert(data.msg);
                        }
                    }
                );
            });      
        }
    }
    // 改价弹窗
    function changePrices() {            
        open_box('#changePoints_view')
    };
    // 批量修改价格
    function savePrices(){        
        var changeprice = parseInt($('#changeprice').val());
        if(changeprice<0){
            alert("价格不能为负数!");
            return false;
        }
        $("input:checkbox[name='checkbox']:checked").each(function () {
            var id = $(this).attr('itemid');
            $.post(
                "<?php echo input::site('admin/item/saveprice') ?>", 
                {'id':id,'price':changeprice}, 
                function (data) {
                    var data = eval('('+data+')');
                    if(data.success == 1){
                       setTimeout(window.location.reload(),1500);
                    }else{
                        alert("操作失败!");
                    }
                }
            );
        });     
    }       
</script>
