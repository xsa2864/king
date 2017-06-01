$(function(){
	$('body').css('visibility', 'visible');
	$('#dt').datagrid({
		title:'',
		iconCls:'icon-save',
		striped: true,
		collapsible:true,
		singleSelect:true,
		pageSize:'30',
		url:siteUrl+'solid/outbox/getOutbox',
		columns:[[
		    {field:'genre',title:'消息类型',width:140},
		    {field:'userName',title:'接收人用户名',width:130},
		    {field:'existFile',title:'是否含文件',width:100},
			{field:'content',title:'发送内容',width:350},
			{field:'ctime',title:'发送时间',width:150}
		]],
		pagination:true,
		rownumbers:true,
		toolbar:[{
			id:'btnadd',
			text:'发送',
			iconCls:'icon-add',
			handler:function(){
				sendMsg();
			}
		},'-',{
			id:'btnshow',
			text:'查看',
			iconCls:'icon-reload',
			handler:function(){
				showMsg();
			}
		}]
	});
	$('#dt').datagrid('getPager');
});

function sendMsg(){
	$('#w').window({
		href:siteUrl+'solid/outbox/add',
		title:'发送信息'
	});
	$('#w').window('open');
}

function showMsg(){
	var node = $('#dt').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要查看的项目');	
	}else{
		$('#w').window({
			href:siteUrl+'solid/outbox/show/'+node.id,
			title:'发送信息'
		});
		$('#w').window('open');		
	}
}

function doSubmit(url,name){
	formSubmit(url);
}