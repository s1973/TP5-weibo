<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:71:"E:\htdoc\ThinkPHP5\public/../application/index\view\login\register.html";i:1506477080;}*/ ?>
<!DOCTYPE html STATIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title><?php echo \think\Config::get('system.WEBNAME'); ?>-注册</title>
	<link rel="stylesheet" href="__STATIC__/Css/regis.css" />
	<script type="text/javascript" src="__STATIC__/Js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="__STATIC__/Js/jquery-validate.js"></script>
	<script type='text/javascript'>
		var checkAccount = "<?php echo url('checkAccount'); ?>";
		var checkUname = "<?php echo url('checkUname'); ?>";
		var checkVerify = "<?php echo url('checkVerify'); ?>";
	</script>
	<script type="text/javascript" src="__STATIC__/Js/register.js"></script>
</head>
<body>
	<div id='logo'></div>
	<div id='reg-wrap'>
		<form action="<?php echo url('runRegis'); ?>" method='post' name='register'>
			<fieldset>
				<legend>用户注册</legend>
				<p>
					<label for="account">登录账号：</label>
					<input type="text" name='account' id='account' class='input'/>
				</p>
				<p>
					<label for="pwd">登录密码：</label>
					<input type="password" name='pwd' id='pwd' class='input'/>
				</p>
				<p>
					<label for="pwded">确认密码：</label>
					<input type="password" name='pwded' class='input'/>
				</p>
				<p>
					<label for="uname">昵称：</label>
					<input type="text"  name='uname' id='uname' class='input'/>
				</p>
				<p>
					<label for="verify">验证码：</label>
					<input type="text" name='verify' class='input' id='verify'/>
					<img src="<?php echo captcha_src(); ?>" width='100' height='30' id='verify-img'/>
				</p>
				<p class='run'>
					<input type="submit" value='马上注册' id='regis'/>
				</p>
			</fieldset>
		</form>
	</div>
</body>
</html>