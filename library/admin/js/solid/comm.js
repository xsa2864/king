	function array_remove(val){
		var i;
		var j;
		for(i = 0; i < this.length; i++){
			if(this[i] == val){
				for(j = i; j < this.length - 1; j++){
			    	this[j] = this[j + 1];
				}
				this.length = this.length - 1;
			}
		}
	}
	Array.prototype.rm = array_remove;
	
	$.extend($.fn.validatebox.defaults.rules, {
	    eque: {
		    validator: function(value){
		    	return $("input[name=passwd]").val() == $("input[name=passwd2]").val();
		    },
		    message:'确认新密码必须与新密码一致'
	    },
	    minLength: {
	        validator: function(value, param){
	            return value.length >= param[0];
	        },
	        message: '至少为{0}个字符.'
	    }
	    
	});

	function loadDynamic(file) {
	    var files = typeof file == "string" ? [file]:file;
	    for (var i = 0; i < files.length; i++) {
	    	var name = files[i];
	    	var att = name.split('.');
	    	var ext = att[att.length - 1].toLowerCase();
	    	var isCSS = ext == "css";
	    	var tag = isCSS ? "link" : "script";
	    	var attr = isCSS ? " type='text/css' rel='stylesheet' " : " type='text/javascript' ";
	    	var link = (isCSS ? "href" : "src") + "='" + name + "'";
	    	if ($(tag + "[" + link + "]").length == 0){ document.write("<" + tag + attr + link + "></" + tag + ">");}
	    }
    }
	
	function vdata(data){
		var d = eval("(" + data+ ")");
		return d;
	}

	function refreshTab(targetTab,cfg){   
		var refresh_tab = cfg.tabTitle?targetTab.tabs('getTab',cfg.tabTitle):targetTab.tabs('getSelected');   
		if(refresh_tab && refresh_tab.find('iframe').length > 0){   
			var _refresh_ifram = refresh_tab.find('iframe')[0];   
			var refresh_url = cfg.url?cfg.url:_refresh_ifram.src;   
			_refresh_ifram.contentWindow.location.href=refresh_url;   
		}   
	} 	
	
	function formSubmitBoxClose(url,formid,gridid,boxid){
		if (!formid)
			formid = 'form1';
		$('#'+formid).form('submit',{
		    url:url,
		    onSubmit:function(){
		        return $(this).form('validate');
		    },
		    success:function(data){
		    	data = vdata(data);
		    	if (data.success == 1){
					closeWin(boxid)
					if (gridid.substring(0,1) == 'd'){
						$('#'+gridid).datagrid('reload');
					}else{
						$('#'+gridid).treegrid('reload');
					}
		    	}else{
		    		$.messager.alert('系统消息',data.msg);
		    	}
		    }
		});
	}
	
	function formSubmitShowMsg(url,formid,boxid,gridid){
		if (!formid)
			formid = 'form1';
		$('#'+formid).form('submit',{
			url:url,
			onSubmit:function(){
				return $(this).form('validate');
			},
			success:function(data){
				data = vdata(data);
				if (data.success == 1){
					$.messager.alert('系统消息',data.msg);
					if (boxid){
						closeWin(boxid)
					}
					if (gridid){
						if (gridid.substring(0,1) == 'd'){
							$('#'+gridid).datagrid('reload');
						}else{
							$('#'+gridid).treegrid('reload');
						}
					}
				}else{
					$.messager.alert('系统消息',data.msg);
				}
			}
		});
	}
	
	function formSubmitCallFun(url,formid,fun,boxid){
		if (!formid)
			formid = 'form1';
		$('#'+formid).form('submit',{
			url:url,
			onSubmit:function(){
				return $(this).form('validate');
			},
			success:function(data){
				data = vdata(data);
				if (data.success == 1){
					fun(data);
					if (boxid){
						closeWin(boxid)
					}					
				}else{
					$.messager.alert('系统消息',data.msg);
				}
			}
		});		
	}
	
	function closeWin(winName){
		if (!winName)
			winName	= 'w';
		$('#'+winName).window('close');
	}
	
	 function addPanel(title,url,tabId){
		if (!tabId)
			tabId	= 'tb';	
		if ($('#'+tabId).tabs('exists', title)){
			$('#'+tabId).tabs('select', title); 
		}else{
			$('#'+tabId).tabs('add',{
				 title: title,
				 content: '<iframe scrolling="auto" frameborder="0" src="'+siteUrl+url+'" style="width:100%;height:100%;"></iframe>',
				 closable: true
			});			
		}
	}	
	
	function closeWinRefreshGrid(winName,gridid){
		if (!winName)
			winName	= 'w';
		$('#'+winName).window('close');		
		$('#'+gridid).datagrid('reload');
	}
	
	function del(id,url,gridid){
		$.messager.confirm('系统消息','确定删除吗?',function(r){
			if (r){
				$.ajax({
					type:'post',
					data:'id='+id,
					url:url,
					success:function(data){
						data = vdata(data);
						if (data.success==1){
							if (gridid){
								if (gridid.substring(0,1) == 'd'){
									$('#'+gridid).datagrid('reload');
								}else{
									$('#'+gridid).treegrid('reload');
								}								
							}
						}else{
							$.messager.alert('系统消息',data.msg);								
						}
					}
				});
			}
			else{
				return false;	
			}		
		});
	}		
	
	function reset(id,url){
		$.messager.confirm('系统消息','确定重置该用户吗?',function(r){
			if (r){
				$.ajax({
					type:'post',
					data:'id='+id,
					url:url,
					success:function(data){
						data = vdata(data);						
						$.messager.alert('系统消息',data.msg);								
						
					}
				});
			}
			else{
				return false;	
			}		
		});
	}	
	

	function showDictItem(id,titleName,boxId){
		if (!boxId){
			boxId = 'w';
		}
		$('#'+boxId).window({  
		    href:siteUrl+'solid/dict/showItem/'+id,
		    title:titleName
		}); 
		$('#'+boxId).window('resize',{ width: 580,height:400});
		$('#'+boxId).window('open');
	}	

	self.setInterval("getMsg()", 300000);//5分钟运行一次
	function getMsg() {
        $.ajax({
            type: "get", url: siteUrl+'solid/inbox/getUnreadCount',
            dataType: 'json', success: function(data) {
            	if (data.count>0){
            		showMsgRight('<span onclick=\'deskTop.createApp({"id":"66","title":"收件箱","frameurl":"'+siteUrl+'inbox/index","barIcon":"library/js/desktop/images/icons/icon_inbox_32.png","iconCls":"icon_network_16","width":"1000","height":"500"})\' class="href">您有'+data.count+'条消息未读，请进入收件箱查收</span>');
            	}
            }
        });
	}

	function showProjectBox(){
		$('#w').window({  
		    href:siteUrl+'solid/project/add',
		    title:'添加项目'
		}); 
		$('#w').window('resize',{ width: 280,height:220});
		$('#w').window('open');
	}
	
	function showWindow(url,titleName,boxId)
	{
		if (!boxId){
			boxId	= 'w'
		}
		$('#'+boxId).window({
			href:siteUrl+url,
			title:titleName
		});
		$('#'+boxId).window('open');
	}
	
	function showNotice(){
		$('#wnotice').window({  
		    href:siteUrl+'solid/display/notice',
		    title:'系统提示'
		}); 
		$('#wnotice').window('open');		
	}
	
	function downloadFile(file){
		fileUrl	= siteUrl+'solid/send/download?file='+file;
		window.open(fileUrl);	
	}
	
	function showMsgRight(msg){
		 $.messager.show({
			 title:'新消息',
			 msg:msg,
			 showType:'show'
		 });
	}
	
	function logOut(){
		$.messager.confirm('系统消息','确定退出吗?',function(r){
			if (r){
				$.get(siteUrl+'solid/display/logOut','',function(data){
					var data	= vdata(data);
					if (data.success ==true){
						parent.location.href	= siteUrl;
					}
				});
			}
			else{
				return false;	
			}		
		});		
	}