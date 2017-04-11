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
                		console.log(index+"-->"+item);
                		$(this).find(".votecount").html(data.results.personsInfo[index].countVotes);
                		
                	})
                		
                }
	            alert(data.msg);
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
            	$(".textArea").html(data).css("font-size","14px");
				$(".name").html(name);
            },
            error: function (err) {

            }
        });
    });
    
   
	$(".closeKuang").click(function(){
		$(".innerDetailBox").animate({scrollTop:0},0);
		$(".detailBox").css("display","none");
	})
	
	
	
	
		

	
	
})