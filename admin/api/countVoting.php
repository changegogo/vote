<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/8
 * Time: 18:49
 * 后台管理候选人投票数据展示接口
 */
header("Access-Control-Allow-Origin: *");
//header( 'Content-Type:text/html;charset=utf-8 ');
header('Content-type: application/json;charset=UTF-8');
//链接数据库
require("../../api/OperatorVotingDB.php");
$ovdb = new OperatorVotingDB();
//countVoting表
//导出表头（也就是表中拥有的字段）
$titles = array("name"=>"姓名","sex"=>"性别","age"=>"年龄","company"=>"公司","position"=>"职位","countVotes"=>"票数","rank"=>"排名");
foreach($titles as $key=>$item){
    if($key!="rank"){
        $t_field[] = $key;
    }
}
//导出数据
$data = array("code"=>200,"msg"=>"success","result"=>[]);
array_push($data["result"],$titles);

$res = $ovdb->getVoteDataToExcel();
$index = 0; // 排名
$befCountVotes = -1; // 上一位备选人的投票数
$curCountVotes = -1; // 当前备选人的投票数
while($row = mysqli_fetch_array($res)){
    $curCountVotes = intval($row["countVotes"]);
    if($curCountVotes!=$befCountVotes){
        $index++;
    }
    $befCountVotes = $curCountVotes;
    $item = array();
    foreach($t_field as $f_key){
        $item[$f_key]=$row[$f_key];
    }
    $item["rank"] = $index;
   array_push($data["result"],$item);
}
print_r(json_encode($data));
?>
