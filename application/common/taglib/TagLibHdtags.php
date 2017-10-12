<?php
namespace app\common\taglib;
use think\template\TagLib;

Class TagLibHdtags extends TagLib {

	Protected $tags = array(
		'userinfo' => array('attr' => 'id', 'close' => 1),
		'maybe' => array('attr' => 'uid', 'close' => 1),
	);

	/**
	 * 读取用户信息标签
	 * @param  [type] $attr    [description]
	 * @param  [type] $content [description]
	 * @return [type]          [description]
	 */
	Public function tagUserinfo($attr, $content) {
		// $attr = $this->parseXmlAttr($attr);
		$id = $attr['id'];
		$str = '';
		$str .= '<?php ';
		$str .= '$where = array("uid" => ' . $id . ');';
		$str .= '$field = array("username", "face80" => "face", "follow", "fans", "weibo", "uid");';
		$str .= '$userinfo = db("userinfo")->where($where)->field($field)->find();';
		$str .= 'extract($userinfo);';
		$str .= '?>';
		$str .= $content;

		return $str;
	}

	/**
	 * 读取可能感兴趣的人
	 * @param  [type] $attr    [description]
	 * @param  [type] $content [description]
	 * @return [type]          [description]
	 */
	Public function tagMaybe($attr, $content) {
		// $attr = $this->parseXmlAttr($attr);
		$uid = $attr['uid'];
		$str = '';
		$str .= '<?php ';
		$str .= '$uid = ' . $uid . ';';
		$str .= '$db = db("follow");';
		$str .= '$where = array("fans" => $uid);';
		$str .= '$follow = $db->where($where)->field("follow")->select();';
		$str .= 'foreach ($follow as $k => $v) :';
		$str .= '$follow[$k] = $v["follow"];';
		$str .= 'endforeach;';
		$str .= '$sql = "SELECT `uid`,`username`,`face50` AS `face`,COUNT(f.`follow`) AS `count` FROM `hd_follow` f LEFT JOIN `hd_userinfo` u ON f.`follow` = u.`uid` WHERE f.`fans` IN (\'" . implode(\',\', $follow) . "\') AND f.`follow` NOT IN (\'" . implode(\',\',$follow) . "\') AND f.`follow` <>" . $uid . " GROUP BY f.`follow` ORDER BY `count` DESC LIMIT 4";';
		$str .= '$friend = $db->query($sql);';
		$str .= 'foreach ($friend as $v) :';
		$str .= 'extract($v);?>';
		$str .= $content;
		$str .= '<?php endforeach;?>';

		return $str;
	}
}

?>