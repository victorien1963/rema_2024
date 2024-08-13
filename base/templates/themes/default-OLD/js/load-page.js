
$(document).ready(function() {
    $('#load-header').load(PDV_TMRP+"load-header.html");
    $('#loadamateur').load(PDV_TMRP+"amateur-case.htm");
    $('#footer').load(PDV_TMRP+"footer.html");
    $('#side-menu').load(PDV_TMRP+"side-menu.htm");
    $('#side-menu-account').load(PDV_TMRP+"side-menu-account.htm");

    var viewportWidth = $(window).width();
    if (viewportWidth > 991) {
    $('#load-navigation').load(PDV_TMRP+"load-navigation.html");
    } else {
        $('#load-mmenu').load(PDV_TMRP+"load-mmenu.html");
    }
    if (viewportWidth > 768) {
    $('#load-index-doctor-ad').append('<img src="img/index/doctor-ad.jpg" class="img-responsive">');
    $('.enviroment').append('<img src="img/index/foot-enviroment.jpg" class="img-responsive-100">');
    $('.section-vote .container a').append('<img src="img/index/vote.jpg" class="img-responsive-100">');
    $(".nav-xs").removeClass("nav-justified").addClass("nav-justified");
    $(".btn-group-change").removeClass("btn-group-lg").addClass("btn-group-lg");
    } else {
        $('#load-index-doctor-ad').append('<img src="img/index/doctor-ad-sm.jpg" class="img-responsive">');
        $('.enviroment').append('');
        $('.section-vote .container a').append('');
        $(".nav-xs").removeClass("nav-justified");
        $(".btn-group-change").removeClass("btn-group-lg");
    }






     $(window).scroll(function() {
         console.log($(this).scrollTop());
        if ( $(this).scrollTop() > 120){
                   $(".main-nav-b").addClass("active");
                   // $('float-bar').css('visibility','visible');
        } else {
            $(".main-nav-b").removeClass("active");
            // $('#gotop').css('visibility','hidden');
        }
    });

    //  $(window).resize(function(){
    //     sidemenuhide();
    //     alert("OK");
    // });

      $sidemenu = $('#sidebar-nav');
      $side_toggle = $('.side-top-toggle');
    sidemenuhide();

    $(window).resize(function(){
        sidemenuhide();
        });

        function  sidemenuhide() {
        var w_width = $(window).width();
        if(w_width < 992){
            $sidemenu.addClass('collapse');
            $side_toggle.attr("data-toggle","collapse")
            $side_toggle.attr("href","#sidebar-nav")
        } else {
            $sidemenu.removeClass('collapse');
            $side_toggle.attr("data-toggle","")
            $side_toggle.attr("href","javascript:;")
        }
}

});
// document



    // function sidemenuhide(){
    //     var w_width = &(window).width();
    //     if(w_width<768){
    //         $("#sidebar-nav").addClass("collapse");
    //     }else{
    //         $("#sidebar-nav").removeClass("collapse");
    //     }
    // }
