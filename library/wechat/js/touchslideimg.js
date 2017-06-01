
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
	//点击按钮
		$('.share_h1 h2').on('touchstart',function(e){
			$(this).addClass('into');
			e.stopPropagation();;
		});
		$(document).on('touchend',function(){
			$('.share_h1 h2.into').removeClass('into');
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
	
	$.extend({
		// 触发自定义键盘
		keyboard : function(callback,notMask){
			var mask = $('<div  class="mask_box" style="display:block"></div>'),
				tpl = '<div  class="up up_box3 keyboard_box">' +
						'<div class="keyboard_box">' +
							'<table class="keyboard" width="100%">' +
							  '<tr>' +
								'<td>1</td><td>2</td><td>3</td>' +
							  '</tr>' +
							  '<tr>' +
								'<td>4</td><td>5</td><td>6</td>' +
							  '</tr>' +
							  '<tr>' +
								'<td>7</td><td>8</td><td>9</td>' +
							  '</tr>' +
							  '<tr>' +
								'<td class="col_e2 key_empty">&nbsp;</td><td>0</td><td class="col_e2 key_del"><i></i></td>' +
							  '</tr>' +
							'</table>' +
						'</div>' +
					 '</div>',
				el = $(tpl),
				pwd = '';
			$('.keyboard_box').trigger('close');
		    el.on('click', function () { return false; }).find('td').on('touchstart', function () {
				var bel = $(this);
				if(bel.hasClass('key_del')){ // 删除
					pwd = pwd.substring(0,(pwd.length-1));
				}else if(bel.hasClass('key_empty')){ // 空白
					return false;
				}else{ // 数字
					pwd = '' + pwd + parseInt(bel.html());
				}
				callback && callback.call(el,pwd,mask);
			}).on('touchstart mousedown',function(){
				if(!$(this).hasClass('key_empty')){ // 空白
					$(this).css('background-color','#ededed');
				}
			});
			el.on('touchend mouseup',function(){
				el.find('td').css('background-color','transparent').filter('.col_e2').css('background-color','#e2e7ed');
			});
			el.on('close',function(){
				el.slideUp(function(){
					el.remove();
					mask.fadeOut('fast',function(){	
						mask.remove();
					});
				});
			}).on('clear',function(){
				pwd = '';
				callback && callback.call(el,pwd,mask);
			});
			$('body').append(el);
			if(!notMask){
				$('body').append(mask);
				mask.hide().fadeIn();
			}
			$(document).on('click',function(){
				el.trigger('close');
			});
			el.hide().slideDown();
			return el;
		},
		// 密码键盘事件
		password : function(callback,title,insertHtml){
			var tpl = 	'<div class="keyboard_h2">' +
							'<i class="close"></i>' +
							'<h1 class="f32">'+(title||'请输入密码')+'</h1>' +
							'<div class="type">' +
								'<h3 class=" tb"><span class="flex_1">*</span><span class="flex_1">*</span><span class="flex_1">*</span><span class="flex_1">*</span><span class="flex_1">*</span><span class="flex_1">*</span></h3>' +
								 '<p style="display:none" class="pass_tips"></p>' +
								 (insertHtml || '') +
							'</div>' +
						'</div>',
				el = $(tpl),
				setPwdText = function(len){
					el.find('.type h3 span').css('color','#ffffff').slice(0,len).css('color','#333333');
				};
			var keyel = $.keyboard(function(pwd){
				setPwdText(pwd.length);
				if(pwd.length>=6){
					if(callback){
						if(callback.call(keyel,pwd)!==false){
							keyel.trigger('close');
						}else{
							keyel.trigger('clear');
						}
					}else{
						keyel.trigger('close');
					}					
				}
			});
			keyel.hide().find('.keyboard_box').prepend(el);
			keyel.showError = function(msg){
				if(msg){
					el.find('.pass_tips').html(msg).show();
				}else{
					el.find('.pass_tips').hide();
				}
			};
			setPwdText(0);
			return keyel.slideDown();
		},
		// 金额键盘事件
		amound : function(callback){
			var tpl = 	'<div class="keyboard_h1">' +
							'<i class="close"></i>' +
							'<h1 class="f32">提现至微信钱包</h1>' +
							'<h2><input type="text" readonly="readonly"/></h2>' +
							'<h3 class="keyboard_btn">' +
								'<span class="mask_box2 radius" style="display:none"></span>' +
								'<span class="mask_btn radius "><font>确 定</font></span>' +
							'</h3>' +
						'</div>',
				el = $(tpl),
				value = '';
				
			var keyel = $.keyboard(function(val){
				value = val;
				el.find('input').val('￥'+val);
			});
			keyel.hide().find('.keyboard_box').prepend(el);
			el.find('.keyboard_btn span').on('click',function(){
				callback && callback.call(keyel,value);
				keyel.trigger('close');
			});	
			el.find('.close').on('touchend',function(){
				keyel.trigger('close');
			});
			el.find('input').val('￥');	
			el.find('.keyboard_btn .mask_btn').on('touchstart',function(){
				el.find('.mask_box2').show();
			});
			$(document).on('touchend',function(){
				el.find('.mask_box2').hide();
			});
			return keyel.slideDown();
		}
	});
	
});

//弹出框
var open_box = function (e) {
    topIosn();
	var el=$(e);
	$('.mask_box').show();
	el.show();
	$('html,body').css({overflow:'hidden'});
	var top = 0;//$(window).scrollTop();
	var height=$(window).height();
	el.css({
		'top':(top+height/2-el.outerHeight()/2),
		'left':'50%',
		'margin-left':-(el.outerWidth()/2)
	});
	el.find('.close').click(function(){
		$('.mask_box').hide();
		el.hide();
		$('html,body').css({ overflow: 'initial' });
	});	
	el.find('select').trigger('resetStyle');
};
	