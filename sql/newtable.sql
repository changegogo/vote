SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

drop table if exists votegroupinfo;

/*==============================================================*/
/* Table: votegroupinfo                                         */
/*==============================================================*/
create table votegroupinfo
(
   serialNumber         int not null,
   name                 varchar(200) not null,
   `explain`            varchar(1000),
   titlePicUrl          varchar(200),
   ruleDes              varchar(1000),
   effectStartTime      date not null,
   effectEndTime        date not null,
   candidateTime        int,
   ipLimit              int,
   optionMark           varchar(10),
   status               varchar(1),
   createTime           date not null,
   modifyTime           date not null,
   primary key (serialNumber)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='投票组信息表';
alter table votegroupinfo comment '投票的信息表,一条记录就是一种类型的投票各种配置数据.投票组IP限制 0 表示不显示，填写数';

INSERT INTO `votegroupinfo` VALUES (1, '蜀南气矿', '开展蜀南气矿第二届“十大杰出青年”评选活动，旨在选树、宣传和表彰在气矿三大工程建设中做出重大贡献、取得突出业绩的杰出青年典型，为广大青年树立榜样，优化青年成长成才环境，打造青年人才培养任用渠道，激励广大青年发奋学习、勤奋工作、艰苦创业、成长成才，积极投身于分公司300亿战略大气区建设和气矿三大工程建设。', '123.png', '投票时间：2017年4月17日到2017年4月27日&每个IP地址对每位候选人24小时内限投一次，每个IP地址每天投票总数不超过10票&投票结束后，气矿青年工作办公室将对候选人票数进行汇总，其结果提交给蜀南气矿第二届“十大杰出青年”评选活动组委会&按姓氏笔画排序', '2017-4-17 00:00:00', '2017-4-27 00:00:00', 23, 1, '1', '1', '2017-4-9 21:49:10', '2017-4-9 21:49:13');

drop table if exists countvoting;

/*==============================================================*/
/* Table: countvoting                                           */
/*==============================================================*/
create table countvoting
(
   id                   int not null,
   serialNumber         int not null DEFAULT 1,
   showOrder            int not null,
   photoUrl             varchar(400) not null,
   company              varchar(400),
   name                 varchar(400),
   sex                  varchar(400),
   age                  varchar(400),
   position             varchar(400) DEFAULT "",
   level                varchar(400) DEFAULT "",
   countVotes           varchar(400) DEFAULT 0,
   `explain`            varchar(400) DEFAULT "",
   option_three         varchar(400) DEFAULT "",
   option_four          varchar(400) DEFAULT "",
   option_five          varchar(400) DEFAULT "",
   stroy                varchar(4000) DEFAULT "",
   primary key (id)
) ENGINE=InnoDB DEFAULT CHARSET=gbk;

drop table if exists ipvotes;

/*==============================================================*/
/* Table: ipvotes                                               */
/*==============================================================*/
create table ipvotes
(
   serialNumber         int not null,
   ip                   varchar(20) not null,
   voteTime             date not null,
   countVotingId        int not null,
   seq                  bigint,
   primary key (serialNumber, ip, voteTime, countVotingId)
) ENGINE=InnoDB DEFAULT CHARSET=gbk;

alter table ipvotes comment 'IP地址限制数据';

drop table if exists user;



/*==============================================================*/
/* Table: UserInfo                                              */
/*==============================================================*/
create table user
(
   userid               varchar(20) not null,
   passwd               varchar(40),
   type                 varchar(20),
   email                varchar(60),
   primary key (userid)
) ENGINE=InnoDB DEFAULT CHARSET=gbk;

alter table user comment '用户信息表,目前就存个后台的账户';

INSERT INTO `user` (`userid`, `passwd`, `type`, `email`) VALUES
('dailiwang', 'e10adc3949ba59abbe56e057f20f883e','admin','dailw@feicuiedu.com'),
('yanxing', 'e10adc3949ba59abbe56e057f20f883e','admin','yanxing@feicuiedu.com');



DROP TABLE IF EXISTS sequence;
CREATE TABLE sequence (
     name VARCHAR(50) NOT NULL,
     current_value INT NOT NULL,
     increment INT NOT NULL DEFAULT 1,
     PRIMARY KEY (name)
) ENGINE=InnoDB;
DROP FUNCTION IF EXISTS currval;
DELIMITER $
CREATE FUNCTION currval (seq_name VARCHAR(50))
     RETURNS INTEGER
     LANGUAGE SQL
     DETERMINISTIC
     CONTAINS SQL
     SQL SECURITY DEFINER
     COMMENT ''
BEGIN
     DECLARE value INTEGER;
     SET value = 0;
     SELECT current_value INTO value
          FROM sequence
          WHERE name = seq_name;
     RETURN value;
END
$
DELIMITER ;
DROP FUNCTION IF EXISTS nextval;
DELIMITER $
CREATE FUNCTION nextval (seq_name VARCHAR(50))
     RETURNS INTEGER
     LANGUAGE SQL
     DETERMINISTIC
     CONTAINS SQL
     SQL SECURITY DEFINER
     COMMENT ''
BEGIN
     UPDATE sequence
          SET current_value = current_value + increment
          WHERE name = seq_name;
     RETURN currval(seq_name);
END
$
DELIMITER ;
DROP FUNCTION IF EXISTS setval;
DELIMITER $
CREATE FUNCTION setval (seq_name VARCHAR(50), value INTEGER)
     RETURNS INTEGER
     LANGUAGE SQL
     DETERMINISTIC
     CONTAINS SQL
     SQL SECURITY DEFINER
     COMMENT ''
BEGIN
     UPDATE sequence
          SET current_value = value
          WHERE name = seq_name;
     RETURN currval(seq_name);
END
$
DELIMITER ;

INSERT INTO sequence VALUES ('seq', 0, 1);

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

--
-- 触发器 `ipVotes`
--
DROP TRIGGER IF EXISTS `vote_count_after_insert_tr`;
DELIMITER //
CREATE TRIGGER `vote_count_after_insert_tr` AFTER INSERT ON `ipVotes`
 FOR EACH ROW UPDATE countVoting SET countVotes = countVotes + 1 WHERE id = NEW.countVotingId
//
DELIMITER ;


insert into countvoting (showOrder,id, photoUrl,company,name,sex,age,position,level) values(6,1,"public/votegroup/shunanqikuangshida/photo/zhuqing.jpg","开发科","朱庆","男","33","工程师","/");
insert into countvoting (showOrder,id, photoUrl,company,name,sex,age,position,level) values(12,2,"public/votegroup/shunanqikuangshida/photo/zengzhengrong.jpg","质量安全环保科","曾正荣","男","31","工程师","/");
insert into countvoting (showOrder,id, photoUrl,company,name,sex,age,position,level) values(7,3,"public/votegroup/shunanqikuangshida/photo/yangkun.jpg","新闻中心","杨锟","女","33","政工师","/");
insert into countvoting (showOrder,id, photoUrl,company,name,sex,age,position,level) values(7,4,"public/votegroup/shunanqikuangshida/photo/zhangyong.jpg","塔里木油气工程分公司","张勇","男","31","工程师","/");
insert into countvoting (showOrder,id, photoUrl,company,name,sex,age,position,level) values(8,5,"public/votegroup/shunanqikuangshida/photo/luoyuhe.jpg","自贡采气作业区","罗玉合","男",35,"生产技术室主任/工程师","/");
insert into countvoting (showOrder,id, photoUrl,company,name,sex,age,position,level) values(4,6,"public/votegroup/shunanqikuangshida/photo/wangchuanjie.jpg","乐山采气作业区","王川杰","男",34,"生产技术室副主任/工程师","/");
insert into countvoting (showOrder,id, photoUrl,company,name,sex,age,position,level) values(6,7,"public/votegroup/shunanqikuangshida/photo/jiangshengfei.jpg","乐山采气作业区","江胜飞","男",30,"工程师 ","/");
insert into countvoting (showOrder,id, photoUrl,company,name,sex,age,position,level) values(12,8,"public/votegroup/shunanqikuangshida/photo/zengcheng.jpg","安岳采气作业区","曾诚","男",28,"生产技术室副主任/工程师","/");
insert into countvoting (showOrder,id, photoUrl,company,name,sex,age,position,level) values(8,9,"public/votegroup/shunanqikuangshida/photo/zhengchuntiao.jpg","长宁页岩气作业区","郑纯桃","男",31,"生产技术室主任/工程师","/");
insert into countvoting (showOrder,id, photoUrl,company,name,sex,age,position,level) values(4,10,"public/votegroup/shunanqikuangshida/photo/wangmiao.jpg","长宁页岩气作业区","王淼","男",32,"中心站站长 ","采气工/中级");
insert into countvoting (showOrder,id, photoUrl,company,name,sex,age,position,level) values(7,11,"public/votegroup/shunanqikuangshida/photo/qiuzongyi.jpg","泸州采气作业区","邱宗毅","男",36,"中心站站长 ","采气工/技师(未聘任)");
insert into countvoting (showOrder,id, photoUrl,company,name,sex,age,position,level) values(4,12,"public/votegroup/shunanqikuangshida/photo/wangjunli.jpg","纳溪采气作业区","王俊力","男",28,"助理工程师 ","/");
insert into countvoting (showOrder,id, photoUrl,company,name,sex,age,position,level) values(7,13,"public/votegroup/shunanqikuangshida/photo/zounibo.jpg","合江采气作业区","邹尼波","男",33,"生产技术室主任/工程师","/");
insert into countvoting (showOrder,id, photoUrl,company,name,sex,age,position,level) values(6,14,"public/votegroup/shunanqikuangshida/photo/lijian.jpg","渝西采气作业区","李健","男",28,"助理工程师 ","/");
insert into countvoting (showOrder,id, photoUrl,company,name,sex,age,position,level) values(5,15,"public/votegroup/shunanqikuangshida/photo/lanqikui.jpg","荣县天然气净化厂","兰启奎","男",28,"生产技术室副主任/助理工程师","/");
insert into countvoting (showOrder,id, photoUrl,company,name,sex,age,position,level) values(5,16,"public/votegroup/shunanqikuangshida/photo/tianjing.jpg","安岳油气处理厂","田婧","女",28,"生产技术室主任/助理工程师","/");
insert into countvoting (showOrder,id, photoUrl,company,name,sex,age,position,level) values(4,17,"public/votegroup/shunanqikuangshida/photo/dengfeiyong.jpg","勘探开发研究所","邓飞涌","男",35,"勘探室副主任/工程师","/");
insert into countvoting (showOrder,id, photoUrl,company,name,sex,age,position,level) values(7,18,"public/votegroup/shunanqikuangshida/photo/chenweizhi.jpg","工艺研究所","陈维志","男",35,"生产技术室主任/工程师","/");
insert into countvoting (showOrder,id, photoUrl,company,name,sex,age,position,level) values(5,19,"public/votegroup/shunanqikuangshida/photo/fengkelai.jpg","维修抢险中心","冯柯来","男",35,"生产技术室主任/工程师","/");
insert into countvoting (showOrder,id, photoUrl,company,name,sex,age,position,level) values(6,20,"public/votegroup/shunanqikuangshida/photo/wuyajie.jpg","泸州炭黑厂","邬娅洁","女",39,"生产技术室主任/工程师","/");
insert into countvoting (showOrder,id, photoUrl,company,name,sex,age,position,level) values(9,21,"public/votegroup/shunanqikuangshida/photo/zhaoyingding.jpg","试修作业中心","赵英丁","男",34,"生产技术室主任/工程师","/");
insert into countvoting (showOrder,id, photoUrl,company,name,sex,age,position,level) values(7,22,"public/votegroup/shunanqikuangshida/photo/chensiyang.jpg","汽车服务中心","陈锶洋","男",31,"/","驾驶员/中级");
insert into countvoting (showOrder,id, photoUrl,company,name,sex,age,position,level) values(11,23,"public/votegroup/shunanqikuangshida/photo/lianglonghua.jpg","消防大队","梁龙华","男",29,"/","消防员/中级");