<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:86:"D:\ruanjian\wamp\wamp64\www\ThinkPHP\public/../application/admin\view\index\index.html";i:1532420234;}*/ ?>
<!doctype html>
<html lang="ch">
<head>
<base href="<%=basePath%>">
<meta charset="UTF-8" />
<title>直尚电竞CRM管理系统</title>
<link rel="icon" href="/static/images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="/static/css/common/font-awesome.css" />
<link rel="stylesheet" href="/static/css/common/Common.css" />
<link rel="stylesheet" href="/static/css/dialog/DeleteConfirm.css" />
<link rel="stylesheet" href="/static/css/sub/Dialog.css" />
<link rel="stylesheet" href="/static/css/sub/Menu.css" />
<link href="/static/css/page/Index.css" rel="stylesheet">
</head>
<body>
	<div class="userName hidden"><%=userName%></div>
	<div class="schoolName hidden"><%=schoolName%></div>
	<table class="main" cellspacing="0" cellpadding="0">
		<tr>
			<!-- 导航栏 -->
			<td colspan="2">
				<div class="nav">
					<ul class="nav-row">
						<li class="nav-logo"><img src="/static/images/logo.png" alt="logo" /></li>
						<li class="nav-title">CRM管理系统</li>
						<li id="btnUser" class="btnUser"><label for="btnUser"> <i class="fa fa-user-o"></i> </label> <a href="javascript:;"><?php echo session('user_info.user_name'); ?></a> <span class="user_more" id="userMore"></span>
							<ul class="ddl" id="showDdl">
								<li>
									<div id="resetData">
										<i class="fa fa-address-card"></i>修改资料
									</div>
								</li>
								<li>
									<div id="loadIndex">
										<i class="fa fa-compass"><a href="<?php echo url('index/user/Logagain'); ?>"></i>重新登录
									</div>
								</li>
								<li>
									<div id="btnExit">
										<i class="fa fa-power-off"><a href="<?php echo url('index/user/logout'); ?>"></i>退出
									</div>
								</li>
							</ul></li>
					</ul>
				</div></td>
		</tr>
		<tr>
			<!-- 左侧菜单栏 -->
			<td>
				<div class="menuContainer">
					<div class="menuTop"></div>
					<div id="leftMenu" class=""></div>
				</div></td>
			<!-- 右侧嵌套页面 -->
			<td>
				<div id="rightContent">
					<iframe id="mainIframe" src="http://www.test.com/admin/IndexCharts/index" frameborder="0"></iframe>
				</div></td>
		</tr>
	</table>
	<div id="dialog"></div>
	<script src="/static/js/common/jquery-1.12.0.js" type="text/javascript" ></script>
	<script src="/static/js/common/util.js" type="text/javascript" ></script>
	<script src="/static/js/sub/Dialog.js" type="text/javascript" ></script>
	<script src="/static/js/sub/Tips.js" type="text/javascript" ></script>
	<script src="/static/js/sub/Menu.js" type="text/javascript" ></script>
	<script src="/static/js/page/Index.js" type="text/javascript" ></script>
</body>
</html>