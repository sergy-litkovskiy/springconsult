function EditSaleProductsFormModule() {
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
                        price: {
                            required: true
                        }
                    },
                    messages: {
                        title: {
                            required: emptyFieldMess,
                            minlength: tooShortFieldMess
                        },
                        price: {
                            required: emptyFieldMess
                        }
                    }
                });
        };

        var _onClickShowLandingArticlesList = function(e){
            e.preventDefault();
            sb.$('.sale-page-list').toggle();
        };        
        
        var _bindEvents = function() {  
            sb.bind('.show-landing-articles-list', _onClickShowLandingArticlesList);
        };
        
        return {
            init : function(){
                _assignValidator();
                _bindEvents();
                _init();
            },
            destroy : function(){ }
        };
    }
}