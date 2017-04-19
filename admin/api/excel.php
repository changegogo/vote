<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/8
 * Time: 18:49
 * 后台管理候选人投票数据导出excel表格
 */
$filename = "vote.xls";
//$filename = iconv("utf-8","gb2312",$filename);
header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:filename=$filename");
// END 配置
//链接数据库
require("../../api/OperatorVotingDB.php");
$ovdb = new OperatorVotingDB();

//countVoting表
echo "<table style='border:0.5px solid #000'><tr>";
//导出表头（也就是表中拥有的字段）
$titles = array("name"=>"姓名","sex"=>"性别","age"=>"年龄","company"=>"公司","countVotes"=>"票数","rank"=>"排名");
foreach($titles as $key=>$item){
    if($key!="rank") {
        $t_field[] = $key;
    }
    echo "<th style=\"border: solid 0.5px #000; height: 20px;\">".$item."</th>";
}
echo "</tr>";
//导出数据
$res = $ovdb->getVoteDataToExcel();
$index = 0; // 排名
$befCountVotes = -1; // 上一位备选人的投票数
$curCountVotes = -1; // 当前备选人的投票数
while($row = mysqli_fetch_array($res)){
    echo "<tr>";
    $curCountVotes = intval($row["countVotes"]);
    if($curCountVotes!=$befCountVotes){
        $index++;
    }
    $befCountVotes = $curCountVotes;
    foreach($t_field as $f_key){
        echo "<td style=\"border: solid 0.5px #000; height: 20px;\">".$row[$f_key]."</td>";
    }
    echo "<td style=\"border: solid 0.5px #000; height: 20px;\">".$index."</td>";
    echo "</tr>";
}
echo "</table>";
?>
