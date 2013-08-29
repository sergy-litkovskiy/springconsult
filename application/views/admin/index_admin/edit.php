<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>js/jquery_multi_select/jquery.multiSelect.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jquery.tagedit.css" />
<script type="text/javascript" src="<?php echo base_url();?>js/jquery_multi_select/jquery.multiSelect.js"></script>
<script  type="text/javascript" src="<?php echo base_url();?>js/jquery/jquery.autoGrowInput.js"></script>
<script  type="text/javascript" src="<?php echo base_url();?>js/jquery/jquery.tagedit.js"></script>
<script  type="text/javascript" src="<?php echo base_url();?>js/spring/modules/main_form_edit.js"></script>
<script type="text/javascript">
    $(document).ready( function() {
        $(".menu_checkbox").multiSelect({ selectAllText: 'Выделить все', oneOrMoreSelected : 'Опубликовано в % разделах' });
    });
</script>
<h2><?php echo $title." '".$content['title']."'";?></h2>
<?php echo @$message; ?>
<?php echo validation_errors(); ?>
<div id="edit-article">
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
        <p>
            <?php if(count($assign_tag_arr) > 0){?>
                <?php foreach($assign_tag_arr as $tagMaster){?>
                    <input class="tag" type="text" id="<?php echo $tagMaster['tag_master_id']?>" name="tag[<?php echo $tagMaster['tag_master_id'].'-a'?>]" value="<?php echo $tagMaster['tag_description']?>"/>
                <?php }
            }?>

            <input class="tag" value="" type="text" name="tag[]">
        </p>
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
</div>
<script>
    SPRING.Core.registerModule("edit-article", MainFormEditModule());
</script>