<script language="javascript" type="text/javascript" src="<?php echo input::cssurl('datetimepicker.css'); ?>"></script>
<link href="http://cdn.bootcss.com/twitter-bootstrap/2.2.2/css/bootstrap.min.css" rel="stylesheet">
<link href="http://cdn.bootcss.com/prettify/r224/prettify.css" rel="stylesheet">

<script src="http://www.bootcss.com/p/bootstrap-datetimepicker/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script language="JavaScript">
    function openWin() {        
        var win = window.open("/admin/special/getProduct/1", window, "dialogHeight:500;dialogWidth:500;help:no");
    }


</script>
<?php 
if (isset($row))//
{
    $url		= input::site('admin/special/update/'.$row->id);
    $posts      = unserialize($row->posts);
    $buttonText = "更新";
	
}
else 
{
    $url	=     input::site('admin/special/save');
    $buttonText = "新增";
}
?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <h1></h1><legend>特卖管理</legend>
            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                    </div>
                    <div class="panel-body">
                        <form id="form1" class="form" method="post" action="<?php echo $url ?>" enctype="multipart/form-data">
                            <table class="table">
                                <tr>
                                    <th width="150">类别</th>
                                    <th>内容</th>
                                </tr>
                                <tr>
                                    <td>选择商品:</td>
                                    <td>
                                        <input type="button" id="btnChoose" value="选择商品" onclick="openWin()" />
                                        <input  type="hidden"  name='itemId'  id="itemId"  value='<?php echo $row->itemId;?>' />
                                        <input  type="hidden"  name='itemTitle'  id="itemTitle"  value='<?php echo $row->title;?>' />
                                        <span id="itemname"><?php echo $row->title;?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>开始时间:</td>
                                    <td>
                                        <input size="16" type="text" readonly  name="beginTime"  value="<?php 
                                                                            if($row->itemId>0)
                                                                            {
                                                                                echo Date('Y-m-d H:m',$row->beginTime);
                                                                            }        
                                                                            else
                                                                            {
                                                                                
                                                                                echo Date('Y-m-d H:m',time());
                                                                            }
                                                                            
                                                                                                        ?>" id="beginTime"  class="form-control" style="height:40px; width:210px" >
                                    </td>
                                </tr>
                                <tr>
                                    <td>结束时间:</td>
                                    <td>
                                        <input type="text"  id="endTime" class="form-control" value="<?php 
                                                                                                     if($row->itemId>0)
                                                                                                     {
                                                                                                         echo Date('Y-m-d H:m',$row->endTime);
                                                                                                     }        
                                                                                                     else
                                                                                                     {
                                                                                                         
                                                                                                         echo Date('Y-m-d H:m',time());
                                                                                                     }
                                                                                                     
                                                                                                     ?>"  name="endTime" readonly  style="height:40px; width:210px" ></td>
                                </tr>
                            </table>
                            <div class="form-group">
                                <div class="col-sm-offset-2 controls">
                                    <button type="submit" class="btn btn-success btn-md">保存</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<button type="button" class="btn" onclick="location.href='javascript:history.back()'">返回</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#beginTime").datetimepicker({ format: 'yyyy-mm-dd hh:ii' });
    $("#endTime").datetimepicker({ format: 'yyyy-mm-dd hh:ii' });
    $("#form1").ajaxForm(function(data) {   
        var da = JSON.parse(data);
        if (da.success == 1) {
            var url = '/admin/special/index';
            location.href = url;
        }
        else {
            alertMsg(da.msg, '', da.msg.length * 40, 40);
        }
    }); 
</script>
