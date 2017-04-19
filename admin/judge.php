<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/10
 * Time: 18:01
 */
require_once("User.php");
if(isset($_POST["user"]) && isset($_POST["passwd"])){
    $username = $_POST["user"];
    $password = $_POST["passwd"];
    $user = new User($username,$password );
    $isRight = $user->isRightUser();
    if($isRight){
        if(setcookie("user",$username,0,"/")){
            header("Access-Control-Allow-Origin: *");
            header('Content-type: application/json;charset=UTF-8');
            echo json_encode(array("code"=>200,"msg"=>"登录成功","href"=>"../manage/index.php"));
        }else{
            echo json_decode(array("code"=>201,"msg"=>"登录失败"));
        }
    }else{
        header("Access-Control-Allow-Origin: *");
        header('Content-type: application/json;charset=UTF-8');
        $arr = array("code"=>201, "msg"=>"用户名或密码错误");
        echo json_encode($arr);
    }
}else{
    echo "请从正确渠道登录";
}
