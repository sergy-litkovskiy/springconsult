<p class="edit_message"><?php echo @$message; ?></p>
<?php echo validation_errors(); ?>
<form id="back_form" class="add_new" action='<?php echo base_url()?>backend/check_valid_announce' method='post' name='edit_text' enctype='multipart/form-data'>
    <p><b>Текст:</b></p>
    <textarea id="full" style='width:100%' name='text' cols='80' rows='8'><?php echo set_value('text', $content['text']);?></textarea>
    
    <input id="id" name="id" type="hidden" value="<?php echo set_value('id', $content['id']);?>"/>
    <input id="status" name="status" type="hidden" value="<?php echo set_value('status', $content['status']);?>"/>
    <input id="created_at" name="created_at" type="hidden" value="<?php echo set_value('created_at', $content['created_at']);?>"/>
    <div style="width:600px; clear:both">&nbsp;</div>
    
    <input id='button' name='edit_text' type='submit' value='Сохранить'/>
</form>