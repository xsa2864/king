<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <h1></h1><legend><?php echo $name; ?></legend>
            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="itemName">名称：</label>
                                <div class="col-sm-4 controls">
                                    <input id="itemName" name="itemName" value="<?php echo $row->name;?>" type="text" required="true" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="itemData">值：</label>
                                <div class="col-sm-4 controls">
                                    <input id="itemData" name="itemData" value="<?php echo $row->data;?>" type="text" required="true" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="orderNum">排序：</label>
                                <div class="col-sm-4 controls">
                                    <input id="orderNum" name="orderNum" value="<?php echo $row->orderNum;?>" type="text" required="true" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 controls">
                                    <button type="button" class="btn btn-success" onclick="javascript:btnSubmit()">保存</button>&nbsp&nbsp&nbsp&nbsp&nbsp
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
    
    function btnSubmit() {
        var itemName = $("#itemName").val();
        var itemData = $("#itemData").val();
        var orderNum = $("#orderNum").val();
        if (!orderNum) {
            orderNum = 0;
        }
        $.post("<?php echo input::site('admin/dict/saveItem/') ?>", { 'itemName': itemName, 'itemData': itemData, 'orderNum': orderNum, 'did': '<?php echo $did;?>', 'id': '<?php echo $row->id;?>' },
                function (data) {
                    var da = JSON.parse(data);
                    if (da.success == 1) {
                        var url = '/admin/dict/showItem?id=<?php echo $did;?>&name=<?php echo $name;?>';
                        location.href = url;
                    }
                    else
                    {
                        alertMsg(da.msg, '', da.msg.length * 40, 40);
                    }
                });
    }
</script>
