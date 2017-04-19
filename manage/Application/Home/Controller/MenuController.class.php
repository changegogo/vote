<?php
namespace Home\Controller;
use Think\Controller;
class MenuController extends Controller {
	//菜单列表
    public function index(){

    	$data = M('Menu')->order('orderby')->select();
    	$data = getNodeTree($data);
    	//dump($data);die;
    	$this -> assign('data',$data);
        $this -> display();
    }
    //添加菜单
    function add(){
    	if (IS_POST) {
    		$data = I('post.');
    		//dump($data);
    		$result = M('Menu')->add($data);
    		if ($result) {
    			$this -> success('添加成功',__ROOT__.'/Home/Menu/index');
    		} else {
    			$this -> error('添加失败',__ROOT__.'/Home/Menu/add');
    		}
    		
    	}else{
	    	$data = M('Menu')->where("pid = '0'")->select();
	    	$this -> assign('data',$data);
	    	$this -> display();	
    	}
    }
    //删除菜单
    function delete(){
    	$id = I('get.id');
    	$result = M('Menu')->delete($id);
    	//dump($result);die;
    	if ($result) {
    			$this -> success('删除成功',__ROOT__.'/Home/Menu/index');
    	} else {
    			$this -> error('删除失败',__ROOT__.'/Home/Menu/index');
    	}
    }
    //修改节点
    public function update(){
        if (IS_POST) {
        	$data = I('post.');
            //dump($data);die;
            //dump(M('Menu') -> save($data));die;
            if(M('Menu') -> save($data)){
                $this -> success('修改成功',U('index'),3);
            }else{
                $this -> error('修改失败',U('index'),3);
            }
        } else {
            //下拉菜单选项
            $Menu = M('Menu')->field('mid,mname')->where("mlevel = '1'")->select();
            $this -> assign('Menu',$Menu);
            //当前数据
            $id = I('get.id');
            $data = M('Menu')->find($id);
            $this -> assign('data',$data);
            $this -> display();
        }
    }
   
}