function ArticleListContainerModule() {
    return function (sb) {
        var _loader = '<img id="img_loader" src="/img/img_main/ajax-loader_red.gif" alt="Loading"/>';
        var _currentContainer;

        var _onClickGoMailer = function (e) {
            e.preventDefault();

            var _articleId = $(this).parent().parent().data('article-id'),
                _articleTitle = $(this).parent().parent().data('article-title'),
                _isLanding = $(this).parent().parent().data('is-landing');

            sb.publish({
                type: 'spec-mailer-container-show',
                data: {article_id: _articleId, article_title: _articleTitle, is_landing: parseInt(_isLanding) || 0}
            });
        };


        var _reloadPage = function () {
            window.location.reload();
        };


        var _onSuccess = function (data) {
            sb.$self().find('img#loader').remove();
            var messageContainer = sb.UI.showMessage('<p class="success">Рассылка успешно стартовала!<br/>' + data + '</p>');
            messageContainer.find('.close').live('click', _reloadPage);
        };


        var _onError = function (mess) {
            sb.$self().find('img#loader').remove();
            sb.UI.showError('<p class="error">' + mess + '</p>');
        };


        var _onClickSendSubscribe = function (e) {
            e.preventDefault();
            if (confirm('Do you really want to START MAIL PROCESS?')) {
                $(this).append('<img id="loader" src="/img/img_main/loader.gif"/>');
                var _articleId = $(this).parent().parent().data('article-id');
                sb.Mailer.sendSubscribersMail({'article_id': _articleId}, _onSuccess, _onError);
            }
        };


        var _onLoaderHide = function () {
            _currentContainer.next('#img_loader').remove();
            _currentContainer.fadeIn();
        };


        var _onChangeStatusError = function (message) {
            _onLoaderHide();
            var $overlayMessageContainer = sb.UI.showError('<p class="error">' + message + '</p>');
            $($overlayMessageContainer).find('div.close').click(
                function () {
                    _reloadPage();
                }
            );
        };


        var _onClickChangeStatus = function (e) {
            e.preventDefault();
            _currentContainer = $(this).parent('form');
            var data = {
                status: $(this).val(),
                id    : _currentContainer.attr('id'),
                table : _currentContainer.data('table')
            };
            _currentContainer.hide().after(_loader);
            sb.Status.statusChange(data, _reloadPage, _onChangeStatusError);
        };


        var _onClickDrop = function (e) {
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


        var _onClickChangeIsTop = function (e) {
            var _currentCheckbox = $(this);

            var data = {};
            data.id = $(this).val();
            data.table = $(this).data('table');
            data.is_top = _currentCheckbox.is(':checked') ? 1 : 0;

            $(this).hide().after(_loader);
            sb.Status.statusIsTopChange(data, _reloadPage, _onChangeStatusError);
        };


        var _base64_decode = function (data) {
            var b64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
            var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
                ac = 0,
                dec = "",
                tmp_arr = [];

            if (!data) {
                return data;
            }

            data += '';

            do { // unpack four hexets into three octets using index points in b64
                h1 = b64.indexOf(data.charAt(i++));
                h2 = b64.indexOf(data.charAt(i++));
                h3 = b64.indexOf(data.charAt(i++));
                h4 = b64.indexOf(data.charAt(i++));

                bits = h1 << 18 | h2 << 12 | h3 << 6 | h4;

                o1 = bits >> 16 & 0xff;
                o2 = bits >> 8 & 0xff;
                o3 = bits & 0xff;

                if (h3 == 64) {
                    tmp_arr[ac++] = String.fromCharCode(o1);
                } else if (h4 == 64) {
                    tmp_arr[ac++] = String.fromCharCode(o1, o2);
                } else {
                    tmp_arr[ac++] = String.fromCharCode(o1, o2, o3);
                }
            } while (i < data.length);

            dec = tmp_arr.join('');

            return dec;
        };


        var _onClickEditSaleLetter = function (e) {
            var _saleProductsLettersData = $(this).data('sale-products-letters');
            sb.publish({
                type: 'sale-products-container-show',
                data: {productData: _base64_decode(_saleProductsLettersData)}
            });
        };


        var _onClickAddSaleLetter = function (e) {
            var _saleProductsLettersId = $(this).parent().parent().data('article-id');
            sb.publish({
                type: 'sale-products-container-show',
                data: {id: _saleProductsLettersId}
            });
        };

        var _subscribeEmailList = function (e) {
            e.preventDefault();
            var $registredListTd = $(this).parent().parent();
            $registredListTd.find('.landing_registred_list').toggle(600);
        };

        var _bindEvents = function () {
            sb.bind('.go-mailer-lp', 'click', _onClickGoMailer);
            sb.bind('.send_subscribe', 'click', _onClickSendSubscribe);
            sb.bind('.status-change input:radio', 'change', _onClickChangeStatus);
            sb.bind('.drop', 'click', _onClickDrop);
            sb.bind('input:checkbox[name=is_top]', 'click', _onClickChangeIsTop);
            sb.bind('.edit_sale_products_letters', 'click', _onClickEditSaleLetter);
            sb.bind('.new_sale_products_letters', 'click', _onClickAddSaleLetter);
            sb.bind('a.registred_detail', 'click', _subscribeEmailList);
        };

        return {
            init   : function () {
                _bindEvents();
            },
            destroy: function () {
            }
        };
    };
}