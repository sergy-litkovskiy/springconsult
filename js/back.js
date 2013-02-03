
$(document).ready(function(){
        var $tableContainer = $("#main_content"),
            delLinks        = $("a[title=delete]", $tableContainer);

//        if(delLinks.length > 0){
//            delLinks.each(function(e){
//                var delUrl = $(delLinks[e]).data("email");
//               $(delLinks[e]).bind('click', function(m){
//                    GotoURL(delUrl, 'Are you sure? Do you really want to DELETE?');
//               });
//            });
//        }
        
        $("#sortable").sortable();
        $("#main_content").tablesorter();

////////////////////////////////////////////////////////////////        
//load datepicker
        $('.datepicker').datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd',
                    showButtonPanel: true
        });

////////////////////////////////////////////////////////////////
   //form validation
       $("input#form_button").click(function(){
        var message_validator = $("#back_form").validate({
            rules: {
                 title:       'required',
                 created_at:  'required'
            },
            messages: {
                 title:      'Enter title',
                 created_at: 'Enter date'
            }
        });
        if(message_validator.valid){
            $('form#back_form').submit();
        }
        return false;
  });

////////////////////////////////////////////////////////////////
   //form validation
    $("input[name=edit_landing]").click(function(e){
        e.preventDefault();
        var message_validator = $("#back_form_landing").validate({
            rules: {
                 title:     'required',
                 unique:    'required'
            },
            messages: {
                 title:     'Enter title',
                 unique:    'Enter unique key'
            }
        });
        if($("#back_form_landing").valid){
            $('form#back_form_landing').submit();
        }
  });

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
    $('#add_new_aforizmus').live('click', function(e){
        var $tableAddNewContainer = $('#add_new_content_container');
        $tableAddNewContainer.slideToggle("fast", "linear");
    });

    $('a.button_aforizmus').live('click', function(e){
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
    
     $('a.edit_aforizmus').live('click', function(e){
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
	
/////////////////start TAG process/////////////////    
//    var TagManager = (function(){
//        var availableTagSet, assignedTagSet, draftTagSet;
//
//        $.ajax({
//             type: "POST",
//             url: "/admin/index_admin/ajax_get_available_tag",
//             data: {},
//             dataType: 'json',
//             success: function (data){
//
//                var _arrAvailableTags = [], _arrAssignedTags  = [];
//
//                $.each(data, function(i, item){
//                    _arrAvailableTags.push(item.description);
//                });
//
//                $('input.assigned_tags[type=hidden]').each(function(i, item) {
//                    _arrAssignedTags.push(item.value);
//                });
//
//                availableTagSet = new TagSet(_arrAvailableTags);
//                assignedTagSet  = new TagSet(_arrAssignedTags);
//                draftTagSet     = new TagSet(_arrAssignedTags);
//
//                $("#mytags").tagit({
//                    availableTags : _arrAvailableTags,
//                    assignedTags  : _arrAssignedTags,
//                    onAdd         : draftTagSet.add,
//                    onRemove      : draftTagSet.remove
//                });
//            }
//        });
//
//        return {
//            getAvailableTagSet : function() {return availableTagSet;},
//            getAssignedTagSet  : function() {return assignedTagSet;},
//            getDraftTagSet     : function() {return draftTagSet;}
//        };
//    }());
//
//  $('input[type=submit]').click(function(e){
//        $(this).parent().find('input[name=json_encode_tag_arr]').remove();
//
//        var availableTagSet = TagManager.getAvailableTagSet(),
//            assignedTagSet  = TagManager.getAssignedTagSet(),
//            draftTagSet     = TagManager.getDraftTagSet();
//
//        var toInsertNewTagSet       = TagSet.sub(draftTagSet, availableTagSet),
//            toDeleteTagSet          = TagSet.sub(assignedTagSet, draftTagSet),
//            toInsertAssignTagSet    = TagSet.sub(TagSet.sub(draftTagSet, toInsertNewTagSet), assignedTagSet),
//            insertAssignTags        = toInsertNewTagSet.values().length ? toInsertNewTagSet.values() : $('#mytags .tagit-input').val(),
//            jsonEncodeTagArr        = JSON.stringify({toInsertNew   : [insertAssignTags],
//                                                    toDelete        : toDeleteTagSet.values(),
//                                                    toInsertAssign  : toInsertAssignTagSet.values()});
//
////console.log(jsonEncodeTagArr);
////return false;
//        $(this).before("<input type='hidden' name='json_encode_tag_arr' value='"+jsonEncodeTagArr+"'/>");
//    });
/////////////////LANDING PAGES/////////////////    	
    $('a.registred_detail').live('click', function(e){
        e.preventDefault();
        var $registredListTd       = $(this).parent().parent();
        $('.landing_registred_list',$registredListTd).toggle(600);
    });
});
//////////////////////////////////////////////////////////////// 
function GotoURL(URL,text){
 if (confirm(text)) {
     window.location.href=URL;
    }
}