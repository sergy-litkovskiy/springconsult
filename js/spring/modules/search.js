function SearchModule() {
    return function(sb){

        var $searchForm = sb.$self();

        var _init   = function () {
            sb.$('input#searchtext').val('');
            sb.$('input#searchtext').watermark('Поиск');
        };
        

        var _onClickSubmit = function(e){
            e.preventDefault();
            var searchText = $('input#searchtext', $searchForm);

            if(searchText.val().length > 0){
                $searchForm.submit();
            } else {
                searchText.css('color', 'red');
                searchText.attr('placeholder', 'Введите текст');
            }
        };


        var _onFocus = function(e){
            var searchText = $('input#searchtext', $searchForm);
            searchText.attr('placeholder', '');
        };

        
        var _bindEvents = function() {  
            sb.bind('.search_button', 'click', _onClickSubmit);
            sb.bind('input#searchtext', 'focus', _onFocus);
        };


        return {
            init : function(){
                _init();
                _bindEvents();
            },
            destroy : function(){ }
        };
    };
}