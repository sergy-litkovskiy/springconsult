<h2><?php echo $title;?></h2>
<p class="edit_message"><?php echo @$message; ?></p>
<?php echo validation_errors(); ?>
<div class="edit_form">
    <form action='<?php echo base_url()?>backend/check_valid_menu' method='post' name='edit_text' enctype='multipart/form-data'>
        <p><b>Название раздела:</b></p>
        <input type="text" id='title' name='title' value="<?php echo $content['title'];?>"/>

        <p><b>Alias раздела:</b></p>
        <input type="text" id='slug' name='slug' value="<?php echo $content['slug'];?>"/>

        <p><b>Color class:</b></p>
        <input type="text" id='color_class' name='color_class' value="<?php echo $content['color_class'];?>"/>

        <p><b>Icon Class:</b></p>
        <input type="text" id='icon_class' name='icon_class' value="<?php echo $content['icon_class'];?>"/>

        <p><b>Short description:</b></p>
        <textarea  style="float:left"  id='description' name='description' cols='60' rows='4'>
            <?php echo $content['description'];?>
        </textarea>

        <p><b>Meta description:</b></p>
        <textarea  style="float:left"  id='meta_description' name='meta_description' cols='60' rows='4'><?php echo $content['meta_description'];?></textarea>

        <div style="width:600px; clear:both">&nbsp;</div>
        <p><b>Meta keywords:</b></p>
        <input type="text" id='meta_keywords' name='meta_keywords' value="<?php echo $content['meta_keywords'];?>"/>

        <p><b>Текст:</b></p>
        <textarea id="full" style='width:80%' name='text' cols='50' rows='8'><?php echo $content['text'];?></textarea>
        <br/>
        <p><b>Выбрать sale products:</b></p>
        <br/>
        <ul class="sale-product-list" style="float: left; margin-left: 2em;">
            <?php foreach($saleProductList as $saleProduct):?>
                <li style="float: left; list-style-type: none;">
                    <input type="checkbox" class="edit_detail" name="new_sale_product_id[]" value="<?php echo $saleProduct['id']?>"
                        <?php
                        echo $assignedSaleProductList && in_array($saleProduct['id'], $assignedSaleProductList) ?
                            'checked="checked"':
                            ''
                        ;?>
                    >
                    <span class="landing_title_list">&nbsp;<?php echo $saleProduct['title'].'('.$saleProduct['label'].')'?></span>&nbsp;|&nbsp;
                </li>
            <?php endforeach;?>
        </ul>
        <input id="status" name="status" type="hidden" value="<?php echo set_value('status', $content['status']);?>"/>
        <input id="num_sequence" name="num_sequence" type="hidden" value="<?php echo set_value('num_sequence', $content['num_sequence']);?>"/>
        <input id="id" name="id" type="hidden" value="<?php echo set_value('id', $content['id']);?>"/>
        <input id="url" name="url" type="hidden" value="<?php echo set_value('id', $content['url']);?>"/>
        <?php foreach($assignedSaleProductList as $assignedSaleProductId):?>
            <input name="old_sale_product_id[]" type="hidden" value="<?php echo set_value('old_sale_product_id', $assignedSaleProductId);?>">
        <?php endforeach;?>
        <div style="width:600px; clear:both">&nbsp;</div>
        <input style='text-align:center' id='button' name='edit_text' type='submit' value='Сохранить'/>
    </form>
</div>