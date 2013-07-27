<p class="edit_message"><?php echo @$message; ?></p>
<?php echo validation_errors(); ?>
<form id="back_form" class="add_new" action='<?php echo base_url()?>backend/check_valid_subscribe' method='post' name='edit_text' enctype='multipart/form-data'>
    <p>
        <b>Название продукта:</b>&nbsp;
        <input style="width:150px" type="text" id='subscribe_name' name='subscribe_name' value="<?php echo set_value('subscribe_name', $content['subscribe_name']);?>"/>
    </p>
    <br/>
    <p>
        <a title="Show" href="<?php echo base_url()."subscribe/".$content['img_path'];?>">
            <img class="subscribe_edit" src="<?php echo base_url()."subscribe/".$content['img_path']?>"/>
        </a>
        <b>Картинка:</b>&nbsp;
        <input style="width:60%" type="file" id='img_path' name='img_path'/>

    </p>
    <div style="width:600px; clear:both">&nbsp;</div>
    <br/>
    <p>
        <?php $file_path_parts = $content['material_path'] ? explode('.', $content['material_path']) : null;?>
        <a title="Show" href="<?php echo base_url()."subscribegift/".$content['material_path'];?>">
            <img class="subscribe_edit material" src="<?php echo base_url()."img/img_main/".@$file_path_parts[1].".png"?>"/>
        </a>
        <b>Материал:</b>&nbsp;
        <input style="width:60%" type="text" id='material_path' name='material_path' value="<?php echo set_value('material_path', $content['material_path']);?>"/>

    </p>
    <div style="width:600px; clear:both">&nbsp;</div>
    <p><b>Описание:</b></p>
    <textarea id="full" style='width:100%' name='description' cols='80' rows='8'><?php echo set_value('status', $content['description']);?></textarea>
    
    <input id="id" name="id" type="hidden" value="<?php echo set_value('id', $content['id']);?>"/>
    <input id="id" name="old_img_path" type="hidden" value="<?php echo set_value('old_img_path', $content['img_path']);?>"/>
    <input id="id" name="old_material_path" type="hidden" value="<?php echo set_value('old_material_path', $content['material_path']);?>"/>
    <input id="status" name="status" type="hidden" value="<?php echo set_value('status', $content['status']);?>"/>
    
    <div style="width:600px; clear:both">&nbsp;</div>
    
    <input id='button' name='edit_text' type='submit' value='Сохранить'/>
</form>