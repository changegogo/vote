<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/18
 * Time: 15:33
 * 投票组信息
 */
header("Access-Control-Allow-Origin: *");
header('Content-type: application/json;charset=UTF-8');
// 标题
$titles = array("投票组名称","活动简介","标题图片地址","投票说明","生效开始日期","截止失效日期","备选数量","IP限制");
//链接数据库
require("../../api/OperatorVotingDB.php");
$ovdb = new OperatorVotingDB();
$res = $ovdb->getVoteGroupInfo();
$row = mysqli_fetch_assoc($res);
unset($row["serialNumber"]);
unset($row["optionMark"]);
unset($row["status"]);
unset($row["createTime"]);
unset($row["modifyTime"]);
$votegropInfo = array("code"=>200,"msg"=>"success","result"=>array("titles"=>$titles,"values"=>$row));
print_r(json_encode($votegropInfo));


