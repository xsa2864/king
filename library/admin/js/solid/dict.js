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
		url:siteUrl+'solid/dict/getDict',
		idField:'id',
		columns:[[
	        {field:'name',title:'字典名称',width:260},
	        {field:'item',title:'字典项',width:200}
		]],
		pagination:true,
		rownumbers:true,
		toolbar:[{
			id:'btnadd',
			text:'添加',
			iconCls:'icon-add',
			handler:function(){
				showDictBox();
			}
		},{
			id:'btnedit',
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


function showDictBox(){
	$('#w').window({  
		href:siteUrl+'solid/dict/add',
		title:'添加字典'
	}); 
	$('#w').window('resize',{ width: 280,height:150});
	$('#w').window('open');
}


function editBox(){
	var node = $('#dt').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要编辑的区域');
	}else{
		$('#w').window({  
		    href:siteUrl+'solid/dict/edit/'+node.id,
		    title:'更新字典'
		}); 
		$('#w').window('open');
	}
}

function delBox(id){
	var node = $('#dt').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要删除的区域');	
	}else{
		$.messager.confirm('系统消息', '删除字典将删除该字典的子项，确定继续吗？', function(r){
			if (r){
				$.post(siteUrl+'solid/dict/del',{id:node.id},function(data){
					data = vdata(data);
			    	if (data.success==1){
			    		$('#dt').datagrid('reload');
			    	}else{
			    		$.messager.alert(data.msg);
			    	}				
				})
			}
		})		
	}
}