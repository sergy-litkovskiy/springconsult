
$(document).ready(function(){
        var $tableContainer = $("#main_content");
        
        $("#sortable").sortable();
        $("#main_content").tablesorter();

////////////////////////////////////////////////////////////////
       $('button#sequence_actual').click(function(){
            $('ul#sortable').before("<img style='float:left' src='/img/img_main/loader.gif'/>");

            var res = $( "#sortable" ).sortable('toArray');
            $.ajax({
             type: "POST",
             url: "/admin/index_admin/ajax_new_actual_sequence_num",
             data: {ids: res},
             success: function(data){
                   if( data === 'true' ){
                    window.location.reload();
                   }
             }
            });
            return false;
        });
        
////////////////////////////////////////////////////////////////
//aforizmus
    $('#add_new_aforizmus').on('click', function(e){
        var $tableAddNewContainer = $('#add_new_content_container');
        $tableAddNewContainer.slideToggle("fast", "linear");
    });

    $('a.button_aforizmus').on('click', function(e){
        e.preventDefault();

        var $rowScope       = $(this).parent().parent(),
            ajaxUrl         = $(this).data('url'),
            $author         = $('input#author', $rowScope),
            $text           = $('textarea#text', $rowScope),
            $messBox        = $('#mess_mailsent');
 
            $rowScope.find('p.error').remove();
            if(_checkValid($author, $text) !== true){
                return false;
            }

            $.ajax({
               type: "POST",
               url:  ajaxUrl,
               data: {"author" : $author.val(), "text" : $text.val()},
               dataType: 'json',
               success: function(msg){
                   if(msg.error == null){
                        ajaxSumbitHandler($messBox, '<p class="success">'+msg.success+'</p>');
                   }
                   else{
                        alert(msg.error);
                        return false;
                   }
               }
            });

    });
    
    var _checkValid = function($author, $text){
        if($author.val().length < 1){
            $author.after('<p class="error">Введите имя автора</p>');
            return false;
        }
        if($text.val().length < 1){
            $text.after('<p class="error">Введите текст</p>');
            return false;
        }
        return true;
    };
    
    
    var ajaxSumbitHandler = function($messBox, message){
        $messBox.html(message);  
        showOverlay($messBox);
    };


    var showOverlay = function($messBox){
        $messBox.overlay({
            mask: {color: "#000000", opacity: 0.5},
            effect: "apple",
            top: "40%",
            load: true,
            onClose: function(done){
                window.location.reload(true);
            }
        });
    };
    
     $('a.edit_aforizmus').on('click', function(e){
        e.preventDefault();

        var ajaxUrl         = $(this).data('url'),
            $authorTd       = $(this).parent().prev().prev(),
            authorText      = $authorTd.text(),
            $authorInput    = $('<input name="author" id="author" value="' + authorText.replace(/(^\s+)|(\s+$)/g, "") + '"/>'),
            $textTd         = $(this).parent().prev(),
            textText        = $textTd.text(),
            $textInput      = $('<textarea name="text" id="text">' + textText.replace(/(^\s+)|(\s+$)/g, "") + '</textarea>'),
            $buttonSave     = $('<a class="button_aforizmus" data-url="'+ ajaxUrl + '" href="#"><img style="width:25px" src="http://' +  location.hostname + '/img/img_main/floppy_disk.png"/></a>');

            $authorTd.html($authorInput);
            $textTd.html($textInput);
            $(this).parent().html($buttonSave);
    });
});