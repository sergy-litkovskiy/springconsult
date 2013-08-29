<script  type="text/javascript" src="<?php echo base_url();?>js/spring/modules/landing_edit.js"></script>
<h2><?php echo $title." '".$content['title']."'";?></h2>
<?php echo @$message; ?>
<?php echo validation_errors(); ?>
<div id="article-landing-edit">
    <form id="back_form_landing" class="add_new" action='<?php echo base_url()?>backend/check_valid_landing' method='post' name='edit_text' enctype='multipart/form-data'>
        <p><b>Unique:</b></p>
        <p><input type="text" id='unique' name='unique' value="<?php echo $content['unique'];?>"/></p>
        <br/>
        <p><b>Название:</b></p>
        <p><input type="text" id='title' name='title' value="<?php echo $content['title'];?>"/></p>
        <br/>
        <p><b>Описание над формой регистрации:</b></p>
        <textarea  style="float:left"  id='title_description' name='title_description' cols='60' rows='4'><?php echo $content['title_description'];?></textarea>
        <div style="width:600px; clear:both">&nbsp;</div>
        <br/>
        <p><b>Текст письма:</b></p>
        <textarea  style="float:left"  id='letter_text' name='letter_text' cols='60' rows='4'><?php echo $content['letter_text'];?></textarea>
        <div style="width:600px; clear:both">&nbsp;</div>
        <br/>
        <p><b>Текст:</b></p>
        <textarea id="full" style='width:100%' name='page_text' cols='80' rows='8'><?php echo $content['page_text'];?></textarea>

        <input id="id" name="id" type="hidden" value="<?php echo set_value('id', $content['id']);?>"/>
        <input id="status" name="status" type="hidden" value="<?php echo set_value('status', $content['status']);?>"/>
        <input id="created_at" name="created_at" type="hidden" value="<?php echo set_value('created_at', $content['created_at']);?>"/>
        <div style="width:600px; clear:both">&nbsp;</div>

        <input id='button' name='edit_landing' type='submit' value='Сохранить'/>
    </form>
<script>
    SPRING.Core.registerModule("article-landing-edit", LandingEditModule());
</script>