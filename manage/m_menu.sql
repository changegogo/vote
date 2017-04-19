-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017 年 04 月 14 日 06:48
-- 服务器版本: 5.5.53
-- PHP 版本: 5.4.45

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `menu`
--

-- --------------------------------------------------------

--
-- 表的结构 `m_menu`
--

CREATE TABLE IF NOT EXISTS `m_menu` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `mname` varchar(255) NOT NULL,
  `mpath` varchar(255) NOT NULL,
  `mlevel` enum('2','1') NOT NULL DEFAULT '1' COMMENT '1为一级目录  2为二级目录',
  `pid` int(11) NOT NULL,
  `orderby` float NOT NULL COMMENT '排序',
  PRIMARY KEY (`mid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- 转存表中的数据 `m_menu`
--

INSERT INTO `m_menu` (`mid`, `mname`, `mpath`, `mlevel`, `pid`, `orderby`) VALUES
(25, '财务子1', '', '2', 1, 1.1),
(29, '财务子2x', '11', '2', 1, 1.2),
(27, '财务子3', '', '2', 1, 1.3),
(3, '人事管理', '', '1', 0, 3),
(2, '教师管理', '', '1', 0, 2),
(1, '财务管理', '111', '1', 0, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
