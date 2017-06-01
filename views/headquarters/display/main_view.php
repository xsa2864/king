<!--Action boxes-->
<div class="container">
    <div class="row-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="span12">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?php echo $orderNum;?>
                        </h3>
                        <p>
                            订单数量
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="/admin/order/index" class="small-box-footer">更多信息 <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?php echo $itemNum;?>
                        </h3>
                        <p>
                            产品数量
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios7-pricetag-outline"></i>
                    </div>
                    <a href="/admin/item/downItemList" class="small-box-footer">更多信息 <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3><?php echo $newNum;?>
                        </h3>
                        <p>
                            新会员注册
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="/admin/member/index" class="small-box-footer">更多信息 <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3><?php echo $userNum;?>
                        </h3>
                        <p>
                            会员数量
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="/admin/member/index" class="small-box-footer">更多信息 <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->


        <div class="col-lg-6">
            <div class="box box-danger">
                <table class="table table-striped">
                    <tr>
                        <th colspan="2">
                            <h4 class="box-title"><i class="fa fa-comments-o"></i>基本类目信息</h4>
                        </th>
                    </tr>
                    <tr>
                        <td><a href="/admin/order/index" target="menu">未支付订单</a></td>
                        <td><?php echo $noPayNum;?></td>
                    </tr>
                    <tr>
                        <td><a href="/admin/order/index" target="menu">未发货订单</a></td>
                        <td><?php echo $unfilledNum;?></td>
                    </tr>
                    <tr>
                        <td><a href="/admin/comment/index" target="menu">未回复评论</a></td>
                        <td><?php echo $unReplyNum;?></td>
                    </tr>
                </table>

            </div>
        </div>
        <!--End-Action boxes-->

        <div class="col-lg-6">

            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-comments-o"></i>用户反馈</h3>

                </div>
                <div id="chat-box" class="box-body chat">
                </div>
                <nav>
                    <ul class="pager">
                        <li>
                            <a class="btn btn-primary" href="<?php echo input::site('admin/feedback/showList')?>" target="menu"><span aria-hidden="true">更多...</span></a></li>
                    </ul>
                </nav>
                <!-- /.chat -->
            </div>
        </div>
    </div>
    <!--end-main-container-part-->
    <!--Footer-part-->

</div>

<script type="text/javascript">
    addCart();
    function addCart() {
        var url = siteUrl;
        url = url + "admin/feedback/index";
        $.ajax({
            type: 'post',
            url: url,
            cache: false,
            dataType: 'json',
            success: function (data) {
                $('#chat-box').html('');
                var sign = data['data'];
                var html = '<div class="item"></div>';
                for (var i = 0; i < 9; i++) {
                    var row = sign[i];
                    if (row) {
                        var reply = '';
                        html = html + '<div class="item"><img class="offline" alt="user image" src="<?php echo input::imgUrl("avatar5.png"); ?>"><p class="message"><a class="name" href="#"><small class="text-muted pull-right"><i class="fa fa-clock-o"></i>' + row['ctime'] + '</small>' + row['realName'] + '</a>' + row['content'] + '</p>' + reply + '</div>';
                    }
                }
                $('#chat-box').html(html);
                page = parseInt(data['page']);
            },
            error: function () {
            }
        });
    }
</script>
