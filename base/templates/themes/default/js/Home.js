// JavaScript Document

$(document).ready(function() {

	var $hero = $('#hero-carousel .owl-carousel');

	$hero.owlCarousel({

		items: 1,

		loop: true,

		dots: true,

		animateOut: 'fadeOut',

		margin: 10,

		URLhashListener:true,

		startPosition: 'URLHash',

		autoplay: true,

		autoplayTimeout: 5000,

		autoplayHoverPause: false,

		smartSpeed:250,

		responsive: {

			10: {

				nav:false,

			},

			1001: {

				nav:true,

			}

		}

	});

	$hero.on('translated.owl.carousel', function(event) {

		$(".hero-carousel-bn.active").removeClass("active");

		$(".hero-carousel-bn").eq(event.item.index-2).addClass("active");

	});

	$('.play').on('click', function() {

		$hero.trigger('play.owl.autoplay', [250]);

	});

	$('.stop').on('click', function() {

		$hero.trigger('stop.owl.autoplay');

	});

	// $('.hero-carousel-bn-con').mouseover(function() {

	// 	$hero.trigger('stop.owl.autoplay');

	// })

	// $('.hero-carousel-bn-con').mouseout(function() {

	// 	$hero.trigger('play.owl.autoplay');

	// })

	if($(window).width() < 700 ){

		sportcategory()

	}

});





$(document).ready(function(){

	var introduce = $('.introduce');

	introduce.owlCarousel({

		margin: 6,

		nav: true,

		dots: false,

		loop: true,

		responsive: {

			0: {

				margin: 0,

				// stagePadding: 40,

				items: 2,

				// nav: false,

			},

			500: {

				margin: 0,

				// stagePadding: 30,

				items: 2,

				// nav: false,

			},
			800: {

				margin: 0,

				// stagePadding: 30,

				items: 3,

				// nav: false,

			},

			1001: {

				items: 4,
				// nav: true

			}

		}

	});

});











function sportcategory(){

	if($(".sports-category-select").hasClass("activ")){

		

	}else{

		$(".gander-category").click(function(){

			if($(this).hasClass("active")){

				var slidenGander = $(this).children(".gander-word");

				slidenGander.slideUp();

				$(this).removeClass("active");

			}else{

				$(".gander-word").slideUp();

				$(".gander-category").removeClass("active");

				var slidenGander = $(this).children(".gander-word");

				slidenGander.slideDown();

				$(this).addClass("active");

			}	

		});

		$(".sports-category-select").addClass("activ");

	}

}





$(window).resize(function(){

	if($(window).width() < 700 ){

		$(".gander-word").css("display","none");

		sportcategory()

	}else if($(window).width() > 700 && $(window).width() < 1000){

		$(".gander-word").css("display","block");

		$(".sports-category-select").removeClass("activ");

		$(".gander-category").unbind();

	}

});