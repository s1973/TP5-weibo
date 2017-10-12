<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:70:"E:\htdoc\ThinkPHP5\public/../application/admin\view\system\filter.html";i:1507773210;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>微博用户列表</title>
	<link rel="stylesheet" href="__STATIC__/Css/common.css" />
	<script type="text/javascript" src='__STATIC__/Js/jquery-1.8.2.min.js'></script>
	<script type="text/javascript" src='__STATIC__/Js/common.js'></script>
</head>
<body>
	<div class='status'>
		<span>设置非法关键字</span>
	</div>
	<form action="<?php echo url('runEditFilter'); ?>" method='post'>
		<table class="table">
			<tr>
				<td width='300' align='right'>需要过滤的关键字（每个关键词之间用'|'分隔）：</td>
				<td>
					<textarea name="filter" cols="100" rows="10"><?php echo $filter; ?></textarea>
				</td>
			</tr>
			<tr>
				<td colspan='2'>
					<input type="submit" value='保存修改' class='big-btn'/>
				</td>
			</tr>
		</table>
	</form>
</body>
</html>