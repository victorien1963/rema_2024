

$(document).ready(function(){

	$("div#print_button").click(function(){ 
		$("div#shoporderdetail").printArea(); 
	});
	$("div#reget_button").click(function(){ 
		sendreget.submit(); 
	});
	
	$("a.delchk").click(function(){
		var getdelid = this.id.substr(7);
		//alert("刪除訂單編號"+getdelid);
		$.ajax({
			type: "POST",
			url:PDV_RP+"shop/post.php",
			data: "act=ordertui&orderid="+getdelid,
			success: function(msg){
				if(msg=="OK"){
					alert("訂單已經取消！");
					location.reload();
				}else if(msg=="1000"){
					alert("訂單不存在");
					$.fancybox.close();
				}else if(msg=="1001"){
					alert("訂單已付款，不能取消");
					$.fancybox.close();
				}else if(msg=="1002"){
					alert("訂單已配送，不能取消");
					$.fancybox.close();
				}else if(msg=="1003"){
					alert("訂單已完成，不能取消");
					$.fancybox.close();
				}else if(msg=="1004"){
					alert("訂單中部分商品已配送，不能取消");
					$.fancybox.close();
				}else{
					alert(msg);
				}
			}
		});
	});
	
});


(function($) {
	var printAreaCount = 0; 
	$.fn.printArea = function() { 
		var ele = $(this); 
		var idPrefix = "printArea_"; 
		removePrintArea( idPrefix + printAreaCount ); 
		printAreaCount++; 
		var iframeId = idPrefix + printAreaCount; 
		var iframeStyle = 'position:absolute;width:0px;height:0px;left:-500px;top:-500px;'; 
		iframe = document.createElement('IFRAME'); 
		$(iframe).attr({ style : iframeStyle, id    : iframeId }); 
		document.body.appendChild(iframe); 
		var doc = iframe.contentWindow.document; 
		$(document).find("link") .filter(function(){ 
			return $(this).attr("rel").toLowerCase() == "stylesheet"; }) .each(function(){
				doc.write('<link type="text/css" rel="stylesheet" href="' + $(this).attr("href") + '" >'); }); 
				doc.write('<div class="' + $(ele).attr("class") + '">' + $(ele).html() + '</div>'); 
				doc.close(); 
				var frameWindow = iframe.contentWindow; 
				frameWindow.close(); 
				frameWindow.focus(); 
				frameWindow.print(); 
				} 
				var removePrintArea = function(id) {
				$( "iframe#" + id ).remove(); 
				}; 
					
})(jQuery); 

