//會員登入
$(document).ready(function(){
	$('#memberLogin').submit(function(){ 
		$('#memberLogin').ajaxSubmit({
			url: PDV_RP+'post.php',
			success: function(msg) {
				if(msg=="OK" || msg.substr(0,2)=="OK"){
					var newurl = msg.split("_");
					if(newurl[1]){
						location.reload();
					}else{
						window.location=PDV_RP;
					}
				}else{
					LoadMsg(msg);
				}
			}
		}); 
       
		return false; 

   }); 
   $('#registration-form').submit(function(){ 
		$('#registration-form').ajaxSubmit({
			url: PDV_RP+'post.php',
			success: function(msg) {
				switch(msg){									
					case "OK":
						if($("#nextstep")[0].value=="enter"){
							window.location='index.php';
						}else{
							window.location='index.php';
						}
					break;
					case "OK_NOMAIL":
						if($("#nextstep")[0].value=="enter"){
							window.location='index.php';
						}else{
							window.location='index.php';
						}
					break;
					case "CHECK":
						LoadMsg("會員註冊成功！您註冊的會員類型需要審核後才能登入，感謝您的註冊");
					break;
					default :
						LoadMsg(msg);
					break;
				}
				
			}
		}); 
		return false; 
   });
});
