<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>js/jquery_multi_select/jquery.multiSelect.css" />
<script type="text/javascript" src="<?php echo base_url();?>js/jquery_multi_select/jquery.multiSelect.js"></script>
<script type="text/javascript">
    $(document).ready( function() {
        $(".menu_checkbox").multiSelect({ selectAllText: 'Выделить все', oneOrMoreSelected : 'Опубликовано в % разделах' });
    });
</script>
<?php echo @$message; ?>
<?php echo validation_errors(); ?>
<form id="back_form" class="add_new" action='<?php echo base_url()?>backend/check_valid_material' method='post' name='edit_text' enctype='multipart/form-data'>
    <p>
        <b>Опубликовать в:</b>&nbsp;&nbsp;
        <select class="menu_checkbox" id="menu" multiple="multiple">
            <?php for($i=0; $i<=count($menu_items)-1; $i++):?>
            <option value="<?php echo $menu_items[$i]->id;?>" <?php if(in_array($menu_items[$i]->id, $assign_materials)){ echo "selected = 'selected'";}?>>
                &nbsp;<?php echo $menu_items[$i]->title;?>
            </option>
                <?php $child = $menu_items[$i]->childs; ?>
                <?php for($k=0; $k<=count($child)-1; $k++):?>
                    <option value="<?php echo $child[$k]->id;?>" <?php if(in_array($child[$k]->id, $assign_materials)){ echo "selected = 'selected'";}?>>
                        &nbsp;<?php echo $child[$k]->title;?>
                    </option>
                <?php endfor;?>
            <?php endfor;?>
        </select>
    </p>
    <br/>
    <p><b>Название(рус.):</b></p>
    <p><input style="width:60%" type="text" id='rus_name' name='rus_name' value="<?php echo set_value('rus_name', $content['rus_name']);?>"/></p>
    <br/>
    <div style="float:left; padding: 0.5em 0.5em 0em 0em">
        <?php $file_path_parts = $content['file_path'] ? explode('.', $content['file_path']) : null;?>
        <a title="Show" href="<?php echo base_url()."materials/".$content['file_path'];?>">
            <img class="material_edit" src="<?php echo base_url()."img/img_main/".@$file_path_parts[1].".png"?>"/>
        </a>
        </div>
    <p><b>Выбрать новый материал:</b></p>
    <p><input style="width:60%" type="file" id='file_path' name='file_path'/></p>
    <br/>
   
    <input id="id" name="id" type="hidden" value="<?php echo set_value('id', $content['id']);?>"/>
    <input id="status" name="status" type="hidden" value="<?php echo set_value('status', $content['status']);?>"/>
    <input id="num_sequence" name="num_sequence" type="hidden" value="<?php echo set_value('num_sequence', $content['num_sequence']);?>"/>
    <?php foreach($assign_materials as $assign):?>
        <input name="old_assign_id[]" type="hidden" value="<?php echo set_value('old_assign_id', $assign);?>">
    <?php endforeach;?>
    <div style="width:600px; clear:both">&nbsp;</div>
    
    <input id='button' name='edit_text' type='submit' value='Сохранить'/>
</form>