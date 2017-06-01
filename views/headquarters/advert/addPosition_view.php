<div class="back_right right_width">
    <div class="right">
        <h1>广告位管理</h1>
        <div class="span12">
            <div class="cen_box">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="lName">广告位名称：</label>
                                <div class="col-sm-5 controls">
                                    <input id="name" name="name" class="form-control" value="<?php echo $row->name;?>" type="text" required="required" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="lName">广告位divId：</label>
                                <div class="col-sm-5 controls">
                                    <input id="divId" name="divId" class="form-control" value="<?php echo $row->divId;?>" type="text" required="required" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">广告位尺寸：</label>
                                <div class="col-sm-2 controls">
                                    <input id="adSizeX" style="width:70px" class="form-control" value="<?php echo $row->adSizeX;?>" type="text" required="required" placeholder="宽度"/>
                                </div>
                                <div class="col-sm-2 controls">
                                    <input id="adSizeY" style="width:70px" class="form-control" value="<?php echo $row->adSizeY?>" type="text" required="required" placeholder="高度" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="btn_two cf">
                                    <a class="a1" href="javascript:" onclick="javascript:btnSubmitOld()">保存</a><a href="javascript:" onclick="location.href='javascript:history.back()'">取消</a>
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
        var name = $('#name').val();
        var adSizeX = $('#adSizeX').val();
        var adSizeY = $('#adSizeY').val();
        var divId = $('#divId').val();

        $.post("<?php echo input::site('admin/advert/savePosition/') ?><?php echo $row->id?$row->id:'' ?>", { 'name': name, 'adSizeX': adSizeX, 'adSizeY': adSizeY, 'divId': divId },
                function (data) {
                    var da = JSON.parse(data);
                    if (da.success == 1) {
                        var url = '/admin/advert/adPositionList';
                        location.href = url;
                    }
                    else
                    {
                        alertMsg(da.msg, '', da.msg.length * 40, 40);
                    }
                });
    }

</script>
