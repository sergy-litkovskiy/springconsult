<script  type="text/javascript" src="<?php echo base_url();?>js/spring/modules/edit_topic.js"></script>
<h2><?php echo $title." '".$content['title']."'";?></h2>
<?php echo @$message; ?>
<?php echo validation_errors(); ?>
<form id="back_form_topic" class="add_new" action='<?php echo base_url()?>backend/check_valid_topic' method='post' name='edit_text' enctype='multipart/form-data'>
    <p><b>Название:</b></p>
    <p><input type="text" class="main_inputs" id='name' name='name' value="<?php echo $content['name'];?>"/></p>
    <br/>
    <p><b>Выбрать статьи:</b></p>
    <p><a class="show-landing-articles-list">показать/скрыть</a></p>
    <br/>
    <ul class="sale-page-list">
        <?php foreach($articleList as $article):?>
            <li>
                <input type="checkbox" class="edit_detail" name="new_article_id[]" value="<?php echo $article['id']?>"
                    <?php
                        echo (count($content['article_list'])&&(in_array($article['id'], $content['article_list']))) ?
                        'checked="checked"':
                        ''
                    ;?>
                >
                <span class="landing_title_list">&nbsp;<?php echo $article['name']?></span>&nbsp;|&nbsp;
            </li>
        <?php endforeach;?>
    </ul> 
    <input id="id" name="id" type="hidden" value="<?php echo set_value('id', $content['id']);?>"/>
    <input id="status" name="status" type="hidden" value="<?php echo set_value('status', $content['status']);?>"/>
    <?php foreach($articleList as $article):?>
        <?php if(in_array($article['id'], $content['article_list'])){ ?>
            <input name="old_topic_id[]" type="hidden" value="<?php echo set_value('old_topic_id', $article['id']);?>">
        <?php }?>
    <?php endforeach;?>
    <div style="width:600px; clear:both">&nbsp;</div>
    
    <input id='button' name='edit_topic' type='submit' value='Сохранить'/>
</form>
<script>
        SPRING.Core.registerModule("back_form_topic", EditTopicFormModule());
</script>  