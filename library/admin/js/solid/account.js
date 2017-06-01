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
		url:siteUrl+'solid/account/getAccount',
		idField:'id',
		columns:[[
	        {field:'userName',title:'用户名',width:160},
	        {field:'project',title:'职务',width:160},
	        {field:'mobile',title:'联系电话',width:160},
	        {field:'groupName',title:'用户组',width:160},
	        {field:'area',title:'所属部门',width:160}
		]],
		pagination:true,
		rownumbers:true,
		toolbar:[{
			id:'btnadd',
			text:'添加',
			iconCls:'icon-add',
			handler:function(){
				showBox();
			}
		},{
			id:'btnEdit',
			text:'编辑',
			iconCls:'icon-edit',
			handler:function(){
				editBox();
			}
		},{
			id:'btndel',
			text:'删除',
			iconCls:'icon-cancel',
			handler:function(){
				delBox();
			}
		},{
			id:'btnret',
			text:'密码重置',
			iconCls:'icon-save',
			handler:function(){
				resetBox();
			}
		}]
	});
	
});

function showBox(){
	$('#w').window({  
	    href:siteUrl+'solid/account/add',
	    title:'添加用户'
	});
	$('#w').window('resize',{ width: 380,height:348});
	$('#w').window('open');
}

function editBox(){
	var node = $('#dt').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要修改的用户');
	}else{
		$('#w').window({  
		    href:siteUrl+'solid/account/edit/'+node.id,
		    title:'更新用户'
		}); 
		$('#w').window('resize',{ width: 380,height:348});
		$('#w').window('open');
	}
}


function resetBox(){
	var node = $('#dt').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要重置的用户');
	}else{
		reset(node.id,siteUrl+'solid/account/resetPwd');
	}
}

function delBox(id){
	var node = $('#dt').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要删除的用户');	
	}else{
		del(node.id,siteUrl+'solid/account/del','dt');
	}
}