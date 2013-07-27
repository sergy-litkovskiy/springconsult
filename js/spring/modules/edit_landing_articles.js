function EditLandingArticlesFormModule() {
    return function(sb){
        var emptyFieldMess      = 'Заполните поле',
            tooShortFieldMess   = 'Введите более 3 символов',
            _validator;

        
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

        var _onClickShowLandingArticlesList = function(e){
            e.preventDefault();
            sb.$('.landing-articles-list').toggle();
        };        
        
        var _bindEvents = function() {  
            sb.bind('.show-landing-articles-list', _onClickShowLandingArticlesList);
        };
        
        return {
            init : function(){
                _assignValidator();
                _bindEvents();
            },
            destroy : function(){ }
        };
    }
}