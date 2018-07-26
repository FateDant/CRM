var SLTGENSER, SLTUDU, SLTSTATE, SLTCHANNEL, SLTONLINE, SLTCONSULTANT, SLTCOURSE, SLTVISIT;
var IS_EDIT = false;
var STUDENTID;
// 错误统计
var errCount = 0;
// 时间变量
var cDate, fDate, rDate;
$(function() {
	// 咨询时间
	$("#consult-time").datepicker();
	// 上门时间
	$("#first-vist-time").datepicker();
	// 报名时间
	$("#register-time").datepicker();
	var topTips = new Tips({
		renderTo : "body"
	});
	// 点击开通账户调用插入数据库
	$("#btnSave").click(function() {
		postStudentInfo();
	});
	// 生成性别下拉列表
	SLTGENSER = new DropDownList({
		renderTo : "select-gender",
		dataSource : [ {
			key : "0",
			value : "女"
		}, {
			key : "1",
			value : "男"
		}, {
			key : "2",
			value : "保密"
		} ],
		defaultSelected : "-1",
		preloadItem : [ {
			key : "-1",
			value : "请选择"
		} ],
		direction : "down",
		onClick : function(t) {
			// alert(t.key); 此处k是键值对为key value的对象
			t.key == "-1" ? $("#select-gender").addClass("txtError") : $("#select-gender").removeClass("txtError");
		},
		onComplete : function() {
		}
	});

	// 生成学历下拉列表
	SLTUDU = new DropDownList({
		renderTo : "select-edu",
		dataSource : [ {
			key : "0",
			value : "初中"
		}, {
			key : "1",
			value : "中专"
		}, {
			key : "2",
			value : "高中"
		}, {
			key : "3",
			value : "高职"
		}, {
			key : "4",
			value : "大专"
		}, {
			key : "5",
			value : "本科"
		}, {
			key : "6",
			value : "研究生"
		} ],
		defaultSelected : "-1",
		preloadItem : [ {
			key : "-1",
			value : "请选择"
		} ],
		direction : "down",
		onClick : function(t) {
			t.key == "-1" ? $("#select-edu").addClass("txtError") : $("#select-edu").removeClass("txtError");
			$("#select-edu").attr("key", t.key);
		},
		onComplete : function() {
		}
	});
	// 生成目前状态下拉列表
	SLTSTATE = new DropDownList({
		renderTo : "select-stuState",
		dataSource : [ {
			key : "0",
			value : "在读学校"
		}, {
			key : "1",
			value : "在读离校"
		}, {
			key : "2",
			value : "待业"
		}, {
			key : "3",
			value : "在职"
		}, {
			key : "4",
			value : "自由职业"
		} ],
		defaultSelected : "-1",
		preloadItem : [ {
			key : "-1",
			value : "请选择"
		} ],
		direction : "down",
		onClick : function(t) {
			t.key == "-1" ? $("#select-stuState").addClass("txtError") : $("#select-stuState").removeClass("txtError");
			$("#select-stuState").attr("key", t.key);
		},
		onComplete : function() {
		}
	});
	// 生成信息来源下拉列表
	SLTCHANNEL = new DropDownList({
		renderTo : "infoSource",
		dataSource : [ {
			key : "1",
			value : "百度"
		}, {
			key : "2",
			value : "360"
		}, {
			key : "3",
			value : "搜狗"
		}, {
			key : "4",
			value : "58同城"
		}, {
			key : "5",
			value : "赶集网"
		}, {
			key : "6",
			value : "智联招聘"
		}, {
			key : "7",
			value : "前程无忧"
		}, {
			key : "8",
			value : "院校招聘"
		}, {
			key : "9",
			value : "院校宣讲"
		}, {
			key : "10",
			value : "院校实训"
		}, {
			key : "11",
			value : "院校专业共建"
		}, {
			key : "12",
			value : "渠道代理"
		} ],
		defaultSelected : "-1",
		preloadItem : [ {
			key : "-1",
			value : "请选择"
		} ],
		direction : "down",
		onClick : function(t) {
			t.key == "-1" ? $("#infoSource").addClass("txtError") : $("#infoSource").removeClass("txtError");
			$("#infoSource").attr("key", t.key);
		},
		onComplete : function() {
		}
	});
	// 生成报名课程下拉列表
	SLTCOURSE = new DropDownList({
		renderTo : "select-course",
		dataSource : "getCourse.action",
		mapping : {
			key : "course_id",
			value : "course_name"
		},
		preloadItem : [ {
			course_id : "-1",
			course_name : "未选择"
		} ],
		onClick : function(t) {
			t.key == "-1" ? $("#select-course").addClass("txtError") : $("#select-course").removeClass("txtError");
			$("#select-course").attr("key", t.key);
		},
		onComplete : function() {
			if (window.parent.editObj != null)
				fillText();
		}
	});

	loadOnline();
	loadConsultant();
	// 生成学生动作状态下拉列表
	SLTVISIT = new DropDownList({
		renderTo : "visit-state",
		dataSource : [ {
			key : "0",
			value : "未上门"
		}, {
			key : "1",
			value : "已上门"
		}, {
			key : "2",
			value : "已报名"
		} ],
		defaultSelected : "-1",
		preloadItem : [ {
			key : "-1",
			value : "请选择"
		} ],
		direction : "down",
		onClick : function(t) {
			t.key == "-1" ? $("#visit-state").addClass("txtError") : $("#visit-state").removeClass("txtError");
			$("#visit-state").attr("key", t.key);
		},
		onComplete : function() {

		}
	});
	// 文本框等各种事件
	$(".needErr").focus(function() {// 获取焦点
		// 隐藏当前文本框上面的错误提示
		hideErrorTip(this);// 传入当前触发事件的文本框
	}).blur(function() {// 失去焦点
		// 检查文本框内的文字是否符合要求
		checkTxt(this);// 传入当前触发事件的文本框
	}).keydown(function(event) {// 键盘按下事件
		// 如果按下的按键编号是13表示按下的是回车
		if (event.which == 13)
			postStudentInfo();
	}).keyup(function() {// 键盘抬起事件操作灰色占位符
		if ($(this).val() == "")
			// 显示灰色占位符
			$(this).next().next().removeClass("hidden");
		else
			// 隐藏灰色占位符
			$(this).next().next().addClass("hidden");
	});
	// 点击灰色占位符时，将焦点设置到下方的文本框中
	$(".placeholder").click(function() {
		$(this).prev().prev().focus();
	});
});

// 从顶层页面获取editObj填写本页面上的文本框
function fillText() {
	// 获取顶层页面top.editObj变量
	var e = window.parent.editObj;
	// 把顶层页面的editObj销毁
	window.parent.editObj = null;
	// 把商品信息填写到文本框
	$("#txtName").val(e.student_name);
	$("#select-gender .ddlTxt").text(e.gender);
	$("#select-edu .ddlTxt").text(e.education);
	$("#select-stuState .ddlTxt").text(e.current_state);
	$("#wechat").val(e.wechat);
	$("#txtMobile").val(e.mobile);
	$("#location").val(e.location);
	$("#qq").val(e.qq);
	$("#infoSource").attr("key", e.channel_id);
	$("#infoSource .ddlTxt").text(e.channel_name);
	$("#select-online").attr("key", e.online_consultant_id);
	$("#select-online .ddlTxt").text(e.online_name);
	$("#select-courseCon").attr("key", e.course_consultant_id);
	$("#select-courseCon .ddlTxt").text(e.consultant_name);
	$("#first-vist-time").val(handleTime(e.first_visit_time));
	$("#register-time").val(handleTime(e.register_time));
	$("#consult-time").val(handleTime(e.consult_time));
	$("#select-course").attr("key", e.course_id);
	$("#select-course .ddlTxt").text(e.course_name);
	$("#register-amount").val(e.register_amount);
	$("#visit-state .ddlTxt").text(e.visit_state);
	// 设置id
	STUDENTID = e.student_id;
	IS_EDIT = true;
}

// 提交商品信息到后台
function postStudentInfo() {
	var btnSave = $("#btnSave");
	// 如果按钮被禁用或者是阻塞状态就退出保存事件
	if (btnSave.hasClass("btnError") || btnSave.hasClass("btnSuccess") || btnSave.hasClass("btnDisable"))
		return;// 退出整个方法

	// 遍历所有输入框
	$("input[type='text'],input[type='password']").each(function() {
		// 如果当前文本框出错就累加错误数量
		errCount += checkTxt(this);
	});
	// 下拉列表是否报错检查
	if (IS_EDIT == false) {
		checkDdl("select-gender");
		checkDdl("select-edu");
		checkDdl("select-stuState");
		checkDdl("infoSource");
		checkDdl("select-online");
		checkDdl("select-courseCon");
		checkDdl("select-course");
		checkDdl("visit-state");
	}

	// 时间格式转换
	cDate = $("#consult-time").val().substring(6, 10) + "-" + $("#consult-time").val().substring(0, 2) + "-" + $("#consult-time").val().substring(3, 5);

	fDate = $("#first-vist-time").val().substring(6, 10) + "-" + $("#first-vist-time").val().substring(0, 2) + "-" + $("#first-vist-time").val().substring(3, 5);

	rDate = $("#register-time").val().substring(6, 10) + "-" + $("#register-time").val().substring(0, 2) + "-" + $("#register-time").val().substring(3, 5);
	alert(errCount)
	// 如果页面中存在错误
	if (errCount > 0)
		return;// 退出整个方法
	// 按钮点击后立即禁用，防止用户短时间快速反复点击
	setTimeout(function() {
		btnSave.addClass("btnDisable").val("保存中...");
	}, 2000);

	$.post(IS_EDIT ? "updateStudent.action" : "addStudent.action", {
		student_id : STUDENTID,
		student_name : $("#txtName").val(),
		gender : $("#select-gender .ddlTxt").text(),
		education : $("#select-edu .ddlTxt").text(),
		current_state : $("#select-stuState .ddlTxt").text(),
		wechat : $("#wechat").val(),
		mobile : $("#txtMobile").val(),
		location : $("#location").val(),
		qq : $("#qq").val(),
		channel_id : $("#infoSource").attr("key"),
		online_consultant_id : $("#select-online").attr("key"),
		course_consultant_id : $("#select-courseCon").attr("key"),
		school_id : $("#schoolId").text(),
		first_visit_time : fDate,
		register_time : rDate,
		course_id : $("#select-course").attr("key"),
		register_amount : $("#register-amount").val(),
		visit_state : $("#visit-state .ddlTxt").text(),
		create_id : $("#userId").text(),
		consult_time : cDate
	}, function(res) {
		// 如果商品保存成功
		if (res.isSuccess == "true") {
			// 先找到顶层页面top.window，再找到frames["mainIframe"].contentWindow内嵌页面，访问全局变量StudentGrid，调用对象的方法reload
			top.window.frames["mainIframe"].contentWindow.studentGrid.reload(1);
			// 隐藏弹出层
			top.topDialog.hide();
			top.topTips.show({
				txtTips : "开通用户成功",
				top : 0,
				classTips : "rightTips"
			});

		} else {
			top.topTips.show({
				txtTips : "开通用户失败",
				top : 0,
				classTips : "errorTips"
			});
		}
	});
}

// 检查文本框内的文字是否符合要求，如果文本框内为空就显示红色提示文字
function checkTxt(txtObj) {
	txtObj = $(txtObj);
	// 文本框是否出现错误
	var isHasError = false;
	// 获取文本框内的文字
	var textStr = txtObj.val();
	// 获取错误信息
	var errMsg = (function() {
		// 获得label中的文字
		var l = txtObj.parent().prev().children().text();
		// 如果文本框内的文字为空
		if ($.trim(textStr) == "") {
			isHasError = true;
			return "请输入" + l;
		}
		// 如果输入的文字的长度小于指定的长度
		if ($.trim(textStr).length < txtObj.attr("minlen")) {
			isHasError = true;
			return "至少输入" + txtObj.attr("minlen") + "个字符";
		}
		// 如果文本格式不符合正则的要求
		/*
		 * if (!util.validate(textStr, txtObj.attr("validate"))) { isHasError =
		 * true; return "请勿输入非法字符"; }
		 */
	})();
	// 如果文本框内的文字为空？显示错误提示信息：隐藏错误提示信息
	return isHasError ? showErrorTip(txtObj, errMsg) : hideErrorTip(txtObj);
}

// 显示错误提示信息
function showErrorTip(txtObj, errMsg) {
	// 给当前文本框加上红色边框
	txtObj.addClass("txtError");
	// 获取文本框后面红色的错误提示元素errTips
	var errTipsObj = txtObj.next();
	// 设置错误提示文字
	errTipsObj.text(errMsg);
	// 如果当前浏览器是IE8/IE9
	if (util.isLTIE10())
		// 从右往左淡入
		errTipsObj.animate({
			opacity : 1
		});
	else
		// 使用CSS3实现显示动画
		errTipsObj.addClass("showErrorTips");
	errTipsObj.click(function() {
		errTipsObj.prev().focus();
	});
	// 如果出错返回1用于统计错误数量
	return 1;
}

// 隐藏错误提示信息
function hideErrorTip(txtObj) {
	txtObj = $(txtObj);
	// 给当前文本框去掉红色边框
	txtObj.removeClass("txtError");
	// 获取文本框后面红色的错误提示元素errTips
	var errTipsObj = txtObj.next();
	// 如果当前浏览器是IE8/IE9
	if (util.isLTIE10())
		// 从左往右淡出
		errTipsObj.animate({
			opacity : 0

		});
	else
		// 使用CSS3实现显示动画
		errTipsObj.removeClass("showErrorTips");
	// 如果没错返回0
	return 0;
}
// 下拉列表未选报错统计
function checkDdl(obj) {
	var selectObj = $("#" + obj + " .ddlItemSelected").attr("key");
	if (selectObj == "-1") {
		errCount++;
		$("#" + obj + "").addClass("txtError");
	} else {
		$("#" + obj + "").removeClass("txtError");
	}
}

function loadOnline() {
	// 拼接查询条件
	var condition = " AND R.ROLE_NAME='在线咨询师'";
	// 生成在线咨询师下拉列表
	SLTONLINE = new DropDownList({
		renderTo : "select-online",
		dataSource : "getUser.action",
		mapping : {
			key : "user_id",
			value : "user_name"
		},
		preloadItem : [ {
			user_id : "-1",
			user_name : "未选择"
		} ],
		onClick : function(t) {
			t.key == "-1" ? $("#select-online").addClass("txtError") : $("#select-online").removeClass("txtError");
			$("#select-online").attr("key", t.key);
		},
		onComplete : function() {
			/*
			 * if (window.parent.editObj != null) fillText();
			 */
		}
	});

}

function loadConsultant() {
	// 拼接查询条件
	var condition = " AND R.ROLE_NAME='课程顾问'";
	// 生成课程顾问下拉列表
	SLTCONSULTANT = new DropDownList({
		renderTo : "select-courseCon",
		dataSource : "getUser.action",
		mapping : {
			key : "user_id",
			value : "user_name"
		},
		preloadItem : [ {
			user_id : "-1",
			user_name : "未选择"
		} ],
		onClick : function(t) {
			t.key == "-1" ? $("#select-courseCon").addClass("txtError") : $("#select-courseCon").removeClass("txtError");
			$("#select-courseCon").attr("key", t.key);
		},
		onComplete : function() {
			/*
			 * if (window.parent.editObj != null) fillText();
			 */
		}
	});

}

// 时间处理
function handleTime(obj) {
	var m = obj.substring(0, 1);
	var d = obj.substring(2, 4);
	m = m < 10 ? "0" + m : m;
	return "2018-" + m + "-" + d;
}