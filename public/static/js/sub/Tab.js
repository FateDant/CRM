// 选项卡组件
function Tab(args) {
	try {
		if (!args.renderTo)
			throw "renderTo元素不存在，请检查ID是否存在";
		if (args.onClick && !$.isFunction(args.onClick))
			throw "onClick属性必须是方法,现在是" + typeof args.onClick;
		if (args.onComplete && !$.isFunction(args.onComplete))
			throw "onComplete属性必须是方法，现在是" + typeof args.onComplete;
		if (!args.dataSource)
			throw "缺失必要参数";
	} catch (e) {
		alert("下拉列表初始化失败，原因：" + e);
		return;
	}
	// 初始化选项卡参数
	this.init(args);
}
;
// 初始化选项卡参数
Tab.prototype.init = function(args) {
	this.renderTo = $("#" + args.renderTo);
	this.dataSource = args.dataSource;
	this.moveSize = args.moveSize;
	// 组件加载完成点击
	this.onClick = args.onClick === undefined ? function() {
	} : args.onClick;
	// 组件加载完成回调
	this.onComplete = args.onComplete === undefined ? function() {
	} : args.onComplete;
	// 映射生成元素
	this.mapping = args.mapping ? args.mapping : {
		key : "key",
		value : "value"
	};
	this.getDataByDatasource();
};
// 根据传入的数据源获取数据
Tab.prototype.getDataByDatasource = function() {
	var t = this;
	if (typeof this.dataSource == "string") {
		$.post(this.dataSource, this.postData, function(res) {
			t.dataSource = res;
			if (t.dataSource.rows == null) {
				alert("表格生成失败，原因：表格JSON必须包含rows属性。");
				return;
			}
			// 生成元素
			t.build();
		});
	} else
		// 生成元素
		this.build();
	// 如果数据源是字符串，默认是url地址
};
// 生成元素
Tab.prototype.build = function() {
	this.renderTo.addClass("tab");
	this.titleList = $("<ul class='titleList'></ul>").appendTo(this.renderTo);
	this.contentList = $("<ul class='contentList'></ul>").appendTo(this.renderTo);
	this.titleHoverBG = $("<div class='titleHoverBG hidden'></div>").appendTo(this.renderTo);
	this.titleSelectedBG = $("<div class='titleSelectedBG'></div>").appendTo(this.renderTo);
	var t = this;
	$(this.dataSource).each(function() {
		$("<li class='titleItem' key='" + this[t.mapping.key] + "'>" + this[t.mapping.value] + "</li>").appendTo(t.titleList);
		$("<li class='contentItem' key='" + this[t.mapping.key] + "'>" + this[t.mapping.value] + "</li>").appendTo(t.contentList);
		
	});
	// 注册事件
	this.eventBind();
};
// 注册事件
Tab.prototype.eventBind = function() {
	var t = this;
	// 鼠标移入选项卡区域时显示hover背景
	this.renderTo.hover(function() {
		// 鼠标移入
		t.titleHoverBG.removeClass("hidden");
	}, function() {
		// 鼠标移出
		t.titleHoverBG.addClass("hidden");
	});
	$(".titleItem", this.renderTo).click(function() {
		t.select(this);
	}).mouseenter(function() {// 鼠标进入选项卡
		if (util.isLTIE10())
			t.titleHoverBG.animate({
				left : $(this).index() * t.moveSize + "%"
			});
		else
			t.titleHoverBG.css("left", $(this).index() * t.moveSize + "%");
	});
	// 组件加载完成
	this.select($("li:eq(0)"), this.titleList);
	this.onComplete();
};
// 设置选项卡选中项
Tab.prototype.select = function(li) {
	//给当前对象添加选中样式
	$(".titleItemSelected").removeClass("titleItemSelected");
	$(li).addClass("titleItemSelected");
	if (util.isLTIE10())
		this.titleSelectedBG.animate({
			left : $(li).index() * this.moveSize + "%"
		});
	else{
		this.titleSelectedBG.css("left", $(li).index() * this.moveSize + "%");	
	}
		
	this.onClick(li);
};
