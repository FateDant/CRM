var dataGrid;
var SLTSCHOOL;
var SLTONLINE;
$(function() {
	// 时间组件
	$("#startDate").datepicker();
	$("#endDate").datepicker();
	// 全查询
	$("#btnSearch").click(function() {
		// 加载表格
		loadGrid();
	});
	// 编辑
	$("#btnEdit").click(function() {
		// 如果当前按钮被禁用
		if ($(this).hasClass("btnDisable"))
			return;// 退出点击事件
		var editObj = {};
		// 编辑选中行中的每一个td
		$("#myTableData .gridSelected>td").each(function(i, t) {
			var alias = $(t).attr("alias");
			editObj[alias] = $(t).attr("originalvalue");
		});
		// 在顶层框架上设置一个变量存放选中行的数据
		top.editObj = editObj;
		// 显示弹出层
		top.topDialog.show({
			title : "编辑学生信息",
			width : 900,
			height : 618,
			url : "jsp/dialog/AddStu.jsp"
		});

	});
//	生成校区下拉列表
	SLTSCHOOL =new DropDownList({
		renderTo : "select-school",
		dataSource : "getSchool.action",
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
//	生成渠道下拉列表
	SLTSCHOOL =new DropDownList({
		renderTo : "select-channel",
		dataSource : "getChannel.action",
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
			if (top.editObj != null)
				fillText();
		}
	});
//	生成在线咨询师下拉列表
	SLTONLINE =new DropDownList({
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
		onClick : function() {
			var userType = $("#select-online .ddlItemSelected").attr("key");
			userType == "-1" ? $("#select-online").addClass("btnError") : $("#select-online").removeClass("btnError");
		},
		onComplete : function() {
			if (top.editObj != null)
				fillText();
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
			value : "请选择"
		} ],
		onComplete : function() {
			// 加载表格
			loadGrid();
		}
	});
	//学生目前状态
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
			value : "选择状态"
		} ]
	});
	//生成学员意向下拉列表
	new DropDownList({
		renderTo : "select-stuAtt",
		dataSource : [ {
			key : "1",
			value : "非常有意向"
		}, {
			key : "2",
			value : "一般有意向"
		}, {
			key : "3",
			value : "意向不明"
		}, {
			key : "4",
			value : "无意向"
		} ],
		defaultSelected : "-1",
		preloadItem : [ {
			key : "-1",
			value : "未选择"
		} ]
	});
//	生成课程顾问下拉列表
	SLTCONSULTANT =new DropDownList({
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
		onClick : function() {
			var userType = $("#select-courseCon .ddlItemSelected").attr("key");
			userType == "-1" ? $("#select-courseCon").addClass("btnError") : $("#select-courseCon").removeClass("btnError");
		},
		onComplete : function() {
			if (top.editObj != null)
				fillText();
		}
	});

});
function loadGrid() {
	// 禁用编辑按钮
	$("#btnEdit").addClass("btnDisable");
	// 拼接查询条件
	var condition = "WHERE ";
	
	//咨询日期
	var sDate = $("#startDate").val();
	var dsDate = sDate.substring(6, 10) + "-" + sDate.substring(0, 2) + "-" + sDate.substring(3, 5);
	var eDate = $("#endDate").val();
	var deDate = eDate.substring(6, 10) + "-" + eDate.substring(0, 2) + "-" + eDate.substring(3, 5);
	if (sDate != "" && eDate != "")
		condition += "T2.CREATE_TIME BETWEEN '" + dsDate + " 00:00:00.0' AND '" + deDate + " 23:59:59.0' AND ";
	condition += "1=1";
	studentGrid = new Grid({
		renderTo : "myTableData",
		columns : [ {
			name : "序号",
			alias : "student_id",
			hide : true
		}, {
			name : "咨询日期",
			alias : "consult_time",
			align : "center",
		}, {
			name : "学员姓名",
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
			name : "录入人id",
			alias : "create_id",
			hide : true
		},{
			name : "录入人",
			alias : "create_name"
		}, {
			name : "在线咨询师id",
			alias : "online_consultant_id",
			hide:true
		},  {
			name : "在线咨询师",
			alias : "online_name"
		},{
			name : "课程顾问id",
			alias : "course_consultant_id",
			hide:true
		},{
			name : "课程顾问",
			alias : "consultant_name"
		},  {
			name : "上门时间",
			alias : "first_visit_time"
		}, {
			name : "报名时间",
			alias : "register_time"
		}, {
			name : "报名课程id",
			alias : "course_id",
			hide:true
		},{
			name : "报名课程",
			alias : "course_name"
		},  {
			name : "费用",
			alias : "register_amount"
		}, {
			name : "学员状态",
			alias : "visit_state"
		},{
			name : "学员意向",
			alias : "will_state",
			align : "center"
		},   {
			name : "创建时间",
			alias : "create_time",
			align : "center"
		}, {
			name : "备注",
			alias : "des"
		} ],
		dataSource : "getStudentsByPage.action",
		postData : {
			condition : condition
		},
		onRowClick : function(row) {
			// 获取表格中的选中行
			var row = $("#myTableData .gridSelected");
			// 如果表中有行被选中
			if (row.length > 0)
				// 删除禁用按钮样式
				$(".btnDisable").removeClass("btnDisable");
			else
				// 给编辑和删除按钮加上禁用样式
				$("#btnEdit,#btnDel").addClass("btnDisable");
		}
	});
}
