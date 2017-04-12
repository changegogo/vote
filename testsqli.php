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

// 创建连接
$conn = new mysqli($servername, $username, $password);

// 检测连接
if ($conn->connect_error) {
    die("mysqli连接失败: " . $conn->connect_error);
}
echo "mysqli连接成功";