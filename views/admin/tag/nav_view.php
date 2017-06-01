<div class="container-fruid">
    <div class="row-fluid">
        <div class="span12">
            <h1></h1><legend>首页定制</legend>
            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                    </div>
                    <div class="panel-body">
                        <form name="form1" action="<?php echo input::site('admin/tag/saveNav');?>" method="post">
                            <table border="0" class="table table-hover table-bordered">
                                <tr>
                                    <th class="text-center info" width="10%" scope="col">选择</th>
                                    <th class="text-center info" width="10%" scope="col">排序</th>
                                    <th class="text-center info" width="30%" scope="col">专题名</th>
                                </tr>
                                <?php
                                foreach ($rs as $r)
                                {
                                    $check = '';
                                    if($r->isNav == 1){
                                        $check = 'checked';
                                    }
                                    echo '<tr>
	    						<td class="text-center"><input name="chk[]" type="checkbox" value="'.$r->id.'" '.$check.' /></td>
	    						<td class="text-center"><input type="text" name="order'.$r->id.'" value="'.$r->order.'"></td>
	    						<td class="text-center">'.$r->name.'</td>
	    					</tr>';
                                }
                                ?>
                            </table>
                            <div class="form-group">
                                <div class="col-sm-offset-5">
                                    <button class="btn btn-success btn-sm" type="submit">提交</button>&nbsp;&nbsp;<a class="btn btn-sm" href="<?php echo input::site('admin/home/index');?>">返回</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
