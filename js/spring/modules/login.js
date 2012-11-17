function LoginModule() {
    return function(sb){
        var _validator;
         
         var _assignValidator = function(e) {
            _validator = sb.$('form#login-form').validate({
                rules: {
                    log:       'required',
                    pass:      'required'
                },
                messages: {
                    log:      'Введите логин',
                    pass:     'Введите пароль'
                }
            });
        };   


        var _init = function() {
            sb.$('input[type=text], input[type=password]').val('');
            sb.$('#login-form > p.error').hide();
            _assignValidator();
        };
        
     
        var _onClickLogin = function(e){
            if(sb.$('form#login-form').valid()){
                var log     = sb.$('input#log').val(),
                    pass    = sb.$('input#pass').val();

                sb.Login.authorize({log : log, pass : pass},  function(data){
                                        window.location = "/backend/login";
                                    }
                                    , function(mess){
                                        sb.$('#login-form > p.error').css('display', 'block').append(mess);
                                    }
                );
            }
            return false;
        };
        
        
        var _bindEvents = function() {  
            sb.bind('input#button_login', 'click', _onClickLogin);
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