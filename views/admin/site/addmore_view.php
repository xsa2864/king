
<form id="form1" class="form" method="post">
    <div class="back_right">
        <div class="right">
            <h1>分红/佣金配置</h1>
            <div class="export">
                <dl class="cf ma20">
                    <dt>代理商件数：</dt>
                    <dd>
                        <input class="inp185" type="text" name="dailiLevel" id="dailiLevel" value="<?php echo $row['dailiLevel'];?>" />  累计件数满足则成为代理商资格</dd>
                </dl>
                <dl class="cf ma20">
                    <dt>省代等级件数：</dt>
                    <dd>
                        <input class="inp185" type="text" name="provLevel" id="provLevel" value="<?php echo $row['provLevel'];?>" />  累计件数满足则升级为省代</dd>
                </dl>
                <dl class="cf ma20">
                    <dt>市代等级件数：</dt>
                    <dd>
                        <input class="inp185" type="text" name="cityLevel" id="cityLevel" value="<?php echo $row['cityLevel'];?>" />  累计件数满足则升级为市代</dd>
                </dl>
                <dl class="cf ma20">
                    <dt>区代等级件数：</dt>
                    <dd>
                        <input class="inp185" type="text" name="distrLevel" id="distrLevel" value="<?php echo $row['distrLevel'];?>" /> 累计件数满足则升级为区代</dd>
                </dl>
                <dl class="cf ma20">
                    <dt>省代分红达标：</dt>
                    <dd>
                        <input class="inp185" type="text" name="provEnfLevel" id="provEnfLevel" value="<?php echo $row['provEnfLevel'];?>" /> （件）</dd>
                </dl>
                <dl class="cf ma20">
                    <dt>市代分红达标：</dt>
                    <dd>
                        <input class="inp185" type="text" name="cityEnfLevel" id="cityEnfLevel" value="<?php echo $row['cityEnfLevel'];?>" /> （件）</dd>
                </dl>
                <dl class="cf ma20">
                    <dt>省代分红率：</dt>
                    <dd>
                        <input class="inp185" type="text" name="provFhBit" id="provFhBit" value="<?php echo $row['provFhBit'];?>" /> 小于1的两位小数表示的百分比。例如：5%则填0.05</dd>
                </dl>
                <dl class="cf ma20">
                    <dt>市代分红率：</dt>
                    <dd>
                        <input class="inp185" type="text" name="cityFhBit" id="cityFhBit" value="<?php echo $row['cityFhBit'];?>" /> 小于1的两位小数表示的百分比。例如：5%则填0.05</dd>
                </dl>
                <dl class="cf ma20">
                    <dt>省代佣金率：</dt>
                    <dd>
                        <input class="inp185" type="text" name="provYjBit" id="provYjBit" value="<?php echo $row['provYjBit'];?>" />  小于1的两位小数表示的百分比。例如：5%则填0.05</dd>
                </dl>
                <dl class="cf ma20">
                    <dt>市代佣金率：</dt>
                    <dd>
                        <input class="inp185" type="text" name="cityYjBit" id="cityYjBit" value="<?php echo $row['cityYjBit'];?>" />  小于1的两位小数表示的百分比。例如：5%则填0.05</dd>
                </dl>
                <dl class="cf ma20">
                    <dt>区代佣金率：</dt>
                    <dd>
                        <input class="inp185" type="text" name="distrYjBit" id="distrYjBit" value="<?php echo $row['distrYjBit'];?>" /> 小于1的两位小数表示的百分比。例如：5%则填0.05</dd>
                </dl>
                <dl class="cf ma20">
                    <dt>佣金含买家：</dt>
                    <dd>
                        <select id="inMe" class="inpsel">
                            <option value="0"<?php if($row['inMe']=='0') echo " selected";?>>否</option>
                            <option value="1"<?php if($row['inMe']=='1') echo " selected";?>>是</option>
                        </select> <font color="#ff0000">级差佣金是否从买家开始计算，填“否”则从买家的直推人开始计佣金</font>
                    </dd>
                </dl>
            </div>
            <div class="add_mem ma20 "><a class="ma_le" href="javascript:submit();">保存</a></div>
        </div>
</form>

<script type="text/javascript">
    function submit()
    {
        var dailiLevel = $('#dailiLevel').val();
        var provLevel = $('#provLevel').val();
        var cityLevel = $('#cityLevel').val();
        var distrLevel = $('#distrLevel').val();
        var provEnfLevel = $('#provEnfLevel').val();
        var cityEnfLevel = $('#cityEnfLevel').val();
        var provFhBit = $('#provFhBit').val();
        var cityFhBit = $('#cityFhBit').val();

        var provYjBit = $('#provYjBit').val();
        var cityYjBit = $('#cityYjBit').val();
        var distrYjBit = $('#distrYjBit').val();

        var inMe = $('#inMe').val();

        $.post("<?php echo input::site('admin/site/savemore') ?>", {
            'dailiLevel':dailiLevel,
            'provLevel':provLevel,
            'cityLevel':cityLevel,
            'distrLevel':distrLevel,
            'provEnfLevel':provEnfLevel,
            'cityEnfLevel':cityEnfLevel,
            'provFhBit':provFhBit,
            'cityFhBit':cityFhBit,
            'provYjBit':provYjBit,
            'cityYjBit':cityYjBit,
            'distrYjBit':distrYjBit,
            'inMe':inMe
        }, function (data) {
            if(data.success=='0')
            {
                alert(data.msg);
                return false;
            }else{
                alert('提交成功！');
                javascript: location.reload();
                return false;
            }
        },"json");
    }
</script>
