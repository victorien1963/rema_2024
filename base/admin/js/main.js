<!--
$(document).ready(function(){
	$.ajax({
		type: "POST",
		url: "post.php",
		data: "act=chkPwCode",
		success: function(msg){
		}
	});
});


/**
* 排版和瀏覽前台
*/
$(document).ready(function(){
	
	$("#modauth").click(function () { 
		window.open(PDV_RP+"base/admin/auth_modauth1.php","mainframe");
	 });
	$("#modpass").click(function () { 
		window.open(PDV_RP+"base/admin/auth_modpass.php","mainframe");
	 });
	
	$("#preview").click(function () { 
		window.open(PDV_RP+"index.php","_blank");
	 });
	
	 $("#pedit").click(function () { 
		$.ajax({
			type: "POST",
			url: "../../post.php",
			data: "act=plusready",
			success: function(msg){
				if(msg=="OK"){
					//mainframe.location=PDV_RP+"index.php";
					window.open(PDV_RP+"index.php","_blank");
				}else if(msg=="NORIGHTS"){
					alert("目前管理帳號沒有排版權限");
					return false;
				}
			}
		});
		
	 });

});



//AJAX 管理退出
$(document).ready(function(){
	$("#pdv_logout").click(function () { 
		$.ajax({
			type: "POST",
			url: PDV_RP+"post.php",
			data: "act=adminlogout",
			success: function(msg){
				if(msg=="OK"){
					window.location=PDV_RP+"admin.php";
				}else{
					alert(msg);
				}
				
			}
		});
	 });
});





-->
	
$('iframe').iFrameResize({
	scrolling: true
});