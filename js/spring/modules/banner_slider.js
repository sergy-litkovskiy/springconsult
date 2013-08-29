function BannerSliderModule() {
    return function (sb) {
        var imgArr = [], i;

        var _makeImgUrl = function (i) {
            return {src: 'http://' + location.hostname + '/img/banner_img/po_mokromu_' + i + '.jpg'};
        };

        var _slideShow = function(){
            sb.$self().crossSlide({
                    sleep: 3,
                    fade : 1
                }, imgArr
            );
        };

        var _makeImgArr = function (i) {
            for (i = 1; i <= 3; i++) {
                imgArr.push(_makeImgUrl(i));
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