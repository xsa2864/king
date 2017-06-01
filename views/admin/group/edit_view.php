<form>
    <div class="back_right">
        <div class="right">
            <h1>修改分组</h1>
            <div class="export add_fz">
                <dl class="cf ma20">
                    <dt><em class="asterisk">*</em>组名：</dt>
                    <dd>
                        <input id="inputGroupName" value="<?php echo $item->groupName;?>" class="inp185" type="text" /></dd>
                </dl>
                <dl class="cf ma20  textarea_width">
                    <dt><em class="asterisk">*</em>说明：</dt>
                    <dd>
                        <textarea id="other" class="width" name=""><?php echo $item->other;?></textarea></dd>
                </dl>
                <dl class="cf ma20 add_power">
                    <dt><em class="asterisk">*</em>选择权限：</dt>
                    <dd class="">
                        <div class="power">
                            <ul class="cf">
                                <?php
                                foreach($tree as $ch)
                                {
                                    echo '<li>
                                    <a class="h1" style="cursor:pointer;">
                                        <i class="i2"></i>
                                        <input name="modId" modId="'.$ch->id.'" type="checkbox" '.$ch->checked.' class="check_all">'.$ch->modName.'
                                    </a>
                                    <div class="next_box cf" style="display: none">';
                                    if($ch->child)
                                    {
                                        foreach($ch->child as $ch1)
                                        {
                                            echo '<a href="javascript:void(0)">
                                            <input name="modId" modId="'.$ch1->id.'" type="checkbox" '.$ch1->checked.' />'.$ch1->modName.'</a>';
                                        }
                                    }
                                    echo '</div>
                                </li>';
                                }
                                ?>
                            </ul>
                        </div>
                    </dd>
                </dl>
            </div>
            <div class="add_mem ma20 cf "><a class="ma_left" href="javascript:btnSubmit()">保存</a><a class="cancel" href="javascript:history.back()">取消</a></div>
        </div>
</form>
<script type="text/javascript">
    
    $(function () {
        //分类标签
        $('.edit_title li').click(function () {
            var index = $('.edit_title li').index(this);
            $('.edit_title li').removeClass('curr');
            $('.edit_title b').show();
            $(this).addClass('curr').find('b').hide();
            $(this).prev().find('b').hide();
            $(".order_box2 ").hide().eq(index).show();
        });
        //全选
        $('.check_all').click(function () {
            var checked = $(this).is(':checked');
            $(this).parents('li').find('.next_box input[type=checkbox]').prop('checked', (checked ? 'checked' : false));
        });

        //点击显示子类目
        $('.power li .h1 i').click(function () {
            var el = $(this).parents('li:first').find('.next_box').toggle();
            $(this)[el.is(':hidden') ? 'removeClass' : 'addClass']('i2');
        }).click().click();
        //弹出框
        $('.qx_rder').click(function () {
            open_box('#up_hy3')
        });
        $('.del_rder').click(function () {
            open_box('#up_hy2')
        });
    });
    
    function btnSubmit() {
        var newGroupName = $("#inputGroupName").val();
        var other = $("#other").val();
        var c = '';
        $("input:checkbox[name='modId']:checked").each(function () {
            var id = $(this).attr('modId');
            c += id;
            c += ',';
        });
        c = c.substring(0, c.length - 1);
        $.post("<?php echo input::site('admin/group/update'); ?>/<?php echo $item->id;?>", { 'newGroupName': newGroupName, 'tree': c, 'other': other },
                    function (data) {
                        var da = eval('('+data+')');
                        if (da.success == 1) {
                            var url = '/admin/group/index';
                            location.href = url;
                        }
                        else {
                            alert(da.msg);
                        }
                    });
    }

</script>
