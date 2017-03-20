(function($){
    $(document).ready(function(){

        /*----------------------------------------------------*/
        /*	Sticky Header
        /*----------------------------------------------------*/
        (function() {
            $('#logo-bar').scrollToFixed(); // Fixed Navigation Bar
         })();

        /*----------------------------------------------------*/
        /*	Same Height Div's
        /*----------------------------------------------------*/
        if(jQuery.isFunction(jQuery.fn.matchHeight)){
            $('.same-height').matchHeight();
        }

        /*----------------------------------------------------*/
        /*	Fraction Slider
        /*----------------------------------------------------*/
        if(jQuery.isFunction(jQuery.fn.fractionSlider)){
            $(window).load(function(){
                $('.slider').fractionSlider({
                    'fullWidth': 			true,
                    'controls': 			true,
                    'responsive': 			true,
                    'dimensions': 			"1920,450",
                    'timeout' :             5000,
                    'increase': 			true,
                    'pauseOnHover': 		true,
                    'slideEndAnimation': 	false,
                    'autoChange':           true
                });
            });
        }

        /*===========================================================*/
        /*	Isotope Portfolio
        /*===========================================================*/
        if(jQuery.isFunction(jQuery.fn.isotope)){
            jQuery('.portfolio_list').isotope({
                itemSelector : '.list_item',
                layoutMode : 'fitRows',
                animationEngine : 'jquery'
            });

            /* ---- Filtering ----- */
            jQuery('#filter li').click(function(){
                var $this = jQuery(this);
                if ( $this.hasClass('selected') ) {
                    return false;
                } else {
                    jQuery('#filter .selected').removeClass('selected');
                    var selector = $this.attr('data-filter');
                    $this.parent().next().isotope({ filter: selector });
                    $this.addClass('selected');
                    return false;
                }
            });
        }

        /*===========================================================*/
        /*	Image Hover Effect - HoverDirection.js
        /*===========================================================*/
        if(jQuery.isFunction(jQuery.fn.hoverDirection)){
            $('.box').hoverDirection();

            // Example of calling removeClass method after a CSS animation
            $('.box .inner').on('animationend', function (event) {
                var $box = $(this).parent();
                $box.filter('[class*="-leave-"]').hoverDirection('removeClass');
            });
        }

        /*----------------------------------------------------*/
        /*	Swipe Slider
         /*----------------------------------------------------*/
        window.mySwipe = new Swipe(document.getElementById('slider'), {
            startSlide: 2,
            speed: 400,
            auto: 3000,
            continuous: true,
            disableScroll: false,
            stopPropagation: false,
            callback: function(index, elem) {},
            transitionEnd: function(index, elem) {}
        });

        /*----------------------------------------------------*/
        /*	Accordians & Toggles
         /*----------------------------------------------------*/

        // $('.panel-group').on('shown.bs.collapse', function (e) {
        //     $(e.target).parent().addClass('active_acc');
        // });
        // $('.panel-group').on('hidden.bs.collapse', function (e) {
        //     $(e.target).parent().removeClass('active_acc');
        // });

        $("body").tooltip({
            selector: '[data-toggle="tooltip"]'
        });
    });
})(this.jQuery);

$(document).ready(function() {
    /*============
     BUTTON UP
     * ===========*/
    var btnUp = $('<div/>', {'class':'btntoTop'});
    btnUp.appendTo('body');
    $(document)
        .on('click', '.btntoTop', function() {
            $('html, body').animate({
                scrollTop: 0
            }, 700);
        });

    $(window)
        .on('scroll', function() {
            if ($(this).scrollTop() > 200)
                $('.btntoTop').addClass('active');
            else
                $('.btntoTop').removeClass('active');
        });
});


/**
 * jQuery Plugin to obtain touch gestures from iPhone, iPod Touch, iPad, and Android mobile phones
 * Common usage: wipe images (left and right to show the previous or next image)
 *
 * @author Andreas Waltl, netCU Internetagentur (http://www.netcu.de)
 */
(function($){$.fn.touchwipe=function(settings){var config={min_move_x:20,min_move_y:20,wipeLeft:function(){},wipeRight:function(){},wipeUp:function(){},wipeDown:function(){},preventDefaultEvents:true};if(settings)$.extend(config,settings);this.each(function(){var startX;var startY;var isMoving=false;function cancelTouch(){this.removeEventListener('touchmove',onTouchMove);startX=null;isMoving=false}function onTouchMove(e){if(config.preventDefaultEvents){e.preventDefault()}if(isMoving){var x=e.touches[0].pageX;var y=e.touches[0].pageY;var dx=startX-x;var dy=startY-y;if(Math.abs(dx)>=config.min_move_x){cancelTouch();if(dx>0){config.wipeLeft()}else{config.wipeRight()}}else if(Math.abs(dy)>=config.min_move_y){cancelTouch();if(dy>0){config.wipeDown()}else{config.wipeUp()}}}}function onTouchStart(e){if(e.touches.length==1){startX=e.touches[0].pageX;startY=e.touches[0].pageY;isMoving=true;this.addEventListener('touchmove',onTouchMove,false)}}if('ontouchstart'in document.documentElement){this.addEventListener('touchstart',onTouchStart,false)}});return this}})(jQuery);



