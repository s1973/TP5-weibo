<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:68:"E:\htdoc\ThinkPHP5\public/../application/admin\view\index\index.html";i:1507774752;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title>HDWeiBo 后台管理中心</title>
	<link rel="stylesheet" href="__STATIC__/Css/index.css" />
	<script type="text/javascript" src='__STATIC__/Js/jquery-1.8.2.min.js'></script>
	<script type="text/javascript" src='__STATIC__/Js/index.js'></script>
	<base target="iframe" />
</head>
<body>
	<div id="top">
		<div class='logo'></div>
		<div class='t_title'>后台管理中心</div>
		<div class='menu'>
			<ul>
				<li class='first first_cur'>
					<a href="<?php echo url('copy'); ?>"><span>首&nbsp;页</span></a>
				</li>
				<li class='next'>
					<a href="<?php echo url('User/index'); ?>"><span>用户管理</span></a>
				</li>
				<li>
					<a href="<?php echo url('Weibo/index'); ?>"><span>微博管理</span></a>
				</li>
				<li class='last'>
					<a href="<?php echo url('System/index'); ?>"><span>系统设置</span><div></div></a>
				</li>
			</ul>
			<div id='user'>
				<span class='user_state'>当前管理员：[<span><?php echo \think\Session::get('username'); ?></span>]</span>
				<a href="<?php echo url('loginOut'); ?>" target='_self' id='login_out'></a>
			</div>
		</div>
	</div>
	<div id='left'>
		<div class='nav'>
			<div class="nav_u"><span class="pos down">用户管理</span></div>
		</div>
		<ul class='option'>
			<li><a href='<?php echo url("User/index"); ?>'>微博用户</a></li>
			<li><a href='<?php echo url("User/sechUser"); ?>'>微博用户检索</a></li>
			<li><a href='<?php echo url("User/admin"); ?>'>后台管理员</a></li>
			<?php if(session("?admin")): ?>
				<li><a href='<?php echo url("User/addAdmin"); ?>'>添加管理员</a></li>
			<?php endif; ?>
		</ul>

		<div class='nav'>
			<div class="nav_u"><span class="pos down">微博管理</span></div>
		</div>
		<ul class='option'>
			<li><a href='<?php echo url("Weibo/index"); ?>'>原作微博</a></li>
			<li><a href='<?php echo url("Weibo/turn"); ?>'>转发微博</a></li>
			<li><a href='<?php echo url("Weibo/sechWeibo"); ?>'>微博检索</a></li>
		</ul>
		<div class='nav'>
			<div class="nav_u"><span class="pos down">评论管理</span></div>
		</div>
		<ul class='option'>
			<li><a href='<?php echo url("Weibo/comment"); ?>'>评论列表</a></li>
			<li><a href='<?php echo url("Weibo/sechComment"); ?>'>评论检索</a></li>
		</ul>
		<div class='nav'>
			<div class="nav_u"><span class="pos down">系统设置</span></div>
		</div>
		<ul class='option'>
			<li><a href='<?php echo url("System/filter"); ?>'>关键字过滤</a></li>
			<li><a href='<?php echo url("System/index"); ?>'>网站设置</a></li>
			<li><a href='<?php echo url("User/editPwd"); ?>'>修改密码</a></li>
		</ul>
	</div>
	<div id="right">
		<iframe src="<?php echo url('copy'); ?>" frameborder="0" name='iframe'></iframe>
	</div>
</body>
</html>