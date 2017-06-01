<header class="header buys pad0">
    <div class="favorites">
        <p><a class="return"><i></i>申请加入拓客</a></p>
    </div>
</header>
<div class="container pad1">
    <div class="reg_cen">
        <div class="reg_h1">
            <h1>欢迎加入拓客商城！拓客轻简、便捷、高效的推广方式，将让您的生意如虎添翼。</h1>
            <h2>详询<a href="tel:<?php echo $tel;?>"> <?php echo $tel;?></a></h2>
        </div>
        <dl class="red_h2">
            <dt>请填写商家申请资料：</dt>
            <dd>
                <p>
                    <label>
                        <input type="hidden" name="type" id="type" value="<?php echo $type;?>">
                        <input type="text" id="realname" name="realname" placeholder="选填，怎么称呼您" maxlength="10" />
                    </label>
                    <span>限10位字符</span>
                </p>
                <p>
                    <label>
                        <input type="text" id="mobile" name="mobile" placeholder="必填，您的手机号" maxlength="11" />
                        <font>*</font>
                    </label>
                    <span>限11位数字</span>
                </p>
                <p>
                    <label>
                        <input type="text" id="zh_name" name="zh_name" placeholder="选填，众合账号(如果有),请填注册手机号" maxlength="11" />
                    </label>
                    <span>众合账号,限11位数字</span>
                </p>
                <p>
                    <label>
                        <input type="text" id="name" name="name" placeholder="选填，店铺名称" maxlength="30" />
                    </label>
                    <span>限30位字符</span>
                </p>
                <p>
                    <label>
                        <input type="text" id="address" name="address" placeholder="选填，店铺地址" maxlength="60" />
                    </label>
                    <span>限60位字符</span>
                </p>
            </dd>
        </dl>
    </div>
    <h3 class="keyboard_btn">
        <span class="mask_box2 radius" style="display: none"></span>
        <span class="mask_btn radius " onclick="apply_save()"><font>提交申请</font></span>
    </h3>
    <h2 class="bottom_text">我已阅读并同意<a href="<?php echo input::site('wechat/businessApply/show_clause')?>">《【拓客共享商城】联盟商家加盟细则》</a></h2>
</div>
<style type="text/css">
    label input {
        border-top: 1px solid #b8b8b8;
        border-bottom: 0 !important;
    }
</style>
<script>
    $(function () {
        $('.return').css('background-image', 'initial');
        //点击按钮
        $('.keyboard_btn').on('touchstart', function () {
            $(this).find('.mask_box2').show();
        });
        $(document).on('touchend', function () {
            $(this).find('.mask_box2').hide();
        });
    });
    function apply_save() {
        var rule = /^1[0-9]{10}$/;
        var zh_name = $("#zh_name").val();
        var mobile = $("#mobile").val();
        var realname = $("#realname").val();
        var name = $("#name").val();
        var address = $("#address").val();
        var type = $("#type").val();

        if (!rule.test(mobile)) {
            alert("请输入10~12位手机号!");
            return false;
        }
        $.post('<?php echo input::site("wechat/businessApply/apply_save");?>', { 'zh_name': zh_name, 'mobile': mobile, 'realname': realname, 'name': name, 'address': address, 'type': type }, function (data) {
            var da = eval("(" + data + ")");
            if (da.success == 1) {
                location.href = "<?php echo input::site('wechat/businessManage/show_shop');?>";
            } else {
                alert(da.msg);
            }
        });
    }
</script>
