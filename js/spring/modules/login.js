function LoginModule() {
    return function(sb){
        var _validator;
         
         var _assignValidator = function(e) {
            _validator = sb.$('form').validate({
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

        var _clearErrorMess = function(mess) {
            sb.$('form p.error').html('').hide();
        };

        var _init = function() {
            sb.$('input[type=text], input[type=password]').val('');
            _clearErrorMess();
            _assignValidator();
        };


        var _onSuccess = function(mess) {
            window.location = "/backend/login";
        };


        var _onError = function(mess) {
            sb.$('form p.error').show().html(mess);
        };


        var _onClickLogin = function(e){
            e.preventDefault();
            _clearErrorMess();
            if(sb.$('form#login_form').valid()){
                var log     = sb.$('input#log').val(),
                    pass    = sb.$('input#pass').val();

                sb.Login.authorize({log : log, pass : pass}, _onSuccess, _onError);
            }
        };
        
        
        var _bindEvents = function() {  
            sb.bind('input[type=submit]', 'click', _onClickLogin);
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