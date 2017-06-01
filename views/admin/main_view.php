<?php defined('KING_PATH') or die('访问被拒绝.'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Bruce博客管理系统</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="robots" content="NOODP" />

    <!-- Le styles -->
	<link href="<?php echo input::cssUrl('bootstrap.css'); ?>" rel="stylesheet" type="text/css" />
	<style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
	  
	  .error{
	  color: Red;
	  font-size: 16px;
	  }
    </style>
	<link href="<?php echo input::cssUrl('bootstrap-responsive.css'); ?>" rel="stylesheet" type="text/css" />

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="<?php echo input::jsUrl('jquery.js'); ?>" type="text/javascript"></script>
	<script type="text/javascript">
		$(function () {
			$("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
		} );
	</script>
</head>
<body>
	<div class="navbar  navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="">网站管理系统</a>
				<div class="nav-collapse collapse">
					<!--p class="navbar-text pull-right">欢迎您， <a href="#" class="navbar-link">管理员</a></p-->
					<ul class="nav">
						<li class="active"><a href="#">用户管理</a></li>
						<li><a href="#about">权限管理</a></li>
					</ul>
					<div class="pull-right">
						<ul class="nav pull-right">
							<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">欢迎您，<?php echo $user ?><b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="/user/preferences"><i class="icon-cog"></i> 个人设置</a></li>
									<li><a href="/help/support"><i class="icon-envelope"></i> 意见反馈</a></li>
									<li class="divider"></li>
									<li><a href="logout.php"><i class="icon-off"></i> 退出</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
    </div>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span2">
				<div class="well sidebar-nav">
					<ul class="nav nav-list">
						<li class="nav-header">用户管理</li>
						<li class="active"><a href="createuser.php">新建用户</a></li>
						<li><a href="userlist.php">用户列表</a></li>
						<li><a href="userlist.php">用户列表</a></li>
						<li><a href="userlist.php">用户列表</a></li>
						<li><a href="userlist.php">用户列表</a></li>
						<li><a href="userlist.php">用户列表</a></li>
					</ul>
				</div>
			</div>
			<div class="span10">
				<div class="well">
					<h3>欢迎您！系统正在建设中。。。</h3>
				</div>
			</div>
		</div>
		<hr/>
		<footer>
			<p></p>
		</footer>
	</div>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo input::jsUrl('jquery.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo input::jsUrl('bootstrap.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo input::jsUrl('jqBootstrapValidation.js'); ?>" type="text/javascript"></script>

  </body>
</html>
