function ShortTextListModule() {
    return function(sb){

        var _init   = function () {
            sb.$('.short_text').each(function(i){
                var $this       = $(this),
                    article_id  = sb.$('#article_' + i).text(),
                    link        = $('<a class="detail_show_text" href="http://' + location.hostname + '/article/'+article_id+'"></a>');

                $this.data('full-text', $this.html());
                $this.data('short-text', $this.text().substr(0,340));
                if($this.data('img-path', $this.find('img:first').attr('src'))){
                    $this.html($this.data('short-text')).before('<div class="article_img"><img class="thumb_my" src="http://' + location.hostname + '/' + $this.data('img-path')+'" /></div>');
                }

                var $linkedText = link.html($this.data('short-text'));
                $this.html($linkedText).append('<a class="detail_show" href="http://' + location.hostname + '/article/'+article_id+'">...Подробнее</a>');
            });

            if(!sb.$('.short_text').html()){
                var img_count = sb.$self().find('img');
                img_count.each(function(i){
                    var tag = img_count[i];
                    var img = $(tag).attr('src');
                    $(tag).attr('src', 'http://' +  location.hostname + '/' + img );
                });
            }
        };

        return {
            init : function(){
                _init();
            },
            destroy : function(){ }
        };
    };
}