// JavaScript Document

window.onscroll = function() {sticky1()};

$(document).ready(function(){
	stickyHeight();
	stickyReset();

	$(".quantity-plus").click(function(){
		var plus_bn = $(this);
		plus( plus_bn );
	});
	
	$(".quantity-minus").click(function(){
		var minus_bn = $(this);
		minus ( minus_bn );
	});
	$("#mobile-buy-bn1").click(function(){
		order_info_con_slide_in();
	});
	$(".mobile-order-close").click(function(){
		mobile_order_close();
	});
	shoping_sw();
	 
});
$(window).resize(function(){
	stickyHeight();
	stickyReset();
	sticky1();

});
	


function sticky1() {
	var order = $(".shop-cart-con");
	var sticky =  order.height() + 98 - $(window).height();
  if (window.pageYOffset <=  sticky ) {
	  $(".fixd-bottom").addClass("sticky");
  } else {
	  $(".fixd-bottom").removeClass("sticky");
  }
}

function stickyHeight(){
	$(".sticky-height").height($(".fixd-bottom").height()+ 2 );
}

function stickyReset(){
	var order = $(".shop-cart-con");
	var sticky =  order.height() + 98 - $(window).height();
	sticky =  order.height() + 98 - $(window).height();
	if(sticky <= 0) {
		$(".fixd-bottom").removeClass("sticky");
	}else{
		$(".fixd-bottom").addClass("sticky");
	}
}


function plus(plus_bn){
	var num = plus_bn .parent().parent().parent().find("input").val() ;
	var num_plus = parseInt(num) + 1 ;
	if (num_plus > 99){
		num_plus = 99;
	}
	plus_bn .parent().parent().parent().find("input").val(num_plus);
}

function minus(minus_bn){
	var num = minus_bn .parent().parent().parent().find("input").val() ;
	var num_minus = parseInt(num) - 1 ;
	if (num_minus < 1){
		num_minus = 1;
	}
	minus_bn .parent().parent().parent().find("input").val(num_minus);
}
function quantity_chante(num_change){
	var quenty_num_change = num_change.val();
	if(quenty_num_change === ""){
		quenty_num_change = 1;
	}
	num_change.val(quenty_num_change);
}

function order_info_con_slide_in(){
	$("html,body").animate({
        scrollTop:0
    },0);
	$(".order-info-con").slideDown();
	$(".shop-list-con").hide();
	$(".mobile-cart-list-con").hide();
}

function mobile_order_close(){
	$(".shop-list-con").slideDown();
	$(".order-info-con").hide();
	$(".mobile-cart-list-con").show();
}



function shoping_sw(){
	$(".use-card").click(function(){
		$(".href-sw").attr("href","Checkout.html");
	});
	$(".cash").click(function(){
		$(".href-sw").attr("href","CheckoutNoCard.html");
	});
}








