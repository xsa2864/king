<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <h1></h1><legend>文章管理</legend>
            <div class="col-sm-8">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="inputGroupName">文章分类:</label>
                                <div class="col-sm-4 controls">
                                    <select id="id" class="col-sm-12 text-center">
                                        <?php
                                        foreach($list as $value)
                                        {
                                            echo '<option value="'.$value->id.'"';
                                            if ($row && $row->dictId==$value->id)
                                            {
                                                echo ' selected="selected" ';
                                            }
                                            echo '>'.$value->name;
                                            echo "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="title">文章标题:</label>
                                <div class="col-sm-4 controls">
                                    <input id="title" class="col-sm-12" name="title" type="text" value="<?php echo $row->title; ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="content">文章内容:</label>
                                <div class="col-sm-10 controls">
                                    <textarea class="form-control" style="width: 700px; height: 400px;" name="content"><?php echo $row->content; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-5 controls">
                                    <button class="btn btn-success" type="button" onclick="javascript:btnSubmit()">保存</button>&nbsp;&nbsp;
                                    <button class="btn " type="button" onclick="location.href='javascript:history.back()'">返回</button>
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
        var content = editor.html();
        var id = $("#id").val();
        var title = $("#title").val();
        $.post("<?php echo $row?input::site('admin/article/update/'.$row->id):input::site('admin/article/save') ?>", { 'content': content, 'dictId': id, 'title': title },
                function (data) {
                    var da = JSON.parse(data);
                    alertMsg(da.msg, '', da.msg.length * 40, 40);
                });
    }
</script>
