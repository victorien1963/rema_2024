// JavaScript Document
$(window).ready(function(){	
	

	
	
	$(".order-item-title").click(function(){
		var detail = $(this).parent().parent().find(".state-detail");
		var iconChange = $(this).parent().find(".icon");
		if(detail.is(":hidden") ){
			detail.slideDown(function(){
				var Hightsimple = $(this).parent().find(".product-tetail-con-height");
				var Hightcollate = $(this).parent().find(".product-tetail-con");
				var BoxHight = Hightsimple.height();
				Hightcollate.height(BoxHight);
			});
			iconChange.removeClass("icon-plus");
			iconChange.addClass("icon-minus");
			
		}else{
			detail.slideUp();
			iconChange.removeClass("icon-minus");
			iconChange.addClass("icon-plus");
		}
		
	});
	
	
	$(".return-bn").click(function(){
		$(this).parent().parent().parent().parent().parent().parent().find(".state-con").hide();
		$(this).parent().parent().parent().parent().parent().parent().find(".return-con").slideDown();
	});
	
	$(".return-apply-bn").click(function(){
		$(this).parent().parent().parent().parent().find(".return-notice").hide();
		$(this).parent().parent().parent().parent().find(".return").slideDown();
	});
	
	$(".return-address-bn").click(function(){
		$(".background-black").css("display","block");
		
	});

	$(".return-submit").on("click",function(){
		$(this).parent().parent().parent().parent().parent().parent().parent().parent().find(".return").hide();
		$(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().find(".arrive-state").hide();
		$(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().find(".return-state").show();
		$(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().find(".return-state").find(".state-detail").show();
		$(this).parent().parent().parent().parent().parent().parent().parent().parent().find(".product-deteail-con").show();
	});

});