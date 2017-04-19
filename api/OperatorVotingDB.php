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
     *  清空ipvotes表中的数据；设置countvoting表中的票数为0
     * 调用数据库操作类，执行clear数据库的操作
     */
    public function clearSetZeroTables()
    {
        $sqls = array("TRUNCATE ipvotes;", "UPDATE countvoting SET countVotes=0;");
        $this->odb->query($sqls[0]);
        $this->odb->query($sqls[1]);
    }

    /**
     * 重置count_voting表中的CountValues字段为0
     */
    public function resetCountValues()
    {
        $sql = "UPDATE countvoting SET countVotes = 0;";
        $this->odb->query($sql);
    }

    /**
     * 投票
     * 将信息写入ip_votes表
     * @param type $ip
     * @param type $loc
     * @param type $time
     * @param type $name
     */
    public function vote($ip, $id, $seq="0")
    {
        // 插入语句
        $sql = "INSERT INTO ipvotes (serialNumber, ip, voteTime, countVotingId) VALUES (1, '$ip', NOW(), '$id')";
        $subsql = "SELECT count(ip) as num FROM ipvotes WHERE serialNumber=1 AND ip='$ip' AND TO_DAYS(voteTime)=TO_DAYS(NOW()) AND countVotingId='$id'";
        $stm = $this->odb->query($subsql);
        $row=mysqli_fetch_array($stm);
        $num = intval($row["num"]);
        //$c = count($row);
        // 每个IP地址对每位候选人24小时内限投一次
        if ($num>=1) {
            return "您已经对此人投过票了";
        }
        // 每个IP地址每天投票总数不超过10票
        $oversql = "SELECT count(ip) as num FROM ipvotes WHERE serialNumber=1 AND TO_DAYS(voteTime) = TO_DAYS(NOW()) AND IP='$ip' AND seq='$seq'";
        $stm = $this->odb->query($oversql);
        $arr = mysqli_fetch_array($stm);
        $n =  intval($arr["num"]);
        if($n>=10){
            return "每天最多投10次票";
        }else{
            $istrue = $this->odb->query($sql);
            if($istrue){
                return "投票成功";
            }else{
                return "投票失败";
            }
        }
    }

    /**
     * 添加countVoting字段的行
     *
     * @param string $name
     * @param string $label
     * @param int $count
     */
    public function addCountVoting($name, $label, $count = 0)
    {
        $sql = "INSERT INTO countvoting VALUES ('$name', '$label', $count);";
        $this->odb->query($sql);
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

    public function getSequeceValue(){
        $sql = "SELECT NEXTVAL('seq') as value;";
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
        $sql = "SELECT * FROM countvoting ORDER BY name DESC;";
        //  echo $sql;
        return $this->odb->query($sql);
    }
    /*
     * 获取要导出的数据
     * */
    public function getVoteDataToExcel(){
        $sql = "select name,sex,age,company,countVotes,position from countvoting order by countVotes desc;";
        return $this->odb->query($sql);
    }

    /*
     * 投票组信息获取
     * */
    public function getVoteGroupInfo(){
        $sql = "select * from votegroupinfo;";
        return $this->odb->query($sql);
    }

    /*
     * 更新投票组信息 表votegroupinfo
     * @param string $name
     * @param string $explain
     * @param string $titlePicUrl
     * @param string $ruleDes
     * @param string $effectStartTime
     * @param string $effectEndTime
     * @param string $candidateTime
     * @param string $ipLimit
     * */
    public function updateVoteGroupInfo($name, $explain,
                                        $titlePicUrl, $ruleDes,
                                        $effectStartTime,
                                        $effectEndTime, $candidateTime,
                                        $ipLimit){
        $sql = "UPDATE votegroupinfo SET name='$name', explain='$explain', titlePicUrl='$titlePicUrl', ruleDes='$ruleDes', effectStartTime='$effectStartTime', effectEndTime='$effectEndTime',candidateTime='$candidateTime',ipLimit='$ipLimit';";
        return $this->odb->query($sql);
    }
}

?>
