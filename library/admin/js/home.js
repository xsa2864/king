$(function(){
	$('.back_nav li').click(function(){
		$('.back_nav li').removeClass('on');
		$('.back_nav li span').show();
		$(this).addClass('on').find('span').hide();
		$(this).prev().find('span').hide();
	});
	//获取焦点
	$('.bor_box input').focus(function(){
		$(this).css({'border-color':'#148cd7','color':'#333'})	
	});
	$('.bor_box input').blur(function(){
		$(this).css({'border-color':'#b7b7b7','color':'#999'})	
	});
	//移动到显示
	$('.upload_img').hover(function(){
		$(this).find('.layer_box').show();
		return false;

	},function(){
		$(this).find('.layer_box').hide();
		return false;
	});

	$('#left_menus>li>a').click(function(){
		var el = $(this).parents('li:first').find('>p').toggle();
		$(this).find('em')[el.is(':hidden') ? 'removeClass' : 'addClass']('two');
	}).click().click();	
	
	
	//广告页  移动显示删除层
	$('.hover').hover(function(){
		$(this).find('.delete').show();	
	},function(){
		$(this).find('.delete').hide();	
	})
	$('input[value]').css({'color':'#888'})
	
});
//弹出框
var open_box=function(e){
	var el=$(e);
	$('.mask_box').show();
	el.show();
	var height = Math.max($(window).height(),$('body').height())
	$('.mask_box').height(height)
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
		