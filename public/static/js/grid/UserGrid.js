var userGrid;
var editObj = {};
$(function() {
	// 时间组件
	$("#startDate").datepicker();
	$("#endDate").datepicker();
	loadGrid();
	// 全查询
	$("#btnSearch").click(function() {
		// 加载表格
		loadGrid();
	});

	// 添加
	$("#btnAdd").click(function() {
		// 显示弹出层
		top.topDialog.show({
			title : "添加用户",
			width : 700,
			height : 668,
			url : "dialog/AddUser.html"
		});
	});

	// 删除
	$("#btnDel").click(
			function() {
				// 如果当前按钮被禁用
				if ($(this).hasClass("btnDisable"))
					return;// 退出点击事件
				// 选中行中要删除的用户id
				var user_id = $(".gridSelected>td[alias='user_id']").attr(
						"originalvalue");
				top.topDialog.show({
					width : 400,
					height : 300,
					confirm : true,
					title : "删除用户",
					text : "用户删除后无法恢复,请确认.",
					onClickYes : function() {
						$.post("delUser.action", {
							user_id : user_id
						}, function(res) {
							if (res.isSuccess == "true") {
								// 隐藏弹出层
								top.topDialog.hide();
								// 刷新表格
								userGrid.reload(1);
								top.topTips.show({
									txtTips : "删除成功",
									top : 0,
									classTips : "rightTips"
								});
							} else {
								top.topTips.show({
									txtTips : "删除失败" + res.errMsg,
									top : 0,
									classTips : "rightTips"
								});
							}
						});
					}
				});
			});

	// 编辑
	$("#btnEdit").click(function() {
		// 如果当前按钮被禁用
		if ($(this).hasClass("btnDisable"))
			return;// 退出点击事件
		
		// 编辑选中行中的每一个td
		$("#myTableUser .gridSelected>td").each(function(i, t) {
			var alias = $(t).attr("alias");
			editObj[alias] = $(t).attr("originalvalue");
		});
		// 在顶层框架上设置一个变量存放选中行的数据
		top.editObj = editObj;
		// 显示弹出层
		top.topDialog.show({
			title : "编辑用户",
			width : 700,
			height : 618,
			url : "dialog/AddUser.html"
		});

	});
	// 生成性别下拉列表
	new DropDownList({
		renderTo : "select-depart",
		dataSource : [ {
			key : "0",
			value : "财务部"
		}, {
			key : "1",
			value : "人力资源"
		}, {
			key : "2",
			value : "平台研发部"
		}, {
			key : "3",
			value : "运营中心"
		} ],
		defaultSelected : "-1",
		preloadItem : [ {
			key : "-1",
			value : "请选择"
		} ],
		onClick : function(t) {
			// alert(t.key); 此处k是键值对为key value的对象
			t.key == "-1" ? $("#select-depart").addClass("txtError") : $(
					"#select-depart").removeClass("txtError");
		},onComplete : function() {
			
		}
	});
	// 职位下拉列表
	new DropDownList({
		renderTo : "select-role",
		dataSource : "getRole.action",
		mapping : {
			key : "role_id",
			value : "role_name"
		},
		defaultSelected : "-1",
		preloadItem : [ {
			role_id : "-1",
			role_name : "选择职位"
		} ],
		onClick : function(t) {
			t.key == "-1" ? $("#select-role").addClass("txtError") : $(
					"#select-role").removeClass("txtError");
			$("#select-role").attr("key", t.key);
		},
		onComplete : function() {
			if (top.editObj != null)
				fillText();
		}
	});

});
function loadGrid() {
	// 禁用添加和编辑按钮
	$("#btnDel,#btnEdit").addClass("btnDisable");
	// 拼接查询条件
	var condition = "WHERE ";
	// 用户真实姓名
	var txtEmpName = $("#txtUser").val();
	if (txtEmpName != "")
		condition += "U.USER_NAME LIKE '%" + txtEmpName + "%' AND ";
	var txtMobile = $("#txtMobile").val();
	if (txtMobile != "")
		condition += "U.MOBILE LIKE '%" + txtMobile + "%' AND ";
	// 用户部门
	/*
	 * var selectEmp = $("#select-depart .ddlItemSelected").attr("key"); if
	 * (selectEmp != "-1") condition += "U.USER_EMP = '" + selectEmp + "' AND ";
	 */
	// 用户职位
	/*
	 * var selectRole = $("#select-role").val(); if (selectRole != "") condition +=
	 * "U.MAILBOX LIKE '%" + selectRole + "%' AND ";
	 */
	condition += "1=1";
	userGrid = new Grid({
		renderTo : "myTableUser",
		columns : [ {
			name : "用户编号",
			alias : "user_id",
			hide : true
		}, {
			name : "姓名",
			alias : "emp_name",
			align : "center",
		}, {
			name : "用户名",
			alias : "user_name",
			align : "center",
		}, {
			name : "密码",
			alias : "pwd"
		}, {
			name : "性别",
			alias : "gender",
			align : "center"
		}, {
			name : "电话",
			alias : "mobile"
		}, {
			name : "邮箱",
			alias : "email"
		}, {
			name : "创建时间",
			alias : "create_time",
			align : "center"
		}, {
			name : "职位id",
			alias : "role_id",
			hide : true
		}, {
			name : "职位",
			alias : "role_name",
			align : "center",
		}, {
			name : "备注",
			alias : "des"
		}, {
			name : "校区编号",
			alias : "school_id",
			hide : true
		}, {
			name : "校区名称",
			alias : "school_name",
			hide : true
		} ],
		dataSource : "getUserByPage.action",
		postData : {
			condition : condition
		},
		onRowClick : function(row) {
			// 获取表格中的选中行
			var row = $("#myTableUser .gridSelected");
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
