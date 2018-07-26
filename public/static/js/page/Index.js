var topDialog;
var LICONTENT;
$(function() {
	// 初始化弹出层
	topDialog = new Dialog({
		renderTo : "dialog"
	});
	// 初始化完成成功提示
	topTips = new Tips({
		renderTo : "body"
	});
	// 显示更多信息
	$("#btnUser").click(function() {
		$("#showDdl").fadeToggle();
		$("#userMore").css("transform", "rotate(90deg)");
	});
	// 跳转登录页
	$(".loadIndex").click(function() {
		window.location.href = "jsp/page/Login.jsp";
	});
	// 退出按钮
	$("#btnExit").click(function() {
		$.post("exit.action", function() {
			location.href = $("base").attr("href");
		});
	});
	// 生成菜单
	new Menu({
		renderTo : "leftMenu",
		dataSource : [ {
			name : "首页",
			url : "IndexCharts\\index"
		}, {
			name : "数据搜索",
			url : "DataGrid\\index"
		}, {
			name : "常规招生",
			url : "RegularGrid\\index"
		}, {
			name : "院校招生",
			url : "CollegeGrid\\index"
		}, {
			name : "口碑招生",
			url : "PraiseGrid\\index"
		}, {
			name : "校区招生",
			url : "CampusGrid\\index"
		}, {
			name : "系统管理",
			url : "UserGrid\\index"
		} ],
		onClick : function(li) {
			$("#mainIframe").attr("src", $(li).attr("url"));
			LICONTENT = $(li).text();
		}

	});
	// 浏览器窗体大小改变时触发该事件
	$(window).resize(function() {
		updateSize();
	});
	updateSize();
});
// 根据浏览器窗口更新元素高度
function updateSize() {
	$("#mainIframe").height(document.body.clientHeight - 80);
}
