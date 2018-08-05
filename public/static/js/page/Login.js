$(function() {
	// 从cookie中获取用户名
	var lastLoginName = util.cookie.get("lastLoginName");
	// 验证码点击
	$("#pic").click(loadImg);
	// 如果能获取到用户名
	if (lastLoginName != null && lastLoginName != "") {
		// 把从cookie中获取到的用户名设置到文本框上
		$("#txtUserName").val(lastLoginName);
		// 把焦点设置到密码框上
		$("#txtPassword").focus();
		// 隐藏占位符
		$(".placeholder:eq(0)").addClass("hidden");
	} else {
		// 把焦点设置到用户名框上
		$("#txtUserName").focus();
	}
	// 登录按钮点击事件
	$("#btnLogin").click(btnLogin_onclick);
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
			btnLogin_onclick();
	}).keyup(function() {// 键盘抬起事件操作灰色占位符
		if ($(this).val() == "")
			// 显示灰色占位符
			$(this).next().next().removeClass("hidden");
		else
			// 隐藏灰色占位符
			$(this).next().next().addClass("hidden");
	});
	// 点击错误提示是,将焦点设置到下方的文本框中
	$(".errTips").click(function() {
		$(this).prev().focus();
	});
	// 点击灰色占位符时，将焦点设置到下方的文本框中
	$(".placeholder").click(function() {
		$(this).prev().prev().focus();
	});
	// 验证码刷新
	loadImg();
});

// 验证码刷新
function loadImg() {
	$("#pic").attr("src", $("#pic").attr("basePath") + "?t=" + Date.now());
}

// 检查文本框内的文字是否符合要求，如果文本框内为空就显示红色提示文字
function checkTxt(txtObj) {
	txtObj = $(txtObj);
	// 错误提示信息
	var errMsg = "请输入" + txtObj.attr("placeholder");
	// 如果文本框内的文字为空？显示错误提示信息：隐藏错误提示信息
	return txtObj.val() == "" ? showErrorTip(txtObj, errMsg)
			: hideErrorTip(txtObj);
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

// 登录按钮点击事件
function btnLogin_onclick() {
	var btnLogin = $("#btnLogin");
	// 如果按钮被禁用或者是阻塞状态就退出登录事件
	if (btnLogin.hasClass("btnError") || btnLogin.hasClass("btnSuccess")
			|| btnLogin.hasClass("btnDisable"))
		return;// 退出整个方法
	// 错误统计
	var errCount = 0;
	// 遍历所有输入框
	$("input[type='text'],input[type='password']").each(function() {
		// 如果当前文本框出错就累加错误数量
		errCount += checkTxt(this);
	});
	// 如果页面中存在错误
	if (errCount > 0)
		return;// 退出整个方法
	// 按钮点击后立即禁用，防止用户短时间快速反复点击
	btnLogin.addClass("btnDisable").val("正在登录，请稍后……");
	$.post("login.action", {
		user_name : $("#txtUserName").val(),
		pwd : $("#txtPassword").val(),
		code : $("#chkRM").val()
	}, function(json) {
		// 服务器响应后解锁按钮
		btnLogin.removeClass("btnDisable");
		// 如果登录成功
		if (json.isSuccess == "true") {
			util.cookie.set("lastLoginName", $("#chkRMW").is(":checked") ? $(
					"#txtUserName").val() : "");
			btnLogin.addClass("btnSuccess").val("登录成功，请稍后……");
			setTimeout(function() {
				// 页面跳转
				location.href = "jsp/page/Index.jsp";
			}, 500);
		} else {
			btnLogin.addClass("btnError").val("登录失败，原因：" + json.errMsg);
			setTimeout(function() {
				btnLogin.removeClass("btnError").val("登录");
				// 刷新验证码
				loadImg();
			}, 2000);
		}
	});
}
