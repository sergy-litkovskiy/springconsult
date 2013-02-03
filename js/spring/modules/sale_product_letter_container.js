function SaleProductLetterContainerModule() {
    return function(sb){
        var $overlayContainer           = {},
            $overlayMessageContainer    = {},
            _saleProductsId          = '',
            _text               = '',
            _letterTitle       = '',
            emptyFieldMess      = 'Заполните поле',
            tooShortFieldMess   = 'Введите более 3 символов',
            _validator;

        var _init = function(cb) {
            _hide();
        };
        
        
        var _assignValidator = function(e) {
            _validator = $($overlayContainer).find('form#spec-mailer-form').validate({
                    rules: {
                        theme: {
                            required: true,
                            minlength: 3
                        }
                    },
                    messages: {
                        theme: {
                            required: emptyFieldMess,
                            minlength: tooShortFieldMess
                        }
                    }
                });
        };


        var _hide = function(cb) {
            sb.$self().fadeOut(cb);
        };
        

        var _initTinymce = function(){
            sb.publish({
                type : 'init-custom-advanced-mce-for-element',
                data : 'spec-mailer-lp'
            });
        };


        var _fillSaleProductsLetterForm   = function(data){
            $('input[name=theme]', $overlayContainer).val(data.subject);
            $('textarea#spec-mailer-lp', $overlayContainer).val(data.text);
            $('input[name=sale_products_id]', $overlayContainer).val(data.sale_products_id);
        };


        var _onSaleProductsContainerShow = function(data){
            if(!data.id && !data.productData) return;

            var params = {el : '#' + sb.$self().attr('id')};
            $overlayContainer = sb.UI.showOverlay(params);
            _initTinymce();
            if(data.id ){
                $('input[name=sale_products_id]', $overlayContainer).val(data.id);
            }

            if(data.productData){
                _fillSaleProductsLetterForm(JSON.parse(data.productData));
            }
            _assignValidator();
            _bindEvents();
        };
               
                
        var _makeSaleProductsLetterData   = function(){
            return {             
                subject         : $('input[name=theme]', $overlayContainer).val(),
                text            : _text,
                saleProductsId  : $('input[name=sale_products_id]', $overlayContainer).val()
            };
        };

        
        var _onSuccess = function(data){
            $overlayMessageContainer = sb.UI.showMessage('<p class="success">' + data + '</p>');
            $($overlayMessageContainer).find('div.close').click(
                function(){
                    window.location.reload();
                }
            );
        };
        
        
        var _onError = function(message){
            $overlayMessageContainer = sb.UI.showError('<p class="error">' + message + '</p>'); 
        };
        
        
        var _trySubmitCatalogForm = function(saleProductsLetterData){
            var _loaderContainer = $($overlayContainer).find('#button').parent();
            _loaderContainer.html($('#loader').show());
//            sb.Mailer.sendSpecMailer(saleProductsLetterData, _onSuccess, _onError);
        };

        
        var _onClickSubmit = function(e){
            e.preventDefault();
            try{
                if($($overlayContainer).find('form#sale-products-letter-form').valid()){
                    _text = tinymce.get('spec-mailer-lp').getContent();
                    if(!_text) return false;
                    _trySubmitCatalogForm(_makeSaleProductsLetterData());
                } 
            } catch(errMess){
                alert(errMess);
            }
            return false;
        };
        
        
        var _onClickClose = function(e){
            e.preventDefault();
            $($overlayContainer).find('p.error-message').remove();
            $($overlayContainer).find('input[type=text], textarea').val('');
            var _loaderContainer = $($overlayContainer).find('#button_red').parent();
            _loaderContainer.html($('#loader').show());
            window.location.reload();
        };

        
        var _bindEvents = function() {  
            $overlayContainer.find('.button_submit').click(_onClickSubmit);
            $overlayContainer.find('.button_reset').click(_onClickClose);
        };
        
        return {
            init : function(){
                _init();
                sb.subscribe({
                    'sale-products-container-show'   : _onSaleProductsContainerShow
                });
            },
            destroy : function(){ }
        };
    }
}