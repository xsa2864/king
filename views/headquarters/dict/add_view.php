<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <h1></h1><legend><?php echo $name;?></legend>
            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="dName"><?php echo $property==0?'属性':'字典';?>名称：</label>
                                <div class="col-sm-4 controls">
                                    <input id="dName" name="dName" value="<?php echo $row->name;?>" type="text" required="true" />
                                </div>
                            </div>
                            <div class="form-group <?php echo $property==0?'hidden':'';?>">
                                <div class="col-sm-offset-2 col-sm-2 controls">
                                    <label>
                                        <input type="checkbox" id="dProperty" name="dProperty" <?php echo $row->property==0?'checked="checked"':'';?>/>
                                        属性
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-2 controls">
                                    <label>
                                        <input type="checkbox" id="dShow" name="dShow" <?php echo $row->show==0?'checked="checked"':'';?>/>
                                        显示
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 controls">
                                    <button type="button" class="btn" onclick="javascript:btnSubmit()">保存</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
        var dName = $("#dName").val();
        var dProperty = 0;
        var dShow = 0;
        if (!$("#dProperty").is(':checked')) {
            dProperty = 1;
        }
        if (!$("#dShow").is(':checked')) {
            dShow = 1;
        }
        $.post("<?php echo input::site('admin/dict/save') ?>", { 'dName': dName, 'dShow': dShow, 'dProperty': dProperty, 'id': '<?php echo $row->id;?>' },
                function (data) {
                    var da = JSON.parse(data);
                    if (da.success == 1) {
                        var url = '/admin/dict/index/<?php echo $property;?>';
                        location.href = url;
                    }
                    else {
                        alertMsg(da.msg, '', da.msg.length * 40, 40);
                    }
                });
    }
</script>
