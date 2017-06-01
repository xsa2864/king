<!-- 顶部导航 -->
	<div class="top_nav nav2">
    	<a href="javascript:history.back();" class="relink">返回</a>
        <span class="text">绑定手机号</span>
    </div>
    <div class="binding_cen pad8">
    	<h1>为了保证您的账户安全，请绑定您的手机号，并通过验证码验证。</h1>
        <div class="binding_inp back2">
            <p class="phone">
                <input type="text" name="mobile" id="mobile" placeholder="您的手机号码"></p>
            <p class="verification">
                <input type="text" name="codestr" id="codestr" placeholder="验证码">          
                <a href="javascript:;" onclick="getcode()" class="btn">获取验证码</a>
            </p>
        </div>
        <div class="next_btn">
            <a class="" href="javascript:bind();">完成绑定，下一步</a>
        </div>
    </div>
<style type="text/css">
.top_nav{ position:relative;height:1rem;background-color:#ff274d;}
.relink,.molink{ position:absolute;left:0;top:0;width:0.72rem;height:1rem;background:url(../../../library/wechat/images/shoping_06.png) no-repeat center;background-size:0.18rem 0.3rem;font-size:0px;display:block;}
.pad8{ padding:0 0.8rem; box-sizing:border-box}
.top_nav .text{ font-size:0.32rem; color:#fff; padding-left:0.72rem; line-height:1rem;}
.binding_cen h1{ padding:0.7rem 0 0.2rem 0; line-height:0.4rem; font-size:0.3rem; color:#646464; }
.binding_inp{ border-radius:0.08rem; border:1px solid #c8c8c8}
.binding_inp input{ border-radius:0.08rem; background:#fff; line-height:1rem; padding:0 0.2rem; width:100%; display:block;box-sizing:border-box; font-size:0.3rem;}
.binding_inp p:first-child{ border-bottom:1px dashed #c8c8c8; box-sizing:border-box;}
.binding_inp .verification{ position:relative}
.binding_inp .verification input{ padding-right:2.5rem; }
.verification .btn{ display:block; background:#fff; border:1px solid #969696; color:#3a3a3a; font-size:0.3rem; padding:0 0.35rem; height:0.8rem; line-height:0.8rem; border-radius:0.08rem; position:absolute; right:0.25rem; top:0.1rem;  box-sizing:border-box;}
.verification .btn.on{ background:#b2b2b2}
.binding_cen h2{ color:#888; line-height:0.4rem; font-size:0.26rem; padding:0.2rem 0}
.next_btn a{ display:block; background:#ff274d; font-size:0.38rem; color:#fff; line-height:0.8rem;border-radius:0.08rem; text-align:center;margin-top:1rem;}
.next_btn a.on{ background:#b21b36}
</style>   
<script>
	$(function(){
		//点击按钮样式
		$('.verification .btn,.next_btn a').on('touchstart',function(){
			$(this).addClass('on')
		});
		$(document).on('touchend',function(){
			$('.verification .btn.on,.next_btn a.on').removeClass('on');
		});
		
	});
// 发送验证码
function getcode(){
    var mobile = $("#mobile").val();
    if(mobile==''){
        alert("手机号不能为空");
        return false;
    }
    $.post('<?php echo input::site("wechat/member/get_code")?>',{'mobile':mobile},
        function(data){
            if(data.errorno==0){
                cutdown();
                alert("发送成功，请注意查收");
            }else{      
                alert(data.msg);
            }
        },'json');
}

var countdown=59; 
function cutdown() { 
    if (countdown == 0) { 
        $(".btn").attr("onclick","getcode()");    
        $(".btn").html("获取验证码"); 
        countdown = 59; 
        clearInterval(i);
        return false;
    } else { 
        $(".btn").attr("onclick",""); 
        $(".btn").html("重新发送(" + countdown + ")");
        countdown--; 
    } 
    var i =setTimeout(function() { 
        cutdown();
    },1000) 
}

// 进行绑定账号
function bind(){
    var mobile = $("#mobile").val();
    var codestr = $("#codestr").val();
    
    if(codestr==''){
        alert("验证码不能为空");
        return false;
    }
    $.post('<?php echo input::site("wechat/member/chkRcode")?>',{'mobile':mobile,'codestr':codestr},
        function(data){
            if(data){                
                alert("绑定成功");
                location.href = "<?php echo input::site('wechat/order/makeOrder/'.$id);?>";
            }else{      
                alert("验证失败，请重新尝试");
            }
        });
}
</script>