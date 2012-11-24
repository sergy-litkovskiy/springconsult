$(document).ready(function(){
    $('input#searchtext').watermark('Поиск');
     $('#content > div.short_text').each(function(i){
        var $this       = $(this),
            article_id  = $('#article_' + i).text(),
            link        = $('<a class="detail_show_text" href="http://' + location.hostname + '/articles/'+article_id+'"></a>');
        
        $this.data('full-text', $this.html());
        $this.data('short-text', $this.text().substr(0,340));
        if($this.data('img-path', $this.find('img:first').attr('src'))){
        $this.html($this.data('short-text')).before('<div class="article_img"><img class="thumb_my" src="http://' + location.hostname + '/' + $this.data('img-path')+'" /></div>');
        }

        var $linkedText = link.html($this.data('short-text'));
        $this.html($linkedText).append('<a class="detail_show" href="http://' + location.hostname + '/articles/'+article_id+'">...Подробнее</a>');
    });
////////////////////////////////////////////////////////////////
//img path for detail news page
    if(!$('div.short_text').html()){
        var img_count = $('#content').find('img');
        img_count.each(function(i){
            var tag = img_count[i];
            var img = $(tag).attr('src');
            $(tag).attr('src', 'http://' +  location.hostname + '/' + img );
        });
    }

////////////////////////////////////////////////////////////////
//search form
    $("input.search_button").click(function(){
        var $searchForm = $('#search_form'),
            searchText = $('input#searchtext', $searchForm);

            if(searchText.val().length > 0){
                $searchForm.submit();
            } else {
                searchText.css('color', 'red');
                searchText.attr('placeholder', 'Введите текст');
            }
        return false;
    });
 
 $("input.search_button").focus(function(){
        var $searchForm = $('#search_form'),
        searchText = $('input#searchtext', $searchForm);
        
        searchText.attr('placeholder', '');
    });
    
////////////////////////////////////////////////////////////////
//default rules for validation + loader
    ValidationDefaultParams = {rules: {
                                 name:  "required"
                                ,email: {required: true,
                                         email: true
                                        }
                            },
                        messages: {
                                 name: "Введите имя"
                                ,email : {required: "Введите e-mail",
                                            email : "Неверный формат e-mail"
                                         }
                            }
                        } 


    $loader = $('#loader');
    ////////////////////////////////////////////////////////////////

    var showOverlay = function($messBox){
                            $messBox.overlay({
                                mask: {color: "#000000", opacity: 0.5},
                                effect: "apple",
                                top: "40%",
                                load: true
                            }).load();
    };
    
    
    var ajaxSumbitHandler = function($form, formFieldsList, $messBox, message){
                                $(formFieldsList, $form).val('');
                                $messBox.html('<a class="close"></a>' + message);
                                showOverlay($messBox);
    };
    
    
    var _sendAjaxPost = function($form, formFieldsList, $messBox, ajaxParams){
                $.ajax({
                    type: "POST",
                    url: ajaxParams.url,
                    data: ajaxParams.data,
                    dataType: 'json',
                    success: function(msg){
                        $loader.fadeOut().unmask();
                        if(msg.success !== null){
                            ajaxSumbitHandler($form, formFieldsList, $messBox, ajaxParams.onSuccessMess);
                        }
                        if(msg.message !== null){
                            ajaxSumbitHandler($form, formFieldsList, $messBox, msg.message);
                        }
                        if(msg.popup !== null){
                            ajaxSumbitHandler($form, formFieldsList, $messBox, msg.data);
                        }
                        $loader.fadeOut().unmask();

                            $('a#success').click(function(){
                                $('#subscribe_mess').fadeOut('slow');
                                $('#exposeMask').remove();
                            });

                            $('a.close').live('click', function(){
                                var $this = $(this).parent();
                                $this.overlay().close();
                            });
                    }
                });
    };
    

    var sendMessage = function($form, ajaxParams, $messBox, formFieldsList, ValidationSpecificParams, $containerForm){
        $loader.show().mask();
        if(ValidationSpecificParams) $.extend(true, ValidationDefaultParams, ValidationSpecificParams);
 
        var message_validator = $form.validate({
            rules:      ValidationDefaultParams.rules,
            messages:   ValidationDefaultParams.messages,
            invalidHandler: function(e) {
                $loader.fadeOut().unmask();
                return false;
            },
            submitHandler: function() {
                if($form.valid()){
                    if($containerForm) $containerForm.overlay().close();
                    _sendAjaxPost($form, formFieldsList, $messBox, ajaxParams);
                } else {
                    $loader.fadeOut().unmask();
                }
                
                return false;
            }
        });
    };


////////////////////////////////////////////////////////////////
//send contact_form message
    $("input.add_mess").click(function(){
        var $contactForm    = $('#contact_form'),
            $messBox        = $('#mess_mailsent'),
            name            = $('input#name', $contactForm).val(),
            email           = $('input#email', $contactForm).val(),
            text            = $('textarea#text', $contactForm).val(),
            formFieldsList  = 'input#name,input#email,textarea#text',
            ajaxParams      = {'data'           : {"name" : name ,"email" : email,"text" : text},
                                'url'           : '/contact_form/send',
                                'onSuccessMess' : "<p class='success'>Сообщение успешно отправлено!</p>"
                              };
                            
            sendMessage($contactForm, ajaxParams, $messBox, formFieldsList, { rules: {text: "required"}, messages: {text: "Введите текст"} }, false);
    });


    
////////////////////////////////////////////////////////////////
    $('#main_content > div.search_result').each(function(){
                var $this = $(this);

                $this.find('img:first').remove();
    });

});                
//////////////////////////////////////////////////////////////// 
function GotoURL(URL,text){
 if (confirm(text)) {
     parent.location.href=URL;
    }
}