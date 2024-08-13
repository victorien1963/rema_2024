<!--

//頁面加載時根據是否登入顯示不同
$(document).ready(function(){
	$.ajax({
		type: "POST",
		url:PDV_RP+"post.php",
		data: "act=isLogin",
		success: function(msg){
			if(msg=="1"){
				$("div#loginform_notLogin").hide();
				$("div#loginform_isLogin").show();
				$("span#loginform_username").html(getCookie("MUSER"));
					$.ajax({
						type: "POST",
						url:PDV_RP+"member/post.php",
						data: "act=countmsn",
						success: function(msg){
							$("span#loginform_countmsn").html(msg);
						}
					});
			}else{
				$("div#loginform_isLogin").hide();
				$("div#loginform_notLogin").show();
			}
		}
	});
});


//會員登入
$(document).ready(function(){
	
	$('#loginform_Form').submit(function(){ 
		$('#loginform_Form').ajaxSubmit({
			target: 'div#loginnotice',
			url: PDV_RP+'post.php',
			success: function(msg) {
				if(msg=="OK" || msg.substr(0,2)=="OK"){
					/*$('div#loginnotice').hide();
					$("div#loginform_notLogin").hide();
					$("div#loginform_isLogin").show();
					$("span#loginform_username").html(getCookie("MUSER"));*/
					//window.location=PDV_RP+'member/index.php';
					var newurl = msg.split("_");
					if(newurl[1]){
						//window.location=PDV_RP;
						location.reload();
					}else{
						window.location=PDV_RP;
					}
					
				}else{
					//$('div#loginnotice').hide();
					alert(msg);
				}
			}
		}); 
       
		return false; 

   }); 
});

//會員退出
$(document).ready(function(){
	
	$('#loginform_logout').click(function(){ 
		
		$.ajax({
			type: "POST",
			url: PDV_RP+"post.php",
			data: "act=memberlogout",
			success: function(msg){
				if(msg=="OK"){
					$("div#loginform_isLogin").hide();
					$("div#loginform_notLogin").show();
				}else{
					alert(msg);
				}
			}
		});
	

   }); 
});


//更新圖形碼
$(document).ready(function() {

	$("img#loginCodeimg").click(function () { 
		$("img#loginCodeimg")[0].src=PDV_RP+"codeimg.php?"+Math.round(Math.random()*1000000);
	 });

});
-->