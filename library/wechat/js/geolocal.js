$(function () {
    // getPosition();

    //关闭弹窗
    $('.mask_box').on('touchend', function (e) {
        $('.mask_box').hide();
        $('.up_box').hide();
        $('html,body').css({ overflow: 'initial' });
        return false;
    });
    if ($('.top_iosn')) {
        $('.top_iosn').hide();
        $('body').on('touchstart',function () {
            $('.top_iosn').show();
        });
        $('body').on('touchend', function () {
            if ($(document).scrollTop() > 1) {
                $('.top_iosn').show();
            } else {
                $('.top_iosn').hide();
            }
        });
        $(window).scroll(function () {
            if ($(document).scrollTop() > 1) {
                $('.top_iosn').show();
            } else {
                $('.top_iosn').hide();
            }
        });
    }
});

// function getPosition() {
//     var geolocation = new qq.maps.Geolocation("QLPBZ-3WU3R-SCEWE-WHR3D-OC3YZ-RLFM2", "myapp");
//     geolocation.getLocation(function (position) {
//         posi = position;
//         $.post(window.location.protocol + '//' + window.location.host + '/wechat/member/savePosition', posi, function () { });
//     });
// }

function topIosn() {
    $(document).scrollTop(0);
}

function wxConfig(appId, timestamp, nonceStr, signature) {
    wx.config({
        debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: appId, // 必填，公众号的唯一标识
        timestamp: timestamp, // 必填，生成签名的时间戳
        nonceStr: nonceStr, // 必填，生成签名的随机串
        signature: signature,// 必填，签名，见附录1
        jsApiList: ['chooseImage','uploadImage','scanQRCode', 'onMenuShareTimeline', 'onMenuShareAppMessage','onMenuShareQQ','onMenuShareQZone'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
    });

}


function share(share_title, share_linkUrl, share_imgUrl, share_desc) {

    if (share_title=="" || share_title==null) {
        share_title = '拓客共享商城';
    }
    if (share_linkUrl=="" || share_linkUrl==null) {
        share_linkUrl = 'http://tok.uszhzh.com/wechat/';
    }
    if (share_imgUrl=="" || share_imgUrl==null) {
        share_imgUrl = 'http://tok.uszhzh.com/library/wechat/images/zhzh_logo.jpg';
    }
    if (share_desc=="" || share_desc==null) {
        share_desc = '优惠多、共享多，朋友多多多~快来一起体验吧！';
    }
    wx.onMenuShareTimeline({
        title: share_desc, // 分享标题
        link: share_linkUrl, // 分享链接
        imgUrl: share_imgUrl, // 分享图标
        success: function () {
            // 用户确认分享后执行的回调函数
            
        },
        cancel: function () {
            // 用户取消分享后执行的回调函数
            
        }
    });
    wx.onMenuShareQZone({
        title: share_title, // 分享标题
        desc: share_desc, // 分享描述
        link: share_linkUrl, // 分享链接
        imgUrl: share_imgUrl, // 分享图标
        success: function () { 
           // 用户确认分享后执行的回调函数
        },
        cancel: function () { 
            // 用户取消分享后执行的回调函数
        }
    });
    wx.onMenuShareQQ({
        title: share_title, // 分享标题
        desc: share_desc, // 分享描述
        link: share_linkUrl, // 分享链接
        imgUrl: share_imgUrl, // 分享图标
        success: function () { 
           // 用户确认分享后执行的回调函数
        },
        cancel: function () { 
           // 用户取消分享后执行的回调函数
        }
    });
    wx.onMenuShareAppMessage({
        title: share_title, // 分享标题
        desc: share_desc, // 分享描述
        link: share_linkUrl, // 分享链接
        imgUrl: share_imgUrl, // 分享图标
        type: 'link', // 分享类型,music、video或link，不填默认为link

        success: function () {
            // 用户确认分享后执行的回调函数
            $('.mask_box').hide();
            $('#up_box2').hide();
            $('html,body').css({ overflow: 'initial' });
        },

        cancel: function () {
            // 用户取消分享后执行的回调函数
            $('.mask_box').hide();
            $('#up_box2').hide();
            $('html,body').css({ overflow: 'initial' });
        }

    });
}