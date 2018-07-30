<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:49:"../application/admin/view/dialog/AddCallback.html";i:1532673915;}*/ ?>
<!doctype html>
<html>
<head>
<base href="<%=basePath%>">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>回访记录</title>
<link rel="stylesheet" href="/static/css/common/font-awesome.css" />
<link rel="stylesheet" href="/static/css/common/jquery-ui.css" />
<link rel="stylesheet" href="/static/css/common/Common.css" />
<link rel="stylesheet" href="/static/css/sub/Tips.css" />
<link rel="stylesheet" href="/static/css/sub/DropDownList.css" />
<link rel="stylesheet" href="/static/css/dialog/AddCallback.css" />
</head>
<body>
<form action="addCallBack" method="post">
	<span id="userId" class="hidden">？？？？？</span>
	<div class="index-callbackGrid-addcallback-content">
		<div class="basicInfo">回访记录</div>
		<table class="add-container" cellspacing="0" cellpadding="0">
			<tbody>
				<tr>
					<td><label for="callback-time">咨询日期</label></td>
					<td><input type="text" name="visit_time" id="callback-time" class="add-container-list"/></td>
					<td><label for="call-way" >回访方式</label></td>
					<td>
						<select name="visit_way">
							<option value="0">电话</option>
							<option value="1">QQ</option>
							<option value="2">微信</option>
							<option value="3">面谈</option>
						</select>
					</td>
					<td><label for="stu-will">学员意向</label></td>
					<td>
						<select name="will_state">
							<option value="0">非常有意向</option>
							<option value="1">一般有意向</option>
							<option value="2">意向不明</option>
							<option value="3">无意向</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><label for="call-user" class="word-space">回访人员</label></td>
					<td><div id="call-user" class="add-container-list"></div></td>
				</tr>
			</tbody>
		</table>
		<div class="callback-content">
			<div class="callback-content-title">回访记录</div>
			<textarea name="log_detail" id="callback-content-container" class="callback-content-container"></textarea>
		</div>
		<div class="submit">
			<!--<input id="btnSave" class="btnSave" type="button" value="提交" /> -->
			<input type="submit" value="提交" />
		</div>
	</div>
</form>
<script src="/static/js/common/jquery-1.12.0.js" type="text/javascript"></script>
<script src="/static/js/common/jquery-ui.min.js" type="text/javascript"></script>
<script src="/static/js/common/util.js" type="text/javascript"></script>
<script src="/static/js/sub/Tips.js" type="text/javascript"></script>
<script src="/static/js/sub/DropDownList.js" type="text/javascript"></script>
<script src="/static/js/dialog/AddCallback.js"></script>
</body>
</html>