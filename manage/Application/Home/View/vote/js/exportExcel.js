$(function(){
	/***点击导出按钮导出数据**/
	$(".exportBtn").click(function(){
		window.location="/vote/admin/api/excel.php";
	});
	
	/*****exportExcel.html    table数据*******/
	function chaxun() {
		var url = "/vote/admin/api/countVoting.php";
		$.ajax({
			url: url,
            type: "get",
			success : function(data) {
				//console.log(data);
				
				if (data.length == 0) {
					alert("当前查询无结果！");
				}
				 if(data.code==200){
				 	$("#data_body").empty();
				 	/**动态加载表格数据**/
				 	$(data.result).each(function(i) {
					var $tr = $("<tr align='center' height='20px' color='#fff'</tr>"); //表格的一行，在里面可以加各种属性;  
					var $td = $("<td width='16% '></td>"); //行中的元素  
					for (var perResult in data.result[i]){
						console.log(data.result[i][perResult])
						$tr.append($td.clone().text(data.result[i][perResult]));
						$tr.appendTo($("#data_body")); //别忘了最后要把内容放入前面的tbody  
					}
				});
			}
		},
		error : function(err) {
			alert('error');
		}
		});
	}
	chaxun();
})
