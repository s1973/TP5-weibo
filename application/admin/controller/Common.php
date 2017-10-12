<?php
namespace app\admin\controller;
/**
 * 公共控制器 是否登陆
 */
class Common extends \think\Controller {

	/**
	 * 判断用户是否已登录
	 */
	Public function _initialize() {
		if (!session('?uid') || !session('?username')) {
			$this->redirect(url('Login/index'));
		}
	}
}
?>