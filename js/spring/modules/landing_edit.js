function LandingEditModule() {
    return function (sb) {
        var _validator;

        var _assignValidator = function () {
            _validator = sb.$('form').validate({
                rules: {
                    title:     'required',
                    unique:    'required'
                },
                messages: {
                    title:     'Enter title',
                    unique:    'Enter unique key'
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
                _bindEvents();
            },
            destroy: function () {
            }
        };
    };
}