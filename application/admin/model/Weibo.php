<?php
namespace app\admin\model;

/**
 * 微博关联模型
 */
class Weibo extends \think\Model {
	/**
	 * 关联删除微博
	 */
	public function relaDelete($pk = null) {
		$pk = ($pk) ? $pk : $this->id;
		$picture = db('picture')->where('wid', $pk)->delete();
		$comment = db('comment')->where('wid', $pk)->delete();
		$keep = db('keep')->where('wid', $pk)->delete();
		$atme = db('atme')->where('wid', $pk)->delete();
		return $this::destroy($pk);
	}

}
?>