<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/15
 * Time: 23:40
 */
require_once("../api/OperatorDB.php");
class User
{
    private $user;
    private $passwd;
    public function __construct($u, $p)
    {
        $this->user = $u;
        $this->passwd = $p;
    }
    public function isRightUser(){
        //$isFind = false;
        $odb = new OperatorDB();
        $sql = "SELECT * FROM user WHERE userid='$this->user' AND passwd=MD5('$this->passwd')";
        $stm = $odb->query($sql);
        $row=mysqli_fetch_row($stm);
        $count = count($row);
        if($count>=1){
            return true;
        }else{
            return false;
        }
    }

}