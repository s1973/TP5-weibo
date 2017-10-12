<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

/**
 * 搜索控制器
 */
class Search extends Common {
	/**
	 * 搜索找人
	 */
	Public function sechUser() {
		$keyword = $this->_getKeyword();

		if ($keyword) {
			//检索出除自己外呢称含有关键字的用户
			$where = array(
				'username' => array('LIKE', '%' . $keyword . '%'),
				'uid' => array('NEQ', session('uid')),
			);
			$field = array('username', 'sex', 'location', 'intro', 'face80', 'follow', 'fans', 'weibo', 'uid');

			$db = db('userinfo');

			$count = $db->where($where)->count('id');

			$users = $db->where($where)->field($field)->paginate(20, $count);

			//重新组合结果集，得到是否已关注与是否互相关注
			$result = $this->_getMutual($users->all());
		}

		return view('', ['result' => $result ? $result : false, 'page' => $users->render(), 'keyword' => $keyword]);
	}

	/**
	 * 搜索微博
	 */
	Public function sechWeibo() {
		$keyword = $this->_getKeyword();

		if ($keyword) {
			//检索含有关键字的微博
			$where = array('content' => array('LIKE', '%' . $keyword . '%'));

			$count = db('weibo')->where($where)->count('id');

			$weibo = Db::view('weibo', 'id,content,isturn,time,turn,keep,comment,uid')
				->view('userinfo', array(
					'username', 'face50' => 'face',
				), 'weibo.uid = userinfo.uid', 'left')
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
		}

		return view('', ['weibo' => $weibo ? $weibo : false, 'page' => $weibo->render(), 'keyword' => $keyword]);
	}

	/**
	 * 返回搜索关键字
	 */
	Private function _getKeyword() {
		return $_GET['keyword'] == '搜索微博、找人' ? NULL : input('get.keyword');
	}

	/**
	 * 重组结果集得到是否互相关注与是否已关注
	 * @param  [Array] $result [需要处理的结果集]
	 * @return [Array]         [处理完成后的结果集]
	 */
	Private function _getMutual($result) {
		if (!$result) {
			return false;
		}
		foreach ($result as $k => $v) {
			//是否互相关注
			$sql = '(SELECT `follow` FROM `hd_follow` WHERE `follow` = ' . $v['uid'] . ' AND `fans` = ' . session('uid') . ') UNION (SELECT `follow` FROM `hd_follow` WHERE `follow` = ' . session('uid') . ' AND `fans` = ' . $v['uid'] . ')';
			$mutual = DB::query($sql);

			if (count($mutual) == 2) {
				$result[$k]['mutual'] = 1;
				$result[$k]['followed'] = 1;
			} else {
				$result[$k]['mutual'] = 0;

				//未互相关注是检索是否已关注
				$where = array(
					'follow' => $v['uid'],
					'fans' => session('uid'),
				);
				$result[$k]['followed'] = db('follow')->where($where)->count();
			}
		}
		return $result;
	}

}
?>