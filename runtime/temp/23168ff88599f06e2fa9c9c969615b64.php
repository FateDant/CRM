<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:45:"../application/admin/view/dialog/EditStu.html";i:1532921555;}*/ ?>
<!doctype html>
<html>
<head>
    <base href="<%=basePath%>">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>编辑学生</title>
    <link rel="stylesheet" href="/static/css/common/font-awesome.css" />
    <link rel="stylesheet" href="/static/css/common/jquery-ui.css" />
    <link rel="stylesheet" href="/static/css/common/Common.css" />
    <link rel="stylesheet" href="/static/css/sub/Tips.css" />
    <link rel="stylesheet" href="/static/css/sub/DropDownList.css" />
    <link rel="stylesheet" href="/static/css/dialog/AddStu.css" />
</head>
<body>
<span id="schoolId" class="hidden"><%=schoolId %></span>
<span id="userId" class="hidden"><%=userId %></span>
<div class="index-stuGrid-addstu-content">
    <div class="basicInfo">基本信息</div>
    <form action="updateStuAction" method="post">
        <table class="add-container" cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
                <td><label for="consult-time">咨询日期</label></td>
                <td><input type="text" id="consult-time" class="add-container-list"/><span class="errTips"></span></td>
                <td><label for="txtName" class="word-space">姓名</label></td>
                <td><input class="needErr" id="txtName" name="student_name" type="text" placeholder="请输入姓名" /><span class="errTips"></span></td>
                <td><label for="select-gender" class="word-space">性别</label></td>
                <!--<td><div id="select-gender" class="add-container-list"></div></td>-->
                <td>
                    <select name="gender">
                        <option value="1">男</option>
                        <option value="0">女</option>
                        <option value="2">保密</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="select-edu" class="word-space">学历</label></td>
                <!--<td><div id="select-edu" class="add-container-list"></div></td>-->
                <td>
                    <select name="education">
                        <option value="0">初中</option>
                        <option value="1">中专</option>
                        <option value="2">高中</option>
                        <option value="3">高职</option>
                        <option value="4">大专</option>
                        <option value="5">本科</option>
                        <option value="6">研究生</option>
                    </select>
                </td>
                <td><label for="select-stuState">目前状态</label></td>
                <!--<td><div id="select-stuState" class="add-container-list"></div></td>-->
                <td>
                    <select name="current_state">
                        <option value="0">在读学校</option>
                        <option value="1">在读离校</option>
                        <option value="2">待业</option>
                        <option value="3">在职</option>
                        <option value="4">自由职业</option>
                    </select>
                </td>
                <td><label for="wechat" class="word-space">微信</label></td>
                <td><input class="needErr" id="wechat" name="wechat" type="text" /><span class="errTips"></span></td>
            </tr>
            <tr>
                <td><label for="txtMobile">联系电话</label></td>
                <td><input class="needErr" id="txtMobile" name="mobile" type="text" placeholder="请输入电话" maxlength="11" validate="n" autocomplete="off" /><span class="errTips"></span></td>
                <td><label for="location" class="word-space">省市</label></td>
                <td><input id="location" name="location" type="text"/></td>
                <td><label for="qq" class="word-space">QQ</label></td>
                <td><input class="needErr" id="qq" name="qq" type="text"/><span class="errTips"></span></td>
            </tr>
            <tr>
                <td><label for="infoSource">信息来源</label></td>
                <!--<td><div id="infoSource" class="add-container-list"></div></td>-->
                <td>
                    <select name="channel_id">
                        <option value="1">百度</option>
                        <option value="2">360</option>
                        <option value="3">搜狗</option>
                        <option value="4">58同城</option>
                        <option value="6">赶集网</option>
                    </select>
                </td>
                <td><label for="select-online">在线咨询</label></td>
                <!--<td><div id="select-online" class="add-container-list"></div></td>-->
                <td>
                    <select name="online_consultant_id">
                        <option value="5">zzz</option>
                        <option value="6">ldh</option>
                    </select>
                </td>
                <td><label for="select-courseCon">课程顾问</label></td>
                <td>
                    <select name="course_consultant_id">
                        <option value="2">fate</option>
                        <option value="4">zhangqiuyang</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="first-vist-time">上门时间</label></td>
                <td><input type="text" name="first_visit_time" id="first-vist-time" class="add-container-list"/><span class="errTips"></span></td>
                <td><label for="register-time">报名时间</label></td>
                <td><input type="text" name="register_time" id="register-time" class="add-container-list"/><span class="errTips"></span></td>
                <td><label for="select-course">报名课程</label></td>
                <td>
                    <select name="course_id">
                        <option value="1">电子竞技运动与管理专业</option>
                        <option value="2">电竞视频剪辑与合成专业</option>
                        <option value="3">电子竞技主播与解说专业</option>
                        <option value="4">电子竞技运动训练营</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="register-amount">报名金额</label></td>
                <td><input class="needErr" name="register_amount" id="register-amount" type="text" /><span class="errTips"></span></td>
                <td><label for="visit-state">访问状态</label></td>
                <!--<td><div id="visit-state" class="add-container-list"></div></td>-->
                <td>
                    <select name="visit_state">
                        <option value="0">未上门</option>
                        <option value="1">已上门</option>
                        <option value="2">已报名</option>
                    </select>
                </td>
                <td><label for=""></label></td>
                <td></td>
            </tr>
            </tbody>
        </table>
        <div class="submit">
            <input class="btnSave" type="submit" value="提交" />
            <!--<input id="btnSave" class="btnSave" type="button" value="提交" />-->
        </div>
    </form>
</div>
<script src="/static/js/common/jquery-1.12.0.js" type="text/javascript"></script>
<script src="/static/js/common/jquery-ui.min.js" type="text/javascript"></script>
<script src="/static/js/common/util.js" type="text/javascript"></script>
<script src="/static/js/sub/DropDownList.js" type="text/javascript"></script>
<script src="/static/js/sub/Tips.js" type="text/javascript"></script>
<script src="/static/js/dialog/AddStu.js"></script>
</body>
</html>