// JavaScript Document
$(document).ready(function(){

	$(".invoice-select").click(function(){
		var selected = $(this);
		invoice(selected);
	});
	
	$(".ship-select").click(function(){
		var selected = $(this);
		ship(selected);
	});
	 
	$(".credit-card-select-bn").click(function(){
		var credit_card_bn = $(this);
		credit_cart(credit_card_bn);
	});
});



function invoice(selected){
	var invoiceselec = selected.parent().parent().find("div.select-box").css('display')
	if (invoiceselec == "none"){
		$(".select-box").slideUp();
		selected.parent().parent().find("div.select-box").slideDown();
	}else{
		$(".select-box").slideUp()
	}

};

function ship(selected){
	var invoiceselec = selected.parent().parent().find("div.ship-box").css('display')
	if (invoiceselec == "none"){
		$(".ship-box").slideUp();
		selected.parent().parent().find("div.ship-box").slideDown();
	}else{
		$(".ship-box").slideUp()
	}

};

function credit_cart(credit_card_bn){
	$(".credit-card-select-bn").removeClass("selected");
	credit_card_bn.addClass("selected");
}