function SpecMailerContainerModule() {
    return function(sb){
        var $overlayContainer           = {},
            $overlayMessageContainer    = {},
            _articleId          = '',
            _text               = '',
            _articleTitle       = '',
            _isLanding          = '',
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
                        },
                        landing: {
                            required: true
                        }
                    },
                    messages: {
                        theme: {
                            required: emptyFieldMess,
                            minlength: tooShortFieldMess
                        },
                        landing: {
                            required: emptyFieldMess
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
                
                
        var _onSpecMailerContainerShow = function(data){
            if(!data.article_id) return;
           _articleId       = data.article_id;
           _articleTitle    = data.article_title;
           _isLanding       = data.is_landing;
        
            var params = {el : '#' + sb.$self().attr('id')};
            $overlayContainer = sb.UI.showOverlay(params);

            _assignValidator();
            _initTinymce();
            _bindEvents();
        };
               
                
        var _makeSpecMailerData   = function(){
            return {             
                theme           : $('input[name=theme]', $overlayContainer).val(),
                text            : _text,
                landingPageId   : $('input[name=landing]:checked', $overlayContainer).val(),
                articleId       : _articleId,
                articleTitle    : _articleTitle,
                isLanding       : _isLanding
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
        
        
        var _trySubmitCatalogForm = function(specMailerData){
            var _loaderContainer = $($overlayContainer).find('#button').parent();
            _loaderContainer.html($('#loader').show());
            sb.Mailer.sendSpecMailer(specMailerData, _onSuccess, _onError);
        };

        
        var _onClickSubmit = function(e){
            e.preventDefault();
            try{
                if($($overlayContainer).find('form#spec-mailer-form').valid()){
                    _text = tinymce.get('spec-mailer-lp').getContent();
                    if(!_text) return false;
                    _trySubmitCatalogForm(_makeSpecMailerData());
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
        
        
        var _onClickShowLandingList = function(e){
            e.preventDefault();
            $($overlayContainer).find('.landing-list').toggle();
        };        
        
        var _bindEvents = function() {  
            $overlayContainer.find('.show-landing-list').click(_onClickShowLandingList);
            $overlayContainer.find('.button_submit').click(_onClickSubmit);
            $overlayContainer.find('.button_reset').click(_onClickClose);
        };
        
        return {
            init : function(){
                _init();
                sb.subscribe({
                    'spec-mailer-container-show'   : _onSpecMailerContainerShow
                });
            },
            destroy : function(){ }
        };
    }
}