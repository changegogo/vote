<?php
require_once('./api/OperatorVotingDB.php');
$ovdb = new OperatorVotingDB();
// 获取投票组信息
$voteGroup = $ovdb->getVotesGroupInfo();
// 循环取出记录
$voteGroupInfo=mysqli_fetch_assoc($voteGroup);
// 投票开始时间
$effectStartTime = $voteGroupInfo["effectStartTime"];
// 投票结束时间
$effectEndTime = $voteGroupInfo["effectEndTime"];
// 系统当前时间戳
$curTime = time();
// 开始时间戳
$startTime = strtotime($effectStartTime);
// 结束时间戳
$endTime = strtotime($effectEndTime);
if($curTime-$startTime>0 && $curTime-$endTime<0){
    require ("index.html");
}else if($curTime-$startTime<=0){
    echo "投票时间还未到，2017年4月17日开始";
}else if($curTime-$endTime>=0){
    echo "已过投票时间，2017年4月27日结束,下次再来吧";
}
?>