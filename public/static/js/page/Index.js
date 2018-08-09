var topDialog;
var LICONTENT;
var IP;
var SCHOOLID;
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
	IP="192.168.1.227";
	// 生成菜单
	new Menu({
		renderTo : "leftMenu",
		dataSource : [ {
			name : "首页",
			url : "./CollegeGrid/showIndex?id=0"
		}, {
			name : "数据搜索",
            url : "./CollegeGrid/showIndex?id=1"
		}, {
			name : "常规招生",
            url : "./CollegeGrid/showIndex?id=2"
		}, {
			name : "院校招生",
            url : "./CollegeGrid/showIndex?id=3"
		}, {
			name : "口碑招生",
            url : "./CollegeGrid/showIndex?id=4"
		}, {
			name : "校区招生",
            url : "./CollegeGrid/showIndex?id=5"
		}, {
			name : "系统管理",
            url : "./CollegeGrid/showIndex?id=6"
		} ],
		onClick : function(li) {
			$("#mainIframe").attr("src", $(li).attr("url"));
			LICONTENT = $(li).text();
            SCHOOLID=$(li).attr("key");
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
