<?php
namespace Home\Controller;
use Think\Controller;
class TestController extends Controller {
	//��ҳ
    public function index(){
    	echo __URL__;
    }
}