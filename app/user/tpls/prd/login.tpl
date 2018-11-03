<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{x2;c:SystemName}</title>

<link href="app/user/styles/css/main.css" rel="stylesheet" type="text/css" />

</head>
<body>


<div class="login">
    <div class="box png">
		<div class="logo png"></div>
		<div class="input">
			<div class="log">
			    <form class="col-xs-12" method="post" action="index.php?user-prd-login">
					<div class="name">
						<label>工　号</label><input type="text" class="text" id="value_1" placeholder="工 号" name="args[username]" tabindex="1">
					</div>
					<div class="pwd">
						<label>密　码</label><input type="password" class="text" id="value_2" placeholder="密码" name="args[userpassword]" tabindex="2">
						<input type="submit" class="submit" tabindex="3" value="登录">
						<div class="check"></div>
					</div>
					<input type="hidden" value="1" name="userlogin"/>
					{x2;if:$app['appsetting']['closeregist']}
					{x2;else}
					<a class="btn btn-default btn-block" href="index.php?user-app-register" style="height:44px;line-height:32px;font-size:16px;margin-top:10px;">注册</a>
					{x2;endif}
					
                    {x2;if:$app['appsetting']['emailverify']}
					<a class="btn btn-danger btn-block" href="index.php?user-app-register-findpassword" style="height:44px;line-height:32px;font-size:16px;margin-top:10px;">忘记密码</a>
                    {x2;endif}
				</form>
				<div class="tip"></div>
			</div>
		</div>
	</div>
    <div class="air-balloon ab-1 png"></div>
	<div class="air-balloon ab-2 png"></div>
    <div class="footer"></div>
</div>

<script type="text/javascript" src="app/user/styles/js/jQuery.js"></script>
<script type="text/javascript" src="app/user/styles/js/fun.base.js"></script>
<script type="text/javascript" src="app/user/styles/js/script.js"></script>


<!--[if IE 6]>
<script src="js/DD_belatedPNG.js" type="text/javascript"></script>
<script>DD_belatedPNG.fix('.png')</script>
<![endif]-->
<div style="text-align:center;margin:50px 0; font:normal 14px/24px 'MicroSoft YaHei';">
</div>
</body>
</html>