<?php
namespace app\index\controller;

class Login extends \think\Controller {
	/**
	 * 登录页面
	 */
	Public function index() {
		return view();
	}

	/**
	 * 登录表单处理
	 */
	public function login() {
		if (!request()->isPost()) {
			$this->error('页面不存在');
		}
		//提取表单内容
		$account = input('post.account');
		$pwd = md5(input('post.pwd'));

		$where = array('account' => $account);

		$user = db('user')->where($where)->find();

		if (!$user || $user['password'] != $pwd) {
			$this->error('用户名或者密码不正确');
		}

		if ($user['lock']) {
			$this->error('用户被锁定');
		}

		//处理下一次自动登录
		if (input('?auto')) {
			$account = $user['account'];
			$ip = request()->ip();
			$value = $account . '|' . $ip;
			$value = encryption($value);
			cookie('auto', $value, config('AUTO_LOGIN_TIME'), '/');
		}
		//登录成功写入SESSION并且跳转到首页
		session('uid', $user['id']);

		$this->redirect('Index/index');
	}

	/**
	 * 注册页面
	 */
	Public function register() {
		// if (!config('REGIS_ON')) {
		// 	$this->error('网站暂停注册', url('index'));
		// }
		return view();
	}

	/**
	 * 注册表单处理
	 */
	Public function runRegis() {
		if (!request()->isPost()) {
			$this->error('页面不存在');
		}
		// if (!captcha_check(input('post.verify'))) {
		// 	$this->error('验证码错误');
		// }
		if (input('post.pwd') != input('post.pwded')) {
			$this->error('两次密码不一致');
		}

		$user = model('User');

		//提取POST数据
		$user->data(array(
			'account' => input('post.account'),
			'password' => md5(input('post.pwd')),
			'registime' => $_SERVER['REQUEST_TIME'],
			'username' => input('post.uname'),

		));
		$user->save();
		$id = $user->id;
		if ($id) {
			//插入数据成功后把用户ID写SESSION
			session('uid', $id);

			//跳转至首页
			header('Content-Type:text/html;Charset=UTF-8');
			$this->success('注册成功，正在为您跳转...', 'index/index');
		} else {
			$this->error('注册失败，请重试...');
		}
	}
	/**
	 * 异步验证账号是否已存在
	 */
	Public function checkAccount() {
		if (!request()->isAjax()) {
			$this->error('页面不存在');
		}
		$account = input('post.account');
		$where = array('account' => $account);
		if (db('user')->where($where)->value('id')) {
			echo 'false';
		} else {
			echo 'true';
		}
	}

	/**
	 * 异步验证昵称是否已存在
	 */
	Public function checkUname() {
		if (!request()->isAjax()) {
			$this->error('页面不存在');
		}
		$username = input('post.uname');
		$where = array('username' => $username);
		if (db('userinfo')->where($where)->value('id')) {
			echo 'false';
		} else {
			echo 'true';
		}
	}

	/**
	 * 异步验证验证码
	 */
	Public function checkVerify() {
		if (!request()->isAjax()) {
			$this->error('页面不存在');
		}
		$verify = input('post.verify');
		if (!captcha_check($verify)) {
			echo 'false';
		} else {
			echo 'true';
		}
	}
}
