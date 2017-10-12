<?php
namespace app\admin\controller;
use think\Controller;

/**
 * 后台登陆控制器
 */
class Login extends Controller {

	/**
	 * 登录页面视图
	 */
	Public function index() {
		return view();
	}

	/**
	 * 登录操作处理
	 */
	Public function login() {
		if (!request()->isPost()) {
			$this->error('页面不存在');
		}

		if (!input('?post.submit')) {
			return false;
		}

		//验证码对比
		if (!captcha_check(input('post.verify'))) {
			$this->error('验证码错误');
		}

		$name = input('post.uname');
		$pwd = md5(input('post.pwd'));
		$db = db('admin');
		$user = $db->where(array('username' => $name))->find();

		if (!$user || $user['password'] != $pwd) {
			$this->error('账号或密码错误');
		}

		if ($user['lock']) {
			$this->error('账号被锁定');
		}

		$data = array(
			'id' => $user['id'],
			'logintime' => time(),
			'loginip' => request()->ip(),
		);
		$db->update($data);

		session('uid', $user['id']);
		session('username', $user['username']);
		session('logintime', date('Y-m-d H:i', $user['logintime']));
		session('now', date('Y-m-d H:i', time()));
		session('loginip', $user['loginip']);
		session('admin', $user['admin']);
		$this->success('正在登录...', 'Index/index');
	}

}
?>