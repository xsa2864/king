
$(window).resize(function(){
	var fsize = Math.round(100/720*$('body>.box').width());
	$('html,body').css('font-size',fsize);	
});
$(function(){
	$(window).resize();
	// 全选
	$('.selectall').on('touchstart',function(){
		var checked = $(this).prop('checked');
		$('.checkbox').not(this).prop('checked',!checked);
	});
	// 文本框清除
	$('input.clear_input').on('keyup change',function(){
		var input = $(this),
			em = input.next();
		if(!em.is('em.clear_input')){
			em = $('<em class="clear_input"></em>');
			input.after(em);
		}
		input.val() ? em.show() : em.hide();
		em.off('touchstart click').on('touchstart click',function(){
			input.val('');
			em.hide();
		});
	});
	// 点击效果
	$('[touchevent]').on('touchstart',function(){
		$(this).addClass($(this).attr('touchevent'));
	});
	$(document).on('touchend',function(){
		$('[touchevent]').each(function(){
			$(this).removeClass($(this).attr('touchevent'));
		});
	});
	// 底部提示窗
	$.bottomTips = function(msg){
		$('.center_tips,.bottom_tips').fadeOut('fast');
		var el = $('<div class="bottom_tips"><div class="bg"></div><p>'+msg+'</p></div>');
		el.appendTo('body');
		el.css('margin-left',-(el.outerWidth()/2));
		el.hide().fadeIn('fast');
		setTimeout(function(){
			el.fadeOut(function(){el.remove();});
		},3000);
	};
	// 中间提示窗
	$.centerTips = function(msg){
		$('.center_tips,.bottom_tips').fadeOut('fast');
		var el = $('<div class="center_tips"><div class="bg"></div><div class="tips_ok"></div><p>'+msg+'</p></div>');
		el.appendTo('body');
		el.hide().fadeIn('fast');
		setTimeout(function(){
			el.fadeOut(function(){el.remove();});
		},3000);
	};
});

//弹出框
var open_box=function(e){
	var el=$(e);
	$('.mask_box').show();
	el.show();
	$('html,body').css({overflow:'hidden'});
	var top=$(window).scrollTop();
	var height=$(window).height();
	el.css({
		'top':(top+height/2-el.outerHeight()/2),
		'left':'50%',
		'margin-left':-(el.outerWidth()/2)
	});
	el.find('.close').click(function(){
		$('.mask_box').hide();
		el.hide();
		$('html,body').css({overflow:'auto'});	
	});	
	el.find('select').trigger('resetStyle');
};
	