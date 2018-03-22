/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// identity function for calling harmony imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ 2:
/***/ (function(module, exports) {

$('body').magnificPopup({
    type: 'image',
    delegate: 'a.mfp-gallery',
    fixedContentPos: true,
    fixedBgPos: true,
    overflowY: 'auto',
    closeBtnInside: true,
    preloader: true,
    removalDelay: 0,
    mainClass: 'mfp-fade',
    gallery:{enabled:true},
    callbacks: {
        buildControls: function() {
            console.log('inside'); this.contentContainer.append(this.arrowLeft.add(this.arrowRight));
        }
    }
});

$('.mfp-image').magnificPopup({
    type: 'image',
    closeOnContentClick: true,
    mainClass: 'mfp-fade',
    image: {
        verticalFit: true
    }
});

$('.product-cart').on('click', function () {
    var button = $(this),
        price = button.data('price'),
        title = button.data('title'),
        productId = button.data('product-id');

    var modalPopup = $('#prompt-popup').modal('show');

    modalPopup.find('.error').remove();

    var _paymentSend = function (e) {
        modalPopup.find('.error').remove();

        var name = modalPopup.find('input[name=name]').val(),
            email = modalPopup.find('input[name=email]').val(),
            phone = modalPopup.find('input[name=phone]').val();

        if (!name.length) {
            modalPopup.find('form').after('<label class="error">Поле Имя обязательно</label>');

            return false;
        }

        if (!email.length && !phone.length) {
            modalPopup.find('form').after('<label class="error">Заполните поле Email или Телефон, чтобы мы могли связаться с вами</label>');

            return false;
        }

        if (email.length) {
            var emailPattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

            if (!email.match(emailPattern)) {
                modalPopup.find('form').after('<label class="error">Неверный формат поля Email</label>');

                return false;
            }
        }

        var paymentUrl = '/shop/payment',
            data = {
                name     : name,
                email    : email,
                phone    : phone,
                price    : price,
                title    : title,
                productId: productId
            };

        $.ajax({
            type      : 'POST',
            url       : paymentUrl,
            dataType  : 'json',
            data      : data,
            beforeSend: function () {
                modalPopup.find('button.confirm').attr('disabled', true);
                modalPopup.find('button[data-dismiss="modal"]').attr('disabled', true);
            },
            success   : function (response) {
                modalPopup.find('.error').remove();
                modalPopup.find('h2').remove();

                if (response.success == true) {
                    modalPopup.find('form input').val('');
                    modalPopup.find('form').hide().after('<h2>Заказ успешно принят!</h2><p class="text-center">С вами свяжется наш менеджер для уточнения деталей заказа</p>');

                    setTimeout(function () {
                        modalPopup.find('h2').remove();
                        modalPopup.find('form').show();
                        modalPopup.find('button.confirm').attr('disabled', false);
                        modalPopup.find('button[data-dismiss="modal"]').attr('disabled', false);
                        modalPopup.modal('hide');
                    }, 3000);
                } else if (response.error == true) {
                    modalPopup.find('form').after('<label class="error">' + response.message + '</label>');
                    modalPopup.find('button.confirm').attr('disabled', false);
                    modalPopup.find('button[data-dismiss="modal"]').attr('disabled', false);
                }
            },
            error     : function (response) {
                modalPopup.find('form').after('<label class="error">' + response.message + '</label>');
                modalPopup.find('button.confirm').attr('disabled', false);
                modalPopup.find('button[data-dismiss="modal"]').attr('disabled', false);
            }
        });
    };

    modalPopup.find('button.confirm').on('click', _paymentSend);
    modalPopup.find('button[data-dismiss=modal]').on('click', function () {
        modalPopup.find('form input').val('');
    });
});

/***/ })

/******/ });
//# sourceMappingURL=shop.js.map