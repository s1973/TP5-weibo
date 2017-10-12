<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:70:"E:\htdoc\ThinkPHP5\public/../application/admin\view\weibo\comment.html";i:1507795483;}*/ ?>
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
		<span>评论列表</span>
	</div>
	<table class="table">
		<tr>
			<th>ID</th>
			<th>评论内容</th>
			<th>评论用户</th>
			<th>评论时间</th>
			<th>操作</th>
		</tr>
		<?php if(is_array($comment) || $comment instanceof \think\Collection || $comment instanceof \think\Paginator): if( count($comment)==0 ) : echo "" ;else: foreach($comment as $key=>$v): ?>
			<tr>
				<td width='50' align='center'><?php echo $v['id']; ?></td>
				<td><?php echo $v['content']; ?></td>
				<td width='100'><?php echo $v['username']; ?></td>
				<td width='100' align='center'><?php echo date('y-m-d H:i', $v['time']); ?></td>
				<td width='60'>
					<a href="<?php echo url('delComment', array('id' => $v['id'], 'wid' => $v['wid'])); ?>" class='del'></a>
				</td>
			</tr>
		<?php endforeach; endif; else: echo "" ;endif; ?>
		<tr>
			<td colspan='5' align='center' height='60'><?php echo $page; ?></td>
		</tr>
	</table>
</body>
</html>