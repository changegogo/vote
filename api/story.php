<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/8
 * Time: 21:29
 * 候选人事迹数据接口
 */
if(isset($_GET["name"])){
    // 获取汉字的拼音
    require_once ("../lib/pinyin.php");
    $p = get_pinyin("蜀南气矿十大");
    $path = "../public/votegroup/".$p."/story/".$_GET["name"].".txt";
    $myfile = fopen($path, "r") or die("没有找到个人事迹");
    header('Content-Type: text/html; charset=utf-8');
    header("Access-Control-Allow-Origin: *");
    echo "<pre>";
    echo fread($myfile,filesize($path));
    echo "</pre>";
    fclose($myfile);
}else{
    echo "请输入姓名";
}