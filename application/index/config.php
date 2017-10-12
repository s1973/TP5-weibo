<?php
return array(

	'DEFAULT_THEME' => 'default', //默认主题模版

	'URL_MODEL' => 1,

	'TOKEN_ON' => false, //关闭令牌功能

	//用于异位或加密的KEY
	'ENCTYPTION_KEY' => 'www.houdunwang.com',
	//自动登录保存时间
	'AUTO_LOGIN_TIME' => time() + 3600 * 24 * 7, //一个星期

	//图片上传
	'UPLOAD_MAX_SIZE' => 2000000, //最大上传大小
	'UPLOAD_PATH' => ROOT_PATH . '/public/Uploads/', //文件上传保存路径
	'UPLOAD_EXTS' => array('jpg', 'jpeg', 'gif', 'png'), //允许上传文件的后缀

	//缓存设置
	// 'DATA_CACHE_SUBDIR' => true, //开启以哈唏形式生成缓存目录
	// 'DATA_PATH_LEVEL' => 2, //目录层次
	'DATA_CACHE_TYPE' => 'Memcache',
	'MEMCACHE_HOST' => '192.168.56.101',
	'MEMCACHE_PORT' => 11211,

);
?>