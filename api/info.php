<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/8
 * Time: 18:49
 * 投票页面信息数据接口
 */
require_once('OperatorVotingDB.php');
$ovdb = new OperatorVotingDB();
// 获取投票组信息
$voteGroup = $ovdb->getVotesGroupInfo();
$voteGroup->setFetchMode(PDO::FETCH_ASSOC);
$arr = $voteGroup->fetchAll();
$voteGroupInfo = $arr[0];

//获取23名候选人信息
$row = $ovdb->getVotesSortByCount();
$row->setFetchMode(PDO::FETCH_ASSOC);
$personsInfo = $row->fetchAll();
// 引入候选人信息类
$resultArr = array("voteGroupInfo"=>$voteGroupInfo, "personsInfo"=>$personsInfo);
$arr = array("code"=>200,"msg"=>"成功","results"=>$resultArr);
header("Access-Control-Allow-Origin: *");
header('Content-type: application/json');
print_r(json_encode($arr));