function LandingDownloadsModule() {
    return function(sb){
        var $overlayContainer           = {},
            $overlayMessageContainer    = {},
            emptyFieldMess      = 'Заполните поле',
            emailNotValid       = 'Невалидный email',
            _validator;

        var _assignValidator = function(e) {
            _validator = sb.$self().validate({
                    rules: {
                        email: {
                            required: true,
                            email   : true
                        }
                    },
                    messages: {
                        email: {
                            required: emptyFieldMess,
                            email   : emailNotValid
                        }
                    }
                });
        };
  

        var _makeDownloadFromData   = function(){
            return {             
                email               : sb.$self().find('input[name=email]').val(),
                landing_page_id     : sb.$self().find('input[name=page]').val(),
                landing_article_id  : sb.$self().find('input[name=article]').val()
            };
        };

        
        var _onSuccess = function(data){
            $('#loader').hide();
            $overlayMessageContainer = sb.UI.showMessage('<p class="success">' + data + '</p>');
            $($overlayMessageContainer).find('div.close').click(
                function(){
                    sb.$self().find('input[name=email]').val('');                    
                    window.location.reload();
                }
            );
        }
        
        
        var _onError = function(message){
            $('#loader').hide();            
            $overlayMessageContainer = sb.UI.showError('<p class="error">' + message + '</p>'); 
        }
        
        
        var _trySubmitDownloadForm = function(downloadFormData){
            var _loaderContainer = $($overlayContainer).find('#button').parent();
            _loaderContainer.html($('#loader').show());
            sb.Landing.getLandingResourceMp3(downloadFormData, _onSuccess, _onError);
        };

        
        var _onClickSubmit = function(e){
            e.preventDefault();
            try{
                if(sb.$self().valid()){
                    _trySubmitDownloadForm(_makeDownloadFromData());
                } 
            } catch(errMess){
                alert(errMess);
            }
            return false;
        };
        
    
        
        var _bindEvents = function() {  
            sb.bind('.download', 'click', _onClickSubmit);
        };
        
        return {
            init : function(){
                _bindEvents();
                _assignValidator();
            },
            destroy : function(){ }
        };
    }
}