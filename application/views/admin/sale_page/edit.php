<script  type="text/javascript" src="<?php echo base_url();?>js/spring/modules/edit_sale_page.js"></script>
<h2><?php echo $title." '".$content['title']."'";?></h2>
<?php echo @$message; ?>
<?php echo validation_errors(); ?>
<form id="back_form_sale_page" class="add_new" action='<?php echo base_url()?>backend/check_valid_sale_page' method='post' name='edit_text' enctype='multipart/form-data'>
    <p><b>Название:</b></p>
    <p><input type="text" class="main_inputs" id='title' name='title' value="<?php echo $content['title'];?>"/></p>
    <br/>
    <p><b>Alias названия:</b></p>
    <p><input type="text" class="main_inputs" id='slug' name='slug' value="<?php echo $content['slug'];?>"/></p>
    <br/>
    <p><b>Первая текстовый блок:</b></p>
    <textarea style='width:100%' name='text1' cols='80' rows='8'><?php echo $content['text1'];?></textarea>
    <br/>
    <p><b>Второй текстовый блок:</b></p>
    <textarea id="my" style='width:100%' name='text2' cols='80' rows='8'><?php echo $content['text2'];?></textarea>
    <br/>
    <input id="id" name="id" type="hidden" value="<?php echo set_value('id', $content['id']);?>"/>
    <input id="status" name="status" type="hidden" value="<?php echo set_value('status', $content['status']);?>"/>
    <input id="status" name="created_at" type="hidden" value="<?php echo set_value('created_at', $content['created_at']);?>"/>
    <div style="width:600px; clear:both">&nbsp;</div>
    
    <input id='button' name='edit_sale_page' type='submit' value='Сохранить'/>
</form>
<script>
        SPRING.Core.registerModule("sale-page-mce", TinymceInitModule()); 
        SPRING.Core.registerModule("back_form_sale_page", EditSalePageFormModule());
</script>  