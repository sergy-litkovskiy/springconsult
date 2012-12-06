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


        var _reloadPage = function() {
            window.location.reload();
        };


        var _onSuccess = function(data) {
            sb.$self().find('img#loader').remove();
            var messageContainer = sb.UI.showMessage('<p class="success">Рассылка успешно стартовала!<br/>'+data+'</p>');
            messageContainer.find('.close').live('click', _reloadPage);
        };


        var _onError = function(mess) {
            sb.$self().find('img#loader').remove();
            sb.UI.showError('<p class="error">'+mess+'</p>');
        };


        var _onClickSendSubscribe = function(e){
            e.preventDefault();
            if (confirm('Do you really want to START MAIL PROCESS?')) {
                $(this).append('<img id="loader" src="/img/img_main/loader.gif"/>');
                var _articleId = $(this).parent().parent().data('article-id');
                sb.Mailer.sendSubscribersMail({'article_id':_articleId}, _onSuccess, _onError);
            }
        };

        
        var _bindEvents = function() {  
            sb.bind('.go-mailer-lp', 'click', _onClickGoMailer);
            sb.bind('.send_subscribe', 'click', _onClickSendSubscribe);
        };
        
        return {
            init : function(){
                _bindEvents();
            },
            destroy : function(){ }
        };
    };
}