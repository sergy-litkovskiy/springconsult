function ArticleListContainerModule() {
    return function(sb){
        var _onClickGoMailer = function(e){
            e.preventDefault();
         
            var _articleId    = $(this).parent().parent().data('article-id'),
                _articleTitle = $(this).parent().parent().data('article-title'),
                _isLanding    = $(this).parent().parent().data('is-landing');
              
            sb.publish({
                type : 'spec-mailer-container-show',
                data: {article_id : _articleId, article_title : _articleTitle, is_landing : parseInt(_isLanding)||0}
            });
        };
        
        
        var _bindEvents = function() {  
            sb.bind('.go-mailer-lp', 'click', _onClickGoMailer);
        };
        
        return {
            init : function(){
                _bindEvents();
            },
            destroy : function(){ }
        };
    }
}