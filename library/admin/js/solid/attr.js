$(function(){
	$('body').css('visibility', 'visible');			
	$('#dtAttr').datagrid({
		title:'',
		iconCls:'icon-save',
		nowrap:false,
		striped:true,
		collapsible:true,
		singleSelect:true,
		pageSize:'30',
		url:siteUrl+'solid/attr/get',
		idField:'id',
		columns:[[
		          {field:'name',title:'商品属性',width:160}
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
        	  id:'btnadd',
        	  text:'添加筛选字典',
        	  iconCls:'icon-add',
        	  handler:function(){
        		  showFilterBox();
        	  }
          },'-',{
        	  id:'btnEdit',
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
	$('#wAttr').window({  
		href:siteUrl+'solid/attr/add',
		title:'添加商品属性'
	});
	$('#wAttr').window('open');
}

function showFilterBox(){
	var node = $('#dtAttr').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择属性项');
	}else{
		$.get(siteUrl+'solid/attr/addFilter/'+node.id,function(data){
		    var data  = vdata(data);
		    if (data.success ==1){
			    showDictItem(data.did,'管理筛选项','wAttr');
			}else{
			    $.messager.alert('系统消息',data.msg);
			}			  
		});
	}
}

function editBox(){
	var node = $('#dtAttr').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择修改项}');
	}else{
		$('#wAttr').window({  
			href:siteUrl+'solid/attr/edit/'+node.id,
			title:'更新友情链接'
		}); 
		$('#wAttr').window('open');
	}
}

function delBox(id){
	var node = $('#dtAttr').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择删除项');	
	}else{
		del(node.id,siteUrl+'solid/attr/delete','dtAttr');
	}
}