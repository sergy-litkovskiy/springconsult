function MainFormEditModule() {
    return function (sb) {
        var _arrAvailableTags = [],
            _validator;

        var _initTagEdit = function () {
            sb.$('input.tag').tagedit({
                autocompleteOptions: {
                    source: _arrAvailableTags
                }
            });
        };

        var _initDatePicker = function () {
            sb.$('.datepicker').datepicker({
                changeMonth    : true,
                changeYear     : true,
                dateFormat     : 'yy-mm-dd',
                showButtonPanel: true
            });
        };

        var _assignValidator = function () {
            _validator = sb.$('form').validate({
                rules   : {
                    title     : 'required',
                    created_at: 'required'
                },
                messages: {
                    title     : 'Enter title',
                    created_at: 'Enter date'
                }
            });
        };

        var _loadAvailableTags = function () {
            $.ajax({
                type    : "POST",
                url     : "/admin/index_admin/ajax_get_available_tag",
                data    : {},
                dataType: 'json',
                success : function (data) {
                    $.each(data, function (i, item) {
                        var tagParam = {
                            id   : item.id,
                            label: item.description,
                            value: item.description
                        };
                        _arrAvailableTags.push(tagParam);
                    });
                    _initTagEdit();
                }
            });
        };

        var _onClickSubmit = function (e) {
            e.preventDefault();
            _assignValidator();
            if (sb.$('form').valid()) {
                sb.$('form').submit();
            }
        };

        var _bindEvents = function () {
            sb.bind('input[type=submit]', 'click', _onClickSubmit);
        };

        return {
            init   : function () {
                _initDatePicker();
                _loadAvailableTags();
                _bindEvents();
            },
            destroy: function () {
            }
        };
    };
}