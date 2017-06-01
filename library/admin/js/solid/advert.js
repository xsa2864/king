$(function(){
	$('body').css('visibility', 'visible');			
	$('#dtAdvert').datagrid({
		title:'',
		iconCls:'icon-save',
		nowrap:false,
		striped:true,
		collapsible:true,
		singleSelect:true,
		pageSize:'30',
		url:siteUrl+'solid/advert/get',
		idField:'id',
		columns:[[
	          {field:'id',title:'广告ID',width:100},
	          {field:'name',title:'广告名称',width:160},
	          {field:'adType',title:'广告类型',width:100}
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
	$('#wAdvert').window({  
		href:siteUrl+'solid/advert/add',
		title:'添加广告'
	});
	$('#wAdvert').window('open');
}

function editBox(){
	var node = $('#dtAdvert').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要修改的广告}');
	}else{
		$('#wAdvert').window({  
			href:siteUrl+'solid/advert/edit/'+node.id,
			title:'更新广告'
		}); 
		$('#wAdvert').window('open');
	}
}

function delBox(id){
	var node = $('#dtAdvert').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要删除的广告');	
	}else{
		del(node.id,siteUrl+'solid/advert/delete','dtAdvert');
	}
}