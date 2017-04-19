<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/18
 * Time: 16:41
 * 提交投票组信息
 */

header("Access-Control-Allow-Origin: *");
//header('Content-type: application/json;charset=UTF-8');
// 获取post提交过来的数据，并进行解析
$postData = json_decode(@file_get_contents("php://input"),true);
if(!empty($postData)){
    $name = $postData["name"];
    $explain = $postData["explain"];
    $titlePicUrl = $postData["titlePicUrl"];
    $ruleDes = $postData["ruleDes"];
    $effectStartTime = $postData["effectStartTime"];
    $effectEndTime = $postData["effectEndTime"];
    $candidateTime = $postData["candidateTime"];
    $ipLimit = $postData["ipLimit"];
    // 链接数据库
    require("../../api/OperatorVotingDB.php");
    $ovdb = new OperatorVotingDB();
    $r = $ovdb->updateVoteGroupInfo($name,$explain,$titlePicUrl,$ruleDes,$effectStartTime,$effectEndTime,$candidateTime,$ipLimit);

    if($r){
        $arr = array("code"=>200,"msg"=>"success");
        echo(json_encode($arr));
    }else{
        $arr = array("code"=>201,"msg"=>"falil");
        echo(json_encode($arr));
    }

}else{
    $arr = array("code"=>201,"msg"=>"falil");
    echo(json_encode($arr));
}




