<?php
/**
 * 页面跳转函数
 * 使用js实现
 * @param string $url
 */
function goToPage($url)
{
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
}

function isLoginNow()
{
    if (!isset($_COOKIE["user"])) {
        return false;
    }
    return true;
}
/*
 * 获取客户端ip地址
 * */
function getClientIP()
{
    if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
        if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $proxy = $_SERVER["HTTP_CLIENT_IP"];
        } else {
            $proxy = $_SERVER["REMOTE_ADDR"];
        }
        $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    } else {
        if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } else {
            $ip = $_SERVER["REMOTE_ADDR"];
        }
    }
    return $ip;
}

?>
