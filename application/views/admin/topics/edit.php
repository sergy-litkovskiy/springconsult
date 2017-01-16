<h2><?php echo $title." '".$content['name']."'";?></h2>
<?php echo @$message; ?>
<?php echo validation_errors(); ?>
<form id="back_form_topic" class="add_new_topic" action='<?php echo base_url()?>backend/topic_save' method='post' name='edit_text' enctype='multipart/form-data'>
    <p><b>Название:</b></p>
    <p><input type="text" class="main_inputs" id='name' name='name' value="<?php echo $content['name'];?>"/></p>
    <br/>
    <p><b>Выбрать статьи:</b></p>
    <br/>
    <ul class="topic-article-list" style="float: left; margin-left: 2em;">
        <?php foreach($articleList as $article):?>
            <li style="float: left; list-style-type: none;">
                <input type="checkbox" class="edit_detail" name="new_article_id[]" value="<?php echo $article['id']?>"
                    <?php
                        echo $assignArticles && array_key_exists($article['id'], $assignArticles) ?
                        'checked="checked"':
                        ''
                    ;?>
                >
                <span class="landing_title_list">&nbsp;<?php echo $article['title']?></span>&nbsp;|&nbsp;
            </li>
        <?php endforeach;?>
    </ul> 
    <input id="id" name="id" type="hidden" value="<?php echo set_value('id', $content['id']);?>"/>
    <input id="status" name="status" type="hidden" value="<?php echo set_value('status', $content['status']);?>"/>
    <?php foreach($assignArticles as $assignArticleId => $articleData):?>
        <input name="old_article_id[]" type="hidden" value="<?php echo set_value('old_article_id', $assignArticleId);?>">
    <?php endforeach;?>
    <div style="width:600px; clear:both">&nbsp;</div>
    
    <input id='button' name='edit_topic' type='submit' value='Сохранить'/>
</form>
