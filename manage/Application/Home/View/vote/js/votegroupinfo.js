$(function(){
	
	
	/*****votegroupinfo.html  数据显示*******/
	function chaxun() {
		var url = "/vote/admin/api/votegroup.php";
		$.ajax({
			url: url,
            type: "get",
			success : function(data) {
				//console.log(data);
				
				if (data.length == 0) {
					alert("当前查询无结果！");
				}
				/*var div = $(".inputContainer");*/
			   
				if(data.code==200){
					var files = ["name","explain","titlePicUrl","ruleDes","effectStartTime","effectEndTime","candidateTime","ipLimit"];
					
					/**动态加载表格数据**/
					for(var i=0;i<data.result.titles.length;i++){
						$(".text").eq(i).text(data.result.titles[i]);
					}
				 	$(data.result.titles).each(function(i) {
				 		/*$(".text").text(data.result.titles[i]);*/
				 		$(".input").eq(i).val(data.result.values[files[i]]);
				 	});	
				 	
				}
			},
			error : function(err) {
				alert('error');
			}
		});
	}
	chaxun();
	
	
	/*****votegroupinfo.html 数据上传 *******/
	 function uploadImg(){
        $("#upload").ajaxSubmit({
            url: "/vote/admin/api/uploadImg.php",
            type: "POST",
            success: function(data){
                alert(JSON.stringify(data));
                if(data.code==200){
                    $("#path").val(data.result.filepath);
                    $("#photo").attr("src",data.result.filepath);
                }

            }
        });
    }
	$(".picBtn").change(function(){
		 uploadImg();
	})
	
	$("textarea").each(function(){
		$(this).css("height",$(this).attr("scrollHeight"));
	});
	
	
	
	
	
})
