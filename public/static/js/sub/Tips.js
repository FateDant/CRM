//操作提示
function Tips(args) {
	try {
		if (!args.renderTo)
			throw "renderTo元素不存在，请检查renderTo是否存在";
	} catch (e) {
		throw ("tips初始化失败，原因：" + e);
		return;
	}
	this.init(args);
}
// 初始化参数
Tips.prototype.init = function(args) {
	// 参数对象为body
	this.renderTo = $(args.renderTo);
	this.top = args.top;
	this.originalTop = args.originalTop == undefined ? 0 : args.originalTop;
};
// 生成元素
Tips.prototype.build = function() {
	this.tips = $("<div class='tips errorTips'></div>").appendTo(this.renderTo);
	this.tips.addClass("hidden");
};
// 显示提示
Tips.prototype.show = function(args) {
	// 生成提示
	this.build();
	var t = this.tips;
	// 提示内容
	$(".tips").text(args.txtTips);
	// 定位提示
	this.tips.removeAttr("style").css({
		top : args.top + "px"
	});
	this.tips.removeClass("hidden").css("opacity", 0);
	this.tips.addClass(args.classTips);
	// IE10以下
	if (util.isLTIE10()) {
		// animate实现动画
		t.animate({
			opacity : 1
		}, 500);
	} else {
		t.css("transition", "all 250ms");
		t.css({
			opacity : 1
		});
	}
	setTimeout(function() {
		t.hide();
	}, 2000);
};
// 隐藏提示
Tips.prototype.hide = function() {
	var t = this.tips;
	if (util.isLTIE10()) {
		// animate实现动画
		t.animate({
			opacity : 0
		}, 300);
	} else {
		// 渐变
		t.css({
			opacity : 0
		});
	}
	// 动画结束后隐藏元素
	setTimeout(function() {
		t.addClass("hidden");
	}, 250);
};
