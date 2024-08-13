// JavaScript Document

$(document).ready(function() {
    SrollItem();
    
    if ($(window).width()<1000){
        $(".mobile-con").addClass("mob-mod")
        wordwidth();
    }else{
        $(".mobile-con").addClass("pc-mod")
    }

    $( window ).resize(function() {
        $(".title-con").unbind();
        if ($(window).width()>1000){
            $(".mobile-hide").css('display','block');
            $(".mobile-con").addClass("pc-mod")
            $(".mobile-con").removeClass("mob-mod")
            $(".title-con").unbind();
        }else if ($(window).width()<1000 && $(".mobile-con").hasClass("pc-mod")) {
            $(".mobile-hide").css('display','none'); 
            $(".mobile-con").addClass("mob-mod");
            $(".mobile-con").removeClass("pc-mod");
            $(".filter-icon-span").removeClass("icon-minus");
            $(".filter-icon-span").addClass("icon-plus");  
            wordwidth();
        }else {    
            wordwidth();
        }
    });


});

function wordwidth(){
    $(".title-con").click(function(){
        $(".mobile-hide").slideUp();
        $(".title-con").find(".filter-icon-span").removeClass("icon-minus");
        $(".title-con").find(".filter-icon-span").addClass("icon-plus");
        var parg = $(this).parent().find(".mobile-hide")
        if (parg.is(":hidden")){
            $(this).find(".filter-icon-span").removeClass("icon-plus");
            $(this).find(".filter-icon-span").addClass("icon-minus");
            parg.slideDown();
        }
    });
}

function SrollItem(){
    $(".scroll-1").click(function (){
        $('html, body').animate({
            scrollTop: $(".scroll-item-1").offset().top-200
        }, 1000);
    });
    $(".scroll-2").click(function (){
        $('html, body').animate({
            scrollTop: $(".scroll-item-2").offset().top-200
        }, 1000);
    });
    $(".scroll-3").click(function (){
        $('html, body').animate({
            scrollTop: $(".scroll-item-3").offset().top-200
        }, 1000);
    });
    $(".scroll-4").click(function (){
        $('html, body').animate({
            scrollTop: $(".scroll-item-4").offset().top-200
        }, 1000);
    });
    $(".scroll-5").click(function (){
        $('html, body').animate({
            scrollTop: $(".scroll-item-5").offset().top-200
        }, 1000);
    });
    $(".scroll-6").click(function (){
        $('html, body').animate({
            scrollTop: $(".scroll-item-6").offset().top-200
        }, 1000);
    });

}