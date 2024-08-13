<!--

//AJAX 管理登入
$(document).ready(function(){
	$('div#notice').hide();
	$('#adminLoginForm').submit(function(){ 
		$('#adminLoginForm').ajaxSubmit({
			target: 'div#notice',
			type: "POST",
			url: 'post.php?adminlog=log',
			success: function(msg) {
				if(msg=="OK"){
					$('div#notice').hide();
					top.location='base/admin/index.php';
				}else{
					$('div#notice').show();
				}
			}
		}); 
       
		return false; 

   }); 
});


//更新圖形碼
$(document).ready(function() {
	$("img#codeimg").click(function () { 
		$("img#codeimg")[0].src="codeimg.php?"+Math.round(Math.random()*1000000);
	 });
});



-->