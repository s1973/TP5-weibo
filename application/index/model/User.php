<?php
namespace app\index\model;
use think\model\Merge;

/**
 *
 */
class User extends Merge {
	// 设置主表名
	Protected $table = 'hd_user';
	//定义用户与用户信处表关联关系属性
	Protected $relationModel = array('userinfo');
	// 定义关联外键
	protected $fk = 'uid';
	protected $mapFields = [
		// 为混淆字段定义映射
		'id' => 'User.id',
		'userinfo_id' => 'userinfo.id',
	];

}

?>