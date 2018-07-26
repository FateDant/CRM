<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:45:"../application/admin/view/dialog/AddUser.html";i:1532511778;}*/ ?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>开通账户</title>
<script src="/static/js/common/jquery-1.12.0.js" type="text/javascript"></script>
<script src="/static/js/common/util.js" type="text/javascript"></script>
<link rel="stylesheet" href="/static/css/common/Common.css" />
<script src="/static/js/sub/Tips.js" type="text/javascript"></script>
<script src="/static/js/sub/DropDownList.js" type="text/javascript"></script>
<link rel="stylesheet" href="/static/css/sub/Tips.css" />
<link rel="stylesheet" href="/static/css/sub/DropDownList.css" />
<link rel="stylesheet" href="/static/css/dialog/AddUser.css" />
<script src="/static/js/dialog/AddUser.js"></script>
</head>
<body>
<form action="addUser" method="post">
	<div class="index-userGrid-addUser-content">
		<div class="row-content">
			<label for="txtName">登录名 </label> <input id="txtName" name="user_name" type="text" placeholder="" maxlength="20" minlen="3" validate="en_" autocomplete="off" />
			<div class="errTips">提示信息</div>
			<div class="placeholder">用户名</div>
		</div>
		<div class="row-content">
			<label for="txtRealName">真实姓名</label> <input id="txtRealName" name="emp_name" type="text" placeholder="" maxlength="20" minlen="3" validate="ce" autocomplete="off" />
			<div class="errTips">提示信息</div>
			<div class="placeholder">真实姓名</div>
		</div>
		<div class="row-content">
			<label for="txtPwd">密码</label> <input id="txtPwd" type="text" name="pwd" placeholder="" maxlength="20" minlen="6" validate="ne_" autocomplete="off" />
			<div class="errTips">提示信息</div>
			<div class="placeholder">密码</div>
		</div>
		<div class="row-content">
			<label for="txtRepeatPwd">确认密码</label> <input id="txtRepeatPwd" name="confirmPwd" type="text" placeholder="" maxlength="20" minlen="6" validate="en_" autocomplete="off" />
			<div class="errTips">提示信息</div>
			<div class="placeholder">确认密码</div>
		</div>
		<div class="row-content divFlex">
			<label for="selectGender">性别</label>
			<!--<div id="selectGender" class="selectGender"></div>-->
			<select name="Gender">
				<option value="1">男</option>
				<option value="0">女</option>
				<option value="2">保密</option>
			</select>
		</div>
		<div class="row-content">
			<label for="txtMobile">手机号码</label> <input id="txtMobile" name="mobile" type="text" placeholder="" maxlength="11" minlen="11" validate="n" autocomplete="off" />
			<div class="errTips">提示信息</div>
			<div class="placeholder">手机号码</div>
		</div>
		<div class="row-content">
			<label for="txtEmail">E-mail</label> <input id="txtEmail" name="email" type="text" placeholder="" maxlength="20" minlen="1" validate="npea" autocomplete="off" />
			<div class="errTips">提示信息</div>
			<div class="placeholder">E-mail</div>
		</div>
		<div class="row-content divFlex">
			<label for="selectRole">职位</label>
			<div id="selectRole" class="selectRole"></div>
		</div>
		<div class="row-content divFlex">
			<label for="selectSchool">校区</label>
			<div id="selectSchool" class="selectSchool"></div>
		</div>
		<div class="row-content divFlex">
			<label for="discription">描述</label>
			<textarea id="description" class="description" maxlength="100"></textarea>
		</div>
		<!--<div class="row-content submit">-->
			<!--<input id="btnSave" class="btnSave" type="button" value="开通" />-->
		<!--</div>-->
		<input type="submit" value="开通">
	</div>
</form>
</body>
</html>