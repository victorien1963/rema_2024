
     //////////////////////////////商品介紹頁///////////////////////////////////


        $(".size-toggle").click(function(){
            $(".size-tab li:eq(1)").tab('show');
            $('html,body').animate({scrollTop:$('#size-point').offset().top-60},800);
        });
    /////////////////////////////////////////////////////////////////
        p_slide_show1 = function() {
            $this = $("#p-slide-show-slide1");
            if ($("#p-slide-show-slide1 .carousel-inner").children('div').length === 1) {
                $this.children(".carousel-control").hide();
            } else if ($("#p-slide-show-slide1 .carousel-inner .item:first").hasClass("active")) {
                $this.children(".left").hide();
                $this.children(".right").show();
            } else if ($("#p-slide-show-slide1 .carousel-inner .item:last").hasClass("active")) {
                $this.children(".right").hide();
                $this.children(".left").show();
            } else {
                $this.children(".carousel-control").show();
            }
        };

        p_slide_show1();
        $this.on("slid.bs.carousel", "", p_slide_show1);
    /////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////
    //$('#p-slide-show-slide1 .item a').on("click",function() {
    $(document.body).on('click', '#p-slide-show-slide1 .item a', function(e){
    	e.preventDefault();
        $("#p-slide-show1 .tab-pane").hide();
        $($(this).attr("href")).show();
        // $(this).parent().addClass("adtive")；
    });
    //$(".slider-pick").find("li").on("click",function(){
    $(document.body).on('click', '.sliderpic', function(){
        $(this).parent().find("li").removeClass("select");
        $(this).addClass("select");
    });
    ////////////////////////////END 商品介紹頁/////////////////////////////////////

    ////////////////////////////////購物車/////////////////////////////////
   
    ////////////////////////////////END 購物車/////////////////////////////////





