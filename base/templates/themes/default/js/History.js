// JavaScript Document

$(document).ready(function() {
	$('.owl-carousel').owlCarousel({
		dots: false,
		nav: true,
		loop:false,
		margin: 50,
		stagePadding: 120,
		autoHeight: true,
		URLhashListener:true,
		startPosition: 'URLHash',
		responsive: {
			0: {
			  items: 1,
			  margin: 10,
				stagePadding: 20,
				nav:false,
			},
			500: {
				items: 1,
				margin: 20,
				stagePadding: 40,
			  },
			750: {
			  items: 1,
			  margin: 50,
			  stagePadding: 100,
			},
			1000: {
				items: 1,
				margin: 80,
				stagePadding: 250,
			  },
			1250: {
				items: 1,
				margin: 80,
				stagePadding: 300,
			},
			1450: {
				items: 1,
				margin: 120,
				stagePadding: 400,
			},
			1550: {
				items: 1,
				margin: 120,
				stagePadding: 420,
			},
			1600: {
				items: 1,
				margin: 120,
				stagePadding: 430,
			},
			1650: {
				items: 1,
				margin: 120,
				stagePadding: 440,
			},
			1750: {
				items: 1,
				margin: 120,
				stagePadding: 500,
			},


		  }
	});
	scroll_filter();
	function scroll_filter(){
		var filter_height = $("#content").height() - $(window).scrollTop() - 61; 
		$(".top-title").height(filter_height);
	}


	function active_block(){
		var main_carousel = $(".history-start");
		var active_item = main_carousel.find(".owl-stage").css(transform);
		var item_width = main_carousel.find(".owl-item").width();
		var active_num   = (active_item / item_width)+1 ;
	}


	$(window).scroll(function() {
    var filter_height = $("#content").height() - $(window).scrollTop() - 61; 
		$(".top-title").height(filter_height);
	});

});

