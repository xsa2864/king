$(function(){
	$('body').css('visibility', 'visible');
	$('#tt').treegrid({
		title:'',
		iconCls:'icon-ok',
		animate:true,
		collapsible:true,
		fitColumns:true,
		url:siteUrl+'solid/mod/getParentMod?all=1',
		idField:'id',
		treeField:'text',
		columns:[[
            {title:'模块名称',field:'text',width:180}
		]],
		toolbar:[{
			id:'btnadd',
			text:'添加',
			iconCls:'icon-add',
			handler:function(){
				showBox();
			}
		},'-',{
			id:'btnupd',
			text:'编辑',
			iconCls:'icon-edit',
			handler:function(){
				editBox();
			}
		},'-',{
			id:'btndel',
			text:'删除',
			iconCls:'icon-cancel',
			handler:function(){
				delBox();
			}
		}]
	});
});

function showBox(){
	$('#w').window({  
	    href:siteUrl+'solid/mod/add',
	    title:'添加模块'
	}); 	
	$('#w').window('open');
}	

function delBox(){
	var node = $('#tt').treegrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要删除的模块');
		return false;
	}
	$.messager.confirm('系统消息', '确定删除吗？', function(r){
		if (r){
			$.post(siteUrl+'solid/mod/del',{nid:node.id},function(data){
				data = vdata(data);
		    	if (data.success==1){
		    		$('#tt').treegrid('reload');
		    	}else{
		    		alert(data.msg);
		    	}				
			})
		}
	})
}

function editBox(){
	var node = $('#tt').treegrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要编辑的模块');
	}else{
		$('#w').window({  
		    href:siteUrl+'solid/mod/edit/'+node.id,
		    title:'更新模块'
		}); 
		$('#w').window('open');
	}
}