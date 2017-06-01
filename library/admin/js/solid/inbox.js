$(function(){
	$('body').css('visibility', 'visible');
	$('#dt').datagrid({
		title:'',
		iconCls:'icon-save',
		striped: true,
		collapsible:true,
		singleSelect:true,
		pageSize:'30',
		url:siteUrl+'solid/inbox/getInbox',
		columns:[[
		    {field:'type',title:'消息类型',width:140},
		    {field:'userName',title:'发送人用户名',width:100},
		    {field:'project',title:'职务',width:100},
		    {field:'existFile',title:'是否含文件',width:100},
			{field:'content',title:'发送内容',width:150},
			{field:'ctime',title:'对方发送时间',width:140},
			{field:'opera',title:'状态',width:140}
		]],
		pagination:true,
		rownumbers:true,
		onClickRow: function(rowIndex,rowData){
			var rid		= rowData.id;
	        $.ajax({
	            type: "get", url: siteUrl+'solid/inbox/setRead/'+rid,
	            dataType: 'json', success: function(data) {
	            	//if (data.success == true){
	            		//$('#dt').datagrid('reload');
	            		//$('#dt').datagrid('selectRow',rowIndex);
	            	//}
	            }
	        });
		},
		toolbar:[{
			id:'btnshow',
			text:'查看',
			iconCls:'icon-reload',
			handler:function(){
				showMsg();
			}
		},'-',{
			id:'btndel',
			text:'删除',
			iconCls:'icon-cancel',
			handler:function(){
				delMsg();
			}
		}]
	});
	$('#dt').datagrid('getPager');
});

function sendMsg(){
	$('#w').window({
		href:siteUrl+'outbox/add',
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
			href:siteUrl+'solid/inbox/show/'+node.id,
			title:'消息详情'
		});
		$('#w').window('open');
	}
}

function allowFriend(id,sid){
	 $.messager.confirm('好友请求', '确认添加该好友吗？', function(r){
		 if (r){
			  $.post(siteUrl+"friend/allowFriend",{id:id,sid:sid},function(data){
					data = vdata(data);
					if (data.success == 1){
						$('#dt').datagrid('reload');
					}
					else{
						$.messager.alert('系统消息',data.msg);
					}
			  });
		 }
	});
}

function refuseFriend(id,sid){
	 $.messager.confirm('好友请求', '拒绝该用户的好友请求吗？', function(r){
		 if (r){
			  $.post(siteUrl+"friend/refuseFriend",{id:id,sid:sid},function(data){
					data = vdata(data);
					if (data.success == 1){
						$('#dt').datagrid('reload');
					}
					else{
						$.messager.alert('系统消息',data.msg);
					}
			  });
		 }
	});	
}

function delMsg(id){
	var node = $('#dt').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要删除的项目');	
	}else{
		del(node.id,siteUrl+'solid/inbox/del','dt');//最后增加参数dt,指定刷新单元
	}
}