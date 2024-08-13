//發送電子折價券

$(document).ready(function(){

	$(".promomail").click(function(){	
		
		//alert("配合註冊會員第一次寄發功能修改中...\n請勿寄發信件！！！");
		
		var promoid=this.id.substr(10);
		$('#frmWindow').remove();
		$("body").append("<div id='frmWindow'></div>");
		$('#frmWindow').append('<div class="topBar">電子折價券發送<div class="pwClose"></div></div><div class="border"><iframe frameborder="0" scrolling="yes" src="promo_email.php?promoid='+promoid+'" class="Frm"></iframe></div>');
		$.blockUI({message:$('#frmWindow'),css:{width:'650px',top:'10px'}}); 
		$('.pwClose').click(function() { 
			$.unblockUI(); 
		}); 
	});

});