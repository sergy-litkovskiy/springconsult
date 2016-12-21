function CategoryListContainerModule() {
    return function (sb) {
        var _loader = '<img id="img_loader" src="/img/img_main/ajax-loader_red.gif" alt="Loading"/>';
        var _currentContainer;

        var _reloadPage = function () {
            window.location.reload();
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


        var _bindEvents = function () {
            sb.bind('.status-change input:radio', 'change', _onClickChangeStatus);
            sb.bind('.drop', 'click', _onClickDrop);
            sb.bind('input:checkbox[name=is_top]', 'click', _onClickChangeIsTop);
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