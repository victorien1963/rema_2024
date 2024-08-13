// JavaScript Document

$(document).ready(function () {
	var owl = $('.scenario-block');
	owl.owlCarousel({
		dots: true,
		items: 1,
		margin: 10,
		nav: true,
		loop: true,
	});

	



	var x, i, j, selElmnt, a, b, c;
	/*look for any elements with the class "custom-select":*/
	x = document.getElementsByClassName("custom-select");
	for (i = 0; i < x.length; i++) {
		selElmnt = x[i].getElementsByTagName("select")[0];
		/*for each element, create a new DIV that will act as the selected item:*/
		a = document.createElement("DIV");
		a.setAttribute("class", "select-selected");
		a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
		x[i].appendChild(a);
		/*for each element, create a new DIV that will contain the option list:*/
		b = document.createElement("DIV");
		b.setAttribute("class", "select-items select-hide");
		for (j = 0; j < selElmnt.length; j++) {
			/*for each option in the original select element,
			create a new DIV that will act as an option item:*/
			c = document.createElement("DIV");
			c.innerHTML = selElmnt.options[j].innerHTML;
			c.addEventListener("click", function (e) {
				/*when an item is clicked, update the original select box,
				and the selected item:*/
				var y, i, k, s, h;
				s = this.parentNode.parentNode.getElementsByTagName("select")[0];
				h = this.parentNode.previousSibling;
				for (i = 0; i < s.length; i++) {
					if (s.options[i].innerHTML == this.innerHTML) {
						s.selectedIndex = i;
						h.innerHTML = this.innerHTML;
						y = this.parentNode.getElementsByClassName("same-as-selected");
						for (k = 0; k < y.length; k++) {
							y[k].removeAttribute("class");
						}
						this.setAttribute("class", "same-as-selected");
						break;
					}
				}
				h.click();
			});
			b.appendChild(c);
		}
		x[i].appendChild(b);
		a.addEventListener("click", function (e) {
			/*when the select box is clicked, close any other select boxes,
			and open/close the current select box:*/
			e.stopPropagation();
			closeAllSelect(this);
			this.nextSibling.classList.toggle("select-hide");
			this.classList.toggle("select-arrow-active");
		});

	}
	function closeAllSelect(elmnt) {
		/*a function that will close all select boxes in the document,
		except the current select box:*/
		var x, y, i, arrNo = [];
		x = document.getElementsByClassName("select-items");
		y = document.getElementsByClassName("select-selected");
		for (i = 0; i < y.length; i++) {
			if (elmnt == y[i]) {
				arrNo.push(i)
			} else {
				y[i].classList.remove("select-arrow-active");
			}
		}
		for (i = 0; i < x.length; i++) {
			if (arrNo.indexOf(i)) {
				x[i].classList.add("select-hide");
			}
		}
	}
	/*if the user clicks anywhere outside the select box,
	then close all select boxes:*/
	document.addEventListener("click", closeAllSelect);


	var introduce = $('.introduce');
	introduce.owlCarousel({
		margin: 10,
		nav: true,
		dots: false,
		loop: true,
		responsive: {
			0: {
				stagePadding: 20,
				items: 2,
				nav: false,
			},
			600: {
				stagePadding: 40,
				items: 3,
				nav: false,
			},
			1000: {
				stagePadding: 50,
				items: 3,
				items: 4
			}
		}
	});

	var detail_carousel = $('.detail-carousel');
	detail_carousel.owlCarousel({
		dots: true,
		items: 1,
		margin: 10,
		nav: true,
		loop: true,
		animateOut: 'fadeOut',
	});

	detail_carousel_nav();

	$(".mobile-color").click(function () {
		$('html,body').animate({
			scrollTop: $(".product-small-img-con").offset().top - 100
		},'slow');
	});

	$(".mobile-size").click(function () {
		if ($(".size-selecter").hasClass("act")) {
			$(".size-selecter").removeClass("act");
			$(".size-selecter").slideUp();
		}else{
			$(".size-selecter").addClass("act");
			$(".size-selecter").slideDown();
		}
		
	});
	
	/*$(document).on("click",".selsize",function () {
			$(".size-selecter").removeClass("act");
			$(".size-selecter").slideUp();
	});*/

	$(".color-img").click(function () {
		if ($(".color-img").hasClass("activ")) {
			$(".color-img").removeClass("activ");
		}
		$(this).addClass("activ");
		
	});

	$(document).on("click",".size-nav-item",function () {
		if ($(".size-nav-item").hasClass("activ")) {
			$(".size-nav-item").removeClass("activ");
		}
		$(this).addClass("activ");
		var selectsize = $(this).html();
		$(".sizein").html(selectsize);
	});

	$(".advice-bn").click(function () {
		if($(window).width() < 700 ){
			$(".size-selecter").removeClass("act");
			$(".size-selecter").css("display","none");
		}
		$('html,body').animate({
			scrollTop: $(".size-conut").offset().top - 100
		},
			'slow');
	});


	$(".size-bn").click(function () {
		$('html,body').animate({
			scrollTop: $(".size-conut").offset().top + 150
		},
			'slow');
		$(".size-conut-fin-con").slideDown();
		$(".size-bn").html("重新尋找");
	});


	if($(window).width() < 700 ){
		$(".product-big-img").hide();
		product_pic_mobile();
	}

	$(".mobile-color-select").click(function() {
		$(".mobile-color-select").removeClass("filter-act");
		$(this).addClass("filter-act");

	});


	var product_small = $('.product-small-img');
	product_small.owlCarousel({		
		nav: true,
		dots: true,
		loop: true,
		responsive: {
			0: {
				items: 1,
				margin: 5,
				stagePadding: 25,
			},
			700: {
				items: 2,
				margin: 10,
				stagePadding: 50,
			},
			1000: {
				items: 2,
				margin: 10,
				stagePadding: 50,
			},
			1200: {
				items: 3,
				margin: 10,
				stagePadding: 50,
			}
		}
	});

	var product_small = $('.mobile-color-img');
	product_small.owlCarousel({
		margin: 5,
		stagePadding: 15,
		nav: false,
		dots: false,
		loop: false,
		responsive: {
			0: {
				items: 3
			},
			700: {
				items: 5
			},
			
		}
	});
	


	mobile_mood(); 
	add_cart();

});



$(window).resize(function(){
	if($(window).width() < 700 && $(".product-img-block").hasClass("sho")){
		$(".product-big-img").hide();
		product_pic_mobile();
		location.reload();
		$(".product-img-block").removeClass("sho");
		$(".product-img-block").addClass("hid");

		mobile_mood(); 
	}else if($(window).width() > 700 && $(".product-img-block").hasClass("hid")){
		location.reload();
		$(".product-img-block").addClass("sho");
		$(".product-img-block").removeClass("hid");
	}
});

function detail_carousel_nav(){
	var dot_qut = $(".detail-carousel.owl-carousel .owl-dots .owl-dot").length;
	var dot_width = $(".detail-carousel.owl-carousel .owl-dots .owl-dot").width();
	var dots_width = dot_qut * dot_width;
	var nav_width = dots_width + 50;
	$(".detail-carousel.owl-carousel  .owl-dots").width(dots_width);
	$(".detail-carousel.owl-carousel .owl-nav").width(nav_width);
};

function product_pic_mobile(){
    $(".product-big-img").each(function(){
		var imgsrc = $(this).find("img").attr("src");
		var input = "<div class='item'><div class='product-small-img-item'><img class='superbig-src' src="+imgsrc+"></div></div>";
		$(".product-small-img").prepend(input);
    });
 };

function mobile_mood(){
	if ($(window).width() > 700) {
		$(".product-small-img .owl-item").click(function () {
			if ($(this).hasClass("active")) {
				var src = $(this).find("img").attr("src");
				// $(".superbig-img").attr("src", src);
				var product_superbig = $('.product-superbig-img');
				product_superbig.owlCarousel({
					margin: 10,
					nav: true,
					dots: true,
					loop: true,
					animateIn: 'fadeIn',
					items:1,
					URLhashListener:true,
					startPosition: 'URLHash',
					smartSpeed:550,
				});
				$(".superbig-product-img").fadeIn();
				$("body").css("overflow","hidden");
			}
		});
		//$(".superbig-product-img").click(function(){
		//	if ($(this) != $(".superbig-img")){
		//		$(".superbig-product-img").fadeOut();
		//		$("body").css("overflow","scroll");
		//	}
		//});
		$(".close-img").click(function () {
			$(".superbig-product-img").fadeOut();
			$("body").css("overflow","scroll");
		});
		$(".product-img-block").removeClass("hid");
		$(".product-img-block").addClass("sho");
	}else{
		$(".product-img-block").addClass("hid");
		$(".product-img-block").removeClass("sho");
	}
};

function add_cart(){
	if ($(window).width() > 1000) {
		$(".add-cart").click(function(){
			var cart = $(".cart").children(".dropdown-nav").children(".dropdown");
			cart.fadeIn();
			setTimeout(function(){$(".cart").children(".dropdown-nav").children(".dropdown").fadeOut();},3000);
		})
	}else{
		$(".add-cart").click(function(){
			var buysize= $("#buysize").val();
			if(buysize==""){
				return false;
			}
			
			$(".mobile-add-car").slideDown();
			setTimeout(function(){$(".mobile-add-car").slideUp();},2000);
			if($(".size-selecter").hasClass("act")){
				$(".size-selecter").slideUp();
			}
		})
	}

}


$(function(){ 
	$(".superbig-product-img").bind("click",function(e){ 
	var target = $(e.target); 
	if(target.closest(".product-superbig-img").length == 0){ 
	$(".superbig-product-img").hide(); 
	$("body").css("overflow","scroll");
	} 
	}) 
});

