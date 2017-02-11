<p class="edit_message"><?php echo @$message; ?></p>
<?php echo validation_errors(); ?>
<form id="back_form" class="add_new" action='<?php echo base_url()?>backend/check_valid_gift' method='post' name='edit_text' enctype='multipart/form-data'>
    <p>
        <b>Название продукта:</b>&nbsp;
        <input style="width:450px" type="text" id='name' name='name' value="<?php echo set_value('name', $content['name']);?>"/>
    </p>
    <br/>
    <p>
        <b>Доп. название продукта:</b>&nbsp;
        <input style="width:450px" type="text" id='label' name='label' value="<?php echo set_value('label', $content['label']);?>"/>
    </p>
    <br/>
    <p>
        <a title="Show" href="<?php echo base_url()."img/subscribe/".$content['image'];?>">
            <img class="subscribe_edit" src="<?php echo base_url()."img/subscribe/".$content['image']?>"/>
        </a>
        <b>Картинка:</b>&nbsp;
        <input style="width:60%" type="file" id='img_path' name='img_path'/>

    </p>
    <div style="width:600px; clear:both">&nbsp;</div>
    <br/>
    <p>
        <?php $file_path_parts = $content['material'] ? explode('.', $content['material']) : null;?>
        <a title="Show" href="<?php echo base_url()."subscribegift/".$content['material'];?>">
            <img class="subscribe_edit material" src="<?php echo base_url()."img/img_main/".@$file_path_parts[1].".png"?>"/>
        </a>
        <b>Материал:</b>&nbsp;
        <input style="width:60%" type="text" id='material' name='material' value="<?php echo set_value('material', $content['material']);?>"/>

    </p>
    <div style="width:600px; clear:both">&nbsp;</div>
    <br/>
    <p><b>Выбрать статьи:</b></p>
    <br/>
    <div class="topic-article-list" style="float: left;">
        <?php foreach($articleList as $article):?>
            <p>
                <input type="radio" class="edit_detail" name="new_article_id[]" value="<?php echo $article['id']?>"
                    <?php
                    echo $assignArticles && array_key_exists($article['id'], $assignArticles) ?
                        'checked="checked"':
                        ''
                    ;?>
                >
                <span class="landing_title_list">&nbsp;<?php echo $article['title']?></span>
            </p>
        <?php endforeach;?>
    </div>
    <input id="id" name="id" type="hidden" value="<?php echo set_value('id', $content['id']);?>"/>
    <input id="id" name="old_image" type="hidden" value="<?php echo set_value('old_image', $content['image']);?>"/>
    <input id="id" name="old_material" type="hidden" value="<?php echo set_value('old_material', $content['material']);?>"/>
    <input id="status" name="status" type="hidden" value="<?php echo set_value('status', $content['status']);?>"/>
    <?php foreach($assignArticles as $assignArticleId => $articleData):?>
        <input name="old_article_id[]" type="hidden" value="<?php echo set_value('old_article_id', $assignArticleId);?>">
    <?php endforeach;?>
    
    <div style="width:600px; clear:both">&nbsp;</div>
    
    <input id='button' name='edit_text' type='submit' value='Сохранить'/>
</form>