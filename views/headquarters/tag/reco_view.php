<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <h1></h1>
            <legend>首页定制</legend>
            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                    </div>
                    <div class="panel-body">
                        <form name="form1" class="form-horizontal" action="<?php echo input::site('admin/tag/saveProduct');?>" method="post">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="lName">选择广告：</label>
                                <div class="col-sm-4 controls">
                                    <select class="col-sm-12" onchange="image1.src=this.value">
                                        <?php
                                        echo '<option></option>';
                                        ?>
                                        <option value="<?php echo input::site(output_ext::getCoverImg('a:1:{s:33:"upload/201507/06/143616175780.jpg";i:0;}','255x255'));?>">logo.jpg</option>
                                        <option value="<?php echo input::site(output_ext::getCoverImg('a:1:{s:33:"upload/logo1.png";i:0;}','280x265'));?>">logo.jpg</option>
                                        <option value="<?php echo input::site(output_ext::getCoverImg('a:1:{s:33:"upload/logo1.png";i:0;}','280x265'));?>">logo.jpg</option>
                                    </select>
                                    <img id="image1" src="" class="col-sm-12">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-5">
                                    <button class="btn btn-success btn-sm" type="submit">提交</button>&nbsp;&nbsp;<a class="btn btn-sm" href="<?php echo input::site('admin/home/index');?>">返回</a>
                                </div>
                            </div>
                            <input type="hidden" name="tagName" value="<?php echo $tagName;?>" />
                        </form>
                        <table class="table table-hover table-bordered" width="500px">
                            <hr />
                            <thead>
                                <tr>
                                    <th class="text-center info">广告名称</th>
                                    <th class="text-center info">广告图片</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($tagValue)
                                {
                                    $tagValue	= unserialize($tagValue);
                                    if (is_array($tagValue))
                                    {
                                        foreach ($tagValue as $tag)
                                        {
                                            $pic	= input::site(output_ext::getCoverImg($tag->pics));
                                            $table = '<tr>
							                <td class="text-center">'. $tag->name.'</td>
							                <td class="text-center"><img src="'. $pic.'"></td>
							                </tr>';
                                            echo $table;
                                        }
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
