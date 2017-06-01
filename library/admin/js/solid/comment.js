$(function(){
	$('body').css('visibility', 'visible');			
	$('#dtComment').datagrid({
		title:'',
		iconCls:'icon-save',
		nowrap:false,
		striped:true,
		collapsible:true,
		singleSelect:true,
		pageSize:'30',
		url:siteUrl+'solid/comment/get',
		idField:'id',
		columns:[[
		   {field:'userName',title:'会员名',width:100},
		   {field:'realName',title:'真实姓名',width:100},       
		   {field:'mobile',title:'手机号',width:100},       
		   {field:'content',title:'评论内容',width:280},       
		   {field:'item',title:'针对商品',width:100},       
		   {field:'reply',title:'已回复',width:60},       
		   {field:'ctime',title:'评论日期',width:160}    
	      ]],
	      pagination:true,
	      rownumbers:true,
	      toolbar:[{
	    	  id:'btnadd',
	    	  text:'查看',
	    	  iconCls:'icon-tip',
	    	  handler:function(){
	    		  viewBox();
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


function viewBox(){
	var node = $('#dtComment').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要查看的评论');	
	}else{
		$('#wComment').window({  
			href:siteUrl+'solid/comment/edit/'+node.id,
			title:'添加回复'
		});
		$('#wComment').window('open');		
	}
}

function delBox(id){
	var node = $('#dtComment').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要删除的评论');	
	}else{
		del(node.id,siteUrl+'solid/comment/delete','dtComment');
	}
}