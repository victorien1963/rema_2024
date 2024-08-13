


//反映表單送出
$(document).ready(function(){
	$('#contact_form').submit(function(){ 
		$('#contact_form').ajaxSubmit({
			url: PDV_RP+'feedback/post.php',
			success: function(msg) {
				if(msg=="OK"){
					$('div#notice').hide();
					$().alertwindow("您的留言已送出，我們會盡快和您聯絡","");
					location.reload();
				}else{
					$('div#notice')[0].className='alert alert-warning';
					$('div#notice').show();
				}
			}
		}); 
       return false; 

   }); 
});


//全站反映表單送出
$(document).ready(function(){
	$('#feedbacksmallform').submit(function(){ 
		$('#feedbacksmallform').ajaxSubmit({
			url: PDV_RP+'feedback/post.php',
			success: function(msg) {
				if(msg=="OK"){
					LoadMsg("您的申請表單已送出，我們會盡快處理");
				}else{
					alert(msg);
				}
			}
		}); 
       return false; 
   }); 
});


