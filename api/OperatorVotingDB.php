<?php
require_once 'OperatorDB.php';

class OperatorVotingDB
{
    private $odb;
    public function __construct()
    {
        $this->odb = new OperatorDB();
    }
    public function __destruct()
    {
        $this->odb = null;
    }
    /**
     * 清空Voting数据中的所有表
     *
     * 调用数据库操作类，执行clear数据库的操作
     */
    public function clearTables()
    {
        $sqls = array("TRUNCATE ip_votes;", "TRUNCATE count_voting;");
        $this->odb->exec($sqls[0]);
        $this->odb->exec($sqls[1]);
    }

    /**
     * 重置count_voting表中的CountValues字段为0
     */
    public function resetCountValues()
    {
        $sql = "UPDATE count_voting SET CountVotes = 0;";
        $this->odb->exec($sql);
    }

    /**
     * 投票
     * 将信息写入ip_votes表
     * @param type $ip
     * @param type $loc
     * @param type $time
     * @param type $name
     */
    public function vote($ip, $id)
    {
        // 插入语句
        $sql = "INSERT INTO ipvotes (serialNumber, ip, voteTime, countVotingId) VALUES (1, '$ip', NOW(), '$id')";
        $subsql = "SELECT * FROM ipvotes WHERE serialNumber=1 AND ip='$ip' AND voteTime=NOW() AND countVotingId='$id'";
        $stm = $this->odb->query($subsql);
        // 每个IP地址对每位候选人24小时内限投一次
        if (count($row = $stm->fetchAll()) >= 1) {
            return "投票失败，同一ip需要隔一天才能投票";
        }
        // 每个IP地址每天投票总数不超过10票
        $oversql = "SELECT count(ip) as num FROM ipvotes WHERE TO_DAYS(voteTime) = TO_DAYS(NOW()) AND IP='$ip' AND serialNumber=1";
        $stm = $this->odb->query($oversql);
        $stm->setFetchMode(PDO::FETCH_ASSOC);
        $arr = $stm->fetchAll();
        $n =  intval($arr[0]["num"]);
        if($n>=10){
            return "每天最多投10次票";
        }else{
            $this->odb->exec($sql);
            return "投票成功";
        }

        /*********************/
        $sql = "INSERT INTO ipvotes (serialNumber, ip, voteTime, countVotingId) VALUES (1, '$ip', NOW(), '$id')";
        $subsql = "SELECT MAX(to_days(voteTime)) FROM ipvotes WHERE ip='$ip' AND countVotingId='$id'";
        $stm = $this->odb->query($subsql);
        // 每个IP地址对每位候选人24小时内限投一次
        if (count($row = $stm->fetchAll()) == 1) {
            $now = date("Y-m-d H:i:s");
            $subsql = "SELECT to_days('$now');";
            $stm = $this->odb->query($subsql)->fetch();
            $time = $stm[0];//使用mysql计算出的today时间
            if ($time - $row[0][0] < 1)//表中最大的时间和现在的时间$time比较
            {
                return "投票失败，同一ip需要隔一天才能投票";
            }
        }
        // 每个IP地址每天投票总数不超过10票
        $oversql = "SELECT count(ip) as num FROM ipvotes WHERE TO_DAYS(voteTime) = TO_DAYS(NOW()) AND IP='$ip' AND serialNumber=1";
        $stm = $this->odb->query($oversql);
        $stm->setFetchMode(PDO::FETCH_ASSOC);
        $arr = $stm->fetchAll();
        $n =  intval($arr[0]["num"]);
        if($n>=10){
            return "每天最多投10次票";
        }else{
            $this->odb->exec($sql);
            return "投票成功";
        }
    }

    /**
     * 添加SelectName字段的行
     *
     * @param string $name
     * @param string $label
     * @param int $count
     */
    public function addSelectName($name, $label, $count = 0)
    {
        $sql = "INSERT INTO count_voting VALUES ('$name', '$label', $count);";
        $this->odb->exec($sql);
    }

    /**
     * 获取总投票情况,按票数排序的结果
     *
     * 按CountVotes字段排序，返回count_voting表
     *
     * @param int $n
     *
     */
    public function getVotesSortByCount($n = -1)
    {
        $sql = "SELECT * FROM countVoting ORDER BY showOrder ASC LIMIT 0 , $n;";
        if (-1 == $n) {
            $sql = "SELECT * FROM countVoting ORDER BY showOrder ASC;";
        }
        //  echo $sql;
        return $this->odb->query($sql);
    }

    /**
     * 获取投票组信息
     *
     * 按
     *
     * @param int $n
     *
     */
    public function getVotesGroupInfo()
    {
        $sql = "SELECT * FROM votegroupinfo order by serialNumber DESC LIMIT 1;";

        //  echo $sql;
        return $this->odb->query($sql);
    }

    /**
     * 获取投票情况,按票数排序并按标签分组的结果
     *
     * 按CountVotes字段排序并按LabelName字段分组，返回count_voting表
     */
    public function getVotesGroupByLabel()
    {
        $sql = "SELECT * FROM count_voting ORDER BY LabelName DESC;";
        //  echo $sql;
        return $this->odb->query($sql);
    }
}

?>
