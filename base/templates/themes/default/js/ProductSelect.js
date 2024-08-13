// JavaScript Document
$(document).ready(function() {
    producthover_switch();
    producthover();
    SelectPicWidth ();
    ColorNav();
    SelectPicChange()
});
$(window).resize(function(){   
    producthover_switch();
    SelectPicWidth ();
    relat_carousel();
    
    
});

function producthover_switch(){
    if($(window).width() > 1000 ){
        $(".product-item").removeClass("mobile_st");
    }else{
        $(".product-item").addClass("mobile_st")
    }
}

function SelectPicWidth(){
    $(".color-pic-width").each(function(){
        var color_pic_cont_width = $(this).parent().parent().width();
        var PicWidth = parseInt(((color_pic_cont_width) / 3)-6);
        $(".color-pic").width(PicWidth); 
        var quandiv = $(this).children()
        var quan = quandiv.length;
        $(this).width( PicWidth*quan );
        $(this).parent().width( PicWidth*3 );
    });
   
 };
 
 function ColorNav(){
    $(".color-prev").click(function(){
        console.log("prev");
        var color_pic_width = $(this).parent().parent().find(".color-pic").width()+6;
        console.log("color_pic_width:"+color_pic_width);
        var carousel = $(this).parent().parent().find(".color-pic-width");
        console.log("carousel:"+carousel);
        var leftzero = parseInt(carousel.css("left"));
        console.log("leftzero:"+leftzero);
        if(leftzero == 0){
            console.log("prev結束");
            return;
        }
        var lettzero_regulate = leftzero / color_pic_width;
        
        console.log("lettzero_regulate:"+lettzero_regulate);
        $(carousel).data("carouselnum",lettzero_regulate);
        carousel.animate({left: leftzero + color_pic_width},100);
        console.log("prev結束");
    });
    $(".color-next").click(function(){
        console.log("next");
        var color_pic_width = $(this).parent().parent().find(".color-pic").width()+6;
        console.log("color_pic_width:"+color_pic_width);
        var carousel = $(this).parent().parent().find(".color-pic-width");
        console.log("carousel:"+carousel);
        var leftzero = parseInt(carousel.css("left"));
        console.log("leftzero:"+leftzero);
        var quan =  $(this).parent().parent().find(".color-pic-width").find("div").length;
        console.log("quan:"+quan);
        var quannext =parseInt(leftzero / color_pic_width) ;
        console.log("quannext:"+quannext);
        if (0 > quannext || 4 > quan) {
            
        console.log("next結束");
            return;
        }
        console.log("-quannext-quan:");
        var lettzero_regulate = leftzero / color_pic_width;
        console.log("lettzero_regulate:"+lettzero_regulate);
        $(carousel).data("carouselnum",lettzero_regulate);
        carousel.animate({left: leftzero - color_pic_width},100);
        console.log("next結束");
    });
 }

function def_relat_carousel(){

}
function relat_carousel(){
    $(".color-pic-width").each(function(){
        var color_pic_width = $(this).find(".color-pic").width();
        var carouselid = $(this).data("carouselnum")-1;
        $(".color-pic").width(color_pic_width); 
        var relat_left = carouselid*(color_pic_width);
        $(this).css("left",relat_left);
    });
}

 function SelectPicChange(){
    $(".color-pic").mouseover(function(){
        var img_block = $(this).parent().parent().parent().parent().parent().find(".product-item-pic > img")
        //var img_url = "url(" + $(this).find("img").attr("src") + ")";
        //img_block.css("background-image",img_url);
        var img_url = $(this).find("img").attr("src");
        img_block.prop("src",img_url);
    });
 };
 function producthover(){
         $('.product-item').bind({
            mouseenter: function(e) {
                // Hover event handler
                if($(".product-item").hasClass("mobile_st")){
                }else{
                    SelectPicWidth()
                    $(this).css("z-index","1");
                    $(this).find(".color-pic-cont").show();
                    SelectPicChange()
                    $(this).css("border","1px solid  hsla(0,0%,60%,1.00)");
                }
            },
            mouseleave: function(e) {
                if($(".product-item").hasClass("mobile_st")){
                }else{
                    $(this).find(".color-pic-cont").hide();
                    $(this).find(".owl-stage-outer").hide();
                    $(this).css("border","1px solid  hsla(0,0%,100%,0.00)");
                    $(this).css("z-index","0");
                }
            },
            click: function(e) {
                if($(".product-item").hasClass("mobile_st")){
                }else{
                    SelectPicWidth()
                    $(this).css("z-index","1");
                    $(this).find(".color-pic-cont").show();
                    SelectPicChange()
                    $(this).css("border","1px solid  hsla(0,0%,60%,1.00)");
                }
            }
        });
        // $('.product-item').hover(function() {
        //     if($(".product-item").hasClass("mobile_st")){

        //     }else{
        //         SelectPicWidth()
        //         $(this).css("z-index","1");
        //         $(this).find(".color-pic-cont").show();
        //         SelectPicChange()
        //         $(this).css("border","1px solid  hsla(0,0%,60%,1.00)");
        //     }
            
        // },function(){
        //     if($(".product-item").hasClass("mobile_st")){

        //     }else{
        //         $(this).find(".color-pic-cont").hide();
        //         $(this).find(".owl-stage-outer").hide();
        //         $(this).css("border","1px solid  hsla(0,0%,100%,0.00)");
        //         $(this).css("z-index","0");
        //     }
           
        // });

        $('.product-item').click(function(){
// 			$(this).children(".product-item-word").children(".color-pic-con").css("display","none");
// 			$(this).find(".color-pic-cont").hide();
//             $(this).find(".owl-stage-outer").hide();
// 			$(this).css("border","none");
// 			$(this).css("z-index","0");
		});
    
 };
 