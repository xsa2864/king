<script src="<?php echo input::jsUrl('date/date.js'); ?>" type="text/javascript"></script>
<link href="<?php echo input::cssUrl('date.css'); ?>" rel="stylesheet" type="text/css" />
<div class="back_right">
    <div class="right">
        <h1 class="margin_bottom">佣金日志</h1>
        <div class=" bor_box return_box cf">
            <form name="jifenlogForm" id="jifenlogForm" method="get">
            <dl class="cf">
                <dd><span>
                        <input class="input158" name="username" id="username" type="text" placeholder="用户名/手机号" /></span></dd>
                <dd class="select_box">
                    <select name="type" class="puiSelect" style="width: 120px">
                        <option value="">全部类别</option>
                        <option value="1">收入</option>
                        <option value="0">支出</option>
                    </select>
                </dd>
                <dd class="inp5"><span>
                        <input style="width: 122px" type="text" name="startTime" id="startTime" class="puiDate" placeholder="起始时间" /></span>&nbsp;&nbsp;到&nbsp;</dd>
                <dd class="inp5"><span>
                        <input style="width: 122px" type="text" id="endTime" name="endTime" class="puiDate" placeholder="结束时间" /></span></dd>
                <dd class="query_box"><a href="javascript:" onclick="document.getElementById('jifenlogForm').submit();">查询</a></dd>
            </dl>
            </form>
        </div>
        <div class="edit_box width95 pad15 cf">
            <div class="order_box2 " style="display: block">
                <div class=" member_cen">
                    <table class="thead tbody_cen">
                        <tr>
                            <th>购买者<i></i></th>
                            <th>获得者<i></i></th>
                            <th>类型<i></i></th>
                            <th>佣金金额<i></i></th>
                            <th>备注<i></i></th>
                            <th>获得时间<i></i></th>
                            <th>操作<i></i></th>
                        </tr>
                        <?php
                        if(!empty($List)){
                            foreach($List as $item)
                            { 
                        ?>
                        <tr>
                            <td><?php echo $item['purchaser'];?></td>
                            <td><?php echo $item['gainer'];?></td>
                            <td><?php echo $item['type'] == 1?'收入':'支出';?></td>
                            <td><?php echo $item['price'];?></td>
                            <td><?php echo $item['note'];?></td>
                            <td><?php echo $item['addtime'];?></td>
                            <td>查看详情</td>
                        </tr>
                        <?php
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>
            <div class=" cf bottom_page">
                <div class="bottom_btn cf">
                </div>
                <div class="page">
                    <?php
                    echo $pagination->render();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>