<?php
namespace app\index\controller;
/**
 * 共用控制器
 */
class Common extends \think\Controller {

	/**
	 * 控制器初始化
	 */
	Public function _initialize() {
		//处理自动登录
		if (cookie('auto') && !session('uid')) {
			$value = explode('|', encryption($_COOKIE['auto'], 1));
			$ip = request()->ip();

			//本次登录IP与上一次登录IP一致时
			if ($ip == $value[1]) {
				$account = $value[0];
				$where = array('account' => $account);

				$user = db('user')->where($where)->field(array('id', 'lock'))->find();

				//检索出用户信息并且该用户没有被锁定时，保存登录状态
				if ($user && !$user['lock']) {
					session('uid', $user['id']);
				}
			}
		}
		//判断用户是否已登录
		if (!session('uid')) {
			$this->redirect('Login/index');
		}
	}

	/**
	 * 头像上传
	 */
	Public function uploadFace() {
		if (!request()->isPost()) {
			$this->error('页面不存在');
		}
		$upload = $this->_upload('Face', '180,80,50', '180,80,50');
		echo json_encode($upload);
	}

	/**
	 * 微博图片上传
	 */
	Public function uploadPic() {
		if (!request()->isPost()) {
			$this->error('页面不存在');
		}
		$upload = $this->_upload('Pic', '800,380,120', '800,380,120');
		echo json_encode($upload);
	}

	/**
	 * 图片上传处理
	 * @param  [String] $path   [保存文件夹名称]
	 * @param  [String] $width  [缩略图宽度多个用，号分隔]
	 * @param  [String] $height [缩略图高度多个用，号分隔(要与宽度一一对应)]
	 * @return [Array]         [图片上传信息]
	 */
	Private function _upload($path, $width, $height) {
		$width = explode(',', $width);
		$height = explode(',', $height);
		$filename = input('post.Filename');
		$path = ROOT_PATH . 'public' . DS . 'Uploads' . DS . $path . DS . date('Y_m') . DS;
		if (!is_dir($path)) {
			mkdir($path);
		}
		$image = \think\Image::open(request()->file('Filedata'));
		$image->thumb($width[0], $height[0], \think\Image::THUMB_SCALING)->save($path . 'max_' . $filename);
		$image->thumb($width[1], $height[1], \think\Image::THUMB_SCALING)->save($path . 'medium_' . $filename);
		$image->thumb($width[2], $height[2], \think\Image::THUMB_SCALING)->save($path . 'mini_' . $filename);

		if (!$image) {
			return array('status' => 0, 'msg' => $image->getErrorMsg());
		} else {

			return array(
				'status' => 1,
				'path' => array(
					'max' => date('Y_m') . DS . 'max_' . $filename,
					'medium' => date('Y_m') . DS . 'medium_' . $filename,
					'mini' => date('Y_m') . DS . 'mini_' . $filename,
				),
			);
		}
	}

	/**
	 * 异步创建新分组
	 */
	Public function addGroup() {
		if (!request()->isAjax()) {
			$this->error('页面不存在');
		}
		$data = array(
			'name' => input('post.name'),
			'uid' => session('uid'),
		);
		if (db('group')->data($data)->insert()) {
			echo json_encode(array('status' => 1, 'msg' => '创建成功'));
		} else {
			echo json_encode(array('status' => 0, 'msg' => '创建失败,请重试...'));
		}
	}

	/**
	 * 异步添加关注
	 */
	Public function addFollow() {
		if (!request()->isAjax()) {
			$this->error('页面不存在');
		}
		$data = array(
			'follow' => intval(input('post.follow')),
			'fans' => (int) session('uid'),
			'gid' => intval(input('post.gid')),
		);
		if (db('follow')->data($data)->insert()) {
			$db = db('userinfo');
			$db->where(array('uid' => $data['follow']))->setInc('fans');
			$db->where(array('uid' => session('uid')))->setInc('follow');
			echo json_encode(array('status' => 1, 'msg' => '关注成功'));
		} else {
			echo json_encode(array('status' => 0, 'msg' => '关注失败请重试...'));
		}
	}

	/**
	 * 异步移除关注与粉丝
	 */
	Public function delFollow() {
		if (!request()->isAjax()) {
			$this->error('页面不存在');
		}

		$uid = intval(input('post.uid'));
		$type = intval(input('post.type'));

		$where = $type ? array('follow' => $uid, 'fans' => session('uid')) : array('fans' => $uid, 'follow' => session('uid'));

		if (db('follow')->where($where)->delete()) {
			$db = db('userinfo');

			if ($type) {
				$db->where(array('uid' => session('uid')))->setDec('follow');
				$db->where(array('uid' => $uid))->setDec('fans');
			} else {
				$db->where(array('uid' => session('uid')))->setDec('fans');
				$db->where(array('uid' => $uid))->setDec('follow');
			}

			echo 1;
		} else {
			echo 0;
		}
	}

	/**
	 * 异步修改模版风格
	 */
	Public function editStyle() {
		if (!request()->isAjax()) {
			$this->error('页面不存在');
		}

		$style = input('post.style');
		$where = array('uid' => session('uid'));

		if (db('userinfo')->where($where)->update(array('style' => $style))) {
			echo 1;
		} else {
			echo 0;
		}
	}

	/**
	 * 异步轮询推送消息
	 */
	Public function getMsg() {
		if (!request()->isAjax()) {
			$this->error('页面不存在');
		}

		$uid = session('uid');
		$msg = cache('usermsg' . $uid);

		if ($msg) {
			if ($msg['comment']['status']) {
				$msg['comment']['status'] = 0;
				cache('usermsg' . $uid, $msg, 0);
				return json_encode(array(
					'status' => 1,
					'total' => $msg['comment']['total'],
					'type' => 1,
				));
			}

			if ($msg['letter']['status']) {
				$msg['letter']['status'] = 0;
				cache('usermsg' . $uid, $msg, 0);
				return json_encode(array(
					'status' => 1,
					'total' => $msg['letter']['total'],
					'type' => 2,
				));
			}

			if ($msg['atme']['status']) {
				$msg['atme']['status'] = 0;
				cache('usermsg' . $uid, $msg, 0);
				return json_encode(array(
					'status' => 1,
					'total' => $msg['atme']['total'],
					'type' => 3,
				));
			}
		}
		echo json_encode(array('status' => 0));
	}

}

?>