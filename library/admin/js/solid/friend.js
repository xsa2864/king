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
		url:siteUrl+'solid/friend/getFriend',
		idField:'id',
		columns:[[
	        {field:'userName',title:'好友用户名',width:160},
	        {field:'project',title:'项目名称',width:160},
	        {field:'ctime',title:'添加日期',width:160}
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
	    href:siteUrl+'solid/friend/add',
	    title:'添加好友请求'
	}); 
	$('#w').window('open');
}

function delBox(id){
	var node = $('#dt').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要删除的好友');	
	}else{
		del(node.id,siteUrl+'solid/friend/del','dt');
	}
}