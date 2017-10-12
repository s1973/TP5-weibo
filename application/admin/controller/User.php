<?php
namespace app\admin\controller;
use think\Db;

/**
 * 用户管理控制器
 */
class User extends Common {

	/**
	 *  微博用户列表
	 */
	Public function index() {

		$count = db('user')->count();

		$user_view = DB::view('user', ['id', '`lock`', 'registime'])
			->view('userinfo', ['username', 'face50' => 'face', 'follow', 'fans', 'weibo'], 'user.id= userinfo.uid', 'LEFT');
		$user = $user_view->paginate(20, $count);

		return view('', ['user' => $user, 'page' => $user->render()]);
	}

	/**
	 * 锁定用户
	 */
	Public function lockUser() {
		$data = array(
			'id' => intval(input('get.id')),
			'lock' => intval(input('get.lock')),
		);

		$msg = $data['lock'] ? '锁定' : '解锁';
		if (db('user')->update($data)) {
			$this->success($msg . '成功', $_SERVER['HTTP_REFERER']);
		} else {
			$this->error($msg . '失败，请重试...');
		}
	}

	/**
	 * 微博用户检索
	 */
	Public function sechUser() {
		$user = null;
		if (input('?get.sech') && isset($_GET['type'])) {
			$where = $_GET['type'] ? array('id' => intval(input('get.sech'))) : array('username' => array('LIKE', '%' . input('get.sech') . '%'));

			$user = DB::view('user', ['id', '`lock`', 'registime'])
				->view('userinfo', ['username', 'face50' => 'face', 'follow', 'fans', 'weibo'], 'user.id= userinfo.uid', 'LEFT')
				->where($where)->select();
			$user = $user ? $user : false;
		}

		return view('', ['user' => $user]);
	}

	/**
	 * 后台管理员列表
	 */
	Public function admin() {
		$this->assign('admin', db('admin')->select());
		return $this->fetch();
	}

	/**
	 * 添加后台管理员
	 */
	Public function addAdmin() {
		return $this->fetch();
	}

	/**
	 * 锁定后台管理员
	 */
	Public function lockAdmin() {
		$data = array(
			'id' => intval(input('get.id')),
			'lock' => intval(input('get.lock')),
		);

		$msg = $data['lock'] ? '锁定' : '解锁';
		if (db('admin')->update($data)) {
			$this->success($msg . '成功', url('admin'));
		} else {
			$this->error($msg . '失败，请重试...');
		}
	}

	/**
	 * 删除后台管理员
	 */
	Public function delAdmin() {
		$id = intval(input('get.id'));

		if (db('admin')->delete($id)) {
			$this->success('删除成功', url('admin'));
		} else {
			$this->error('删除失败，请重试...');
		}
	}

	/**
	 * 执行添加管理员操作
	 */
	Public function runAddAdmin() {
		if ($_POST['pwd'] != $_POST['pwded']) {
			$this->error('两次密码不一致');
		}

		$data = array(
			'username' => input('post.username'),
			'password' => md5(input('post.pwd')),
			'logintime' => time(),
			'loginip' => request()->ip(),
			'admin' => intval(input('post.admin')),
		);

		if (db('admin')->data($data)->insert()) {
			$this->success('添加成功', url('admin'));
		} else {
			$this->error('添加失败，请重试...');
		}
	}

	/**
	 * 修改密码视图
	 */
	Public function editPwd() {
		return $this->fetch();
	}

	/**
	 * 修改密码操作
	 */
	Public function runEditPwd() {
		$db = db('admin');
		$old = $db->where(array('id' => session('uid')))->value('password');

		if ($old != md5($_POST['old'])) {
			$this->error('旧密码错误');
		}

		if ($_POST['pwd'] != $_POST['pwded']) {
			$this->error('两次密码不一致');
		}

		$data = array(
			'id' => session('uid'),
			'password' => md5(input('post.pwd')),
		);

		if ($db->update($data)) {
			$this->success('修改成功', url('Index/copy'));
		} else {
			$this->error('修改失败，请重试...');
		}
	}

}
?>