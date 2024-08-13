

//會員帳戶扣款付款訂單
$(document).ready(function(){
	
	$('#memberpay').click(function(){ 
		var orderid=$("#orderid")[0].value;
		$.ajax({
			type: "POST",
			url: "post.php",
			data: "act=payfrommemberaccount&orderid="+orderid,
			success: function(msg){
				if(msg=="OK"){
					$().alertwindow("訂單付款成功","orderdetail.php?orderid="+orderid);
				}else if(msg=="1000"){
					alert("訂單不存在");
				}else if(msg=="1001"){
					alert("該訂單已經付過款了，不能重複付款");
				}else if(msg=="1002"){
					alert("該訂單已退訂，不能付款");
				}else if(msg=="1003"){
					alert("訂單付款方式不符，不能從會員帳戶扣款");
				}else if(msg=="1004"){
					alert("會員帳戶餘額不足");
				}else if(msg=="1005"){
					alert("會員帳號不存在");
				}else if(msg=="1006"){
					alert("您尚未登入");
				}else{
					alert(msg);
				}
			}
		});
	

   }); 
});

