

$(document).ready(function(){
	
	$(".sendtui").click(function(){
		
		var thisorderid = this.id.substr(4);
		
		$('#sendtuiform_'+thisorderid).ajaxSubmit({
			url:PDV_RP+"shop/post.php",
			success: function(msg){
				if(msg=="OK"){
					alert("申請完成");
					window.location.reload();
				}else{
					alert(msg);
				}
			}
		});
	});
	
});