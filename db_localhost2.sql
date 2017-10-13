-- phpMyAdmin SQL Dump
-- version 4.0.10.10
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2017-10-13 09:04:46
-- 服务器版本: 5.1.73
-- PHP 版本: 5.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `db_localhost2`
--

-- --------------------------------------------------------

--
-- 表的结构 `hd_admin`
--

CREATE TABLE IF NOT EXISTS `hd_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(20) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '',
  `logintime` int(10) unsigned NOT NULL DEFAULT '0',
  `loginip` char(20) NOT NULL DEFAULT '',
  `lock` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `admin` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '0: 超级管理员\n1：普通管理员',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `hd_admin`
--

INSERT INTO `hd_admin` (`id`, `username`, `password`, `logintime`, `loginip`, `lock`, `admin`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1507776036, '0.0.0.0', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `hd_atme`
--

CREATE TABLE IF NOT EXISTS `hd_atme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wid` int(11) NOT NULL COMMENT '提到我的微博ID',
  `uid` int(11) NOT NULL COMMENT '所属用户ID',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `wid` (`wid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='@提到我的微博' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `hd_atme`
--

INSERT INTO `hd_atme` (`id`, `wid`, `uid`) VALUES
(1, 4, 1),
(2, 10, 1),
(3, 11, 1);

-- --------------------------------------------------------

--
-- 表的结构 `hd_comment`
--

CREATE TABLE IF NOT EXISTS `hd_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '评论内容',
  `time` int(10) unsigned NOT NULL COMMENT '评论时间',
  `uid` int(11) NOT NULL COMMENT '评论用户的ID',
  `wid` int(11) NOT NULL COMMENT '所属微博ID',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `wid` (`wid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='微博评论表' AUTO_INCREMENT=21 ;

--
-- 转存表中的数据 `hd_comment`
--

INSERT INTO `hd_comment` (`id`, `content`, `time`, `uid`, `wid`) VALUES
(1, '学习学习', 1504775716, 1, 2),
(6, ' // @admin : 转发咯[嘻嘻] 又转发咯[嘘]', 1507600312, 1, 8),
(5, '转发咯[嘻嘻]', 1507540173, 1, 7),
(7, '又转发咯 嘿嘿[太开心] // @admin : 转发咯[嘻嘻]', 1507601634, 1, 8),
(8, '哈哈哈哈', 1507603731, 1, 8),
(9, '的广泛大概', 1507603821, 1, 8),
(10, '来评论哟', 1507603888, 1, 8),
(11, '哟哟哟', 1507603915, 1, 8),
(12, '哟哟哟', 1507604001, 1, 8),
(13, '哟哟哟', 1507604084, 1, 8),
(14, '地十条评论？？', 1507604118, 1, 8),
(15, '才8条  哈哈哈 ', 1507604147, 1, 8),
(16, '才8条  哈哈哈 ', 1507604156, 1, 8),
(17, '11条咯   [左哼哼][钱]', 1507604179, 1, 8);

-- --------------------------------------------------------

--
-- 表的结构 `hd_follow`
--

CREATE TABLE IF NOT EXISTS `hd_follow` (
  `follow` int(10) unsigned NOT NULL COMMENT '关注用户的ID',
  `fans` int(10) unsigned NOT NULL COMMENT '粉丝用户ID',
  `gid` int(11) NOT NULL COMMENT '所属关注分组ID',
  KEY `follow` (`follow`),
  KEY `fans` (`fans`),
  KEY `gid` (`gid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='关注与粉丝表';

--
-- 转存表中的数据 `hd_follow`
--

INSERT INTO `hd_follow` (`follow`, `fans`, `gid`) VALUES
(2, 1, 0),
(3, 1, 1),
(4, 3, 0),
(4, 2, 0),
(3, 5, 0),
(5, 3, 0),
(1, 2, 0);

-- --------------------------------------------------------

--
-- 表的结构 `hd_group`
--

CREATE TABLE IF NOT EXISTS `hd_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL DEFAULT '' COMMENT '分组名称',
  `uid` int(11) NOT NULL COMMENT '所属用户的ID',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='关注分组表' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `hd_group`
--

INSERT INTO `hd_group` (`id`, `name`, `uid`) VALUES
(1, '明星', 1),
(2, '嘿嘿', 1);

-- --------------------------------------------------------

--
-- 表的结构 `hd_keep`
--

CREATE TABLE IF NOT EXISTS `hd_keep` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '收藏用户的ID',
  `time` int(10) unsigned NOT NULL COMMENT '收藏时间',
  `wid` int(11) NOT NULL COMMENT '收藏微博的ID',
  PRIMARY KEY (`id`),
  KEY `wid` (`wid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='收藏表' AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `hd_keep`
--

INSERT INTO `hd_keep` (`id`, `uid`, `time`, `wid`) VALUES
(2, 1, 1507604350, 8),
(6, 1, 1507794387, 21);

-- --------------------------------------------------------

--
-- 表的结构 `hd_letter`
--

CREATE TABLE IF NOT EXISTS `hd_letter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from` int(11) NOT NULL COMMENT '发私用户ID',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '私信内容',
  `time` int(10) unsigned NOT NULL COMMENT '私信发送时间',
  `uid` int(11) NOT NULL COMMENT '所属用户ID（收信人）',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='私信表' AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `hd_letter`
--

INSERT INTO `hd_letter` (`id`, `from`, `content`, `time`, `uid`) VALUES
(3, 1, 'kjfldjsklajflkdjisf', 1507709824, 2),
(2, 1, '你是谁', 1505899195, 2),
(4, 3, 'jdlfjklajglkjdklashgbvlid', 1507710034, 1),
(5, 1, '', 1507710052, 3);

-- --------------------------------------------------------

--
-- 表的结构 `hd_picture`
--

CREATE TABLE IF NOT EXISTS `hd_picture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mini` varchar(60) NOT NULL DEFAULT '' COMMENT '小图',
  `medium` varchar(60) NOT NULL DEFAULT '' COMMENT '中图',
  `max` varchar(60) NOT NULL DEFAULT '' COMMENT '大图',
  `wid` int(11) NOT NULL COMMENT '所属微博ID',
  PRIMARY KEY (`id`),
  KEY `wid` (`wid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='微博配图表' AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `hd_picture`
--

INSERT INTO `hd_picture` (`id`, `mini`, `medium`, `max`, `wid`) VALUES
(1, '2017_09/mini_59b10d9cae7b0.jpg', '2017_09/medium_59b10d9cae7b0.jpg', '2017_09/max_59b10d9cae7b0.jpg', 2),
(3, '2017_10\\mini_ac1a03ff3a5f9f0f5a408f1a5c2242b6.jpg', '2017_10\\medium_ac1a03ff3a5f9f0f5a408f1a5c2242b6.jpg', '2017_10\\max_ac1a03ff3a5f9f0f5a408f1a5c2242b6.jpg', 7),
(9, '2017_10\\mini_CgAANVmpEAkEAAAAAAAAAOutljA445.jpg', '2017_10\\medium_CgAANVmpEAkEAAAAAAAAAOutljA445.jpg', '2017_10\\max_CgAANVmpEAkEAAAAAAAAAOutljA445.jpg', 23);

-- --------------------------------------------------------

--
-- 表的结构 `hd_user`
--

CREATE TABLE IF NOT EXISTS `hd_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` char(20) NOT NULL DEFAULT '' COMMENT '账号',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  `registime` int(10) unsigned NOT NULL COMMENT '注册时间',
  `lock` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否锁定（0：否，1：是）',
  PRIMARY KEY (`id`),
  UNIQUE KEY `account` (`account`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户表' AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `hd_user`
--

INSERT INTO `hd_user` (`id`, `account`, `password`, `registime`, `lock`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1504775129, 0),
(2, 'admin01', '18c6d818ae35a3e8279b5330eda01498', 1504775164, 0),
(3, 'admin02', '6e60a28384bc05fa5b33cc579d040c56', 1505181567, 0),
(4, 'admin03', '7dc2466ad3ff5911f6a5e47e043e0abc', 1505181602, 0),
(5, 'admin04', '499c208ceafb4fbba162f077060955bd', 1505184024, 0),
(9, 'admin05', '3deffd4cb346737769a7a509c95cee17', 1506751350, 0);

-- --------------------------------------------------------

--
-- 表的结构 `hd_userinfo`
--

CREATE TABLE IF NOT EXISTS `hd_userinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL DEFAULT '' COMMENT '用户昵称',
  `truename` varchar(45) DEFAULT NULL COMMENT '真实名称',
  `sex` enum('男','女') NOT NULL DEFAULT '男' COMMENT '性别',
  `location` varchar(45) NOT NULL DEFAULT '' COMMENT '所在地',
  `constellation` char(10) NOT NULL DEFAULT '' COMMENT '星座',
  `intro` varchar(100) NOT NULL DEFAULT '' COMMENT '一句话介绍自己',
  `face50` varchar(60) NOT NULL DEFAULT '' COMMENT '50*50头像',
  `face80` varchar(60) NOT NULL DEFAULT '' COMMENT '80*80头像',
  `face180` varchar(60) NOT NULL DEFAULT '' COMMENT '180*180头像',
  `style` varchar(45) NOT NULL DEFAULT 'default' COMMENT '个性模版',
  `follow` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关注数',
  `fans` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '粉丝数',
  `weibo` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '微博数',
  `uid` int(11) NOT NULL COMMENT '所属用户ID',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户信息表' AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `hd_userinfo`
--

INSERT INTO `hd_userinfo` (`id`, `username`, `truename`, `sex`, `location`, `constellation`, `intro`, `face50`, `face80`, `face180`, `style`, `follow`, `fans`, `weibo`, `uid`) VALUES
(1, 'admin', 'ANAN', '男', '河北 保定', '双子座', 'zzzzzzzzzzz', '2017_10\\mini_ccf24b885cbb825fa40f665e7de273aa.jpeg', '2017_10\\medium_ccf24b885cbb825fa40f665e7de273aa.jpeg', '2017_10\\max_ccf24b885cbb825fa40f665e7de273aa.jpeg', 'style2', 2, 0, 11, 1),
(2, 'admin01', NULL, '男', '', '', '', '', '', '', 'default', 1, 1, 1, 2),
(3, 'admin02', NULL, '男', '', '', '', '', '', '', 'default', 2, 2, 0, 3),
(4, 'admin03', NULL, '男', '', '', '', '', '', '', 'default', 0, 2, 0, 4),
(5, 'admin04', NULL, '男', '', '', '', '', '', '', 'default', 1, 1, 0, 5),
(8, 'admin05', NULL, '男', '', '', '', '', '', '', 'default', 0, 0, 0, 9);

-- --------------------------------------------------------

--
-- 表的结构 `hd_weibo`
--

CREATE TABLE IF NOT EXISTS `hd_weibo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '微博内容',
  `isturn` int(11) NOT NULL DEFAULT '0' COMMENT '是否转发（0：原创， 如果是转发的则保存该转发微博的ID）',
  `time` int(10) unsigned NOT NULL COMMENT '发布时间',
  `turn` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '转发次数',
  `keep` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收藏次数',
  `comment` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收藏次数',
  `uid` int(11) NOT NULL COMMENT '所属用户的ID',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='微博表' AUTO_INCREMENT=24 ;

--
-- 转存表中的数据 `hd_weibo`
--

INSERT INTO `hd_weibo` (`id`, `content`, `isturn`, `time`, `turn`, `keep`, `comment`, `uid`) VALUES
(1, '很开心看见大家  再见[挖鼻屎]', 0, 1504775184, 0, 0, 0, 2),
(2, '哈哈哈哈哈哈[害羞]', 0, 1504775582, 1, 0, 1, 1),
(4, 'jdflasjflkdjslaj @admin [可怜]', 0, 1505899133, 0, 0, 0, 2),
(22, '我就是不想说fuck\r\n', 0, 1507796565, 0, 0, 0, 1),
(7, '图片哦[哈哈]', 0, 1507539109, 4, 0, 1, 1),
(8, '转发咯[嘻嘻]', 7, 1507540173, 6, 1, 11, 1),
(11, '又转发咯 嘿嘿[太开心] // @admin : 转发咯[嘻嘻]', 7, 1507601634, 0, 0, 0, 1),
(14, '哈哈哈哈 // @admin : 转发咯[嘻嘻]', 7, 1507603731, 0, 0, 0, 1),
(15, '的广泛大概 // @admin : 转发咯[嘻嘻]', 7, 1507603821, 0, 0, 0, 1),
(16, '来评论哟 // @admin : 转发咯[嘻嘻]', 7, 1507603888, 0, 0, 0, 1),
(23, 'fuck', 0, 1507855965, 0, 0, 0, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
