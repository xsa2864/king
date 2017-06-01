<header class="header buys">
    <a class="return" href="javascript:history.go(-1);"><i></i></a>
    购物车（<span id="total_num">0</span>）
        <span class="edit">编辑</span>
</header>
<div class="container pad1 mar2">
    <div class="commodity_list cart" id="str_y">
        <!-- 正常商品展示 -->
    </div>
    <div class="commodity_list cart mar3" id="str_n">
        <!-- 无效商品展示 -->
    </div>

    <div class="del_btn ">
        <span class="mask_box2 radius"></span>
        <a class="weed" href="javascript:clear_invalid();">清空失效商品</a>
    </div>
    <dl class="checkbox_btn tb">
        <dt><span class="input_click">
            <input type="checkbox" class="checkbox selectall"><font>全选</font></span></dt>
        <dd class="flex_1">
            <p class="tb" style="display: none">
                <a class="flex_1" href="#">移至收藏夹</a><a class="flex_1" href="#">删除</a>
            </p>
            <p class="tb settlement ">
                <span class="flex_1">
                    <font class="cor"><em>合计</em>￥<span id='total_money'>0.00</span></font><font>不含运费</font>
                </span>
                <a class="flex_1" href="#">结算(<span id="total_num">0</span>)</a>
            </p>
        </dd>
    </dl>
</div>

<script>
    $(function () {
        // 清除失效
        $('.del_btn').on('touchstart', function () {
            $('.del_btn').removeClass('on');
            $(this).addClass('on');
            $('.invalid_box').hide();
            $('.del_btn').hide();
        });
        $(document).on('touchend', function () {
            $('.del_btn').removeClass('on');
        });

    });
    //购物车商品展示 
    (function () {
        $.post(fx_get_cart_info, function (data) {
            var data = eval("(" + data + ")");
            if (data.success == 1) {
                var info = data.info;
                var str_y = '';
                var str_n = '';
                var i = 0;
                var total_money = 0;
                for (; i < info.length; i++) {
                    var pic = fx_prefix + info[i].attr_pic;
                    total_money += parseInt(info[i].number) * parseInt(info[i].attr_price);
                    if (info[i].status == 1) {
                        str_y += '    <div class="title">                                                     ';
                        str_y += '        <input type="checkbox" class="checkbox">                            ';
                        str_y += '        <dl class="list_dl tb" >                                            ';
                        str_y += '            <dt ><img src="' + pic + '"/></dt>                                  ';
                        str_y += '            <dd class="flex_1 d2">                                          ';
                        str_y += '                <h1>' + info[i].item_title + '</h1>                             ';
                        str_y += '                <div class="list_text">                                     ';
                        str_y += ' <h4>' + info[i].attr_name + '<font>x' + info[i].number + '</font></h4>             ';
                        str_y += ' <h3><font>￥</font>' + info[i].attr_price + '<p>' + info[i].attr_golds + '</p></h3>';
                        str_y += '                </div>                                                      ';
                        str_y += '            </dd>                                                           ';
                        str_y += '            <dd class="edit_num flex_1" style="display:none">               ';
                        str_y += '                <p class="tb">                                              ';
                        str_y += '     <span class="flex_1" onclick="reduce(this,' + info[i].id + ',' + info[i].item_attr_id + ')">-</span>    ';
                        str_y += '  <input type="text" id=c_' + info[i].id + '_' + info[i].item_attr_id + ' value="' + info[i].number + '" onchange="change(this)"/>    ';
                        str_y += '     <span class="flex_1" onclick="add(this,' + info[i].id + ',' + info[i].item_attr_id + ')">+</span>       ';
                        str_y += '                </p>                                                        ';
                        str_y += '                <h5 class="f28">' + info[i].attr_name + '</h5>                  ';
                        str_y += '            </dd>                                                           ';
                        str_y += '        </dl>                                                               ';
                        str_y += '    </div>                                                                  ';
                    } else {
                        str_n += '    <div class="title invalid_box">                                         ';
                        str_n += '        <a class="invalid" href="javascript:;">失效</a>                     ';
                        str_n += '        <dl class="list_dl tb" >                                            ';
                        str_n += '            <dt ><img src="' + pic + '"/></dt>                                  ';
                        str_n += '            <dd class="flex_1 d2">                                          ';
                        str_n += '                <h1>' + info[i].item_title + '</h1>                             ';
                        str_n += '                <div class="list_text">                                     ';
                        str_n += '<h4>' + info[i].attr_name + '<font>x' + info[i].number + '</font></h4>              ';
                        str_n += '<h3><font>￥</font>' + info[i].attr_price + '<p>' + info[i].attr_golds + '</p></h3> ';
                        str_n += '                </div>                                                      ';
                        str_n += '            </dd>                                                           ';
                        str_n += '            <dd class="edit_num flex_1" style="display:none">               ';
                        str_n += '                <p class="tb">                                              ';
                        str_n += '                    <span class="flex_1">-</span>                           ';
                        str_n += '                    <input type="text" value="0" />                         ';
                        str_n += '                    <span class="flex_1">+</span>                           ';
                        str_n += '                </p>                                                        ';
                        str_n += '               <input type="hidden" id="cart_id" value=' + info[i].id + ' >     ';
                        str_n += '                <h5 class="f28">' + info[i].attr_name + '</h5>                  ';
                        str_n += '            </dd>                                                           ';
                        str_n += '        </dl>                                                               ';
                        str_n += '    </div>                                                                  ';
                    }
                }
            } else {
                alert(data.msg);
            }
            $('#total_money').html(total_money);
            $('#str_y').append(str_y);
            $('#str_n').append(str_n);
            $("span[id='total_num']").html(i);
        })
    })();

    //数量增加
    function add(str, n, m) {
        var patt = /^[0-9]{1,2}$/;
        var obj = $("#c_" + n + "_" + m);
        var num = parseInt(obj.val());
        var flag = patt.test(obj.val());
        if (num >= 99 || !flag) {
            obj.val(99);
            return false;
        } else {
            var sum = num + 1;
            var re_str = changeNum(n, sum, m);
            if (re_str) {
                obj.val(sum);
            }
        }
    }
    //数量减少
    function reduce(str, n, m) {
        var obj = $("#c_" + n + "_" + m);
        var num = parseInt(obj.val());
        if (num <= 1) {
            obj.val(1);
            return false;
        } else {
            var sum = num - 1;
            var re_str = changeNum(n, sum, m);
            if (re_str) {
                obj.val(sum);
            }
        }
    }
    // 直接填写触发检查
    function change(str) {
        var patt = /^[0-9]{1,2}$/;
        var obj = $(str);
        var num = obj.val();
        var flag = patt.test(num);
        if (!flag) {
            obj.val(1);
            num = 1;
        }
        var arr = $(str).attr('id').split('_');
        var id = arr[1];
        var item_attr_id = arr[2];
        var re_str = changeNum(id, num, item_attr_id);
        if (re_str) {
            obj.val(num);
        }
    }

    // 刷新购物车
    $("span[class='edit']").click(function () {
        if ($(this).text() == '完成') {
            window.location.reload();
        }
        if ($(this).text() == '编辑') {
            $('.list_dl .edit_num').css('display', 'block');
            $('.list_dl .d2').css('display', 'none');
            $(this).html('完成');
        }
    })
    // 执行更新功能
    function changeNum(id, num, item_attr_id) {
        $.ajax({
            type: "POST",
            url: fx_changeNum,
            data: { 'id': id, 'num': num, 'item_attr_id': item_attr_id },
            success: function (data) {
                var data = eval("(" + data + ")");
                if (data.success != 1) {
                    alert(data.msg);
                    return false;
                }
            }
        });
        return true;
    }

    // 清空失效商品
    function clear_invalid() {
        if (confirm("确定清空失效商品?")) {
            var str = '';
            $('input[id=cart_id]').each(function (n, e) {
                if (str != '') {
                    str += ',';
                }
                str += $(e).val();
            })
            if (str != '') {
                $.post(fx_clear_invalid, { 'str': str }, function (data) {
                    var data = eval("(" + data + ")");
                    if (data.success == 1) {
                        window.location.reload();
                    } else {
                        alert(data.msg);
                    }
                })
            } else {
                alert('当前无失效商品');
            }
        }
    }

    // 清空购物车
    function clear() {
        if (confirm("确定清空购物车?")) {
            $.post(fx_clear_cart, function (data) {
                var data = eval("(" + data + ")");
                if (data.success == 1) {
                    window.location.reload();
                } else {
                    alert(data.msg);
                }
            })
        }
    }

</script>

