$(function(){

	/**更新照片和人物信息**/
	$.ajax({
            url: "http://20.14.3.175:8080/vote/api/info.php",
            type: "get",
            success: function(data){
            	var div = $(".eachPhoto.fl.div");
            	data.results.personsInfo.forEach(function(item,index){
            		var self = div.clone(true);
            		$(".photoContent").append(self.css("display","block").attr("class","eachPhoto fl "+"divAfter"));
            		self.find(".photoPic").attr("src",item.photoUrl);
            		self.find(".code").html(item.id);
	               	self.find(".company").html(item.company);
	                self.find(".name").html(item.name);
	                self.find(".sex").html(item.sex);
	                self.find(".age").html(item.age);
	                self.find(".position").html(item.position);
	                self.find(".level").html(item.level);
	               	self.find(".votecount").html(item.countVotes);
	                self.find(".photoPic").attr("src",item.photoUrl);
	            });
            	
            	/**更新活动简介内容**/
            	$(".activityBriefText").text(data.results.voteGroupInfo.explain);
            	/**投票说明三条信息**/	
            	var ruleDesArray = data.results.voteGroupInfo.ruleDes;
            	var newRuleDesArray = ruleDesArray.split("&");
            	$(".one").text(newRuleDesArray[0]);
            	$(".two").text(newRuleDesArray[1]);
            	$(".three").text(newRuleDesArray[2]);
            },
            error: function (err) {

        	}
        });
    /**点击投票按钮**/    
    $(".votingBtn").click(function () {
    	var _id = $(this).parents(".photoText").find(".code").text();
        $.ajax({
            url: "http://20.14.3.175:8080/vote/api/vote.php",
            type: "post",
            data:{
                id: _id
            },
            success: function(data){
                if(data.code==200){
                	$(".eachPhoto.divAfter").each(function(index,item){
                		$(this).find(".votecount").html(data.results.personsInfo[index].countVotes);
                		
                	})
                		
                }
                $(".votingKuangText").html(data.msg);
		        $(".votingKuang").css("display","block");
	           /*alert(data.msg);*/
            },
            error: function (err) {

            }
        });
    });
    // 点击事迹
    $(".story").click(function () {
       var name = $(this).parents(".photoText").find(".name").text();
        $.ajax({
            url: "http://20.14.3.175:8080/vote/api/story.php?name="+name,
            type: "get",
            success: function(data){
            	$(".detailBox").css("display","block");
            	$(".textAreaTxt").html(data).css("font-size","14px");
				$(".detailBoxName").html(name);
            },
            error: function (err) {

            }
        });
    });
    
    /***详细事迹弹出框的关闭****/
	$(".closeKuang").click(function(){
		$(".detailBox").css("display","none");
		$(".innerDetailBox").animate({scrollTop:0},0);
		
	})
	/***关闭投票按钮的弹出框***/
	$(".votingKuangCloseBtn").click(function(){
		$(".votingKuang").css("display","none");
	})
	

	
	
})