<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

/**
 *  用户个人页控制器
 */
class User extends Common {
	/**
	 * 空操作
	 */
	Public function _empty($name) {
		$this->_getUrl($name);
	}

	/**
	 * 处理用户名空操作，获得用户ID 跳转至用户个人页
	 */
	Private function _getUrl($name) {
		$name = htmlspecialchars($name);
		$where = array('username' => $name);
		$uid = db('userinfo')->where($where)->value('uid');

		if (!$uid) {
			$this->redirect(url('Index/index'));
		} else {
			$this->redirect(url('/' . $uid));
		}
	}

	/**
	 * 用户个人页视图
	 */
	Public function index() {
		$id = intval(input('id'));

		//读取用户个人信息
		$where = array('uid' => $id);
		$userinfo = db('userinfo')->where($where)->field('truename,face50,face80,style', true)->find();

		if (!$userinfo) {
			header('Content-Type:text/html;Charset=UTF-8');
			$this->error('用户不存在，正在为您跳转至首页...', 'Index/index');
		}

		//统计分页
		$where = array('uid' => $id);
		$count = db('weibo')->where($where)->count();

		//读取用户发布的微博
		$weiboview = Db::view('weibo', 'id,content,isturn,time,turn,keep,comment,uid')
			->view('userinfo', array(
				'username', 'face50' => 'face',
			), 'weibo.uid = userinfo.uid', 'left')
			->view('picture', array('mini', 'medium', 'max'), 'weibo.id=picture.wid', 'left');
		$weibo = $weiboview->where($where)->order('time DESC')->paginate(5, $count);
		//重组结果集数组，得到转发微博
		if ($weibo->all()) {
			foreach ($weibo as $k => $v) {
				if ($v['isturn']) {
					$tmp = Db::view('weibo', 'id,content,isturn,time,turn,keep,comment,uid')
						->view('userinfo', array(
							'username', 'face50' => 'face',
						), 'weibo.uid = userinfo.uid', 'left')
						->view('picture', array('mini', 'medium', 'max'), 'weibo.id=picture.wid', 'left')
						->find($v['isturn']);
					$v['isturn'] = $tmp ? $tmp : -1;
					$weibo[$k] = $v;
				}
			}
		}

		//我的关注
		if (cache('follow_' . $id)) {
			//缓存已成功并且缓存未过期
			$follow = cache('follow_' . $id);
		} else {
			//生成缓存
			$where = array('fans' => $id);
			$follow = db('follow')->where($where)->field('follow')->select();
			foreach ($follow as $k => $v) {
				$follow[$k] = $v['follow'];
			}
			$where = array('uid' => array('IN', $follow));
			$field = array('username', 'face50' => 'face', 'uid');
			$follow = db('userinfo')->field($field)->where($where)->limit(8)->select();

			cache('follow_' . $id, $follow, 3600);
		}

		//我的粉丝
		if (cache('fans_' . $id)) {
			//缓存已成功并且缓存未过期
			$fans = cache('fans_' . $id);
		} else {
			//生成缓存
			$where = array('follow' => $id);
			$fans = db('follow')->where($where)->field('fans')->select();
			foreach ($fans as $k => $v) {
				$fans[$k] = $v['fans'];
			}
			$where = array('uid' => array('IN', $fans));
			$field = array('username', 'face50' => 'face', 'uid');
			$fans = db('userinfo')->field($field)->where($where)->limit(8)->select();

			cache('fans_' . $id, $fans, 3600);
		}

		return view('index', [
			'userinfo' => $userinfo,
			'weibo' => $weibo,
			'page' => $weibo->render(),
			'follow' => $follow,
			'fans' => $fans,
		]);
	}

	/**
	 * 用户关注与粉丝列表
	 */
	Public function followList() {

		$uid = intval(input('uid'));

		//区分关注 与 粉丝(1：关注，2：粉丝)
		$type = intval(input('type'));

		$db = db('follow');

		//根据type参数不同，读取用户关注与粉丝ID
		$where = $type ? array('fans' => $uid) : array('follow' => $uid);
		$field = $type ? 'follow' : 'fans';
		$count = $db->where($where)->count();

		$uids = $db->field($field)->where($where)->limit(0, 20)->select();

		if ($uids) {
			//把用户关注或者粉丝ID重组为一维数组
			foreach ($uids as $k => $v) {
				$uids[$k] = $type ? $v['follow'] : $v['fans'];
			}

			//提取用户个人信息
			$where = array('uid' => array('IN', $uids));
			$field = array('face50' => 'face', 'username', 'sex', 'location', 'follow', 'fans', 'weibo', 'uid');

			$users = db('userinfo')->where($where)->field($field)->select();

		}

		$where = array('fans' => session('uid'));
		$follow = $db->field('follow')->where($where)->select();

		if ($follow) {
			foreach ($follow as $k => $v) {
				$follow[$k] = $v['follow'];
			}
		}

		$where = array('follow' => session('uid'));
		$fans = $db->field('fans')->where($where)->select();

		if ($fans) {
			foreach ($fans as $k => $v) {
				$fans[$k] = $v['fans'];
			}
		}

		return view('followList', [
			'users' => isset($users) ? $users : null,
			'type' => $type,
			'count' => $count,
			'follow' => $follow,
			'fans' => $fans,
		]);
	}

	/**
	 * 收藏列表
	 */
	Public function keep() {
		$uid = session('uid');

		$count = db('keep')->where(array('uid' => $uid))->count();
		$where = array('keep.uid' => $uid);

		//收藏微博视图
		$keep_view = DB::view('keep', ['id' => 'kid', 'time' => 'ktime'])
			->view('weibo', ['id', 'content', 'isturn', 'time', 'turn', 'comment', 'uid'], 'keep.wid = weibo.id', 'INNER')
			->view('picture', ['mini', 'medium', 'max'], 'weibo.id = picture.wid', 'LEFT')
			->view('userinfo', ['username', 'face50' => 'face'], 'weibo.uid = userinfo.uid', 'LEFT');
		$weibo = $keep_view->where($where)->paginate(20, $count);

		foreach ($weibo as $k => $v) {
			if ($v['isturn'] > 0) {
				$v['isturn'] = Db::view('weibo', 'id,content,isturn,time,turn,keep,comment,uid')
					->view('userinfo', ['username', 'face50' => 'face'], 'weibo.uid = userinfo.uid', 'left')
					->view('picture', array('mini', 'medium', 'max'), 'weibo.id=picture.wid', 'left')
					->find($v['isturn']);
				$weibo[$k] = $v;
			}
		}

		// return p($weibo);

		return view('weiboList', ['weibo' => $weibo, 'page' => $weibo->render()]);
	}

	/**
	 * 异步取消收藏
	 */
	Public function cancelKeep() {
		if (!request()->isAjax()) {
			$this->error('页面不存在');
		}

		$kid = intval(input('post.kid'));
		$wid = intval(input('post.wid'));

		if (db('keep')->delete($kid)) {
			db('weibo')->where(array('id' => $wid))->setDec('keep');

			echo 1;
		} else {
			echo 0;
		}
	}

	/**
	 * 私信列表
	 */
	Public function letter() {
		$uid = session('uid');

		set_msg($uid, 2, true);

		$count = db('letter')->where(array('uid' => $uid))->count();

		$where = array('letter.uid' => $uid);

		//私信视图
		$letterView = DB::view('letter', ['id', 'content', 'time'])
			->view('userinfo', ['username', 'face50' => 'face', 'uid'], 'letter.from=userinfo.uid', 'LEFT');
		$letter = $letterView->where($where)->order('time DESC')->paginate(20, $count);

		return view('letter', ['letter' => $letter, 'count' => $count, 'page' => $letter->render()]);
	}

	/**
	 * 异步删除私信
	 */
	Public function delLetter() {
		if (!request()->isAjax()) {
			$this->error('页面不存在');
		}

		$lid = intval(input('post.lid'));

		if (db('letter')->delete($lid)) {
			echo 1;
		} else {
			echo 0;
		}
	}

	/**
	 * 私信发送表单处理
	 */
	Public function letterSend() {
		if (!request()->isPost()) {
			$this->error('页面不存在');
		}
		$name = input('post.name');
		$where = array('username' => $name);
		$uid = db('userinfo')->where($where)->value('uid');

		if (!$uid) {
			$this->error('用户不存在');
		}

		$data = array(
			'from' => session('uid'),
			'content' => input('post.content'),
			'time' => time(),
			'uid' => $uid,
		);

		if (db('letter')->data($data)->insert()) {

			set_msg($uid, 2);

			$this->success('私信已发送', url('letter'));
		} else {
			$this->error('发送失败请重试...');
		}
	}

	/**
	 * 评论列表
	 */
	Public function comment() {
		set_msg(session('uid'), 1, true);

		$where = array('uid' => session('uid'));
		$count = db('comment')->where($where)->count();

		//评论列表视图
		$comment_view = DB::view('comment', ['id', 'content', 'time', 'wid'])
			->view('userinfo', ['username', 'face50' => 'face', 'uid'], 'comment.uid=userinfo.uid', 'LEFT');
		$comment = $comment_view->where($where)->order('time DESC')->paginate(20, $count);

		return view('comment', ['count' => $count, 'page' => $comment->render(), 'comment' => $comment]);
	}

	/**
	 * 评论回复
	 */
	Public function reply() {
		if (!request()->isAjax()) {
			$this->error('页面不存在');
		}

		$data = array(
			'content' => input('post.content'),
			'time' => time(),
			'uid' => session('uid'),
			'wid' => intval(input('post.wid')),
		);

		if (db('comment')->data($data)->insert()) {
			db('weibo')->where(array('id' => $wid))->setInc('comment');
			echo 1;
		} else {
			echo 0;
		}
	}

	/**
	 * 删除评论
	 */
	Public function delComment() {
		if (!request()->isAjax()) {
			$this->error('页面不存在');
		}
		$cid = intval(input('post.cid'));
		$wid = intval(input('post.wid'));

		if (db('comment')->delete($cid)) {
			db('weibo')->where(array('id' => $wid))->setDec('comment');
			echo 1;
		} else {
			echo 0;
		}
	}

	/**
	 * @提到我的
	 */
	Public function atme() {
		set_msg(session('uid'), 3, true);

		$where = array('uid' => session('uid'));
		$wid = db('atme')->where($where)->field('wid')->select();

		if ($wid) {
			foreach ($wid as $k => $v) {
				$wid[$k] = $v['wid'];
			}
		}

		$count = count($wid);

		$where = array('id' => array('IN', $wid));
		$weibo = Db::view('weibo', 'id,content,isturn,time,turn,keep,comment,uid')
			->view('userinfo', ['username', 'face50' => 'face'], 'weibo.uid = userinfo.uid', 'left')
			->view('picture', array('mini', 'medium', 'max'), 'weibo.id=picture.wid', 'left')
			->where($where)->order('time DESC')->paginate(20, $count);
		//重组结果集数组，得到转发微博
		if ($weibo->all()) {
			foreach ($weibo as $k => $v) {
				if ($v['isturn']) {
					$tmp = Db::view('weibo', 'id,content,isturn,time,turn,keep,comment,uid')
						->view('userinfo', array(
							'username', 'face50' => 'face',
						), 'weibo.uid = userinfo.uid', 'left')
						->view('picture', array('mini', 'medium', 'max'), 'weibo.id=picture.wid', 'left')
						->find($v['isturn']);
					$v['isturn'] = $tmp ? $tmp : -1;
					$weibo[$k] = $v;
				}
			}
		}

		return view('weiboList', ['weibo' => $weibo, 'page' => $weibo->render(), 'atme' => 1]);
	}

}
?>