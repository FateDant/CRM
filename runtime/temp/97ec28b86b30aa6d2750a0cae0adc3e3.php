<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:95:"D:\ruanjian\wamp\wamp64\www\ThinkPHP\public/../application/index\view\user\forgot_password.html";i:1532328176;}*/ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<base href="<%=basePath%>">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>找回密码</title>
<link rel="icon" href="/static/images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="/static/css/common/font-awesome.css" />
<link rel="stylesheet" href="/static/css/common/Common.css" />
<link rel="stylesheet" href="/static/css/sub/Tab.css" />
<link rel="stylesheet" href="/static/css/page/ForgetPwd.css" />

</head>

<body>
	<div class="forget-top">
		<!-- 头部 -->
		<div class="forget-top-content">
			<div class="logo"></div>
			<div class="content-title">成为电竞教育的领航者</div>
		</div>

	</div>
	<!-- 中间部分 -->
	<div class="section-body">
		<div class="section-title">密码找回</div>
		<div class="section">
			<div class="infoTab" id="infoTab"></div>
			<table class="basicInfo" cellspacing="0" cellpadding="0">
				<tbody>
					<tr>
						<td><label for="txtName">用户名</label></td>
						<td><input id="txtName" class="txtName" type="text" placeholder="请输入用户名" />
						</td>
					</tr>
					<tr>
						<td><label for="getWay">找回方式</label></td>
						<td><span class="check"><i class="fa fa-check-square"></i><span class="wordEmail">邮箱</span></span></td>
					</tr>

					<tr>
						<td><label for="txtEmail">邮箱</label></td>
						<td><input id="txtEmail" class="txtEmail" type="text" placeholder="请输入邮箱" />
						</td>
					</tr>
					<tr>
						<td><label for=""></label></td>
						<td><input type="button" value="下一步" /></td>
					</tr>
				</tbody>
			</table>
			<table class="confirmInfo" cellspacing="0" cellpadding="0">
				<tbody>
					<tr>
						<td><label for="code">验证码</label></td>
						<td><input id="code" class="code" type="text" placeholder="请输入验证码" />
						</td>
					</tr>
					<tr>
						<td><label for=""></label></td>
						<td><input type="button" value="下一步" /></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>


	<script src="/static/js/common/jquery-1.12.0.js" type="text/javascript"></script>
	<script src="/static/js/common/util.js" type="text/javascript"></script>
	<script src="/static/js/sub/Tab.js"></script>
	<script src="/static/js/page/ForgetPwd.js"></script>

</body>
</html>
