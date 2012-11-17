function EditSalePageFormModule() {
    return function(sb){
        var emptyFieldMess      = 'Заполните поле',
            tooShortFieldMess   = 'Введите более 3 символов',
            _validator;

        
        var _init = function(){
            sb.publish({
                type : 'init-advanced-mce-for-all-textarea'
            });
        };   
        
        
        var _assignValidator = function(e) {
            _validator = sb.$self().validate({
                    rules: {
                        title: {
                            required: true,
                            minlength: 3
                        },
                        slug: {
                            required: true
                        }
                    },
                    messages: {
                        title: {
                            required: emptyFieldMess,
                            minlength: tooShortFieldMess
                        },
                        slug: {
                            required: emptyFieldMess
                        }
                    }
                });
        };

        return {
            init : function(){
                _assignValidator();
                _init();
            },
            destroy : function(){ }
        };
    }
}