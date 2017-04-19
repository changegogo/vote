<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
	//首页
    public function index(){
    	$menu = M('Menu')->where("pid = '0'")->order('orderby')->select();
    	$this -> assign('menu',$menu);
    	$node = M('Menu')->where("pid != '0'")->select();
    	$this -> assign('node',$node);
    	//dump($menu);dump($node);die;
        $this -> display();
    }
}