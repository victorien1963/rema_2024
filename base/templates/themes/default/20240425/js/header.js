$(document).ready(function() {

    // 取得背景顏色的亮度
    function getBackgroundBrightness(element) {
        var rgb = $(element).css('background-color');
        var rgbValues = rgb.match(/\d+/g); // 提取 RGB 值
        var r = parseInt(rgbValues[0]);
        var g = parseInt(rgbValues[1]);
        var b = parseInt(rgbValues[2]);
        
        // 使用亮度公式：Y = 0.299R + 0.587G + 0.114B
        var brightness = 0.299 * r + 0.587 * g + 0.114 * b;
        return brightness;
    }

    // 設定一個亮度閾值，128為中間值。
    var brightnessThreshold = 128;

    // 檢查背景顏色，根據亮度添加或移除active。
    function checkAndToggleActive() {
        var brightness = getBackgroundBrightness('body'); // 假設檢查的是body的背景顏色
        if (brightness > brightnessThreshold) {
            $('header').addClass('active'); // 背景接近白色時，讓menu變黑色
        } else {
            $('header').removeClass('active'); // 背景接近黑色時，維持menu白色
        }
    }

    checkAndToggleActive();

    $(window).on('scroll resize', function() {
        checkAndToggleActive();
    });

    $('.mobile-menu-category-back').on('click', function() {
        $('.mobile-menu-category').addClass('un-open');
    });

    $('.mobile-menu-type-back').on('click', function() {
        $('.mobile-menu-type').addClass('un-open');
    });

    $('.mobile-menu-type-items li').on('click', function() {
        let id = $(this).data('id');
        $('.mobile-menu-category-box').removeClass('active');
        $('.mobile-menu-category-box.' + id).addClass('active');
        $('.mobile-menu-category').removeClass('un-open');
    });

    $('.mobile-menu-items li').on('click', function() {
        let id = $(this).data('id');
        $('.mobile-menu-type-box').removeClass('active');
        $('.mobile-menu-type-box.' + id).addClass('active');
        $('.mobile-menu-type').removeClass('un-open');
    });

    $('.max-pc-menu-items li').hover(function() {
        let id = $(this).data('id');
        if (id) {
            $('.pc-menu').removeClass('un-open');
            $('.mobile-menu').removeClass('un-open');
            var menuHeight = $('.pc-menu .box').outerHeight(true);
            $('.pc-menu').css('height', menuHeight + 'px');
            $('.type-tag').removeClass('active');
            $('#' + id).addClass('active');
            $('.pc-menu-items li').removeClass('active');
            $(this).addClass('active');
            $('.member-bar-btn').addClass('color-black');
        }
    });

    $('.pc-menu').on("mouseleave", function() {
        $('.pc-menu').addClass('un-open');
        $('.mobile-menu').addClass('un-open');
        $('.member-bar-btn').removeClass('color-black');
    });

    $('.pc-menu-items li').hover(function() {
        let id = $(this).data('id');
        if (id) {
            $('.pc-menu-items li').removeClass('active');
            $('.type-tag').removeClass('active');
            $('#' + id).addClass('active');
            $(this).addClass('active');
        }

        var menuHeight = $('.pc-menu .box').outerHeight(true);
        $('.pc-menu').css('height', menuHeight + 'px');
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

    $('.search-fixed, .search-close-btn').on('click', () => {
        $('.search-fixed').removeClass('active');
    });

    $('.search-box').on('click', (event) => {
        event.stopPropagation();
    });
});
