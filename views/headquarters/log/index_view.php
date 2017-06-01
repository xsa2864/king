<body>
    <div id="cc" class="easyui-layout" fit="true">
    <div data-options="region:'west',title:'日志类型',split:true" style="width:200px;">
    	<ul id="logTree"></ul>
    </div>
    <div data-options="region:'center',title:'详细记录'" style="padding:5px;background:#eee;">
    	<div id="logGrid" fit="true"></div>
    </div>
    </div>
   <script type="text/javascript">
	$(function(){
		$('#logTree').tree({
			url: '<?php echo input::site('solid/log/getLogTree');?>',
			lines:true,
			onClick:function(node){
				$('#logGrid').datagrid('reload',{'tid':node.id});
			}
		});

		$('#logGrid').datagrid({
			title:'',
			iconCls:'icon-save',
			nowrap:false,
			striped:true,
			collapsible:true,
			singleSelect:true,
			pageSize:'30',
			url:siteUrl+'solid/log/getLog',
			idField:'id',
			columns:[[
		        {field:'ctime',title:'操作日期',width:150},
		        {field:'user',title:'操作人员',width:160},
		        {field:'type',title:'操作类型',width:160},
		        {field:'msg',title:'操作信息',width:360}
			]],
			pagination:true,
			rownumbers:true
		});
	});

    </script>
</body>