function Carousel(args) {
	try {
		if (!args.renderTo)
			throw "renderTo元素不存在，请检查ID是否存在";
		if (args.onClick && !$.isFunction(args.onClick))
			throw "onClick属性必须是方法，现在传的onClick是" + typeof args.onClick;
		if (args.onComplete && !$.isFunction(args.onComplete))
			throw "onComplete属性必须是方法，现在传的onComplete是" + typeof args.onComplete;
		if (args.preloadItem && !$.isArray(args.preloadItem))
			throw "preloadItem属性必须是数组，现在传的preloadItem是"
					+ typeof args.preloadItem;
		if (!args.dataSource)
			throw "缺失必要参数";
	} catch (e) {
		alert("下拉列表初始化失败，原因：" + e);
		return;
	}
	// 初始化图片轮播参数
	this.init(args);
}
// 初始化图片轮播参数
Carousel.prototype.init = function(args) {
	this.renderTo = $("#" + args.renderTo);
	this.dataSource = args.dataSource;
	this.defaultSelected = args.defaultSelected;
	this.mapping = args.mapping ? args.mapping : {
		key : "key",
		imgUrl : "imgUrl"
	};
	this.onClick = args.onClick === undefined ? function() {
	} : args.onClick;
	this.onComplete = args.onComplete === undefined ? function() {
	} : args.onComplete;
	this.getDataByDataSource();
};
// 根据传入的数据源获取数据
Carousel.prototype.getDataByDataSource = function() {
	var t = this;
	if (typeof this.dataSource == "string") {
		$.ajax({
			type : "POST",
			url : this.dataSource,
			// 只有数据库返回数据时，这个回调的success才会执行
			success : function(res) {
				t.dataSource = res;
				// 生成元素
				t.build();
			}
		});
	} else
		// 生成元素
		this.build();
};

// 生成元素
Carousel.prototype.build = function() {
	var t = this;
	this.renderTo.html("");
	var putImg = $("<ul class='putImg'></ul>").appendTo(this.renderTo);
	$(this.dataSource).each(
			function() {
				$("<li><img src='shopping/" + this[t.mapping.imgUrl] + "'></li>")
						.appendTo(putImg);
			});
	var showNav = $("<div class='showNav'></div>").appendTo(this.renderTo);
	$(this.dataSource).each(
			function() {
				$("<span class='point'>" + /* this[t.mapping.key] */"</span>")
						.appendTo(showNav);
			});
	// 默认选中第一个
	$(".showNav>span:first").addClass("active");
	this.eventBind();
};

/* 注册事件 */
Carousel.prototype.eventBind = function() {
	var ul = $("#slideShow>ul");
	var showNumber = $(".showNav>span");
	var oneWidth = $("#slideShow>ul>li:first").width();
	var timer = null;
	var iNow = 0;
	showNumber.click(function() {
		showNumber.removeClass("active");
		$(this).addClass("active");
		// 被点击按钮的下标
		var index = $(this).index();
		iNow = index;
		ul.animate({
			// 动画效果实现：往左滑动，其值是当前点击按钮图片的宽度乘以当前点击span的下标
			"left" : -oneWidth * iNow,
		});
	});
	/* 自动播放事件 */
	function autoPlay() {
		var oldWidth = $("#slideShow>ul:first").width();
		var t = this;
		timer = setInterval(function() {
			iNow++;
			if (iNow > showNumber.length - 1) {
				iNow = 0;
				if (util.isLTIE10())
					ul.animate({
						left : -iNow * oneWidth + "px"
					});
				else
					ul.css("left", iNow * oneWidth + "px");
			}
			showNumber.eq(iNow).trigger("click"); // 模拟触发数字按钮的click trigger()
			// 方法触发被选元素的指定事件类型。
		}, 2000);
	}
	autoPlay();

	/* 鼠标悬浮图片停止轮播 */
	$("#slideShow").hover(function() {
		clearInterval(timer);
	}, autoPlay);
};

 