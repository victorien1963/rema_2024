
$(document).ready(function() {
    $('.mobile-menu-category-back').on('click', function() {
        $('.mobile-menu-category').addClass('un-open');
    });

    $('.mobile-menu-type-back').on('click', function() {
        $('.mobile-menu-type').addClass('un-open');
    });

    $('.mobile-menu-type-items li').on('click', function() {
        let id = $(this).data('id');
        $(`.mobile-menu-category-box`).removeClass('active');
        $(`.mobile-menu-category-box.${id}`).addClass('active');
        $('.mobile-menu-category').removeClass('un-open');
    });

    $('.mobile-menu-items li').on('click', function() {
        let id = $(this).data('id');
        $(`.mobile-menu-type-box`).removeClass('active');
        $(`.mobile-menu-type-box.${id}`).addClass('active');
        $('.mobile-menu-type').removeClass('un-open');
    });

    $('.max-pc-menu-items li').hover(function() {
        let id = $(this).data('id');
        if(id) {
            $('.pc-menu').removeClass('un-open');
            $('.mobile-menu').removeClass('un-open');
            var menuHeight = $('.pc-menu .box').outerHeight(true);
            $('.pc-menu').css('height', menuHeight + 'px');       
            $('.type-tag').removeClass('active');
            $(`#${id}`).addClass('active');
            $('.pc-menu-items li').removeClass('active');
            $(this).addClass('active');
            $('.member-bar-btn').addClass('color-black');
        }
    });
    
    $('.pc-menu').on( "mouseleave", function() {
        $('.pc-menu').addClass('un-open');
        $('.mobile-menu').addClass('un-open');
        $('.member-bar-btn').removeClass('color-black');
    });

    $('.pc-menu-items li').hover(function() {

        let id = $(this).data('id');
        if(id) {
            $('.pc-menu-items li').removeClass('active');
            $('.type-tag').removeClass('active');
            $(`#${id}`).addClass('active');
            $(this).addClass('active');
        }

        var menuHeight = $('.pc-menu .box').outerHeight(true);
        $('.pc-menu').css('height', menuHeight + 'px');
        // $('.pc-menu').animate({ height: menuHeight }, 1000);
    });
    $('.btn-menu').on('click', () => { 
        $('.pc-menu').removeClass('un-open');
        $('.mobile-menu').removeClass('un-open');
        var menuHeight = $('.pc-menu .box').outerHeight(true);
        $('.pc-menu').css('height', menuHeight + 'px');        
    });

    $('.close-btn').on('click', () => { 
        $('.pc-menu').addClass('un-open');
        $('.mobile-menu').addClass('un-open');
        $('.mobile-menu-type').addClass('un-open');
        $('.mobile-menu-category').addClass('un-open');
    });

    $('.search').on('click', () => {
        $('.search-fixed').addClass('active');
    });
    $('.search-fixed , .search-close-btn').on('click', () => {
        $('.search-fixed').removeClass('active');
    });
    $('.search-box').on('click', (event) => {
        event.stopPropagation();
    });
});

