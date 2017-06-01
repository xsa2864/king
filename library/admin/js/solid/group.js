$(function(){
	$('body').css('visibility', 'visible');
	$('#dt').datagrid({
		title:'',
		iconCls:'icon-save',
		nowrap:false,
		striped:true,
		collapsible:true,
		singleSelect:true,
		pageSize:'30',
		url:siteUrl+'solid/group/getGroup',
		columns:[[
			{field:'groupName',title:'组名',width:120},
			{field:'ctime',title:'创建时间',width:150},
			{field:'modPower',title:'权限id',width:150}
		]],
		pagination:true,
		rownumbers:true,
		toolbar:[{
			id:'btnadd',
			text:'添加',
			iconCls:'icon-add',
			handler:function(){
				addBox();
			}
		},'-',{
			id:'btnupd',
			text:'编辑',
			iconCls:'icon-edit',
			handler:function(){
				editBox();
			}
		}
		,'-',{
			id:'btndel',
			text:'删除',
			iconCls:'icon-cancel',
			handler:function(){
				delBox();
			}
		}]
	});
});

function addBox(){
	$('#w').window({  
	    href:siteUrl+'solid/group/add',
	    title:'添加用户组'
	}); 
	$('#w').window('open');
}

function editBox(){
	var node = $('#dt').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要编辑的用户组');
	}else{
		$('#w').window({  
		    href:siteUrl+'solid/group/edit/'+node.id,
		    title:'更新用户组'
		}); 
		$('#w').window('open');
	}
}

function delBox(){
	var node = $('#dt').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要删除的用户组');
	}
	else{
		del(node.id,siteUrl+'solid/group/del/'+node.id,'dt');
	}	
}