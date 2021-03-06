'use strict';

require('../app-angular/node_modules/core-js/client/shim.min.js');
require('../app-angular/node_modules/zone.js/dist/zone.min.js');
require('../app-angular/node_modules/reflect-metadata/Reflect.js');

$(document).ready(function(){
    (function() {
        $('#logo-bar').scrollToFixed(); // Fixed Navigation Bar
    })();

    if(jQuery.isFunction(jQuery.fn.matchHeight)){
        $('.same-height').matchHeight();
    }

    $('[data-toggle="popover"]').popover({
        placement : 'top',
        trigger : 'hover'
    });

    if(jQuery.isFunction(jQuery.fn.hoverDirection)){
        $('.box').hoverDirection();

        // Example of calling removeClass method after a CSS animation
        $('.box .inner').on('animationend', function (event) {
            var $box = $(this).parent();
            $box.filter('[class*="-leave-"]').hoverDirection('removeClass');
        });
    }

    $("body").tooltip({
        selector: '[data-toggle="tooltip"]'
    });

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


(function($){$.fn.touchwipe=function(settings){var config={min_move_x:20,min_move_y:20,wipeLeft:function(){},wipeRight:function(){},wipeUp:function(){},wipeDown:function(){},preventDefaultEvents:true};if(settings)$.extend(config,settings);this.each(function(){var startX;var startY;var isMoving=false;function cancelTouch(){this.removeEventListener('touchmove',onTouchMove);startX=null;isMoving=false}function onTouchMove(e){if(config.preventDefaultEvents){e.preventDefault()}if(isMoving){var x=e.touches[0].pageX;var y=e.touches[0].pageY;var dx=startX-x;var dy=startY-y;if(Math.abs(dx)>=config.min_move_x){cancelTouch();if(dx>0){config.wipeLeft()}else{config.wipeRight()}}else if(Math.abs(dy)>=config.min_move_y){cancelTouch();if(dy>0){config.wipeDown()}else{config.wipeUp()}}}}function onTouchStart(e){if(e.touches.length==1){startX=e.touches[0].pageX;startY=e.touches[0].pageY;isMoving=true;this.addEventListener('touchmove',onTouchMove,false)}}if('ontouchstart'in document.documentElement){this.addEventListener('touchstart',onTouchStart,false)}});return this}})(jQuery);