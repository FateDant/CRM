var SLTUSER;
var IS_EDIT = false;
var USERID;
var SLTSCHOOL;
//错误统计
var errCount = 0;
$(function() {
	var topTips = new Tips({
		renderTo : "body"
	});
	// 点击开通账户调用插入数据库
	$("#btnSave").click(function() {
		postUserInfo();
	});

	// 生成性别下拉列表
	SLTUSER = new DropDownList({
		renderTo : "selectGender",
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
			t.key == "-1" ? $("#selectGender").addClass("txtError") : $(
					"#selectGender").removeClass("txtError");
		},
		onComplete : function() {
			/*if (window.parent.editObj != null)
				fillText();*/
		}
	});
	// 生成职位下拉列表
	SLTSCHOOL = new DropDownList({
		renderTo : "selectRole",
		dataSource : "getRole.action",
		mapping : {
			key : "role_id",
			value : "role_name"
		},
		preloadItem : [ {
			role_id : "-1",
			role_name : "请选择"
		} ],
		onClick : function(t) {
			t.key == "-1" ? $("#selectRole").addClass("txtError") : $(
					"#selectRole").removeClass("txtError");
			$("#selectRole").attr("key", t.key);
		},
		onComplete : function() {
			
		}
	});
	// 生成校区下拉列表
	SLTSCHOOL = new DropDownList({
		renderTo : "selectSchool",
		dataSource : "getSchool.action",
		mapping : {
			key : "school_id",
			value : "school_name"
		},
		preloadItem : [ {
			school_id : "-1",
			school_name : "请选择校区"
		} ],
		onClick : function(t) {
			t.key == "-1" ? $("#selectSchool").addClass("txtError") : $(
					"#selectSchool").removeClass("txtError");
			$("#selectSchool").attr("key", t.key);
		},
		onComplete : function() {
			if (window.parent.editObj != null)
				fillText();
		}
	});
	// 文本框注册等各种事件
	$("input[type='text'],input[type='password']").focus(function() {// 获取焦点
		// 隐藏当前文本框上面的错误提示
		hideErrorTip(this);// 传入当前触发事件的文本框
	}).blur(function() {// 失去焦点
		// 检查文本框内的文字是否符合要求
		checkTxt(this);// 传入当前触发事件的文本框
	}).keydown(function(event) {// 键盘按下事件
		// 如果按下的按键编号是13表示按下的是回车
		if (event.which == 13)
			postUserInfo();
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
	$("#txtName").val(e.user_name);
	$("#txtRealName").val(e.emp_name);
	$("#txtPwd").val(e.pwd);
	$("#txtRepeatPwd").val(e.pwd);
	$("#selectGender .ddlTxt").text(e.gender);
	$("#txtMobile").val(e.mobile);
	$("#txtEmail").val(e.email);
	$("#selectRole").attr("key",e.role_id);
	$("#selectRole .ddlTxt").text(e.role_name);
	$("#selectSchool").attr("key",e.school_id);
	$("#selectSchool .ddlTxt").text(e.school_name);
	$("#description").val(e.des);
	// 设置id
	USERID = e.user_id;
	IS_EDIT = true;
}

// 提交商品信息到后台
function postUserInfo() {
	var btnSave = $("#btnSave");
	// 如果按钮被禁用或者是阻塞状态就退出保存事件
	if (btnSave.hasClass("btnError") || btnSave.hasClass("btnSuccess")
			|| btnSave.hasClass("btnDisable"))
		//return;// 退出整个方法
	
	// 遍历所有输入框
	$("input[type='text'],input[type='password']").each(function() {
		// 如果当前文本框出错就累加错误数量
		errCount += checkTxt(this);
	});
	
	// 如果页面中存在错误
	if (errCount > 0)
		return;// 退出整个方法
	// 按钮点击后立即禁用，防止用户短时间快速反复点击
	setTimeout(function() {
		btnSave.addClass("btnDisable").val("正在保存，请稍后……");
	}, 2000);

	$.post(IS_EDIT ? "updateUser.action" : "addUser.action", {
		user_id : USERID,
		user_name : $("#txtName").val(),
		pwd : $("#txtPwd").val(),
		email : $("#txtEmail").val(),
		mobile : $("#txtMobile").val(),
		emp_name : $("#txtRealName").val(),
		gender : $("#selectGender .ddlItemSelected").text(),
		role_id : $("#selectRole").attr("key"),
		school_id : $("#selectSchool").attr("key"),
		des : $("#description").val()
	}, function(res) {
		// 如果商品保存成功
		if (res.isSuccess == "true") {
			// 先找到顶层页面top.window，再找到frames["mainIframe"].contentWindow内嵌页面，访问全局变量userGrid，调用对象的方法reload
			top.window.frames["mainIframe"].contentWindow.userGrid.reload(1);
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
		var l = txtObj.prev().text();
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
		if (!util.validate(textStr, txtObj.attr("validate"))) {
			isHasError = true;
			return "请勿输入非法字符";
		}
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

//下拉列表未选报错统计
function checkDdl(obj) {
	var selectObj = $("#" + obj + " .ddlItemSelected").attr("key");
	if (selectObj == "-1") {
		errCount++;
		$("#" + obj + "").addClass("txtError");
	} else {
		$("#" + obj + "").removeClass("txtError");
	}
}
