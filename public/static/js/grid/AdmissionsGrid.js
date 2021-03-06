var studentGrid;
var editObj = {};
var STUID;
var callbackGrid;
$(function() {
	// 时间组件
	$("#startDate").datepicker();
	$("#endDate").datepicker();

	// 添加
	$("#btnAdd").click(function() {
		// 显示弹出层
		top.topDialog.show({
			title : "学员数据添加",
			width : 1100,
			height : 618,
			url : "./CollegeGrid/addStu"
		});
	});

	// 编辑
	$("#btnEdit").click(function() {
		// 如果当前按钮被禁用
		if ($(this).hasClass("btnDisable"))
			return;// 退出点击事件

		// 编辑选中行中的每一个td
		$("#myTableAdmissions .gridSelected>td").each(function(i, t) {
			var alias = $(t).attr("alias");
			editObj[alias] = $(t).attr("originalvalue");
		});
		// 在顶层框架上设置一个变量存放选中行的数据
		top.editObj = editObj;
		// 显示弹出层
		top.topDialog.show({
			title : "编辑学生信息",
			width : 1100,
			height : 618,
			url : "./CollegeGrid/addStu"
		});
	});
	// 添加回访记录
	$("#btnAddRecord").click(function() {
		// 如果当前按钮被禁用
		if ($(this).hasClass("btnDisable"))
			return;// 退出点击事件
		var editObj = {};
		// 编辑选中行中的每一个td
		$("#myTableAdmissions .gridSelected>td").each(function(i, t) {
			var alias = $(t).attr("alias");
			editObj[alias] = $(t).attr("originalvalue");
		});
		// 在顶层框架上设置一个变量存放选中行的数据
		top.editObj = editObj;
		// 显示弹出层
		top.topDialog.show({
			title : "添加回访记录",
			width : 900,
			height : 618,
			url : "./CollegeGrid/callBack"
		});
	});
	// 生成校区下拉列表
	new DropDownList({
		renderTo : "select-school",
		dataSource : "schoolList",
		mapping : {
			key : "school_id",
			value : "school_name"
		},
		preloadItem : [ {
			school_id : "-1",
			school_name : "请选择校区"
		} ],
		onClick : function() {
            var schoolsType = $("#selectSchool .ddlItemSelected").attr("key");
            schoolsType == "-1" ? $("#selectSchool").addClass("btnError") : $("#selectSchool").removeClass("btnError");
        },
		onComplete : function() {
            if (top.editObj != null)
                fillText();
		}
	});
	// 生成渠道下拉列表
	new DropDownList({
		renderTo : "select-channel",
		dataSource : "channelData?id="+window.parent.SCHOOLID,
		mapping : {
			key : "channel_id",
			value : "channel_name"
		},
		preloadItem : [ {
			channel_id : "-1",
			channel_name : "请选择渠道"
		} ],
		onClick : function() {
			var channelsType = $("#select-channel .ddlItemSelected").attr("key");
			channelsType == "-1" ? $("#select-channel").addClass("btnError") : $("#select-channel").removeClass("btnError");
		},
		onComplete : function() {
			/*
			 * if (top.editObj != null) fillText();
			 */
		}
	});
	// 生成在线咨询师下拉列表
	new DropDownList({
		renderTo : "select-online",
		dataSource : "onlineConsultantData?id="+window.parent.SCHOOLID,
		mapping : {
			key : "user_id",
			value : "user_name"
		},
		preloadItem : [ {
			user_id : "-1",
			user_name : "未选择"
		} ],
		onClick : function() {
			var userType = $("#select-online .ddlItemSelected").attr("key");
			userType == "-1" ? $("#select-online").addClass("btnError") : $("#select-online").removeClass("btnError");
		},
		onComplete : function() {
			/*
			 * if (top.editObj != null) fillText();
			 */
		}
	});
	// 生成学历下拉列表
	new DropDownList({
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
			value : "未选择"
		} ],
		onComplete : function() {
		}
	});
	// 生成学生目前状态下拉列表
	new DropDownList({
		renderTo : "select-stuState",
		dataSource : [ {
			key : "1",
			value : "在读学校"
		}, {
			key : "2",
			value : "在读离校"
		}, {
			key : "3",
			value : "待业"
		}, {
			key : "4",
			value : "在职"
		}, {
			key : "5",
			value : "自由职业"
		} ],
		defaultSelected : "-1",
		preloadItem : [ {
			key : "-1",
			value : "未选择"
		} ]
	});
	// 生成意向下拉列表
	new DropDownList({
		renderTo : "select-stuAtt",
		dataSource : [ {
			key : "1",
			value : "已上门"
		}, {
			key : "2",
			value : "未上门"
		}, {
			key : "3",
			value : "已报名"
		} ],
		defaultSelected : "-1",
		preloadItem : [ {
			key : "-1",
			value : "未选择"
		} ],
		onComplete : function() {

		}
	});

	// 生成课程顾问下拉列表
	new DropDownList({
		renderTo : "select-courseCon",
		dataSource : "courseConsultantData?id="+window.parent.SCHOOLID,
		mapping : {
			key : "user_id",
			value : "user_name"
		},
		preloadItem : [ {
			user_id : "-1",
			user_name : "未选择"
		} ],
		onClick : function() {
			var userType = $("#select-courseCon .ddlItemSelected").attr("key");
			userType == "-1" ? $("#select-courseCon").addClass("btnError") : $("#select-courseCon").removeClass("btnError");
		},
		onComplete : function() {
			if (top.editObj != null)
				fillText();
			loadGrid();

		}
	});
	// 全查询
	$("#btnSearch").click(function() {
		// 加载表格
		loadGrid();
	});
	// 重置功能
	$("#btnReset").click(function() {
		$("#txtStu").val("");
		$("#txtMobile").val("");
		$("#startDate").val("");
		$("#endDate").val("");
		// 下拉列表重置
		resize("select-school");
		resize("select-channel");
		resize("select-online");
		resize("select-edu");
		resize("select-stuState");
		resize("select-stuAtt");
		resize("select-courseCon");
	});
});

// 重置功能 不能广泛使用
function resize(obj) {
	$("#" + obj + " .ddlItem").removeClass("ddlItemSelected");
	$("#" + obj + " .ddlItem[key=-1]").addClass("ddlItemSelected");
	$("#" + obj + " .ddlTxt").text($("#" + obj + " .ddlItem[key=-1]").text());
}
function loadGrid() {
	// 禁用添加和编辑按钮
	$("#btnEdit,#btnAddRecord").addClass("btnDisable");
	// 拼接查询条件
	var conditionInfo = "&&";
	// 校区
	var txtSchool = $("#select-school .ddlItemSelected").attr("key");
	// 此处兼容其他几种招生渠道
	if (txtSchool != "-1" && txtSchool != undefined)
        conditionInfo += "school_id=" + txtSchool + "&&";
	// 学生姓名
	var txtStu = $("#txtStu").val();
	// 此处兼容数据搜索表内内容
	if (txtStu != "" && txtStu != undefined)
        conditionInfo += "student_name=" + txtStu + "&&";
	// 渠道
	var txtChannel = $("#select-channel .ddlItemSelected").attr("key");
	if (txtChannel != "-1" && txtChannel != undefined) {
        conditionInfo += "channel_id=" + txtChannel + "&&";
	}
	// 学生电话
	var txtMobile = $("#txtMobile").val();
	if (txtMobile != "")
        conditionInfo += "mobile=" + txtMobile + "&&";
	// 在线咨询师
	var txtOnline = $("#select-online .ddlItemSelected").attr("key");
	if (txtOnline != "-1" && txtOnline != undefined)
        conditionInfo += "online_consultant_id=" + txtOnline + "&&";
	// 学历
	var txtEdu = $("#select-edu .ddlItemSelected").attr("key");
	if (txtEdu != "-1")
        conditionInfo += "education=" + $("#select-edu .ddlItemSelected").text() + "&&";
	// 学员状态
	var txtState = $("#select-stuState .ddlItemSelected").attr("key");
	if (txtState != "-1")
        conditionInfo += "current_state=" + $("#select-stuState .ddlItemSelected").text() + "&&";
	// 学员意向
	var txtWill = $("#select-stuAtt .ddlItemSelected").attr("key");
	if (txtWill != "-1")
        conditionInfo	// 课程顾问
	var txtConsult = $("#select-courseCon .ddlItemSelected").attr("key");
	if (txtConsult != "-1" && txtConsult != undefined)
        conditionInfo += "course_consultant_id=" + txtConsult + "&&";
	// 咨询日期
	var sDate = $("#startDate").val();
	var eDate = $("#endDate").val();
	if (sDate != "" && eDate != "") {
        conditionInfo += "CONSULT_TIME BETWEEN '" + sDate + "' AND '" + eDate + "' &&";
	}
	// 判断是否是数据搜索或是其他几种渠道
	/*if (window.parent.LICONTENT != "数据搜索")
		condition += "T2.CHANNEL_CATEGORY='" + window.parent.LICONTENT + "' AND 1=1";
	else*/
	studentGrid = new Grid({
		renderTo : "myTableAdmissions",
		columns : [ {
			name : "序号",
			alias : "student_id",
			hide : true
		}, {
			name : "咨询日期",
			alias : "consult_time",
			align : "center",
		}, {
			name : "姓名",
			alias : "student_name",
			align : "center",
		}, {
			name : "学历",
			alias : "education"
		}, {
			name : "性别",
			alias : "gender"
		}, {
			name : "电话",
			alias : "mobile"
		}, {
			name : "渠道id",
			alias : "channel_id",
			hide : true
		}, {
			name : "渠道",
			alias : "channel_name"
		}, {
			name : "录入人id",
			alias : "create_id",
			hide : true
		}, {
			name : "录入人",
			alias : "create_name"
		}, {
			name : "在线咨询师id",
			alias : "online_consultant_id",
			hide : true
		}, {
			name : "在线咨询师",
			alias : "online_consultant_name"
		}, {
			name : "课程顾问id",
			alias : "course_consultant_id",
			hide : true
		}, {
			name : "课程顾问",
			alias : "course_consultant_name"
		}, {
			name : "上门时间",
			alias : "first_visit_time"
		}, {
			name : "报名时间",
			alias : "register_time"
		}, {
			name : "报名课程id",
			alias : "course_id",
			hide : true
		}, {
			name : "报名课程",
			alias : "course_name"
		}, {
			name : "费用",
			alias : "register_amount"
		}, {
			name : "学员状态",
			alias : "current_state"
		}, {
			name : "访问状态",
			alias : "visit_state",
			align : "center"
		}, {
			name : "创建时间",
			alias : "create_time",
			align : "center",
			hide : true
		}, {
			name : "备注",
			alias : "desc",
			hide : true
		}, {
			name : "目前现状",
			alias : "current_state",
			hide : true
		}, {
			name : "微信",
			alias : "wechat",
			hide : true
		}, {
			name : "QQ",
			alias : "qq",
			hide : true
		}, {
			name : "位置",
			alias : "location",
			hide : true
		} ],
		dataSource : "stuListData?id="+window.parent.SCHOOLID+conditionInfo,
		onRowClick : function(row) {
			// 获取表格中的选中行
			var row = $("#myTableAdmissions .gridSelected");
			// 如果表中有行被选中
			if (row.length > 0) {
				// 删除禁用按钮样式
				$(".btnDisable").removeClass("btnDisable");
				$("#myTableCallback").removeClass("hidden");
				/* 获取选中行学生id */
				STUID = $(".gridSelected .gridCell[alias='student_id']").text();
				loadCallback();
			} else {
				// 给编辑和删除按钮加上禁用样式
				$("#btnEdit,#btnAddRecord").addClass("btnDisable");
				$("#myTableCallback").addClass("hidden");
			}
		}
	});
}

function loadCallback() {
	/*var condition = "WHERE ";

	condition += "STU_ID=" + STUID + " AND 1=1";*/
	callbackGrid = new Grid({
		renderTo : "myTableCallback",
		columns : [ {
			name : "学生id",
			alias : "student_id",
			hide : true
		}, {
			name : "咨询日期",
			alias : "visit_time"
		}, {
			name : "回访方式",
			alias : "visit_way"
		}, {
			name : "学生意愿",
			alias : "will_state"
		}, {
			name : "用户id",
			alias : "call_userid",
			hide : true
		}, {
			name : "用户姓名",
			alias : "call_username"
		}, {
			name : "回访记录",
			alias : "log_detail"
		} ],
		dataSource : "selectRevisitData?student_id="+STUID


	});
}
