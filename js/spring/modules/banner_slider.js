function BannerSliderModule() {
    return function (sb) {
        var imgArr = [];

        var _makeImgUrl = function (num) {
            return {src: 'http://' + location.hostname + '/img/banner_img/banner_site_' + num + '.jpg'};
        };

        var _slideShow = function(){
            sb.$self().crossSlide({
                    sleep: 3,
                    fade : 1
                }, imgArr
            );
        };

        var _makeImgArr = function () {
            var i;
            for (i = 1; i <= 3; i++) {
                var num = (i < 10) ? '0' + i : i;
                imgArr.push(_makeImgUrl(num));
            }

            _slideShow();
        };

        return {
            init   : function () {
                _makeImgArr();
            },
            destroy: function () {
            }
        };
    };
}