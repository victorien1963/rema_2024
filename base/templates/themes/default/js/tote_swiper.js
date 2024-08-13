// <!-- Initialize Swiper -->

$(document).ready(function (){
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 2.2,
        loop:true,
        autoplay:true,
        speed:1000,
        spaceBetween: 6,
        centeredSlides: false,
        pagination: {
        el: ".swiper-pagination",
        clickable: true,
        },
        navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            // Default parameters
            slidesPerView: 1,
            spaceBetween: 10,
            // Responsive breakpoints
            320: {
            slidesPerView: 1.2,
            spaceBetween: 4
            },
            // when window width is >= 320px
            325: {
            slidesPerView: 1.2,
            spaceBetween: 4
            },
            // when window width is >= 480px
            468: {
            slidesPerView: 1.2,
            spaceBetween: 5
            },
            // when window width is >= 640px
            767: {
            slidesPerView: 2.2,
            spaceBetween: 5
            
            },
            768: {
            slidesPerView: 2.2,
            spaceBetween: 5
            },
            2560: {
            slidesPerView: 2.2,
            spaceBetween: 5
            }
        }

  });

}