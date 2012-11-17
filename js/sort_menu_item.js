
$(document).ready(function(){

    var modelChangeSequenceNumber = new changeSequenceNumberModel();

    $('.arrow_up').live('click', function(){
        var $parentTr   = $(this).parent().parent(),
            $prevTr     = $parentTr.prevAll('tr[parent='+$parentTr.attr('parent')+']'),
            changesData = {   currentId     : $parentTr.attr('id')
                            , secondId      : $prevTr.attr('id')
                            , currentNumSeq : parseInt($parentTr.attr('position')) - 1
                            , secondNumSeq  : parseInt($prevTr.attr('position')) + 1 };
                        
        if($prevTr.length > 0){
            modelChangeSequenceNumber.changeSequenceNumber(changesData);    
        }
        
        return false;
    });


    $('.arrow_down').live('click', function(){
        var $parentTr   = $(this).parent().parent(),
            $nextTr     = $parentTr.nextAll('tr[parent='+$parentTr.attr('parent')+']'),
            changesData = {   currentId     : $parentTr.attr('id')
                            , secondId      : $nextTr.attr('id')
                            , currentNumSeq : parseInt($parentTr.attr('position')) + 1
                            , secondNumSeq  : parseInt($nextTr.attr('position')) - 1 };

        if($nextTr.length > 0){
            modelChangeSequenceNumber.changeSequenceNumber(changesData);
        }

        return false;
    });

});

function changeSequenceNumberModel()
{
    var _changeSequenceNumber = function(changesData) {

        $.ajax({
         type: "POST",
         url: "/admin/menu_admin/ajax_change_sequence_num_menu",
         dataType: "json",
         data: {  current_id            : changesData.currentId
                , current_num_seq       : changesData.currentNumSeq
                , second_id             : changesData.secondId
                , second_num_seq        : changesData.secondNumSeq },
         success: function(json){
             if (json.success === true) {
                    window.location.reload();
                } else {
                    alert(json.error);
                }
         }
        });

        return false;
    }

    //Public
    return {
        changeSequenceNumber : _changeSequenceNumber
    };
}