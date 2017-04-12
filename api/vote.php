<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/8
 * Time: 21:50
 * 投票接口
 */
if(isset($_POST["id"]) && isset($_POST["seqVote"])){
    require_once("../lib/func.php");
    require_once ('./OperatorVotingDB.php');
    $id = intval($_POST["id"]); // $id 是整型
    $ip = getClientIP();
    $ovdb = new OperatorVotingDB();
    $seqVote = intval($_POST["seqVote"]); // 拿到序列值
    $msg = $ovdb->vote($ip, $id, $seqVote);
    if($msg == '投票失败，相同ip需要隔一天才能投票'){
        header('Content-type: application/json');
        $arr = array("code"=>201, "msg"=>$msg);
        header("Access-Control-Allow-Origin: *");
        header('Content-type: application/json');
        echo json_encode($arr);
    }else if($msg == '投票成功'){
        require_once ("info.php");
    }else{
        header("Access-Control-Allow-Origin: *");
        header('Content-type: application/json');
        $arr = array("code"=>202, "msg"=>$msg);
        echo json_encode($arr);
    }
}else{
    header("Access-Control-Allow-Origin: *");
    header('Content-type: application/json');
    $arr = array("code"=>203, "msg"=> "投票失败,缺少id");
    echo json_encode($arr);
}
