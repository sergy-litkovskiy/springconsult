function SaleProductsListModule() {
    return function (sb) {
        var emptyFieldMess = 'Заполните поле',
            tooShortFieldMess = 'Введите более 3 символов',
            _paymentContainer,
            _saleProductsId,
            _paymentForm;

        var _init = function () {
            sb.$self().find('.sale-block-payment form input[type=text]').val('');
            sb.$self().find('.sale-block-payment form input[type=button]').prev('.error').remove();
        };


        var _assignValidator = function () {
            _paymentContainer.find('.sale-block-payment form').validate({
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
            _paymentContainer.find('.sale-block-payment form input[type=submit]').prev('.error').remove();
            _paymentContainer.find('.sale-block-payment form input[type=submit]').before('<p class="error">' + message + '</p>');
        };


        var _onPaymentRegistrationSuccess = function (saleHistoryData) {
            _paymentForm.find('input[name=ik_baggage_fields]').val(saleHistoryData.recipients_id + '|' + saleHistoryData.sale_history_id);
            _paymentForm.submit();
        };


        var _registrationProcess = function (e) {
            e.preventDefault();

            var _formData = {
                name            : _paymentContainer.find('.sale-block-payment form input[name=recipient_name]').val(),
                email           : _paymentContainer.find('.sale-block-payment form input[name=email]').val(),
                sale_products_id: _saleProductsId
            };

            sb.Payment.registration(_formData, _onPaymentRegistrationSuccess, _onError);
        };


        var _bindPaymentEvents = function () {
            _paymentContainer.find('.sale-block-payment input[type=submit]').on('click', _registrationProcess);
        };


        var _tryRegistrationProcess = function () {
            _saleProductsId = _paymentForm.find('input[name=ik_payment_id]').val();

            _paymentContainer.find('.sale-block-description').fadeOut('fast');
            _paymentContainer.find('.sale-block-payment').fadeIn('fast');

            _assignValidator();
            _bindPaymentEvents();
        };


        var _onClickPaymentButton = function (e) {
            e.preventDefault();
            _paymentContainer = $(this).parent().parent().parent().parent().parent();
            _paymentForm = $(this).parent();
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