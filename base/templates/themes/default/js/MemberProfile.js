// JavaScript Document
$(document).ready(function(){
	$(".connection-bn").click(function(){
		$(".background-black").fadeIn();
		$(".window-block .title").html("新增通訊錄");
		$(".new-connection-bn").html("確認新增");
	});
	$(".member-close").click(function(){
		$(this).parent().parent().parent().parent().slideUp();
	});
	$(".member-edit").click(function(){
		var receiver = $(this).parent().parent().parent().parent().find("div.receiver").html();
		var phonenumber = $(this).parent().parent().parent().parent().find("div.phonenumber").html();
		var location = $(this).parent().parent().parent().parent().find("div.locate").html();
		$(".background-black").fadeIn();
		$('input[name="receive"]').val(receiver);
		$('input[name="phonenum"]').val(phonenumber);
		$('input[name="location"]').val(location);
		$(".window-block .title").html("修改通訊錄");
		$(".new-connection-bn").html("確認修改");
	});
	
	function formblock(){
		jQuery (function ($){
			var h = Number.MIN_VALUE;
			$ (".form-block").each (function (i, dom)
			{
				var me = $ (this), mh = me.height ();
				h = h < mh ? mh : h;
			}).height (h);
		});
	}
	
	if( $(window).width()>700){
		formblock();
	}
	
	
	
});
 