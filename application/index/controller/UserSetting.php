<?php
namespace app\index\controller;

use think\Controller;

class UserSetting extends Common {

	Public function index() {
		$where = array('uid' => session('uid'));
		$field = array('username', 'truename', 'sex', 'location', 'constellation', 'intro', 'face180');
		$user = db('userinfo')->field($field)->where($where)->find();
		return view('index', ['user' => $user]);
	}

	/**
	 * 修改用户基本信息
	 */
	Public function editBasic() {
		if (!request()->isPost()) {
			$this->error('页面不存在');
		}
		header('Content-Type:text/html;Charset=UTF-8');
		$data = array(
			'username' => input('post.nickname'),
			'truename' => input('post.truename'),
			'sex' => ((int) $_POST['sex'] == 1) ? '男' : '女',
			'location' => input('post.province') . ' ' . input('post.city'),
			'constellation' => input('post.night'),
			'intro' => input('post.intro'),
		);
		$where = array('uid' => session('uid'));
		if (db('userinfo')->where($where)->update($data)) {
			$this->success('修改成功', url('index'));
		} else {
			$this->error('修改失败');
		}
	}

	/**
	 * 修改用户头像
	 */
	Public function editFace() {
		if (!request()->isPost()) {
			$this->error('页面不存在');
		}
		$db = db('userinfo');
		$where = array('uid' => session('uid'));
		$field = array('face50', 'face80', 'face180');
		$old = $db->where($where)->field($field)->find();
		if ($db->where($where)->update($_POST)) {
			if (!empty($old['face180'])) {
				@unlink('./Uploads/Face/' . $old['face180']);
				@unlink('./Uploads/Face/' . $old['face80']);
				@unlink('./Uploads/Face/' . $old['face50']);
			}
			$this->success('修改成功', url('index'));
		} else {
			$this->error('修改失败，请重试...');
		}
	}

	/**
	 * 修改密码
	 */
	Public function editPwd() {
		if (!request()->isPost()) {
			$this->error('页面不存在');
		}

		$db = db('user');
		//验证旧密码
		$where = array('id' => session('uid'));
		$old = $db->where($where)->value('password');

		if (md5(input('post.old')) != $old) {
			$this->error('旧密码错误');
		}

		if (input('post.new') != input('post.newed')) {
			$this->error('两次密码不一致');
		}

		$newPwd = md5(input('post.new'));
		$data = array(
			'id' => session('uid'),
			'password' => $newPwd,
		);

		if ($db->update($data)) {
			$this->success('修改成功', url('index'));
		} else {
			$this->error('修改失败，请重试...');
		}
	}

}

?>