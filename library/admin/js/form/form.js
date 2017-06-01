(function($){
	var defaultOptions = {}; // 默认配置

	// 标签美化
	var jqTransformGetLabel = function(objfield){
		var selfForm = $(objfield.get(0).form);
		var oLabel = objfield.next();
		if(!oLabel.is('label')) {
			oLabel = objfield.prev();
			if(oLabel.is('label')){
				var inputname = objfield.attr('id');
				if(inputname){
					oLabel = selfForm.find('label[for="'+inputname+'"]');
				} 
			}
		}
		if(oLabel.is('label')){return oLabel.css('cursor','pointer');}
		return false;
	};
	
	// 隐藏所有下拉框
	var jqTransformHideSelect = function(oTarget){
		var ulVisible = $('.jqTransformSelectWrapper ul:visible');
		ulVisible.each(function(){
			var oSelect = $(this).parents(".jqTransformSelectWrapper:first").find("select").get(0);
			//do not hide if click on the label object associated to the select
			if( !(oTarget && oSelect.oLabel && oSelect.oLabel.get(0) == oTarget.get(0)) ){$(this).hide();}
		});
	};

	// 文档监听事件
	var jqTransformAddDocumentListener = function(event) {
		if ($(event.target).parents('.jqTransformSelectWrapper').length === 0) { jqTransformHideSelect($(event.target)); }
	};	
			
	// reset事件
	var jqTransformReset = function(f){
		var sel;
		$('.jqTransformSelectWrapper select', f).each(function(){sel = (this.selectedIndex<0) ? 0 : this.selectedIndex; $('ul', $(this).parent()).each(function(){$('a:eq('+ sel +')', this).click();});});
		$('a.jqTransformCheckbox, a.jqTransformRadio', f).removeClass('jqTransformChecked');
		$('input:checkbox, input:radio', f).each(function(){if(this.checked){$('a', $(this).parent()).addClass('jqTransformChecked');}});
	};

	// 按纽美化
	$.fn.jqTransInputButton = function(){
		return this.each(function(){
			var _this = $(this),
				newBtn = $('<button id="'+ this.id +'" name="'+ this.name +'" type="'+ 'button' +'" class="'+ this.className +' jqTransformButton"><span><span>'+ $(this).attr('value') +'</span></span>')
				.hover(function(){newBtn.addClass('jqTransformButton_hover');},function(){newBtn.removeClass('jqTransformButton_hover')})
				.mousedown(function(){newBtn.addClass('jqTransformButton_click')})
				.mouseup(function(){newBtn.removeClass('jqTransformButton_click')});
			_this.after(newBtn);
			newBtn.prepend(_this.addClass('jqTransformButton_Inner'));
		});
	};
	
	// 文本框美化
	$.fn.jqTransInputText = function(){
		return this.each(function(){
			var $input = $(this);
	
			if($input.hasClass('jqtranformdone') || !$input.is('input')) {return;}
			$input.addClass('jqtranformdone');
	
			var oLabel = jqTransformGetLabel($(this));
			oLabel && oLabel.bind('click',function(){$input.focus();return false;});
	
			var inputSize=$input.width() || parseInt($input.css('width')) || 150;
			if($input.attr('size')){
				inputSize = $input.attr('size')*10;
				$input.css('width',inputSize);
			}
			
			$input.addClass("jqTransformInput").wrap('<div class="jqTransformInputWrapper"><div class="jqTransformInputInner"><div></div></div></div>');
			var $wrapper = $input.parent().parent().parent();
			$wrapper.css("width", inputSize+10);
			$input
				.width(inputSize)
				.focus(function(){$wrapper.addClass("jqTransformInputWrapper_focus");})
				.blur(function(){$wrapper.removeClass("jqTransformInputWrapper_focus");})
				.hover(function(){$wrapper.addClass("jqTransformInputWrapper_hover");},function(){$wrapper.removeClass("jqTransformInputWrapper_hover");})
			;
	
			/* If this is safari we need to add an extra class */
			$.browser.safari && $wrapper.addClass('jqTransformSafari');
			$.browser.safari && $input.css('width',$wrapper.width()+16);
			this.wrapper = $wrapper;
			
		});
	};
	
	// 多选框美化
	$.fn.jqTransCheckBox = function(){
		return this.each(function(){
			if($(this).hasClass('jqTransformHidden')) {return;}

			var $input = $(this);
			var inputSelf = this;

			//set the click on the label
			var oLabel=jqTransformGetLabel($input);
			oLabel && oLabel.click(function(){aLink.trigger('click');return false;});
			
			var aLink = $('<a href="#" class="jqTransformCheckbox"></a>');
			//wrap and add the link
			$input.addClass('jqTransformHidden').wrap('<span class="jqTransformCheckboxWrapper"></span>').parent().prepend(aLink);
			//on change, change the class of the link
			$input.change(function(){
				this.checked && aLink.addClass('jqTransformChecked') || aLink.removeClass('jqTransformChecked');
				return true;
			});
			// Click Handler, trigger the click and change event on the input
			aLink.click(function(){
				//do nothing if the original input is disabled
				if($input.attr('disabled')){return false;}
				//trigger the envents on the input object
				$input.trigger('click').trigger("change");	
				return false;
			});

			// set the default state
			this.checked && aLink.addClass('jqTransformChecked');	
			
			if($input.attr('disabled')) $input.parents('.jqTransformCheckboxWrapper').addClass('disabled');
			if($input.attr('readonly')) $input.parents('.jqTransformCheckboxWrapper').addClass('readonly');
		});
	};

	// 单选框美化
	$.fn.jqTransRadio = function(){
		return this.each(function(){
			if($(this).hasClass('jqTransformHidden')) {return;}

			var $input = $(this);
			var inputSelf = this;
				
			oLabel = jqTransformGetLabel($input);
			oLabel && oLabel.click(function(){aLink.trigger('click');return false;});
	
			var aLink = $('<a href="#" class="jqTransformRadio" rel="'+ this.name +'"></a>');
			$input.addClass('jqTransformHidden').wrap('<span class="jqTransformRadioWrapper"></span>').parent().prepend(aLink);
			
			$input.change(function(){
				inputSelf.checked && aLink.addClass('jqTransformChecked') || aLink.removeClass('jqTransformChecked');
				return true;
			});
			// Click Handler
			aLink.click(function(){
				if($input.attr('disabled')){return false;}
				$input.trigger('click').trigger('change');
	
				// uncheck all others of same name input radio elements
				$('input[name="'+$input.attr('name')+'"]',inputSelf.form).not($input).each(function(){
					$(this).attr('type')=='radio' && $(this).trigger('change');
				});
	
				return false;					
			});
			// set the default state
			inputSelf.checked && aLink.addClass('jqTransformChecked');

			if($input.attr('disabled')) $input.parents('.jqTransformRadioWrapper').addClass('disabled');
			if($input.attr('readonly')) $input.parents('.jqTransformRadioWrapper').addClass('readonly');
		});
	};
	
	// 文本框美化
	$.fn.jqTransTextarea = function(){
		return this.each(function(){
			var textarea = $(this);
	
			if(textarea.hasClass('jqtransformdone')) {return;}
			textarea.addClass('jqtransformdone');
	
			oLabel = jqTransformGetLabel(textarea);
			oLabel && oLabel.click(function(){textarea.focus();return false;});
			
			var strTable = '<table cellspacing="0" cellpadding="0" border="0" class="jqTransformTextarea">';
			strTable +='<tr><td id="jqTransformTextarea-tl"></td><td id="jqTransformTextarea-tm"></td><td id="jqTransformTextarea-tr"></td></tr>';
			strTable +='<tr><td id="jqTransformTextarea-ml">&nbsp;</td><td id="jqTransformTextarea-mm"><div></div></td><td id="jqTransformTextarea-mr">&nbsp;</td></tr>';	
			strTable +='<tr><td id="jqTransformTextarea-bl"></td><td id="jqTransformTextarea-bm"></td><td id="jqTransformTextarea-br"></td></tr>';
			strTable +='</table>';					
			var oTable = $(strTable)
					.insertAfter(textarea)
					.hover(function(){
						!oTable.hasClass('jqTransformTextarea-focus') && oTable.addClass('jqTransformTextarea-hover');
					},function(){
						oTable.removeClass('jqTransformTextarea-hover');					
					})
				;
				
			textarea
				.focus(function(){oTable.removeClass('jqTransformTextarea-hover').addClass('jqTransformTextarea-focus');})
				.blur(function(){oTable.removeClass('jqTransformTextarea-focus');})
				.appendTo($('#jqTransformTextarea-mm div',oTable))
			;
			this.oTable = oTable;
			if($.browser.safari){
				$('#jqTransformTextarea-mm',oTable)
					.addClass('jqTransformSafariTextarea')
					.find('div')
						.css('height',(textarea.height() || parseInt(textarea.css('width')) || 150))
						.css('width',(textarea.width() || parseInt(textarea.css('height')) || 50))
				;
			}
		});
	};
	
	// 下拉框美化
	$.fn.jqTransSelect = function(){
		this.each(function(index){
			var $select = $(this);

			if($select.hasClass('jqTransformHidden')) {return;}
			if($select.attr('multiple')) {return;}
			if($.fn.jqTransSelect.zIndex<=1) $.fn.jqTransSelect.zIndex=89;

			var oLabel  =  jqTransformGetLabel($select);
			var $wrapper = $select
				.addClass('jqTransformHidden')
				.wrap('<div class="jqTransformSelectWrapper"></div>')
				.parent()
				.css({zIndex: $.fn.jqTransSelect.zIndex--});
			
			$wrapper.prepend('<div><span></span><a href="#" class="jqTransformSelectOpen"></a></div><ul></ul>');
			var $ul = $('ul', $wrapper).css('width',($select.width() || parseInt($select.css('width')) || 150)).hide();
			$select.bind('resetOption',function(){
				$ul.empty();
				$('option', this).each(function(i){
					var oLi = $('<li><a href="#" index="'+ i +'">'+ $(this).html() +'</a></li>');
					$ul.append(oLi);
				});

				// 添加事件
				$ul.find('a').click(function(){
						$('a.selected', $wrapper).removeClass('selected');
						$('li', $wrapper).show();
						$(this).addClass('selected').parents('li:first').hide();	
						if ($select[0].selectedIndex != $(this).attr('index')){ 
							$select[0].selectedIndex = $(this).attr('index'); 
							$select.trigger("change").trigger("blur");
						}
						$('span:eq(0)', $wrapper).html($(this).html());
						$ul.hide();
						return false;
				});
				$('a:eq('+ this.selectedIndex +')', $ul).click();
			}).trigger('resetOption');

			$('span:first', $wrapper).click(function(){$("a.jqTransformSelectOpen",$wrapper).trigger('click');});
			oLabel && oLabel.click(function(){$("a.jqTransformSelectOpen",$wrapper).trigger('click');return false;});
			this.oLabel = oLabel;
			var oLinkOpen = $('a.jqTransformSelectOpen', $wrapper)
				.click(function(){
					//Check if box is already open to still allow toggle, but close all other selects
					if( $ul.css('display') == 'none' ) {jqTransformHideSelect();} 
					if($select.attr('disabled') || $select.attr('readonly')){return false;}

					$ul.slideToggle('fast', function(){					
						var offSet = ($('a.selected', $ul).offset().top - $ul.offset().top);
						$ul.animate({scrollTop: offSet});
					});
					return false;
				});
			
			$select.bind({
				'show' : function(){$wrapper.show();$(this).hide();},
				'hide' : function(){$wrapper.hide();$(this).hide();},
				'remove' : function(){$wrapper.remove();$(this).remove();},
				'resetStyle' : function(){
					var iSelectWidth = $select.show().outerWidth() || parseInt($select.css('width')) || 150;
					var oSpan = $('span:first',$wrapper).css('width','auto');
					var newWidth = (iSelectWidth > oSpan.innerWidth())?oSpan.innerWidth()+oLinkOpen.outerWidth():$wrapper.width();
					newWidth=Math.max(newWidth,iSelectWidth);
					if($select.attr('size')){
						iSelectWidth = newWidth = $select.attr('size')*10;
					}
					$wrapper.css('width',newWidth);
					$ul.css('width',newWidth-2);
					oSpan.css({width:iSelectWidth});
					
					if($select.attr('disabled')) $wrapper.addClass('disabled');
					else $wrapper.removeClass('disabled');
					if($select.attr('readonly')) $wrapper.addClass('readonly');
					else $wrapper.removeClass('readonly');
				
					$ul.css({display:'block',visibility:'hidden',height:280,overflow:'auto'});
					var iSelectHeight = ($('li',$ul).length-1)*($('li:first',$ul).height());//+1 else bug ff
					(iSelectHeight < $ul.height()) && $ul.css({height:iSelectHeight,'overflow':'hidden'});//hidden else bug with ff
					$ul.css({display:'none',visibility:'visible'});
					$select.hide();
				}
			}).trigger('resetStyle');
		});

		$(document).bind('mousedown',jqTransformAddDocumentListener).bind('mousedown',jqTransformAddDocumentListener);
		return this;
	};
	$.fn.jqTransSelect.zIndex=89;

	// 定义控件
	$.fn.form = function(options){
		var opt = $.extend({},defaultOptions,options);
		 return this.each(function(){
			var selfForm = $(this),maxIndex=88;
			if(selfForm.hasClass('jqtransformdone')) {return;}
			selfForm.addClass('jqtransformdone');
			selfForm.find('div').each(function(){
				if(maxIndex<=1) maxIndex=88;
				$(this).css('z-index',maxIndex--);
			}); // fix zIndex
			
			$('input:submit, input:reset, input[type="button"]', this).jqTransInputButton();			
			$('input:text, input:password', this).jqTransInputText();			
			$('input:checkbox', this).jqTransCheckBox();
			$('input:radio', this).jqTransRadio();
			$('textarea', this).jqTransTextarea();
			$('select', this).jqTransSelect();
			selfForm.bind('reset',function(){var _this=this,action = function(){jqTransformReset(_this);}; window.setTimeout(action, 10);});
		});
	};
	$(function(){
		$('.puiSelect').jqTransSelect();
		$('.puiRadio').jqTransRadio();
		$('.puiCheckbox').jqTransCheckBox();
		$('.puiForm').form();
	});
})(jQuery);