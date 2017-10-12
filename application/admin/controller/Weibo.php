<?php
namespace app\admin\controller;
use think\Db;

/**
 * 微博管理控制器
 */
class Weibo extends Common {

	/**
	 *  原作微博列表
	 * @return [type] [description]
	 */
	Public function index() {

		$where = array('isturn' => 0);
		$count = db('weibo')->where($where)->count();

		$weibo_view = DB::view('weibo', ['id', 'content', 'isturn', 'time', 'turn', 'keep', 'comment'])
			->view('picture', ['max' => 'pic'], 'weibo.id= picture.wid', 'LEFT')
			->view('userinfo', ['uid', 'username'], 'weibo.uid=userinfo.uid', 'LEFT');
		$weibo = $weibo_view->where($where)->order('time DESC')->paginate(20, $count);

		return view('', ['weibo' => $weibo, 'page' => $weibo->render()]);
	}

	/**
	 * 删除微博
	 */
	Public function delWeibo() {
		$id = intval(input('id'));
		$uid = intval(input('uid'));

		//删除微博
		if (model('Weibo')->relaDelete($id)) {

			//用户发布微博数-1
			db('userinfo')->where(array('uid' => $uid))->setDec('weibo');
			$this->success('删除成功', url('index'));
		} else {
			$this->error('删除失败，请重试...');
		}
	}

	/**
	 * 转发微博列表
	 */
	Public function turn() {

		$where = array('isturn' => array('GT', 0));
		$count = db('weibo')->where($where)->count();

		$weibo_view = DB::view('weibo', ['id', 'content', 'isturn', 'time', 'turn', 'keep', 'comment'])
			->view('userinfo', ['uid', 'username'], 'weibo.uid=userinfo.uid', 'LEFT');
		$turn = $weibo_view->where($where)->order('time DESC')->paginate(20, $count);

		return view('', ['turn' => $turn, 'page' => $turn->render()]);
	}

	/**
	 * 微博检索
	 */
	Public function sechWeibo() {
		$weibo = null;
		if (isset($_GET['sech'])) {
			$where = array('content' => array('LIKE', '%' . input('get.sech') . '%'));
			$weibo = DB::view('weibo', ['id', 'content', 'isturn', 'time', 'turn', 'keep', 'comment'])
				->view('picture', ['max' => 'pic'], 'weibo.id= picture.wid', 'LEFT')
				->view('userinfo', ['uid', 'username'], 'weibo.uid=userinfo.uid', 'LEFT')
				->where($where)->order('time DESC')->select();

			$weibo = $weibo ? $weibo : false;
		}
		return view('', ['weibo' => $weibo]);
	}

	/**
	 * 评论列表
	 */
	Public function comment() {

		$count = db('comment')->count();

		$comment_view = DB::view('comment', ['id', 'content', 'time', 'wid'])
			->view('userinfo', 'username', 'comment.uid=userinfo.uid', 'LEFT');
		$comment = $comment_view->order('time DESC')->paginate(20, $count);

		return view('', ['comment' => $comment, 'page' => $comment->render()]);
	}

	/**
	 * 删除评论
	 */
	Public function delComment() {
		$id = intval(input('id'));
		$wid = intval(input('wid'));

		if (db('comment')->delete($id)) {
			db('weibo')->where(array('id' => $wid))->setDec('comment');
			$this->success('删除成功', $_SERVER['HTTP_REFERER']);
		} else {
			$this->error('删除失败，请重试...');
		}
	}

	/**
	 * 评论检索
	 */
	Public function sechComment() {
		$comment = null;
		if (isset($_GET['sech'])) {
			$where = array('content' => array('LIKE', '%' . input('get.sech') . '%'));
			$comment = DB::view('comment', ['id', 'content', 'time', 'wid'])
				->view('userinfo', 'username', 'comment.uid=userinfo.uid', 'LEFT')
				->where($where)->order('time DESC')->select();
			$comment = $comment ? $comment : false;
		}
		return view('', ['comment' => $comment]);
	}

}
?>
