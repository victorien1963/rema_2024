// JavaScript Document
	$(document).ready(function() {
		$('.color-bar').owlCarousel({
			loop:false,
			margin:5,
			nav:true,
			touchDrag:true,
			dots:false,
			checkVisible:false,
			items:3
		});
		$('.color-bar').on('refreshed.owl.carousel', function(event){
			$(this).find(".owl-stage-outer").fadeIn();
		});
		$('.product-item').mouseover(function() {
			$(this).css("z-index","1");
			$(this).children(".product-item-word").children(".color-pic-con").css("display","block");
			$(this).css("border","1px solid  hsla(0,0%,60%,1.00)");
		});
		$('.product-item').mouseleave(function(){
			$(this).children(".product-item-word").children(".color-pic-con").css("display","none");
			$(this).find(".owl-stage-outer").hide();
			$(this).css("border","none");
			$(this).css("z-index","0");
		});
		$('.product-item').click(function(){
			$(this).children(".product-item-word").children(".color-pic-con").css("display","none");
			$(this).find(".owl-stage-outer").hide();
			$(this).css("border","none");
			$(this).css("z-index","0");
		});
		
		
		
		
		
	});