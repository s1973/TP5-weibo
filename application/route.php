<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;
Route::pattern(['id' => '\d+', 'uid' => '\d+']);
Route::rule('/:id', 'User/index');
Route::rule('/index/follow/:uid', 'User/followList?type=1');
Route::rule('/index/fans/:uid', 'User/followList?type=0');

return [
	'__pattern__' => [
		'name' => '\w+',
	],
	'[hello]' => [
		':id' => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
		':name' => ['index/hello', ['method' => 'post']],
	],

];
