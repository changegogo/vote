<?php
/**
 * 操作数据库
 * 封装PDO，使其方便自己的操作
 */
class OperatorDB
{
    //root feicui123
    //连接数据库的基本信息
    //private $dbms='mysql';        //数据库类型,对于开发者来说，使用不同的数据库，只要改这个.
    private $host='127.0.0.1';      //数据库主机名
    private $dbName='vote';    //使用的数据库
    private $user='root';           //数据库连接用户名
    //private $passwd='snqk_mysqldb123';    //对应的密码
    private $passwd='feicui123';    //对应的密码
    private $pdo=null;
    private $dsn = "";
    // mysqli对象
    private $mysqli = null;

    public function  __construct(){
        $this->mysqli = new mysqli($this->host,$this->user,$this->passwd,$this->dbName);
        // 检测连接
        if ($this->mysqli->connect_error) {
            die("mysqli连接失败: " . $this->mysqli->connect_error);
        }
        mysqli_set_charset( $this->mysqli,"utf8");
    }
    public function __destruct(){
        $this->mysqli = null;
    }

    public function exec($sql){
        try {
            return $this->mysqli->query($sql);
        }
        catch(Exception $e) {
            die("<br/>exec()失败(exec()Failed！): ".$e->getMessage()."<br/>");
        }
    }
    public function query($sql){
        try{
            //$this->mysqli->query("set names 'utf8'");
            return $this->mysqli->query($sql);
        }
        catch(Exception $e) {
            die("<br/>query()失败(exec()Failed！): ".$e->getMessage()."<br/>");
        }
    }
}
?>
