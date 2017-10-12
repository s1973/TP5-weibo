<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;

/**
 * 后台首页控制器
 */
class Index extends Common {

	Public function index() {
		return view();
	}

	/**
	 * 后台信息页
	 */
	Public function copy() {
		$db = db('user');
		$user = $db->count();
		$lock = $db->where(array('lock' => 1))->count();
		$mysql_version = DB::query('select version() as `version`');
		$mysql_version = $mysql_version[0]['version'];

		$db = db('weibo');
		$weibo = $db->where(array('isturn' => 0))->count();
		$turn = $db->where(array('isturn' => array('GT', 0)))->count();
		$comment = db('comment')->count();

		return view('', ['user' => $user, 'lock' => $lock, 'weibo' => $weibo, 'turn' => $turn, 'comment' => $comment, 'mysql_version' => $mysql_version]);
	}

	/**
	 * 退出登录
	 */
	Public function loginOut() {
		session(null);
		$this->redirect('Login/index');
	}

}
?>