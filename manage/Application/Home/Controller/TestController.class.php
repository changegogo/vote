<?php
namespace Home\Controller;
use Think\Controller;
class TestController extends Controller {
	//สืาณ
    public function index(){
    	echo __URL__;
    }
}