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
});
