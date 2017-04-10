<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/8
 * Time: 19:26
 */
class Info{
    public $code;
    public $msg;
    public $results;
    function __construct($code, $msg, $results)
    {
        $this->code = $code;
        $this->msg = $msg;
        $this->results = $results;
    }
    public function getCode(){
        return $this->code;
    }
    public function getMsg(){
        return $this->msg;
    }
    public function getResults(){
        return $this->results;
    }
}