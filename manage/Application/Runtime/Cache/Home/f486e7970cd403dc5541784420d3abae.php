<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="/vote/manage/Public/css/base.css" />
<link rel="stylesheet" href="/vote/manage/Public/css/info-mgt.css" />
<link rel="stylesheet" href="/vote/manage/Public/css/WdatePicker.css" />
<title>移动办公自动化系统</title>
<style type='text/css'>
	table tr .num{ width:63px; text-align: center;}
	table tr .name{ width:63px; padding-left:17px;}
	table tr .nickname{ width:63px; padding-left:13px;}
	table tr .dept{ width:63px; padding-left:13px;}
	table tr .role{ width:63px; padding-left:13px;}
	table tr .sex{ width:63px; padding-left:13px;}
	table tr .birthday{ width:63px; padding-left:13px;}
	table tr .tel{ width:63px; padding-left:13px;}
	table tr .email{ width:63px; padding-left:13px;}
	table tr .ctime{ width:63px; padding-left:13px;}
	table tr .operate{ width:63px; padding-left:15px;}
	table tr .operate a{ color:#2c7bbc;}
	table tr .operate a:hover{ text-decoration:underline;}
</style>
</head>

<body>
<div class="title"><h2>信息管理</h2></div>
<div class="table-operate ue-clear">
	<a href="/vote/manage/index.php/Home/Menu/add" class="add">添加</a>
    <a href="javascript:;" class="del">删除</a>
    <a href="javascript:;" class="edit">编辑</a>
    <a href="javascript:;" class="count">统计</a>
    <a href="javascript:;" class="check">审核</a>
</div>
<div class="table-box">
	<table>
    	<thead>
        	<tr>
            	<th class="num">序号</th>
                <th class="name">菜单名称</th>
                <th class="email">上级菜单</th>
                <th class="birthday">路径</th>
                <th class="tel">级别</th>
                <th class="tel">排序编号</th>
                <th class="operate">操作</th>
            </tr>
        </thead>
        <tbody>
        	<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
            	<td class="num"><?php echo ($vo["mid"]); ?></th>
                <td class="name">
                	<?php echo (str_repeat('---',$vo["mlevel"])); echo ($vo["mname"]); ?>
                </th>
                <td class="nickname"><?php echo ($vo["pid"]); ?></th>
                <td class="dept"><?php echo ($vo["mpath"]); ?></th>
                <th class="tel"><?php echo ($vo["mlevel"]); ?></th>
                <th class="tel"><?php echo ($vo["orderby"]); ?></th>
                <th class="operate">
                    <a href="/vote/manage/index.php/Home/Menu/update/id/<?php echo ($vo["mid"]); ?>">修改</a>|
                    <a href="/vote/manage/index.php/Home/Menu/delete/id/<?php echo ($vo["mid"]); ?>">删除</a>
                </th>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
</div>
<div class="pagination ue-clear"></div>
</body>
<script type="text/javascript" src="/vote/manage/Public/js/jquery.js"></script>
<script type="text/javascript" src="/vote/manage/Public/js/common.js"></script>
<script type="text/javascript" src="/vote/manage/Public/js/WdatePicker.js"></script>
<script type="text/javascript" src="/vote/manage/Public/js/jquery.pagination.js"></script>
<script type="text/javascript">
$(".select-title").on("click",function(){
	$(".select-list").hide();
	$(this).siblings($(".select-list")).show();
	return false;
})
$(".select-list").on("click","li",function(){
	var txt = $(this).text();
	$(this).parent($(".select-list")).siblings($(".select-title")).find("span").text(txt);
})

$('.pagination').pagination(100,{
	callback: function(page){
		alert(page);	
	},
	display_msg: true,
	setPageNo: true
});

$("tbody").find("tr:odd").css("backgroundColor","#eff6fa");

//showRemind('input[type=text], textarea','placeholder');
</script>
</html>