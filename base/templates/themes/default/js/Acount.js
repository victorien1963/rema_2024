// JavaScript Document
$(document).ready(function(){
	var surplus  = $(".fin-surplus").html();
	$(".fin-surplus-show").html(surplus);
	
	finangular();
	
	$(window).resize(function(){
		finangular();
	});
	
	function finangular (){
		if($(window).width() < 700){
			var cont = $(".account-item-list").html();
			$(".mobile-account-item-list-block").html(cont);
		}else{
			$(".mobile-account-item-list-block").html("");
		}
	}
	
});