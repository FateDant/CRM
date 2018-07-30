<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:44:"../application/admin/view/grid/UserGrid.html";i:1532656098;s:76:"D:\ruanjian\wamp\wamp64\www\ThinkPHP\application\admin\view\public\meta.html";i:1532404238;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>用户管理</title>
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
	<link href="/static/css/grid/UserGrid.css" rel="stylesheet">
	<script src="/static/js/grid/UserGrid.js"></script>
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

<!--<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>数据搜索</title>
    <link rel="stylesheet" href="/static/css/common/font-awesome.css" />
    <link rel="stylesheet" href="/static/css/common/jquery-ui.css" />
    <link rel="stylesheet" href="/static/css/sub/DropDownList.css" />
    <link rel="stylesheet" href="/static/css/sub/Grid.css" />
    <link rel="stylesheet" href="/static/css/sub/Tips.css" />
    <script src="/static/js/common/jquery-1.12.0.js" type="text/javascript"></script>
    <script src="/static/js/common/highcharts.js" type="text/javascript"></script>
    <script src="https://img.hcharts.cn/highcharts/modules/exporting.js"></script>
    <script src="https://img.hcharts.cn/highcharts/modules/variable-pie.js"></script>
    <script src="/static/js/common/jquery-ui.min.js" type="text/javascript"></script>
    <link href="/static/css/common/Common.css" rel="stylesheet">
    <script src="/static/js/common/util.js" type="text/javascript"></script>
    <script src="/static/js/sub/DropDownList.js" type="text/javascript"></script>
    <script src="/static/js/sub/Grid.js" type="text/javascript"></script>
    <script src="/static/js/sub/Tips.js" type="text/javascript"></script>
    <link href="/static/css/grid/AdmissionsGrid.css" rel="stylesheet" />
    <script src="/static/js/grid/AdmissionsGrid.js"></script>
    <link href="/static/css/grid/IndexCharts.css" rel="stylesheet" />
    <script src="/static/js/grid/IndexCharts.js"></script>
    <link href="/static/css/grid/UserGrid.css" rel="stylesheet">
    <script src="/static/js/grid/UserGrid.js"></script>
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

</head>-->
<body>
	<div class="userGrid-body">
		<div class="userGrid-body-top">
			<span>账号管理及添加-</span> <span><?php echo $school_name; ?></span>
		</div>
		<div class="acount-search">账号搜索</div>
		<form action="selectUser" method="post">
		<table class="search-container">
			<tbody>
				<tr>
					<td><label for="txtUser">姓名</label></td>
					<td><input id="txtUser" type="text" name="user_name" placeholder="请输入用户名"
						maxlength="20" minlen="6" validate="en_" autocomplete="on" /></td>
					<td><label for="txtMobile">电话</label></td>
					<td><input id="txtMobile" type="text" name="mobile" placeholder="请输入电话"
						maxlength="11" validate="n" autocomplete="off" /></td>
					<td><label for="select-depart">部门</label></td>
					<td>
						<div id="select-depart" class="search-container-list"></div>
					</td>
					<td><label for="select-role">职位</label></td>
					<td><div id="select-role" class="search-container-list"></div>
					</td>
				</tr>
				<tr>
					<td><label for="">申请日期</label></td>
					<td><input type="text" id="startDate" name="dateBegin" />
					</td>
					<td><label>至</label></td>
					<td><input type="text" id="endDate" name="dateEnd" /></td>
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
			<!-- <button class="add" id="btnAdd">
				<i class="fa fa-plus"></i> 添加
			</button> -->
			<!--<a href="javascript:admin/userGrid/add;" class="add" >开通账户</a>-->
			<a href="show" class="add" >开通账户</a>
		</div>
		<div class="list-title">
			<span>学员信息列表</span>
			<div class="del-update">
				<button class="delete" id="btnDel">
					<i class="fa fa-trash-o"></i> 删除
				</button>
				<button class="update" id="btnEdit">
					<i class="fa fa-pencil-square-o"></i> 编辑
				</button>
			</div>
		</div>
		<div id="myTableUser" class="myTableUser"></div>
	</div>
</body>
</html>