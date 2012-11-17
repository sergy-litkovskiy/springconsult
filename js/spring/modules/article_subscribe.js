function ArticleSubscribeModule() {
    return function(sb){
        var $overlayContainer           = {},
            $overlayMessageContainer    = {},
            emptyFieldMess      = 'Заполните поле',
            emailNotValid       = 'Невалидный email',
            tooShortFieldMess   = 'Введите более 3 символов',
            _validator;


        var _init   = function(){
            sb.$('form input[type=text]').val('');
        };
        
        
        var _assignValidator = function() {
             _validator = $overlayContainer.find('form').validate({
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
                            email: emailNotValid
                    }
                }
            });
        };
  

        var _makeDownloadFromData   = function(){
            return {             
                name            : $('input#name', $overlayContainer.find('form')).val(),
                email           : $('input#email', $overlayContainer.find('form')).val()
            };
        };

        
        var _onSuccess = function(data){
            $overlayContainer.find('form input.subscribe_action').show();
            $overlayContainer.find('#loader').hide();
            $overlayMessageContainer = sb.UI.showMessage(data);
            $($overlayMessageContainer).find('div.close').click(
                function(){
                    sb.$self().find('input[name=email]').val('');                    
                    window.location.reload();
                }
            );
        }
        
        
        var _onError = function(message){
            $overlayMessageContainer = sb.UI.showError('<p class="error">' + message + '</p>'); 
        }
        
        
        var _trySubmitDownloadForm = function(e){
            e.preventDefault();
            if($overlayContainer.find('form').valid()){
                $overlayContainer.find('form input.subscribe_action').fadeOut().before(sb.$('#loader').fadeIn());
                sb.Subscribe.subscribe(_makeDownloadFromData(), _onSuccess, _onError);
            }
        };

        
        var _onClickShowSubscribeForm = function(e){
            e.preventDefault();
            $overlayContainer = sb.UI.showMessage({message : sb.$('#article_subscribe_form').html()});
            _assignValidator();
            $overlayContainer.find('.subscribe_action').live('click', _trySubmitDownloadForm);
        };
        
    
        
        var _bindEvents = function() {  
            sb.bind('.detail_show', 'click', _onClickShowSubscribeForm);
        };
        
        return {
            init : function(){
                _init();
                _bindEvents();
            },
            destroy : function(){ }
        };
    }
}