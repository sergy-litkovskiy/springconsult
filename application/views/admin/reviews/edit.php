<h2><?php echo $title;?></h2>
<?php echo @$message; ?>
<?php echo validation_errors(); ?>
<form id="back_form_sale_products" class="add_new" action='<?php echo base_url()?>backend/review_save' method='post' name='edit_text' enctype='multipart/form-data'>
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
    <p><b>Выбрать sale products:</b></p>
    <br/>
    <ul class="topic-article-list" style="float: left; margin-left: 2em;">
        <?php foreach($saleProductList as $saleProduct):?>
            <li style="float: left; list-style-type: none;">
                <input type="checkbox" class="edit_detail" name="new_sale_products_id[]" value="<?php echo $saleProduct['id']?>"
                    <?php
                        echo $assignedSaleProductList && array_key_exists($saleProduct['id'], $assignedSaleProductList) ?
                        'checked="checked"':
                        ''
                    ;?>
                >
                <span class="landing_title_list">&nbsp;<?php echo $saleProduct['title']?></span>&nbsp;|&nbsp;
            </li>
        <?php endforeach;?>
    </ul> 
    <input id="id" name="id" type="hidden" value="<?php echo set_value('id', $content['id']);?>"/>
    <input id="status" name="status" type="hidden" value="<?php echo set_value('status', $content['status']);?>"/>
    <input id="date" name="date" type="hidden" value="<?php echo set_value('date', $content['date']);?>"/>
    <?php foreach($assignedSaleProductList as $assignedSaleProductId => $saleProductData):?>
        <input name="old_sale_products_id[]" type="hidden" value="<?php echo set_value('old_sale_products_id', $assignedSaleProductId);?>">
    <?php endforeach;?>
    <div style="width:600px; clear:both">&nbsp;</div>
    
    <input id='button' name='edit_review' type='submit' value='Сохранить'/>
</form>
