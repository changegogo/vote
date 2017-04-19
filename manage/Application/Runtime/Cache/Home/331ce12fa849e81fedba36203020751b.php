<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="/vote/manage/Public/css/base.css" />
<link rel="stylesheet" href="/vote/manage/Public/css/info-reg.css" />
<title>移动办公自动化系统</title>
<style>
	.main p input {
		float:none;
	}
</style>
</head>

<body>
<div class="title"><h2>信息登记</h2></div>
<div class="main">
	<form action="/vote/manage/index.php/Home/Menu/add" method="post">
    <p class="short-input ue-clear">
    	<label>菜单名：</label>
        <input type="text" name="mname" placeholder="节点名" />
    </p>
    <div class="short-input select ue-clear">
    	<label>上级菜单：</label>
        <select name="pid">
        	<option value="0">顶级节点</option>
        	<?php if(is_array($data)): foreach($data as $key=>$value): ?><option value="<?php echo ($value["mid"]); ?>"><?php echo ($value["mname"]); ?></option><?php endforeach; endif; ?>
        </select>
    </div>
     <p class="short-input ue-clear">
        <label>路径：</label>
        <input type="text" name="mpath" placeholder="例如：/Home/Main/index" />
    </p>
    <p class="short-input ue-clear">
    	<label>级别：</label>
        <input type="text" name="mlevel" placeholder="级别 顶级菜单为0" />
    </p>
    <p class="short-input ue-clear">
        <label>排序编号：</label>
        <input type="text" name="orderby" placeholder="排序编号" />
    </p>
</div>
<div class="btn ue-clear">
	<a href="javascript:;" class="confirm">确定</a>
    <a href="javascript:;" class="clear">清空内容</a>
</div>
</form>
</body>
<script type="text/javascript" src="/vote/manage/Public/js/jquery.js"></script>
<script type="text/javascript" src="/vote/manage/Public/js/common.js"></script>
<script type="text/javascript" src="/vote/manage/Public/js/WdatePicker.js"></script>
<script type="text/javascript">
$('.confirm').click(function(){
	$('form').submit();
})
$(".select-title").on("click",function(){
	$(".select-list").toggle();
	return false;
});
$(".select-list").on("click","li",function(){
	var txt = $(this).text();
	$(".select-title").find("span").text(txt);
});


showRemind('input[type=text], textarea','placeholder');
</script>
</html>