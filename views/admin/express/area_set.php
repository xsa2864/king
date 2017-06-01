<?php
$url = input::site("admin/express/area/".$data['shipping']->id);
if ($data['note']){
    echo "<script>alert('".$data['note']."')</script>";
}
?>
<script>
    $(document).ready(function(){
        if ($(".types:checked").val() == 2)
        {
            $(".rule2").show();
        }
        $(".types").change(function(){
            getrule();
        });
    });
    function getrule(){
        var eles              = document.forms['theForm'].elements;
        var types             = eles['expressType'].value;
        var ids               = <?php echo $data['shipping']->id; ?>;
	  if (types != 2)
	  {
	      $(".rule").show();
	      $(".rule2").hide();
	      $.post("/admin/express/rule",{types:types,sid:ids}, function(data,status){
	          $(".rule").html(data);
	      });
	  }else{
	      $(".rule").hide();
	      $(".rule2").show();
	  }
  }
  function Forms(){
      var eles              = document.forms['theForm'].elements;
      var types             = eles['expressType'].value;
      var note              = true;
      if (types == 2)
      {
          $(".rule2 :text").each(function(){
              if (isNaN($(this).val()) || $.trim($(this).val()) == "" )
              {  
                  note = false;
              }
          });
          if ($(".rule2 :checked").length == 0)
          {
              note = false;
          }
      }
      return note;
  }
</script>
<div class="back_right right_width">
    <div class="right">
        <h1>商品配送设置</h1>
        <div class="cen_box">

            <div class="edit_box hy_cen width97 mar0">

                <form action="<?php echo $url; ?>" method="post" name="theForm" class="form-inline">
                    <table class="table table-striped">
                        <caption>
                            <center><h3>运费设置</h3></center>
                        </caption>
                        <?php
                        if(is_array($data) && sizeof($data) > 0){
                            $tr = "<tr><td width='200' align='right' >配送方式名称:</td><td><input  name='shipping_name' type='text' value='".$data['shipping']->name."' class='form-control'/></td></tr><tr><td align='right'>配送方式描述:</td><td><input type='text' name='shipping_desc' size='100' value='".$data['shipping']->brief."' class='form-control'/></td></tr>";
                            $tr .= "<tr><td width='200' align='right'>排序:</td><td><input type='text' name='shipping_order' size='10' value='".$data['shipping']->orderNum."' class='form-control'/></td></tr>";
                            echo $tr;
                        }
                        $check = array("","","");
                        $text  = "";
                        switch ($data['shipping']->expressType){
                            case 0:
                                $check = '<label class="radio-inline">
			                 <input type="radio" class="types" name="shipping_type"  value="0" checked > 免费配送
			            </label>';
                                $text     = "商城所有商品免费配送";
                                break;
                            case 1:
                                $check = '<label class="radio-inline">
			                 <input type="radio" class="types" name="shipping_type"  value="1" checked > 满金额免运费
			            </label>';
                                $rule     =  $data['rule'][0]->configure ? $data['rule'][0]->configure : 0;
                                $text     = "商城所有商品满金额免费配送<br /><br /><div class='input-group'><div class='input-group-addon'>￥</div><input type='text' name='rule' class='form-control' value= '$rule' /></div>";
                                break;
                            default:
                                $check = '<label class="radio-inline">
			                 <input type="radio" class="types" name="shipping_type"  value="2" checked > 正常配送
			            </label>';
                                $text     = "商城正常收取快递费用";
                                break;
                        }
                        ?>
                        <tr>
                            <td align='right'>配送类型:</td>
                            <td>
                                <?php echo $check; ?>
                            </td>
                        </tr>
                        <tr>
                            <td align='right'>配送规则:</td>
                            <td>
                                <div class="rule"><?php echo $text;?></div>
                                <div class="rule2" style="display: none">
                                    <table class="table table-striped">
                                        <tr>
                                            <th width="100">首重 单价/KG </th>
                                            <th width="100">续重 单价/KG </th>
                                            <th>省份</th>
                                            <th width="150">操作</th>
                                        </tr>
                                        <?php
                                        if(is_array($data['normal']) && sizeof($data['normal']) > 0){
                                            $tr = "";
                                            foreach ($data['normal'] as $value){
                                                $city = array();
                                                $configure = unserialize($value->configure);
                                                if(is_array($configure['cityid']) && sizeof($configure['cityid']) > 0){
                                                    foreach ($configure['cityid'] as $cid){
                                                        $city[] = $data['city'][$cid]['name'];
                                                    }
                                                }
                                                $city = implode(",", $city);
                                                $tr .= "<tr><td>".$configure['fkg']."</td><td>".$configure['ekg']."</td><td>".$city."</td><td><a href='".input::site("admin/express/deletes?del=".$value->id."&area=".$data['shipping']->id)."' target='menu' >移除</a></td></tr>";
                                            }
                                            echo $tr;
                                        }
                                        ?>
                                        <tr>
                                            <td>
                                                <input type="text" name="rule_fkg" class="form-control" /></td>
                                            <td>
                                                <input type="text" name="rule_ekg" class="form-control" /></td>
                                            <td>
                                                <?php
                                                $city = "";
                                                if (is_array($data['city']) && sizeof($data['city'])){
                                                    foreach($data['city'] as $key=>$value){
                                                        if (!in_Array($key,  $data['city_s'])){
                                                            $city .= "<label class='checkbox-inline'><input type='checkbox' name='rule_citys[]' value='".$key."' />".$value['name']."</label>";
                                                        }
                                                    }
                                                } 
                                                echo $city;
                                                ?>
                                            </td>
                                            <td>
                                                <button type="submit" onclick="return Forms();">添加</button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td align='right'>
                                <button class="btn btn-info" type="submit">确认</button>&nbsp;&nbsp;<a class="btn btn-danger" href="<?php echo input::site('admin/express/index');?>">返回</a></td>
                            <td></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
