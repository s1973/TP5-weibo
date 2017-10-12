<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

class Index extends Common {
	public function index() {

		//取得当前用户的ID与当前用户所有关注好友的ID
		$uid = array(session('uid'));
		$where = array('fans' => session('uid'));

		if (input('gid')) {
			$gid = intval(input('gid'));
			$where['gid'] = $gid;
			$uid = array();
		}

		$result = db('follow')->field('follow')->where($where)->select();

		if ($result) {
			foreach ($result as $v) {
				$uid[] = $v['follow'];
			}
		}
		//微博视图
		$db = Db::view('weibo', 'id,content,isturn,time,turn,keep,comment,uid')
			->view('userinfo', array(
				'username', 'face50' => 'face',
			), 'weibo.uid = userinfo.uid', 'left')
			->view('picture', array('mini', 'medium', 'max'), 'weibo.id=picture.wid', 'left');

		//组合WHERE条件,条件为当前用户自身的ID与当前用户所有关注好友的ID
		$where = array('uid' => array('IN', $uid));

		//统计数据总条数，用于分页
		$count = db('weibo')->where($where)->count();

		$result = $db->where($where)->order('time DESC')->paginate(20, $count);
		//重组结果集数组，得到转发微博
		if ($result->all()) {
			foreach ($result as $k => $v) {
				if ($v['isturn']) {
					$tmp = Db::view('weibo', 'id,content,isturn,time,turn,keep,comment,uid')
						->view('userinfo', array(
							'username', 'face50' => 'face',
						), 'weibo.uid = userinfo.uid', 'left')
						->view('picture', array('mini', 'medium', 'max'), 'weibo.id=picture.wid', 'left')
						->find($v['isturn']);
					$v['isturn'] = $tmp ? $tmp : -1;
					$result[$k] = $v;
				}
			}
		}

		return view('index', array(
			'weibo' => $result,
			'page' => $result->render(),
		));

	}

	/**
	 * 微博发布处理
	 */
	Public function sendWeibo() {
		if (!request()->isPost()) {
			$this->error('页面不存在');
		}
		$data = array(
			'content' => input('post.content'),
			'time' => time(),
			'uid' => session('uid'),
		);

		if ($wid = db('weibo')->insertGetId($data)) {
			if (!empty($_POST['max'])) {
				$img = array(
					'mini' => input('post.mini'),
					'medium' => input('post.medium'),
					'max' => input('post.max'),
					'wid' => $wid,
				);
				db('picture')->insert($img);
			}
			db('userinfo')->where(array('uid' => session('uid')))->setInc('weibo'); // 用户微博数加1

			//处理@用户
			$this->_atmeHandel($data['content'], $wid);

			$this->success('发布成功');
		} else {
			$this->error('发布失败请重试...');
		}
	}

	/**
	 * @用户处理
	 */
	Private function _atmeHandel($content, $wid) {
		$preg = '/@(\S+?)\s/is';
		preg_match_all($preg, $content, $arr);

		if (!empty($arr[1])) {
			$db = db('userinfo');
			$atme = db('atme');
			foreach ($arr[1] as $v) {
				$uid = $db->where(array('username' => $v))->value('uid');
				if ($uid) {
					$data = array(
						'wid' => $wid,
						'uid' => $uid,
					);

					//写入消息推送
					set_msg($uid, 3);
					$atme->data($data)->insert();
				}
			}
		}
	}

	/**
	 * 转发微博
	 */
	Public function turn() {
		if (!request()->isPost()) {
			$this->error('页面不存在');
		}
		//原微博ID
		$id = intval(input('post.id'));
		$tid = intval(input('post.tid'));
		//转发内容
		$content = input('post.content');

		//提取插入数据
		$data = array(
			'content' => $content,
			'isturn' => $tid ? $tid : $id,
			'time' => time(),
			'uid' => session('uid'),
		);

		//插入数据至微博表
		$db = db('weibo');
		if ($wid = $db->insertGetId($data)) {
			//原微博转发数+1
			$db->where(array('id' => $id))->setInc('turn');

			if ($tid) {
				$db->where(array('id' => $tid))->setInc('turn');
			}

			//用户发布微博数+1
			db('userinfo')->where(array('uid' => session('uid')))->setInc('weibo');

			//处理@用户
			$this->_atmeHandel($data['content'], $wid);

			//如果点击了同时评论插入内容到评论表
			if (input('?post.becomment')) {
				$data = array(
					'content' => $content,
					'time' => time(),
					'uid' => session('uid'),
					'wid' => $id,
				);
				//插入评论数据后给原微博评论次数+1
				if (db('comment')->insert($data)) {
					$db->where(array('id' => $id))->setInc('comment');
				}
			}

			$this->success('转发成功', $_SERVER['HTTP_REFERER']);
		} else {
			$this->error('转发失败请重试...');
		}
	}

	/**
	 * 收藏微博
	 */
	Public function keep() {
		if (!request()->isAjax()) {
			$this->error('页面不存在');
		}

		$wid = intval(input('post.wid'));
		$uid = session('uid');

		$db = db('keep');

		//检测用户是否已经收藏该微博
		$where = array('wid' => $wid, 'uid' => $uid);
		if ($db->where($where)->value('id')) {
			echo -1;
			exit();
		}

		//添加收藏
		$data = array(
			'uid' => $uid,
			'time' => $_SERVER['REQUEST_TIME'],
			'wid' => $wid,
		);

		if ($db->data($data)->insert()) {
			//收藏成功时对该微博的收藏数+1
			db('weibo')->where(array('id' => $wid))->setInc('keep');
			echo 1;
		} else {
			echo 0;
		}
	}

	/**
	 * 评论
	 */
	Public function comment() {
		if (!request()->isAjax()) {
			$this->error('页面不存在');
		}
		//提取评论数据
		$data = array(
			'content' => input('post.content'),
			'time' => time(),
			'uid' => session('uid'),
			'wid' => intval(input('post.wid')),
		);

		if (db('comment')->data($data)->insert()) {
			//读取评论用户信息
			$field = array('username', 'face50' => 'face', 'uid');
			$where = array('uid' => $data['uid']);
			$user = db('userinfo')->where($where)->field($field)->find();

			//被评论微博的发布者用户名
			$uid = intval(input('post.uid'));
			$username = db('userinfo')->where(array('uid' => $uid))->value('username');

			$db = db('weibo');
			//评论数+1
			$db->where(array('id' => $data['wid']))->setInc('comment');

			//评论同时转发时处理
			if (input('post.isturn')) {
				//读取转发微博ID与内容
				$field = array('id', 'content', 'isturn');
				$weibo = $db->field($field)->find($data['wid']);
				$content = $weibo['isturn'] ? $data['content'] . ' // @' . $username . ' : ' . $weibo['content'] : $data['content'];

				//同时转发到微博的数据
				$cons = array(
					'content' => $content,
					'isturn' => $weibo['isturn'] ? $weibo['isturn'] : $data['wid'],
					'time' => $data['time'],
					'uid' => $data['uid'],
				);

				if ($db->data($cons)->insert()) {
					$db->where(array('id' => $weibo['id']))->setInc('turn');
				}

				echo 1;
				exit();
			}

			//组合评论样式字符串返回
			$str = '';
			$str .= '<dl class="comment_content">';
			$str .= '<dt><a href="' . url('/' . $data['uid']) . '">';
			$str .= '<img src="';
			$str .= request()->root(true);
			if ($user['face']) {
				$str .= '/Uploads/Face/' . $user['face'];
			} else {
				$str .= '/static/Images/noface.gif';
			}
			$str .= '" alt="' . $user['username'] . '" width="30" height="30"/>';
			$str .= '</a></dt><dd>';
			$str .= '<a href="' . url('/' . $data['uid']) . '" class="comment_name">';
			$str .= $user['username'] . '</a> : ' . replace_weibo($data['content']);
			$str .= '&nbsp;&nbsp;( ' . time_format($data['time']) . ' )';
			$str .= '<div class="reply">';
			$str .= '<a href="">回复</a>';
			$str .= '</div></dd></dl>';

			set_msg(session('uid'), 1);
			echo $str;

		} else {
			echo 'false';
		}

	}

	/**
	 * 异步获取评论内容
	 */
	Public function getComment() {
		if (!request()->isAjax()) {
			$this->error('页面不存在');
		}
		$wid = intval(input('post.wid'));
		$where = array('wid' => $wid);

		//sleep(1);
		//数据的总条数
		$count = db('comment')->where($where)->count();
		//数据可分的总页数
		$total = ceil($count / 10);
		$page = input('?post.page') ? intval(input('post.page')) : 1;
		$limit = $page < 2 ? '0,10' : (10 * ($page - 1)) . ',10';

		//评论视图
		$db = DB::view('Comment', 'id,content,time,wid')
			->view('Userinfo', array('username', 'face50' => 'face', 'uid'), 'Comment.uid = Userinfo.uid', 'LEFT');

		$result = $db->where($where)->order('time DESC')->limit($limit)->select();

		if ($result) {
			$str = '';
			foreach ($result as $v) {
				$str .= '<dl class="comment_content">';
				$str .= '<dt><a href="' . url('/' . $v['uid']) . '">';
				$str .= '<img src="';
				$str .= request()->root(true);
				if ($v['face']) {
					$str .= '/Uploads/Face/' . $v['face'];
				} else {
					$str .= '/static/Images/noface.gif';
				}
				$str .= '" alt="' . $v['username'] . '" width="30" height="30"/>';
				$str .= '</a></dt><dd>';
				$str .= '<a href="' . url('/' . $v['uid']) . '" class="comment_name">';
				$str .= $v['username'] . '</a> : ' . replace_weibo($v['content']);
				$str .= '&nbsp;&nbsp;( ' . time_format($v['time']) . ' )';
				$str .= '<div class="reply">';
				$str .= '<a href="">回复</a>';
				$str .= '</div></dd></dl>';
			}

			if ($total > 1) {
				$str .= '<dl class="comment-page">';

				switch ($page) {
				case $page > 1 && $page < $total:
					$str .= '<dd page="' . ($page - 1) . '" wid="' . $wid . '">上一页</dd>';
					$str .= '<dd page="' . ($page + 1) . '" wid="' . $wid . '">下一页</dd>';
					break;

				case $page < $total:
					$str .= '<dd page="' . ($page + 1) . '" wid="' . $wid . '">下一页</dd>';
					break;

				case $page == $total:
					$str .= '<dd page="' . ($page - 1) . '" wid="' . $wid . '">上一页</dd>';
					break;
				}

				$str .= '</dl>';
			}

			echo $str;

		} else {
			echo 'false';
		}
	}

	/**
	 * 异步删除微博
	 */
	Public function delWeibo() {
		if (!request()->isAjax()) {
			$this->error('页面不存在');
		}
		//获取删除微博ID
		$wid = intval(input('post.wid'));
		if (db('weibo')->delete($wid)) {
			//如果删除的微博含有图片
			$db = db('picture');
			$img = $db->where(array('wid' => $wid))->find();

			//对图片表记录进行删除
			if ($img) {
				$db->delete($img['id']);

				//删除图片文件
				@unlink('./Uploads/Pic/' . $img['mini']);
				@unlink('./Uploads/Pic/' . $img['medium']);
				@unlink('./Uploads/Pic/' . $img['max']);
			}
			db('userinfo')->where(array('uid' => session('uid')))->setDec('weibo');
			db('comment')->where(array('wid' => $wid))->delete();

			echo 1;
		} else {
			echo 0;
		}
	}

	/**
	 * 退出登陆
	 */
	Public function loginOut() {
		session(null);
		cookie('auto', null);
		$this->redirect('Login/index');
	}
}
