$(document).ready(function(){

	$('#ordersend').click(function(id){
		
		var email = $("#orderemail").val();
		email = email.toLowerCase();
		var order = $('#paperorder').val();
		var patrn=/^[_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,3}$/;
		if(!patrn.exec(email)){
			LoadMsg("電子郵件格式不正確，請輸入正確的電子郵件！");
		}else{
			var email = encodeURI(email);
		 	$.ajax({
				type: "POST",
				url: PDV_RP+"paper/post.php",
				data: "act=paperorder&email="+email+"&order="+order,
				success: function(msg){
					if(msg == "OK"){
						LoadMsg("謝謝您，電子報訂閱成功！");
					}else if(msg == "DELOK"){
						LoadMsg("謝謝您，已經成功取消訂閱！");
					}else if(msg == "ALREADY"){
						LoadMsg("謝謝您，您已經訂閱過了！");
					}else if(msg == "NONE"){
						LoadMsg("您的電子信箱不存在於資料庫，不用取消訂閱！");
					}else{
						LoadMsg("系統出錯，請重新操作。");
						LoadMsg(msg);
					}
				}
			});
		}
	}); 
}); 


$(document).ready(function(){

	if($("#orderemail")[0].value==""){

		$("#orderemail").focus(function(){

			$("#orderemail")[0].value="";

		});

	}

	$("#ordersend").mouseover(function(){

			if($("#orderemail")[0].value=="請輸入e-mail"){

				$("#orderemail")[0].value="";

			}

	});

});

