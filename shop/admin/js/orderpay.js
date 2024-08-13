
//付款確認
$(document).ready(function(){
	
	$("#orderpaychk").click(function(){
		var orderid=$("input#orderid")[0].value;
		$.ajax({
			type: "POST",
			url:"post.php",
			data: "act=orderpaychk&orderid="+orderid,
			success: function(msg){
				if(msg=="OK"){
					parent.location.reload();
				}else if(msg=="1000"){
					alert("訂單不存在");
				}else if(msg=="1001"){
					alert("訂單是已付款狀態，不能重複付款確認");
				}else if(msg=="1002"){
					alert("訂單已退訂，不能進行付款確認");
				}else if(msg=="1003"){
					alert("訂單已完成，不能進行付款確認");
				}else if(msg=="1004"){
					alert("會員不存在，可能已刪除");
				}else if(msg=="1005"){
					alert("會員帳戶餘款不足，不能進行付款確認");
				}else{
					alert(msg);
				}
			}
		});
	});
});


//退款確認
$(document).ready(function(){
	
	$("#orderunpay").click(function(){
		var orderid=$("input#orderid")[0].value;
		$.ajax({
			type: "POST",
			url:"post.php",
			data: "act=orderunpay&orderid="+orderid,
			success: function(msg){
				if(msg=="OK"){
					parent.location.reload();
				}else if(msg=="1000"){
					alert("訂單不存在");
				}else if(msg=="1001"){
					alert("訂單是未付款狀態，不能進行退款確認");
				}else if(msg=="1002"){
					alert("訂單已退訂，不能進行退款確認");
				}else if(msg=="1003"){
					alert("訂單已完成，不能進行退款確認");
				}else if(msg=="1004"){
					alert("本訂單是會員訂單，但會員不存在，可能已刪除");
				}else if(msg=="1005"){
					alert("本訂單是網路平台訂單，已取消付款記錄");
				}else{
					alert(msg);
				}
			}
		});
	});
});


