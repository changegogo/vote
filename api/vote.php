<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/8
 * Time: 21:50
 * 投票接口
 */
// 判断是否在有效时间
date_default_timezone_set("PRC");
require_once('./OperatorVotingDB.php');
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
$curTime = strtotime(date("Y-m-d"));
// 开始时间戳
$startTime = strtotime($effectStartTime);
// 结束时间戳
$endTime = strtotime($effectEndTime);
if($curTime-$startTime<0){
    header("Access-Control-Allow-Origin: *");
    header('Content-type: application/json;charset=UTF-8');
    $arr = array("code"=>204, "msg"=> "投票时间还未到");
    echo json_encode($arr);
    return;
}else if($curTime-$endTime>0){
    header("Access-Control-Allow-Origin: *");
    header('Content-type: application/json;charset=UTF-8');
    $arr = array("code"=>204, "msg"=> "投票时间已过");
    echo json_encode($arr);
    return;
}
// 在投票时间范围内
if(isset($_POST["id"])){
    require_once("../lib/func.php");
    require_once ('./OperatorVotingDB.php');
    $id = intval($_POST["id"]); // $id 是整型
    $ip = getClientIP();
    $ovdb = new OperatorVotingDB();
    //$seqVote = intval($_POST["seqVote"]); // 拿到序列值
    $msg = $ovdb->vote($ip, $id);
    if($msg == '投票失败，相同ip需要隔一天才能投票'){
        header('Content-type: application/json');
        $arr = array("code"=>201, "msg"=>$msg);
        header("Access-Control-Allow-Origin: *");
        header('Content-type: application/json;charset=UTF-8');
        echo json_encode($arr);
    }else if($msg == '投票成功'){
        require_once ("info.php");
    }else{
        header("Access-Control-Allow-Origin: *");
        header('Content-type: application/json;charset=UTF-8');
        $arr = array("code"=>202, "msg"=>$msg);
        echo json_encode($arr);
    }
}else{
    header("Access-Control-Allow-Origin: *");
    header('Content-type: application/json;charset=UTF-8');
    $arr = array("code"=>203, "msg"=> "投票失败,缺少id");
    echo json_encode($arr);
}
