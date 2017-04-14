<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/8
 * Time: 18:49
 * 投票页面信息数据接口
 */
// 判断前端中是否有对应的cookie
// 如果没有就生成一个
/*$seq = "";
if(!isset($_GET["seqVote"]) || $_GET["seqVote"]==""){
    // 生成token
    $seq = require_once ("sequece.php");
}else{
    $seq = $_GET["seqVote"];
}*/

require_once('OperatorVotingDB.php');
$ovdb = new OperatorVotingDB();
// 获取投票组信息
$voteGroup = $ovdb->getVotesGroupInfo();
//   循环取出记录
$voteGroupInfo = "";
while ($row=mysqli_fetch_assoc($voteGroup))
{
    $voteGroupInfo = $row;
}
$curTime = date("Y-m-d H:i:s");
$voteGroupInfo["curSysTime"] = $curTime;
//获取23名候选人信息
$personAll = $ovdb->getVotesSortByCount();
$personsInfo = array();
while ($row=mysqli_fetch_assoc($personAll))
{
    array_push($personsInfo,$row);
}

// 引入候选人信息类
$resultArr = array("voteGroupInfo"=>$voteGroupInfo, "personsInfo"=>$personsInfo);

$arr = array("code"=>200,"msg"=>"成功","results"=>$resultArr);
header("Access-Control-Allow-Origin: *");
header('Content-type: application/json;charset=UTF-8');
print_r(json_encode($arr));