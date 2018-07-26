function Dialog(args) {
	try {
		if (!args.renderTo)
			throw "renderTo元素不存在，请检查ID是否存在";
	} catch (e) {
		alert("弹出层初始化失败，原因：" + e);
		return;
	}
	// 初始化下拉列表参数
	this.init(args);
}

// 初始化参数
Dialog.prototype.init = function(args) {
	this.renderTo = $("#" + args.renderTo);
}

// 生成元素
Dialog.prototype.build = function() {
	this.renderTo.addClass("dialog hidden");
	this.renderTo.html("");
	var titleBar = $("<div class='titleBar'></div>").appendTo(this.renderTo);
	this.titleTxt = $("<div class='titleTxt'></div>").appendTo(titleBar);
	this.btnClose = $("<div class='btnClose' unselectable='on'></div>").appendTo(titleBar);
	// 判断是否生成iframe
	if (this.confirm) {
		this.content = $("<div class='content'></div>").appendTo(this.renderTo);
		this.container = $("<div class='dialog-container'></div>").appendTo(this.content);
		this.icon = $("<i class='fa fa-trash-o'></i>").appendTo(this.container);
		this.contentText = $("<span class='contentText'></span>").text(this.text).appendTo(this.container);
		this.btnBar = $("<div class='btnBar'></div>").appendTo(this.content);
		this.btnYes = $("<button id='btnYes'>确认</button>").appendTo(this.btnBar);
		this.btnNo = $("<button id='btnNo'>取消</button>").appendTo(this.btnBar);
	} else
		this.iframe = $("<iframe id='dialogIframe' src='' frameborder='0'></iframe>").appendTo(this.renderTo);
	// 如果后面一个元素不是遮罩层
	if (!this.renderTo.next().hasClass("dialogMask"))
		this.dialogMask = $("<div class='dialogMask hidden'></div>").insertAfter(this.renderTo);
};

// 注册事件
Dialog.prototype.eventBind = function() {
	var t = this;
	// 关闭
	this.btnClose.click(function() {
		t.hide();
	});
	if (this.confirm)
		$("button", this.btnBar).click(function() {
			t.hide();
			if ($(this).attr("id") == "btnYes")
				t.onClickYes();
		});
};

// 显示弹出层
Dialog.prototype.show = function(args) {
	this.confirm = args.confirm;
	this.text = args.text;
	this.onClickYes = args.onClickYes;
	var t = this;
	// 生成弹出层
	this.build();
	// 定位弹出层
	this.renderTo.removeAttr("style").css({
		width : args.width + "px",
		margin : "-" + args.height / 2 + "px 0 0 -" + args.width / 2 + "px"
	});
	if (!this.confirm)
		// 设置弹出层内部框架尺寸和地址
		this.iframe.height(args.height + "px").attr("src", args.url);
	// 设置弹出层标题
	this.titleTxt.text(args.title);
	// 淡入准备：先取消display隐藏样式hidden，使用opacity隐藏
	this.renderTo.removeClass("hidden").css("opacity", 0);
	this.dialogMask.removeClass("hidden").css("opacity", 0);
	// 如果是IE10以下的版本
	if (util.isLTIE10()) {
		// 使用animate实现动画
		t.dialogMask.animate({
			opacity : .5
		}, 500);
		t.renderTo.animate({
			opacity : 1
		}, 500);
	} else {
		// 使用CSS3实现动画
		setTimeout(function() {
			t.renderTo.css("transition", "all 250ms");
			t.dialogMask.css("transition", "all 250ms");
			setTimeout(function() {
				t.dialogMask.css({
					opacity : .5
				});
				t.renderTo.css({
					opacity : 1,
					transform : "scale(1, 1)"
				});
			}, 50);
		}, 50);
	}
	this.eventBind();
}

// 隐藏弹出层
Dialog.prototype.hide = function() {
	var t = this;
	if (util.isLTIE10()) {
		// 使用animate实现动画
		t.dialogMask.animate({
			opacity : 0
		}, 300);
		t.renderTo.animate({
			opacity : 0
		}, 300);
	} else {
		// 先实现渐变
		t.dialogMask.css("opacity", 0);
		t.renderTo.css({
			opacity : 0,
			transform : "scale(.5, .5)"
		});
	}
	// 动画结束后隐藏元素
	setTimeout(function() {
		t.renderTo.addClass("hidden");
		t.dialogMask.addClass("hidden");
	}, 250);
};

