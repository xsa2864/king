<header style="text-align:center;">
        <h1 style="font-size: 3.2em;color: #EA0808;padding-top: 30px;">绑定拓客店铺</h1>
</header>
<div class="container pad1">
    <div class="reg_cen">
        <dl class="red_h2">
            <dt>请填写商家手机号：</dt>
            <dd>
                <p>
                    <label>
                        <input type="text" id="mobile" name="mobile" placeholder="必填，您的手机号" maxlength="11" />
                        <font>*</font>
                    </label>
                    <span>限11位数字</span>
                </p>               
            </dd>
        </dl>
    </div>
    <h3 class="keyboard_btn">
        <span class="mask_btn radius " onclick="apply_save()"><font>绑定</font></span>
    </h3>
</div>
<style type="text/css">
    label input {
        border-top: 1px solid #b8b8b8;
        border-bottom: 0 !important;
    }
</style>
<script>
    function apply_save() {
        var rule = /^1[0-9]{10}$/;
        var mobile = $("#mobile").val();

        if (!rule.test(mobile)) {
            alert("请输入有效11位手机号!");
            return false;
        }
        $.post('<?php echo input::site("wechat/businessApply/apply_bind");?>', {'mobile': mobile,}, 
            function (data) {
            var da = eval("(" + data + ")");
            alert(da.msg);
        });
    }
</script>
