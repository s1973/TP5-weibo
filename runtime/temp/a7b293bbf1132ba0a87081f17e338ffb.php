<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:68:"E:\htdoc\ThinkPHP5\public/../application/admin\view\login\index.html";i:1507774044;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <title>HDWeiBo 后台登录</title>
    <link rel="stylesheet" href="__STATIC__/Css/login.css" />
    <link rel="stylesheet" href="__STATIC__/Js/JqueryUI/jquery-ui-1.9.2.min.css" />
    <script type="text/javascript" src='__STATIC__/Js/jquery-1.8.2.min.js'></script>
    <script type="text/javascript" src='__STATIC__/Js/JqueryUI/jquery-ui-1.9.2.min.js'></script>
    <script type="text/javascript" src='__STATIC__/Js/login.js'></script>
</head>
<body>
    <div id='top'>
        <a href='http://www.houdunwang.com' target='_blank'>
            <img src='__STATIC__/Images/blogo.png' width='270' height='52'/>
        </a>
        <a href='__ROOT__' class='home'>-微博首页-</a>
    </div>
    <div id='main'>
        <div id="login">
            <p class='user_logo'><b>登录</b></p>
            <div class='login_form'>
                <form action="<?php echo url('login'); ?>" method="post" name="login">
                    <p>
                        <label>用户名：</label>
                        <input type="text" name="uname" class='input-big'/>
                    </p>
                    <p>
                        <label>密码：</label>
                        <input type="password" name="pwd" class='input-big'/>
                    </p>
                    <p class='verify'>
                        <span>验证码：</span>
                        <input type="text" name="verify" class='input-medium'/>
                        <img width="80" height="25" src="<?php echo captcha_src(); ?>" id="getCode"/>
                    </p>
                    <p class='login_btn'>
                        <input type='submit' name='submit' value='' class='loginbg'/>
                    </p>
                </form>
            </div>
        </div>
    </div>
    <div id='dialog'></div>
</body>
</html>