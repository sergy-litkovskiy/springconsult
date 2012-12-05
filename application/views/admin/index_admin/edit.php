<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>js/jquery_multi_select/jquery.multiSelect.css" />
<script type="text/javascript" src="<?php echo base_url();?>js/jquery_multi_select/jquery.multiSelect.js"></script>
<script  type="text/javascript" src="<?php echo base_url();?>js/tag-it.js"></script>
<script  type="text/javascript" src="<?php echo base_url();?>js/tag_set.js"></script>
<script type="text/javascript">
    $(document).ready( function() {
        $(".menu_checkbox").multiSelect({ selectAllText: 'Выделить все', oneOrMoreSelected : 'Опубликовано в % разделах' });
        /////////////////start TAG process/////////////////
        var TagManager = (function(){
            var availableTagSet, assignedTagSet, draftTagSet;

            $.ajax({
                type: "POST",
                url: "/admin/index_admin/ajax_get_available_tag",
                data: {},
                dataType: 'json',
                success: function (data){

                    var _arrAvailableTags = [], _arrAssignedTags  = [];

                    $.each(data, function(i, item){
                        _arrAvailableTags.push(item.description);
                    });

                    $('input.assigned_tags[type=hidden]').each(function(i, item) {
                        _arrAssignedTags.push(item.value);
                    });

                    availableTagSet = new TagSet(_arrAvailableTags);
                    assignedTagSet  = new TagSet(_arrAssignedTags);
                    draftTagSet     = new TagSet(_arrAssignedTags);

                    $("#mytags").tagit({
                        availableTags : _arrAvailableTags,
                        assignedTags  : _arrAssignedTags,
                        onAdd         : draftTagSet.add,
                        onRemove      : draftTagSet.remove
                    });
                }
            });

            return {
                getAvailableTagSet : function() {return availableTagSet;},
                getAssignedTagSet  : function() {return assignedTagSet;},
                getDraftTagSet     : function() {return draftTagSet;}
            };
        }());

        $('input[type=submit]').click(function(e){
            $(this).parent().find('input[name=json_encode_tag_arr]').remove();

            var availableTagSet = TagManager.getAvailableTagSet(),
                    assignedTagSet  = TagManager.getAssignedTagSet(),
                    draftTagSet     = TagManager.getDraftTagSet();

            var toInsertNewTagSet       = TagSet.sub(draftTagSet, availableTagSet),
                    toDeleteTagSet          = TagSet.sub(assignedTagSet, draftTagSet),
                    toInsertAssignTagSet    = TagSet.sub(TagSet.sub(draftTagSet, toInsertNewTagSet), assignedTagSet),
                    insertAssignTags        = toInsertNewTagSet.values().length ? toInsertNewTagSet.values() : $('#mytags .tagit-input').val(),
                    jsonEncodeTagArr        = JSON.stringify({toInsertNew   : [insertAssignTags],
                        toDelete        : toDeleteTagSet.values(),
                        toInsertAssign  : toInsertAssignTagSet.values()});

//console.log(jsonEncodeTagArr);
//return false;
            $(this).before("<input type='hidden' name='json_encode_tag_arr' value='"+jsonEncodeTagArr+"'/>");
        });
    });
</script>
<h2><?php echo $title." '".$content['title']."'";?></h2>
<?php echo @$message; ?>
<?php echo validation_errors(); ?>
<form id="back_form" class="add_new" action='<?php echo base_url()?>backend/check_valid_article' method='post' name='edit_text' enctype='multipart/form-data'>
    <p>
        <b>Дата:</b>&nbsp;&nbsp;<input type="text" class="datepicker" id='date' name='date' value="<?php echo $content['date'];?>"/>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <b>Время:</b>&nbsp;&nbsp;<input type="text" id='time' name='time' value="<?php echo $content['time'];?>"/>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <b>Опубликовать в:</b>&nbsp;&nbsp;
        <select class="menu_checkbox" id="menu" multiple="multiple">
            <?php for($i=0; $i<=count($menu_items)-1; $i++):?>
            <option value="<?php echo $menu_items[$i]->id;?>" <?php if(in_array($menu_items[$i]->id, $assign_articles)){ echo "selected = 'selected'";}?>>
                &nbsp;<?php echo $menu_items[$i]->title;?>
            </option>
                <?php $child = $menu_items[$i]->childs; ?>
                <?php for($k=0; $k<=count($child)-1; $k++):?>
                    <option value="<?php echo $child[$k]->id;?>" <?php if(in_array($child[$k]->id, $assign_articles)){ echo "selected = 'selected'";}?>>
                        &nbsp;<?php echo $child[$k]->title;?>
                    </option>
                <?php endfor;?>
            <?php endfor;?>
        </select>
    </p>
    <br/>
    <p><b>Название:</b></p>
    <p><input type="text" id='title' name='title' value="<?php echo $content['title'];?>"/></p>
    <br/>
    <p><b>Alias названия:</b></p>
    <p><input type="text" id='slug' name='slug' value="<?php echo $content['slug'];?>"/></p>
    <br/>
    <p><b>Meta description:</b></p>
    <textarea  style="float:left"  id='meta_description' name='meta_description' cols='60' rows='4'><?php echo $content['meta_description'];?></textarea>
<!--    <p><input type="text" id='meta_description' name='meta_description' value="<?php echo $content['meta_description'];?>"/></p>-->
    <div style="width:600px; clear:both">&nbsp;</div>
    <p><b>Meta keywords:</b></p>
    <p><input type="text" id='meta_keywords' name='meta_keywords' value="<?php echo $content['meta_keywords'];?>"/></p>
    <br/>
    <p><b>TAGs:</b></p>
    <?php if(count($assign_tag_arr) > 0){?>
         <?php foreach($assign_tag_arr as $tagMaster){?>
            <input class="assigned_tags" type="hidden" id="<?php echo $tagMaster['id']?>" name="assigned_tags_old[<?php echo $tagMaster['id']?>]" value="<?php echo $tagMaster['tag_description']?>"/>
        <?php }
    }?>
    <label for="tags"></label>
    <ul id="mytags"></ul>
    <br/>
    <p><b>Текст:</b></p>
    <textarea id="full" style='width:100%' name='text' cols='80' rows='8'><?php echo $content['text'];?></textarea>
    
    <input id="id" name="id" type="hidden" value="<?php echo set_value('id', $content['id']);?>"/>
    <input id="status" name="status" type="hidden" value="<?php echo set_value('status', $content['status']);?>"/>
    <input id="num_sequence" name="num_sequence" type="hidden" value="<?php echo set_value('num_sequence', $content['num_sequence']);?>"/>
    <input id="is_sent_mail" name="is_sent_mail" type="hidden" value="<?php echo set_value('is_sent_mail', $content['is_sent_mail']);?>"/>
    
    <?php foreach($assign_articles as $assign):?>
        <input name="old_assign_id[]" type="hidden" value="<?php echo set_value('old_assign_id', $assign);?>">
    <?php endforeach;?>
    <div style="width:600px; clear:both">&nbsp;</div>
    
    <input id='button' name='edit_articles' type='submit' value='Сохранить'/>
</form>