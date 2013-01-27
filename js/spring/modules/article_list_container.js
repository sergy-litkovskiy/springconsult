function ArticleListContainerModule() {
    return function(sb){
        var _loader = '<img id="img_loader" src="/img/img_main/ajax-loader_red.gif" alt="Loading"/>';
        var _currentContainer;

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


        var _onLoaderHide = function(){
            _currentContainer.next('#img_loader').remove();
            _currentContainer.fadeIn();
        };


//        var _onChangeStatusSuccess = function(){
////            _onLoaderHide();
//            _reloadPage();
//        };


        var _onChangeStatusError = function(message){
            _onLoaderHide();
            $overlayMessageContainer = sb.UI.showError('<p class="error">' + message + '</p>');
            $($overlayMessageContainer).find('div.close').click(
                function(){
                    _reloadPage();
                }
            );
        };


        var _onClickChangeStatus = function(e){
            e.preventDefault();
            _currentContainer = $(this).parent('form');
            var data = {
                status  : $(this).val(),
                id      : _currentContainer.attr('id'),
                table   : _currentContainer.data('table')
            };
            _currentContainer.hide().after(_loader);
            sb.Status.statusChange(data, _reloadPage, _onChangeStatusError);
        };


        var _onClickDrop = function(e){
            e.preventDefault();
            _currentContainer = $(this);
            if (confirm('Are you sure? Do you really want to DELETE?')) {
                var data = {};
                data.email = $(this).data('email');
                data.file = $(this).data('file');
                $(this).hide().after(_loader);
                sb.ItemMove.drop(data, _reloadPage, _onChangeStatusError);
            }
        };


        var _onClickChangeIsTop = function(e){
//            e.preventDefault();
            var _currentCheckbox = $(this);

            var data = {};
            data.id = $(this).val();
            data.table = $(this).data('table');
            data.is_top = _currentCheckbox.is(':checked') ? 1 : 0;
console.log(data);
            $(this).hide().after(_loader);
            sb.Status.statusIsTopChange(data, _reloadPage, _onChangeStatusError);
        };


        var _bindEvents = function() {  
            sb.bind('.go-mailer-lp', 'click', _onClickGoMailer);
            sb.bind('.send_subscribe', 'click', _onClickSendSubscribe);
            sb.bind('.status-change input:radio', 'change', _onClickChangeStatus);
            sb.bind('.drop', 'click', _onClickDrop);
            sb.bind('input:checkbox[name=is_top]', 'click', _onClickChangeIsTop);
        };
        
        return {
            init : function(){
                _bindEvents();
            },
            destroy : function(){ }
        };
    };
}