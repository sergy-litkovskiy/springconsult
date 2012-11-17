function SaleProductsListModule() {
    return function(sb){
        var emptyFieldMess      = 'Заполните поле',
            tooShortFieldMess   = 'Введите более 3 символов',
            _paymentForm,
            $overlayContainer;


        var _tryRegistrationProcess = function(){
            sb.publish({
                type : 'payment-registration-form-show',
                data : {
                        product_id : _paymentForm.find('input[name=ik_payment_id]').val(),
                        product_description : _paymentForm.find('input[name=ik_payment_desc]').val(),
                        product_price : _paymentForm.find('input[name=ik_payment_amount]').val()
                        }
            });
        }; 
        

        var _onClickPaymentButton = function(e){
            e.preventDefault();
            _paymentForm = $(this).parent();
            _tryRegistrationProcess();
        };        
        
        
        var _bindEvents = function() {  
            sb.bind('.button-payment', _onClickPaymentButton);
        };
        
        
        var _onPaymentRegistrationSuccess = function(saleHistoryData){
            _paymentForm.find('input[name=ik_baggage_fields]').val(saleHistoryData.recipients_id + '|' + saleHistoryData.sale_history_id);
            _paymentForm.submit();                      
        };
        
        
        return {
            init : function(){
                _bindEvents();
                sb.subscribe({
                    'payment-registration-success'   : _onPaymentRegistrationSuccess
                });
            },
            destroy : function(){ }
        };
    }
}