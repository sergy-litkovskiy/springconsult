function PaymentRegistrationFormModule() {
    return function(sb){
        var emptyFieldMess      = 'Заполните поле',
            tooShortFieldMess   = 'Введите более 3 символов',
            $overlayContainer,
            _saleProductsId;

        var _init = function(){
            _hide();
        }; 
        
                
        var _hide = function(cb) {
            sb.$self().fadeOut(cb);
        };
        
        
        var _assignValidator = function() {
            $overlayContainer.find('form').validate({
                    rules: {
                        name: {
                            required: true,
                            minlength: 3
                        },
                        email: {
                            required: true,
                            email: true
                        }
                    },
                    messages: {
                        name: {
                            required: emptyFieldMess,
                            minlength: tooShortFieldMess
                        },
                        email: {
                            required: emptyFieldMess,
                            email: "Введите email в допустимом формате"
                    }
                }
            });
        };


        var _onError = function(message){
            sb.UI.showError('<p class="error">' + message + '</p>'); 
        };


        var _onSuccesPaymentRegistration = function(saleHistoryData){
            sb.publish({
                type : 'payment-registration-success',
                data : saleHistoryData
            });            
        };
        
        
        var _registrationProcess = function(){
            var _formData = {name : $('input[name=recipient_name]', $overlayContainer).val(),
                            email : $('input[name=email]', $overlayContainer).val(),
                            sale_products_id : _saleProductsId};
            sb.Payment.registration(_formData, _onSuccesPaymentRegistration, _onError);
        }; 
        

        var _onPaymentRegistrationFormShow = function(saleProductData){
            _saleProductsId     = saleProductData.product_id;
            $overlayContainer = sb.UI.showMessage({message : sb.$self().html()});

            _assignValidator();
            _bindEvents();
        }; 
        

        var _onClickPaymentRegistrationButton = function(e){
            e.preventDefault();
            _registrationProcess();
        };        
        
        
        var _bindEvents = function() {  
            $overlayContainer.find('input[type=submit]').live('click', _onClickPaymentRegistrationButton);
        };
        
        return {
            init : function(){
                _init();
                sb.subscribe({
                    'payment-registration-form-show'   : _onPaymentRegistrationFormShow
                });
            },
            destroy : function(){ }
        };
    };
}