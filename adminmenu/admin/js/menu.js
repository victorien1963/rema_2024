function submitMenu(id){
	if($("#menu_"+id).val().length<1){
		$().alertwindow("請輸入選單名稱","");
		return false;
	}
	
	if($("#url_"+id).val().length<1 ){
		$().alertwindow("請輸入內部網址，格式如：news/class/index.php","");
		return false;
	}
	
	var auth = $('#auth_'+id).val();
	var ifshow = $('#ifshow_'+id).val();
	var url = $('#url_'+id).val();
	var authuser = $('#authuser_'+id).val();
	var groupid = $('#gid').val();
	$('#form_'+id).ajaxSubmit({
		url: 'index.php?auth='+auth+'&ifshow='+ifshow+'&url='+url+'&authuser='+authuser+'&groupid='+groupid,
		type: 'POST',
		success: function(msg) {
			self.location='index.php?groupid='+groupid;
		}
	}); 

}





//添加分組
$(document).ready(function(){
	$('#addgroup').submit(function(){ 
		
		$('#addgroup').ajaxSubmit({
			url: 'post.php',
			success: function(msg) {
				if(msg=="OK"){
					$().getMenuGroup();
				}else{
					$().alertwindow(msg,"");
				}
			}
		}); 
       return false; 

   }); 
});


//刪除分組
$(document).ready(function(){
	
		$('#btdelgroup').click(function(){ 
			
			qus=confirm("確定要刪除目前選單組嗎?")
			if(qus==0){
				return false; 
			}
			var gid = $('#gid').val();
			
				$.ajax({
					type: "POST",
					url: "post.php",
					data: "act=delgroup&groupid="+gid,
					success: function(msg) {
						if(msg=="OK"){
							$().getMenuGroup();
							self.location='index.php';
						}else{
							$().alertwindow(msg,"");
						}
					}
				}); 
			    return false; 
	   });
   
});
