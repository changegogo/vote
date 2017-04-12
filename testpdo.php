<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/12
 * Time: 11:17
 */
$servername = "localhost";
$username = "root";
$password = "feicui123";

try {
    $conn = new PDO("mysql:host=$servername;dbname=vote", $username, $password);
    echo "PDO连接成功";
}
catch(PDOException $e)
{
    echo $e->getMessage();
}