function ContactFormModule() {
    return function(sb){
        var $overlayContainer           = {},
            $overlayMessageContainer    = {},
            emptyFieldMess      = 'Заполните поле',
            emailNotValid       = 'Невалидный email',
            tooShortFieldMess   = 'Введите более 3 символов',
            _validator,
            _currentForm,
            _loaderContainer;


        var _init   = function () {
            sb.$('input[type=text]').val('');
            sb.$('textarea').val('');
        };
        
        
        var _assignValidator = function(){
            _validator = _currentForm.validate({
                rules: {
                    recip_name: {
                        required: true,
                        minlength: 3
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    text: {
                        required: true
                    }
                },
                messages: {
                    recip_name: {
                        required: emptyFieldMess,
                        minlength: tooShortFieldMess
                    },
                    email: {
                        required: emptyFieldMess,
                        email: emailNotValid
                    },
                    text: {
                        required: emptyFieldMess
                    }
                }
            });
        };
  

        var _makeDownloadFromData   = function(){
            return {             
                name    : _currentForm.find('input[name=recip_name]').val(),
                email   : _currentForm.find('input[name=email]').val(),
                text    : _currentForm.find('textarea').val()
            };
        };

        
        var _onSuccess = function(data){
            _loaderContainer.hide();
            _currentForm.find('.add_mess').fadeIn();
            $overlayMessageContainer = sb.UI.showMessage(data);
            $($overlayMessageContainer).find('div.close').click(
                function(){
                    _init();
                    window.location.reload();
                }
            );
        };
        
        
        var _onError = function(message){
            _loaderContainer.hide();
            _currentForm.find('.add_mess').fadeIn();
            $overlayMessageContainer = sb.UI.showError('<p class="error">' + message + '</p>');
            $($overlayMessageContainer).find('div.close').click(
                function(){
                    _init();
                    window.location.reload();
                }
            );
        };
        
        
        var _trySubmitDownloadForm = function(downloadFormData){
            _loaderContainer = sb.$('#loader');
            _currentForm.find('.add_mess').fadeOut().before(_loaderContainer.fadeIn());
            sb.Contacts.sendContactMessage(downloadFormData, _onSuccess, _onError);
        };

        
        var _onClickSubmit = function(e){
            e.preventDefault();
            _currentForm = $(this).parent('form');
            _assignValidator();
            if(_currentForm.valid()) _trySubmitDownloadForm(_makeDownloadFromData());
        };
        
    
        
        var _bindEvents = function() {  
            sb.bind('.add_mess', 'click', _onClickSubmit);
        };
        
        return {
            init : function(){
                _init();
                _bindEvents();
            },
            destroy : function(){ }
        };
    };
}