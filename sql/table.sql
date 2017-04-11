-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 09 月 17 日 20:35
-- 服务器版本: 5.0.90-community-nt
-- PHP 版本: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `voting`
--

-- --------------------------------------------------------

--
-- 表的结构 `voteGroupInfo`
-- 投票组信息表
DROP TABLE IF EXISTS  `voteGroupInfo`;
CREATE TABLE IF NOT EXISTS  `voteGroupInfo`(
  `serialNumber` INT unsigned NOT NULL auto_increment COMMENT '投票组序号',
  `name` VARCHAR (200) NOT NULL COMMENT '投票组名称',
  `explain` VARCHAR(1000) NOT NULL  COMMENT '投票组说明文字',
  `titlePicUrl` VARCHAR(200) NOT NULL  COMMENT '投票组标题图片地址',
  `ruleDes` VARCHAR(1000) NOT NULL  COMMENT '投票组规则说明文字',
  `effectStartTime` datetime NOT NULL  COMMENT '投票组生效开始时间',
  `effectEndTime` datetime NOT NULL  COMMENT '投票组截止失效时间',
  `candidateCount` INT NOT NULL  COMMENT '备选数据数量',
  `ipLimit` INT NOT NULL  COMMENT '投票组IP限制',
  `optionMark` VARCHAR(10) NOT NULL  COMMENT '投票组备选项标识',
  `status` VARCHAR(1) NOT NULL  COMMENT '投票组当前状态',
  `createTime` datetime NOT NULL  COMMENT '记录创建日期',
  `modifyTime` datetime NOT NULL  COMMENT '记录最后修改日期',
   PRIMARY KEY  (`serialNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='投票组信息表';
-- --------------------------------------------------------
INSERT INTO `votegroupinfo` VALUES (1, '蜀南气矿', '开展蜀南气矿第二届“十大杰出青年”评选活动，旨在选树、宣传和表彰在气矿三大工程建设中做出重大贡献、取得突出业绩的杰出青年典型，为广大青年树立榜样，优化青年成长成才环境，打造青年人才培养任用渠道，激励广大青年发奋学习、勤奋工作、艰苦创业、成长成才，积极投身于分公司300亿战略大气区建设和气矿三大工程建设。', '123.png', '投票时间：2017年4月17日到2017年4月27日&每个IP地址对每位候选人24小时内限投一次，每个IP地址每天投票总数不超过10票&投票结束后，气矿青年工作办公室将对候选人票数进行汇总，其结果提交给蜀南气矿第二届“十大杰出青年” 评选活动组委会', '2017-4-17 00:00:00', '2017-4-27 00:00:00', 23, 1, '1', '1', '2017-4-9 21:49:10', '2017-4-9 21:49:13');

--
-- 表的结构 `countVoting`
-- 投票组备选组数据
--

DROP TABLE IF EXISTS `countVoting`;
CREATE TABLE IF NOT EXISTS `countVoting` (
  `id` INT unsigned NOT NULL auto_increment COMMENT '候选人id' ,
  `serialNumber` INT unsigned NOT NULL COMMENT '投票组序号' ,
  `showOrder` INT  COMMENT '显示顺序' ,
  `photoUrl` VARCHAR(400) COMMENT '照片地址' ,
  `company` VARCHAR(400) COMMENT '单位' ,
  `name` VARCHAR(400) COMMENT '姓名' ,
  `sex` VARCHAR(400) COMMENT '性别' ,
  `age` VARCHAR(400) COMMENT '年龄' ,
  `position` VARCHAR(400) DEFAULT ""  COMMENT '职位' ,
  `level` VARCHAR(400) DEFAULT ""  COMMENT '工种等级' ,
  `countVotes` INT unsigned NOT NULL COMMENT '被投票数量' ,
  `explain` VARCHAR(400) DEFAULT ""  COMMENT '说明' ,
  `option_three` VARCHAR(400) DEFAULT "" COMMENT '备选3' ,
  `option_four` VARCHAR(400) DEFAULT ""  COMMENT '备选4' ,
  `option_five` VARCHAR(400) DEFAULT ""  COMMENT '备选5' ,
  `story` VARCHAR(4000) DEFAULT ""  COMMENT '备选6',
   PRIMARY KEY  (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='投票统计表';

-- --------------------------------------------------------

--
-- 表的结构 `ipVotes`
--

DROP TABLE IF EXISTS `ipVotes`;
CREATE TABLE IF NOT EXISTS `ipVotes` (
  `id` bigint(20) unsigned NOT NULL auto_increment COMMENT '投票人序号：自增',
  `serialNumber` INT unsigned NOT NULL  COMMENT '投票组序号',
  `ip` varchar(20) NOT NULL COMMENT '投票人IP',
  `voteTime` datetime NOT NULL COMMENT '投票时间',
  `countVotingId` INT unsigned NOT NULL COMMENT '候选人id',
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=gbk AUTO_INCREMENT=1 ;

--
-- 触发器 `ipVotes`
--
DROP TRIGGER IF EXISTS `vote_count_after_insert_tr`;
DELIMITER //
CREATE TRIGGER `vote_count_after_insert_tr` AFTER INSERT ON `ipVotes`
 FOR EACH ROW UPDATE countVoting SET countVotes = countVotes + 1 WHERE id = NEW.countVotingId
//
DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `user`
-- 后台用户信息表
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `userid` VARCHAR(20) NOT NULL COMMENT '用户ID',
  `passwd` VARCHAR(32) NOT NULL COMMENT '登录密码MD5值',
  `type` VARCHAR(20) NOT NULL COMMENT '用户类别',
  `email` VARCHAR(60) COMMENT '用户邮箱',
   PRIMARY KEY  (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='用户表';

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`userid`, `passwd`, `type`, `email`) VALUES
('dailiwang', 'e10adc3949ba59abbe56e057f20f883e','admin','dailw@feicuiedu.com'),
('yanxing', 'e10adc3949ba59abbe56e057f20f883e','admin','yanxing@feicuiedu.com');

--
-- 限制导出的表
--

--
-- 限制表 `ip_votes`
--
ALTER TABLE `ipVotes`
  ADD CONSTRAINT `ip_votes_ibfk_1` FOREIGN KEY (`countVotingId`) REFERENCES `countVoting` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `ipVotes`
  ADD CONSTRAINT `ip_votes_ibfk_2` FOREIGN KEY (`serialNumber`) REFERENCES `voteGroupInfo` (`serialNumber`) ON DELETE CASCADE ON UPDATE CASCADE;
--
-- 限制表 `countVoting`
--
ALTER TABLE `countVoting`
  ADD CONSTRAINT `countvoting_ibfk_1` FOREIGN KEY (`serialNumber`) REFERENCES `voteGroupInfo` (`serialNumber`) ON DELETE CASCADE ON UPDATE CASCADE;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
