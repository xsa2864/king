$(function() {
	$('body').css('visibility', 'visible');
	$('#dtArticle').datagrid({
		title : '',
		iconCls : 'icon-save',
		nowrap : false,
		striped : true,
		collapsible : true,
		singleSelect : true,
		pageSize : '30',
		url : siteUrl + 'solid/article/get',
		idField : 'id',
		columns : [[
		            {field : 'dict',title : '分类',width : 160},
		            {field : 'title',title : '标题',width : 160}
		]],
		pagination : true,
		rownumbers : true,
		toolbar : [  {
			id : 'btnadd',
			text : '添加分类',
			iconCls : 'icon-add',
			handler : function() {
				showGenreBox();
			}
		},{
			id : 'btnadd',
			text : '添加',
			iconCls : 'icon-add',
			handler : function() {
				showBox();
			}
		}, {
			id : 'btnEdit',
			text : '编辑',
			iconCls : 'icon-edit',
			handler : function() {
				editBox();
			}
		}, {
			id : 'btndel',
			text : '删除',
			iconCls : 'icon-cancel',
			handler : function() {
				delBox();
			}
		}]
	});
});

function showGenreBox(){
	$('#wArticle').window({
		href : siteUrl + 'solid/dict/showItem/9',
		title : '添加文章分类'
	});
	$('#wArticle').window('open');	
}

function showBox() {
	$('#wArticle').window({
		href : siteUrl + 'solid/article/add',
		title : '添加文章'
	});
	$('#wArticle').window('open');
}

function editBox() {
	var node = $('#dtArticle').datagrid('getSelected');
	if (!node) {
		$.messager.alert('系统消息', '请选择要修改的文章');
	} else {
		$('#wArticle').window({
			href : siteUrl + 'solid/article/edit/' + node.id,
			title : '更新文章'
		});
		$('#wArticle').window('open');
	}
}

function delBox(id) {
	var node = $('#dtArticle').datagrid('getSelected');
	if (!node) {
		$.messager.alert('系统消息', '请选择要删除的数据');
	} else {
		del(node.id, siteUrl + 'solid/article/delete', 'dtArticle');
	}
}