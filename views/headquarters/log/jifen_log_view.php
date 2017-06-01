<script src="<?php echo input::jsUrl('date/date.js'); ?>" type="text/javascript"></script>
<link href="<?php echo input::cssUrl('date.css'); ?>" rel="stylesheet" type="text/css" />
<div class="back_right">
    <div class="right">
        <h1 class="margin_bottom">积分日志</h1>
        <div class=" bor_box return_box cf">
            <form name="jifenlogForm" id="jifenlogForm" method="get">
            <dl class="cf">
                <dd><span>
                        <input class="input158" name="username" id="username" type="text" placeholder="用户名/手机号" /></span></dd>
                <dd class="select_box">
                    <select name="type" class="puiSelect" style="width: 120px">
                        <option value="">全部类别</option>
                        <option value="1">收入</option>
                        <option value="2">支出</option>
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
                            <th width="15%">用户名<i></i></th>
                            <th width="15%">时间<i></i></th>
                            <th width="10%">类别<i></i></th>
                            <th width="10%">金额<i></i></th>
                            <th width="50%">详情<i></i></th>
                        </tr>
                        <?php
                        foreach($List as $item)
                        { ?>
                        <tr>
                            <td><?php echo $item['uname'];?></td>
                            <td><?php echo $item['ptime']?date('Y-m-d H:i:s',$item['ptime']):'--';?></td>
                            <td><?php echo $item['type']==1?'收入':'支出';?></td>
                            <td><?php echo $item['point'];?></td>
                            <td><?php echo $item['remo'];?></td>
                        </tr>
                        <?php
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
<script type="text/javascript">
    function clearlog(){
        if(confirm('是否确认清空日志？')){
            $.get('<?php echo input::site('admin/log/clearlog') ?>',{},function(data){
                if(data.errorno=='0'){
                    location.reload();
                }else{
                    if(data.msg!=''){
                        alertMsg(data.msg,'',320,40);
                    }else{
                        alertMsg('操作失败！','',320,40)
                    }
                }
            },"json");
        }else{
            return false;
        }
    }
</script>