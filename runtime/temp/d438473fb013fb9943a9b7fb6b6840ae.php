<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:46:"../application/admin/view/grid/CampusGrid.html";i:1532595342;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<base href="<%=basePath%>">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>数据搜索</title>
	<link rel="stylesheet" href="/static/css/common/font-awesome.css" />
	<link rel="stylesheet" href="/static/css/common/jquery-ui.css" />
	<link rel="stylesheet" href="/static/css/sub/DropDownList.css" />
	<link rel="stylesheet" href="/static/css/sub/Grid.css" />
	<link rel="stylesheet" href="/static/css/sub/Tips.css" />
	<script src="/static/js/common/jquery-1.12.0.js" type="text/javascript"></script>
	<script src="/static/js/common/jquery-ui.min.js" type="text/javascript"></script>
	<link href="/static/css/common/Common.css" rel="stylesheet">
	<script src="/static/js/common/util.js" type="text/javascript"></script>
	<script src="/static/js/sub/DropDownList.js" type="text/javascript"></script>
	<script src="/static/js/sub/Grid.js" type="text/javascript"></script>
	<script src="/static/js/sub/Tips.js" type="text/javascript"></script>
	<link href="/static/css/grid/AdmissionsGrid.css" rel="stylesheet" />
	<script src="/static/js/grid/AdmissionsGrid.js"></script>
	<style>
		.f {
			color: white;
			background-color: #E91E63;
			padding: .1em 0.5em;
		}

		.m {
			color: white;
			background-color: #2196F3;
			padding: .1em .4em;
		}

		.f,.m {
			border-radius: 0.2em;
		}
	</style>

</head>
<body>
	<div class="admissionsGrid-body">
		<div class="admissionsGrid-body-top">
			<span>校区招生-</span> <span>学校名称</span>
		</div>
		<div class="acount-search">数据搜索</div>
		<form action="stuInfo" method="post">
		<table class="search-container">
			<tbody>
				<tr>
					<td><label for="txtStu">姓名</label>
					</td>
					<td><input id="txtStu" name="student_name" type="text" placeholder="请输入用户名" maxlength="20" minlen="6" validate="en_" autocomplete="on" />
					</td>
					</td>
					<td><label for="select-channel">渠道</label></td>
					<!--<td><div id="select-channel" class="search-container-list"></div></td>-->
					<td>
						<select name="channel_id">
							<option value="1">百度</option>
							<option value="2">360</option>
							<option value="3">搜狗</option>
							<option value="4">58同城</option>
							<option value="6">赶集网</option>
						</select>
					</td>
					<td><div id="select-channel" class="search-container-list"></div></td>
					<td><label for="txtMobile">电话</label></td>
					<td><input id="txtMobile" name="mobile" type="text" placeholder="请输入电话" maxlength="11" validate="n" autocomplete="off" /></td>
					<td><label for="txtOnline">在线咨询师</label></td>
					<td>
						<!--<div id="select-online" class="search-container-list"></div>-->
						<select name="online_consultant_id">
							<option value="5">zzz</option>
							<option value="6">ldh</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><label for="select-edu">学历</label></td>
					<td>
						<!--<div id="select-edu" class="search-container-list"></div>-->
						<select name="education">
							<option value="0">初中</option>
							<option value="1">中专</option>
							<option value="2">高中</option>
							<option value="3">高职</option>
							<option value="4">大专</option>
							<option value="5">本科</option>
							<option value="6">研究生</option>
						</select>
					</td>
					<td><label for="select-stuState">学员状态</label></td>
					<td>
						<!--<div id="select-stuState" class="search-container-list"></div>-->
						<select name="current_state">
							<option value="0">在读学校</option>
							<option value="1">在读离校</option>
							<option value="2">待业</option>
							<option value="3">在职</option>
							<option value="4">自由职业</option>
						</select>
					</td>
					<td><label for="select-stuAtt">学员意向</label></td>
					<td>
						<!--<div id="select-stuAtt" class="search-container-list"></div>-->
						<select name="will_state">
							<option value="0">非常有意向</option>
							<option value="1">一般有意向</option>
							<option value="2">意向不明</option>
							<option value="3">无意向</option>
						</select>
					</td>
					<td><label for="select-courseCon">课程顾问</label></td>
					<td>
						<!--<div id="select-courseCon" class="search-container-list"></div>-->
						<select name="course_consultant_id">
							<option value="2">fate</option>
							<option value="4">zhangqiuyang</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><label for="">咨询日期</label></td>
					<td><input type="text" id="startDate" />
					</td>
					<td><label>至</label></td>
					<td><input type="text" id="endDate" /></td>
				</tr>
			</tbody>
		</table>
		<div class="act">
			<!--<button class="select" id="btnSearch">-->
				<!--<i class="fa fa-search"></i> 查询-->
			<!--</button>-->
			<input type="submit" value="查询">
			<button class="reset" id="btnReset">
				<i class="fa fa-refresh"></i> 重置
			</button>
		</div>
		</form>
		<div class="addContainer">
			<!--<a href="javascript:;" class="add" id="btnAdd">录入学生</a>-->
			<a href="show" class="add" >录入学生</a>

		</div>
		<div class="list-title">
			<span>学员信息列表</span>
			<div class="del-update">
				<button class="addRecord" id="btnAddRecord">
					<i class="fa fa-plus"></i> 添加回访记录
				</button>
				<button class="update" id="btnEdit">
					<i class="fa fa-pencil-square-o"></i> 编辑
				</button>
			</div>
		</div>
		<div id="myTableAdmissions" class="myTableAdmissions"></div>
		<div id="myTableCallback" class="myTableCallback hidden"></div>
	</div>
</body>
</html>