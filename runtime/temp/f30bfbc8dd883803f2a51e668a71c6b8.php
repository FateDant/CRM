<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:48:"../application/admin/view/grid/index_charts.html";i:1532308599;}*/ ?>
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
<script src="/static/js/common/highcharts.js" type="text/javascript"></script>
<script src="https://img.hcharts.cn/highcharts/modules/exporting.js"></script>
<script src="https://img.hcharts.cn/highcharts/modules/variable-pie.js"></script>
<script src="/static/js/common/jquery-ui.min.js" type="text/javascript"></script>
<link href="/static/css/common/Common.css" rel="stylesheet">
<script src="/static/js/common/util.js" type="text/javascript"></script>
<script src="/static/js/sub/DropDownList.js" type="text/javascript"></script>
<script src="/static/js/sub/Grid.js" type="text/javascript"></script>
<script src="/static/js/sub/Tips.js" type="text/javascript"></script>
<link href="/static/css/grid/IndexCharts.css" rel="stylesheet" />
<script src="/static/js/grid/IndexCharts.js"></script>

</head>
<body>
	<div class="IndexCharts-body">
		<div class="IndexCharts-body-top">首页</div>
		<div class="acount-search">数据总览</div>
		<div class="chartsContainer">
			<div class="school-rank" id="schoolRank"></div>
		<div class="infoContainer">
			<div class="infoSource" id="infoSource"></div>
			<div class="stuState" id="stuState"></div>
		</div>
		<div class="stuTotal" id="stuTotal"></div>
		</div>
		
	</div>
</body>
</html>