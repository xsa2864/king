
<div class="back_right right_width">
    <div class="right">
        <div class="span12">
            <h1>商品组合</h1>
            <div class="cen_box">
                <div class="sale_cen attr_box cf">
                    <div class="sort_table attr_table">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">组合名称：</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="name" value="<?php echo $row->name;?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="page" class="col-sm-2 control-label">专题页：</label>
                                <div class="col-sm-4">
                                   <!-- <input type="text" class="form-control" id="page" value="<?php echo $row->page;?>">-->
                                    <select name="page" id="page">
                                        <option value="">选择专题模板</option>
                                        <?php
                                            $specialPage = C('specialConfig');
                                        foreach($specialPage as $sp) {
                                            ?>
                                            <option value="<?php echo $sp['fileName'] ?>" <?php if($row->page == $sp['fileName']){echo 'selected';} ?> label="<?php echo $sp['preview'] ?>"><?php echo $sp['fileName'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select> <a target="_blank" id="preview_href" href=""><img id="preview_img" src="" width="50" height="50"></a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="order" class="col-sm-2 control-label">排序：</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="order" value="<?php echo $row->order;?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button id="save" class="btn btn-success" type="button">保存</button>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <button class="btn btn-danger" type="button" onclick="location.href='javascript:history.back()'">返回</button>
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

    $(function () {

        $("#page").change(function(){
            var img_path = $("#page option:selected").attr('label');
            $("#preview_img").attr('src','<?php echo input::site().'library/admin/images/' ?>'+img_path+'');
            $("#preview_href").attr('href','<?php echo input::site().'library/admin/images/' ?>'+img_path+'');
        });

        $("#save").click(function () {
            var name = $("#name").val();
            var page = $("#page").val();
            var order = $("#order").val();
            $.post("<?php echo input::site('admin/itemgroup/save') ?>", { 'name': name, 'page': page, 'order': order,'id': <?php echo $row->id>0?$row->id:0; ?>}, 
                function (data) 
                {
                    var da = JSON.parse(data);
                    if (da.success == 0) {
                        alertMsg(da.msg,'',da.msg.length*40,40);
                    }
                    else 
                    {
                        var url = '/admin/itemgroup/index';
                        location.href = url;
                    }
                });
        });
    });    

</script>
