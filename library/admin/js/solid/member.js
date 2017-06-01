$(function(){
	$('body').css('visibility', 'visible');			
	$('#dtMember').datagrid({
		title:'',
		iconCls:'icon-save',
		nowrap:false,
		striped:true,
		collapsible:true,
		singleSelect:true,
		pageSize:'30',
		url:siteUrl+'solid/member/get',
		idField:'id',
		columns:[[
		          {field:'userName',title:'用户名',width:160},
		          {field:'realName',title:'真实姓名',width:160},
		          {field:'mobile',title:'手机号',width:100},
		          {field:'address',title:'地址',width:260}
          ]],
          pagination:true,
          rownumbers:true,
          toolbar:[{
        	  id:'btnview',
        	  text:'查看',
        	  iconCls:'icon-tip',
        	  handler:function(){
        		  showBox();
        	  }
          },{
        	  id:'btnadd',
        	  text:'添加',
        	  iconCls:'icon-add',
        	  handler:function(){
        		  addBox();
        	  }
          },{
        	  id:'btnadd',
        	  text:'添加会员等级',
        	  iconCls:'icon-add',
        	  handler:function(){
        		  addLevelBox();
        	  }
          },{
        	  id:'btnedit',
        	  text:'修改等级',
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


function addBox() {
	$('#wMember').window({
		href : siteUrl + 'solid/member/add',
		title : '添加文章'
	});
	$('#wMember').window('open');
}

function addLevelBox() {
	$('#wMember').window({
		href : siteUrl + 'dict/showItem/11',
		title : '添加会员等级'
	});
	$('#wMember').window('open');
}

function editBox() {
	var node = $('#dtMember').datagrid('getSelected');
	if (!node) {
		$.messager.alert('系统消息', '请选择要修改的会员');
	} else {
		$('#wMember').window({
			href : siteUrl + 'solid/member/edit/' + node.id,
			title : '更新会员'
		});
		$('#wMember').window('open');
	}
}

function showBox(){
	var node = $('#dtMember').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要查看的会员}');
	}else{
		$('#wMember').window({  
			href:siteUrl+'solid/member/show/'+node.id,
			title:'查看会员'
		}); 
		$('#wMember').window('open');
	}
}

function delBox(id){
	var node = $('#dtMember').datagrid('getSelected');
	if (!node){
		$.messager.alert('系统消息','请选择要删除的会员');	
	}else{
		del(node.id,siteUrl+'solid/member/delete','dtMember');
	}
}