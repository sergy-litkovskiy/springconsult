function SaleProductsListModule() {
    return function (sb) {
        var emptyFieldMess = 'Заполните поле',
            tooShortFieldMess = 'Введите более 3 символов',
            _paymentContainer,
            _paymentRegistrationForm,
            _paymentForm;

        var _init = function () {
            sb.$self().find('.sale-block-payment form input[type=text]').val('');
            sb.$self().find('.sale-block-payment form input[type=button]').prev('.error').remove();
        };

        var _assignValidator = function () {
            _paymentRegistrationForm.validate({
                rules   : {
                    recipient_name: {
                        required : true,
                        minlength: 3
                    },
                    email         : {
                        required: true,
                        email   : true
                    }
                },
                messages: {
                    recipient_name: {
                        required : emptyFieldMess,
                        minlength: tooShortFieldMess
                    },
                    email         : {
                        required: emptyFieldMess,
                        email   : "Введите email в допустимом формате"
                    }
                }
            });
        };


        var _onError = function(message){
            _paymentRegistrationForm.find('input[type=submit]').prev('.error').remove();
            _paymentRegistrationForm.find('input[type=submit]').before('<p class="error">' + message + '</p>');
        };


        var _onPaymentRegistrationSuccess = function (saleHistoryData) {
            window.location.reload();
            // _paymentForm = _paymentContainer.find('form[name=payment]');
            //
            // _paymentForm.find('input[name=data]').val(saleHistoryData.data);
            // _paymentForm.find('input[name=signature]').val(saleHistoryData.signature);
            //
            // _paymentForm.submit();
        };


        var _registrationProcess = function (e) {
            e.preventDefault();

            var _formData = {
                name       : _paymentRegistrationForm.find('input[name=recipient_name]').val(),
                email      : _paymentRegistrationForm.find('input[name=email]').val(),
                phone      : _paymentRegistrationForm.find('input[name=phone]').val(),
                product_id : _paymentRegistrationForm.find('input[name=product-id]').val(),
                price      : _paymentRegistrationForm.find('input[name=price]').val(),
                description: _paymentRegistrationForm.find('input[name=description]').val(),
                slug       : _paymentRegistrationForm.find('input[name=slug]').val()
            };

            sb.Payment.registration(_formData, _onPaymentRegistrationSuccess, _onError);
        };


        var _bindPaymentEvents = function () {
            _paymentRegistrationForm.find('button.add_payment_data').on('click', _registrationProcess);
        };


        var _tryRegistrationProcess = function () {
            _paymentContainer.find('.sale-block-description').fadeOut('fast');
            _paymentContainer.find('.sale-block-payment').fadeIn('fast');

            _assignValidator();
            _bindPaymentEvents();
        };


        var _onClickPaymentButton = function (e) {
            e.preventDefault();
            _paymentContainer = $(this).parent().parent().parent().parent().parent();
            _paymentRegistrationForm = _paymentContainer.find('.sale-block-payment form');
            _tryRegistrationProcess();
        };


        var _bindEvents = function () {
            sb.bind('.button-payment', _onClickPaymentButton);
        };


        return {
            init   : function () {
                _init();
                _bindEvents();
            },
            destroy: function () {
            }
        };
    };
}