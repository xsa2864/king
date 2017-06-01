$(function(){
	$('body').css('visibility', 'visible');			
	$('#dtLink').datagrid({
		title:'',
		iconCls:'icon-save',
		nowrap:false,
		striped:true,
		collapsible:true,
		singleSelect:true,
		pageSize:'30',
		url:siteUrl+'solid/link/get',
		idField:'id',
		columns:[[
		          {field:'name',title:'站点名称',width:160},
		          {field:'href',title:'链接地址',width:260}
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
          }]
	});
});


function showBox(){
	$('#wLink').window({  
		href:siteUrl+'solid/link/add',
		title:'添加友情链接'
	});
	$('#wLink').window('open');
}

function editBox(){
	var node = $('#dtLink').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要修改的友情链接}');
	}else{
		$('#wLink').window({  
			href:siteUrl+'solid/link/edit/'+node.id,
			title:'更新友情链接'
		}); 
		$('#wLink').window('open');
	}
}

function delBox(id){
	var node = $('#dtLink').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要删除的友情链接');	
	}else{
		del(node.id,siteUrl+'solid/link/delete','dtLink');
	}
}
