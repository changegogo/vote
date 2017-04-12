<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/11
 * Time: 22:13
 */
require_once('OperatorVotingDB.php');
$ovdb = new OperatorVotingDB();
// 获取自增的序列值
$seqValue = $ovdb->getSequeceValue();
$seqValue->setFetchMode(PDO::FETCH_ASSOC);
$seqValuearr = $seqValue->fetchAll();
$value = $seqValuearr[0]["value"];
return $value;