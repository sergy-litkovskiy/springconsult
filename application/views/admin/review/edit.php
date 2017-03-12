<h2><?php echo $title;?></h2>
<?php echo @$message; ?>
<?php echo validation_errors(); ?>
<form id="back_form_sale_product" class="add_new" action='<?php echo base_url()?>backend/review_save' method='post' name='edit_text' enctype='multipart/form-data'>
    <p><b>Автор:</b></p>
    <p><input type="text" class="main_inputs" id='author' name='author' value="<?php echo $content['author'];?>"/></p>
    <br/>
    <p><b>Фото:</b></p>
    <p><input type="text" class="main_inputs" id='image' name='image' value="<?php echo $content['image'];?>"/></p>
    <br/>
    <p><b>Текст:</b></p>
    <p>
        <textarea class="main_inputs" id='text' name='text' cols='80' rows='8'>
            <?php echo $content['text'];?>
        </textarea>
    </p>
    <br/>
    <p><b>Выбрать sale pages:</b></p>
    <br/>
    <ul class="topic-article-list" style="float: left; margin-left: 2em;">
        <?php foreach($salePageList as $salePage):?>
            <li style="float: left; list-style-type: none;">
                <input type="checkbox" class="edit_detail" name="new_sale_page_id[]" value="<?php echo $salePage['id']?>"
                    <?php
                        echo $assignedSalePageList && array_key_exists($salePage['id'], $assignedSalePageList) ?
                        'checked="checked"':
                        ''
                    ;?>
                >
                <span class="landing_title_list">&nbsp;<?php echo $salePage['title']?></span>&nbsp;|&nbsp;
            </li>
        <?php endforeach;?>
    </ul>
    <br/>
    <br/>
    <p><b>Выбрать разделы:</b></p>
    <br/>
    <ul class="topic-article-list" style="float: left; margin-left: 2em;">
        <?php foreach($menuList as $menuData):?>
            <li style="float: left; list-style-type: none;">
                <input type="checkbox" class="edit_detail" name="new_menu_id[]" value="<?php echo $menuData['id']?>"
                    <?php
                    echo $assignedMenuList && array_key_exists($menuData['id'], $assignedMenuList) ?
                        'checked="checked"':
                        ''
                    ;?>
                >
                <span class="landing_title_list">&nbsp;<?php echo $menuData['title']?></span>&nbsp;|&nbsp;
            </li>
        <?php endforeach;?>
    </ul>
    <input id="id" name="id" type="hidden" value="<?php echo set_value('id', $content['id']);?>"/>
    <input id="status" name="status" type="hidden" value="<?php echo set_value('status', $content['status']);?>"/>
    <input id="date" name="date" type="hidden" value="<?php echo set_value('date', $content['date']);?>"/>
    <?php foreach($assignedSalePageList as $assignedSalePageId => $salePageData):?>
        <input name="old_sale_page_id[]" type="hidden" value="<?php echo set_value('old_sale_page_id', $assignedSalePageId);?>">
    <?php endforeach;?>
    <?php foreach($assignedMenuList as $assignedMenuId => $assignedMenuData):?>
        <input name="old_menu_id[]" type="hidden" value="<?php echo set_value('old_menu_id', $assignedMenuId);?>">
    <?php endforeach;?>
    <div style="width:600px; clear:both">&nbsp;</div>
    
    <input id='button' name='edit_review' type='submit' value='Сохранить'/>
</form>
