<div class="back_right right_width">
    <div class="right">
        <h1>商品组合</h1>
        <div class="cen_box">

            <div class="sale_box">
                <h2><a style="cursor:pointer;" href="javascript:" onclick="javascript:history.back();" class="addcate">返回</a></h2>
            </div>

            <div class="edit_box hy_cen width97 mar0">
                <div class="bq_box">
                    <div class="b5"></div>
                    <div class="sort_table dispa_tab">
                <label>商品名称：<input id="keyword" class="input158" type="text" /></label>
                <button class="btn btn-primary" type="button" onclick="javascript:search()"><span class="glyphicon glyphicon-search" aria-hidden="true">查询</span></button>
                <table border="0" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center info" style="width: 10%" scope="col">ID</th>
                            <th class="text-center info" style="width: 80%" scope="col" colspan="2">标题</th>
                            <th class="text-center info" style="width: 10%" scope="col">操作</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                    </tbody>
                </table>
                <nav>
                    <ul class="pager">
                        <li>
                            <button onclick="javascript:getTbodyUp();"><span aria-hidden="true">上一页</span></button></li>
                        <li>
                            <button onclick="javascript:getTbodyDown();"><span aria-hidden="true">下一页</span></button></li>
                    </ul>
                </nav>
            </div></div></div>
        </div>
    </div>


    <div class="right">
        <h1>已选商品</h1>
        <div class="cen_box">

            <div class="edit_box hy_cen width97 mar0">
                <div class="bq_box">
                    <div class="b5"></div>
                    <div class="sort_table dispa_tab">
                <table border="0" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center info" style="width: 10%" scope="col">ID</th>
                            <th class="text-center info" style="width: 80%" scope="col" colspan="2">标题</th>
                            <th class="text-center info" style="width: 10%" scope="col">操作</th>
                        </tr>
                    </thead>
                    <tbody id="mTbody">
                    </tbody>
                </table>
                <div class="col-sm-offset-5">
                    <button class="btn btn-danger" onclick="javascript:history.back();"><span aria-hidden="true">保存</span></button>
                </div>
            </div></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    
    var pageNum = 0;
    var myPageNum = 0;
    var name = '';
    $(function () {
        getTbodyDown();
        getMtbodyDown();
    });

    function getTbodyUp() {
        pageNum = pageNum - 1;
        $.post("<?php echo input::site('admin/itemgroup/itemList') ?>", { 'name': name, 'pageNum': pageNum, 'id': <?php echo $id;?> },
                function (data) {
                    var da = JSON.parse(data);
                    pageNum = parseInt(da.pageNum);
                    var rows = da.data;
                    var html = '';
                    for (var i = 0; i < 10; i++) {
                        var row = rows[i];
                        if (row) {
                            html = html + '<tr><td class="text-center" style="width: 10%">' + row.id + '</td><td class="text-center" style="width: 20%"><span class="sp1"><img class="bor" src="' + row.images + '"  width="60" height="60" /></span></td><td class="text" style="width:60%">' + row.title + '</td><td class="text-center" style="width: 10%"><button class="btn btn-info" onclick="javascript:add(' + row.id + ');">添加</button></td><tr>';
                        }
                    }
                    $("#tbody").html(html);
                });
    }

    function getTbodyDown() {
        pageNum = pageNum + 1;
        $.post("<?php echo input::site('admin/itemgroup/itemList') ?>", { 'name': name, 'pageNum': pageNum, 'id': <?php echo $id;?> },
                function (data) {
                    var da = JSON.parse(data);
                    pageNum = parseInt(da.pageNum);
                    var rows = da.data;
                    var html = '';
                    for (var i = 0; i < 10; i++) {
                        var row = rows[i];
                        if (row) {
                            html = html + '<tr><td class="text-center" style="width: 10%">' + row.id + '</td><td class="text-center" style="width: 20%"><span class="sp1"><img class="bor" src="' + row.images + '"  width="60" height="60" /></span></td><td class="text" style="width:60%">' + row.title + '</td><td class="text-center" style="width: 10%"><button class="btn btn-info" onclick="javascript:add(' + row.id + ');">添加</button></td><tr>';
                        }
                    }
                    $("#tbody").html(html);
                });
    }

    function getMtbodyUp() {
        myPageNum = myPageNum - 1;
        $.post("<?php echo input::site('admin/itemgroup/myItemList') ?>", { 'pageNum': myPageNum, 'id': <?php echo $id;?> },
                function (data) {
                    var da = JSON.parse(data);
                    myPageNum = parseInt(da.pageNum);
                    var rows = da.data;
                    var html = '';
                    for (var i = 0; i < 10; i++) {
                        var row = rows[i];
                        if (row) {
                            html = html + '<tr><td class="text-center" style="width: 10%">' + row.id + '</td><td class="text-center" style="width: 20%"><span class="sp1"><img class="bor" src="' + row.images + '"  width="60" height="60" /></span></td><td class="text" style="width:60%">' + row.title + '</td><td class="text-center" style="width: 10%"><button class="btn btn-info" onclick="javascript:reMove(' + row.id + ');">移除</button></td><tr>';
                        }
                    }
                    $("#mTbody").html(html);
                });
    }

    function getMtbodyDown() {
        myPageNum = myPageNum + 1;
        $.post("<?php echo input::site('admin/itemgroup/myItemList') ?>", { 'pageNum': myPageNum, 'id': <?php echo $id;?> },
                function (data) {
                    var da = JSON.parse(data);
                    myPageNum = parseInt(da.pageNum);
                    var rows = da.data;
                    var html = '';
                    for (var i = 0; i < 10; i++) {
                        var row = rows[i];
                        if (row) {
                            html = html + '<tr><td class="text-center" style="width: 10%">' + row.id + '</td><td class="text-center" style="width: 20%"><span class="sp1"><img class="bor" src="' + row.images + '"  width="60" height="60" /></span></td><td class="text" style="width:60%">' + row.title + '</td><td class="text-center" style="width: 10%"><button class="btn btn-info" onclick="javascript:reMove(' + row.id + ');">移除</button></td><tr>';
                        }
                    }
                    $("#mTbody").html(html);
                });
    }

    function add(id) {
        $.post("<?php echo input::site('admin/itemgroup/ItemListAdd') ?>", { 'id': <?php echo $id;?> , 'addId': id },
                function (data) {
                    var da = JSON.parse(data);
                    if(da.success==0)
                    {
                        alertMsg(da.msg);
                    }
                    pageNum = pageNum-1;
                    myPageNum = myPageNum-1;
                    getTbodyDown();
                    getMtbodyDown();
                });
    }

    function reMove(id) {
        $.post("<?php echo input::site('admin/itemgroup/ItemListRe') ?>", { 'id': <?php echo $id;?> , 'reId': id },
                function (data) {
                    var da = JSON.parse(data);
                    if(da.success==0)
                    {
                        alertMsg(da.msg);
                    }
                    pageNum = pageNum-1;
                    myPageNum = myPageNum-1;
                    getTbodyDown();
                    getMtbodyDown();
                });
    }
    
    function search() {
        name = $('#keyword').val();
        pageNum = pageNum-1;
        getTbodyDown();
    }

</script>
