<script  type="text/javascript" src="<?php echo base_url();?>js/spring/modules/edit_landing_articles.js"></script>
<h2><?php echo $title." '".$content['title']."'";?></h2>
<?php echo @$message; ?>
<?php echo validation_errors(); ?>
<form id="back_form_landing_articles" class="add_new" action='<?php echo base_url()?>backend/check_valid_landing_articles' method='post' name='edit_text' enctype='multipart/form-data'>
    <p><b>Название:</b></p>
    <p><input type="text" class="main_inputs" id='title' name='title' value="<?php echo $content['title'];?>"/></p>
    <br/>
    <p><b>Alias названия:</b></p>
    <p><input type="text" class="main_inputs" id='slug' name='slug' value="<?php echo $content['slug'];?>"/></p>
    <br/>
    <p><b>Ссылка на MP3:</b></p>
    <p><input type="text" class="mp3" id='link_mp3' name='link_mp3' value="<?php echo $content['link_mp3'];?>"/></p>
    <br/>    
    <p><b>Пароль к MP3:</b></p>
    <p><input type="text" class="mp3" id='password_mp3' name='password_mp3' value="<?php echo $content['password_mp3'];?>"/></p>
    <br/>
    <p><b>Текст:</b></p>
    <textarea id="full" style='width:100%' name='text' cols='80' rows='8'><?php echo $content['text'];?></textarea>
    <br/>
    <p><b>Выбрать landing page:</b></p>
    <p><a class="show-landing-articles-list">показать/скрыть</a></p>
    <br/>
    <p class="landing-articles-list">
        <?php foreach($landings as $landing):?>
            <input type="radio" class="edit_detail" name="landing" value="<?php echo $landing['id']?>" <?php echo ($landing['id'] == $content['landing_page_id']) ? 'checked="checked"': null;?>>
            <span class="landing_title_list">&nbsp;<?php echo $landing['title']?></span>
        <?php endforeach;?>
    </p>    

    <input id="id" name="id" type="hidden" value="<?php echo set_value('id', $content['id']);?>"/>
    <input id="status" name="status" type="hidden" value="<?php echo set_value('status', $content['status']);?>"/>
    <input id="status" name="created_at" type="hidden" value="<?php echo set_value('created_at', $content['created_at']);?>"/>
    <div style="width:600px; clear:both">&nbsp;</div>
    
    <input id='button' name='edit_articles' type='submit' value='Сохранить'/>
</form>
<script>
        SPRING.Core.registerModule("back_form_landing_articles", EditLandingArticlesFormModule());
</script>  