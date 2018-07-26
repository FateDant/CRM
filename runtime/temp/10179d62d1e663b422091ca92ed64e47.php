<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:95:"D:\ruanjian\wamp\wamp64\www\ThinkPHP\public/../application/index\view\user\register_action.html";i:1532401412;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>直尚电竞CRM管理系统</title>
<link rel="icon" href="/static/images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="/static/css/common/Common.css" />
<link href="/static/css/page/Login.css" rel="stylesheet">

</head>
<body>
	<div class="container">
		<div class="login">
			<div class="login-logo">
				<img src="/static/images/logo_header.png" alt="">
			</div>
			<div class="login-title">CRM管理平台</div>
			<form action="index.html" method="post">
			<div class="login-userName">
				<input id="txtUserName" type="text" name="name" placeholder="用户名" maxlength="20" minlen="3" validate="cenm_" autocomplete="off">
				<span class="errTips"></span>
				<div class="placeholder">用户名</div>
			</div>
			<div class="login-pwd">
				<input id="txtPassword" type="password" name="password" placeholder="密码" maxlength="20" minlen="6" validate="en" autocomplete="off">
				<span class="errTips"></span>
				<div class="placeholder">密码</div>
			</div>
			<div class="yzmContainer">
				<div class="yzm">
					<input id="chkRM" type="text" name="captcha" placeholder="验证码" class="yzm-word" maxlength="4" minlen="3" autocomplete="off">
					<span class="errTips"></span>
					<div class="placeholder">验证码</div>
				</div>
				<div class="yzm-img">
					<img src="<?php echo captcha_src(); ?>" id="captcha_img" alt="验证码" title="点击刷新" />
					<a id="kanbuq" href="javascript:captcha_refresh();">看不清，换一张</a>
				</div>
			</div>
			<div class="login-act">
				<!--<input type="button" id="btnLogin" class="btnLogin" onclick="btnLogin_onclick()" value="登录"/>-->
				<input id="login" type="button" class="btn btn-success radius size-L" value="&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;">
			</div>
			</form>
			<div class="forget">
				<a href="jsp/page/ForgetPwd.jsp" class="forget-word">忘记密码?</a>
			</div>
		</div>
	</div>

	<script src="/static/js/common/jquery-1.12.0.js" type="text/javascript"></script>
	<!--<script src="/static/js/common/util.js" type="text/javascript"></script>-->
	<!--<script src="/static/js/page/Login.js" type="text/javascript"></script>-->
	<script>
        $(function(){
            $('#login').on('click', function(){
                $.ajax({
                    type: 'POST',
                    url: "<?php echo url('checkLogin'); ?>",
                    data: $('form').serialize(),
                    dataType: 'json',
                    success: function(data){
                        if (data.status == 7) {
                            alert(data.message);
                            window.location.href="<?php echo url('admin\index'); ?>";
                        } else {
                            alert(data.message);
                        }
                    }
                });
            })
        })
	</script>
	<script>
        function captcha_refresh(){
            var str = Date.parse(new Date())/1000;
            $('#captcha_img').attr("src", "/captcha?id="+str);
        }
	</script>
</body>
</html>