<script  type="text/javascript" src="<?php echo base_url();?>js/spring/modules/edit_sale_products.js"></script>
<h2><?php echo $title." '".$content['title']."'";?></h2>
<?php echo @$message; ?>
<?php echo validation_errors(); ?>
<form id="back_form_sale_products" class="add_new" action='<?php echo base_url()?>backend/sale_product_save' method='post' name='edit_text' enctype='multipart/form-data'>
    <p><b>Название:</b></p>
    <p><input type="text" class="main_inputs" id='title' name='title' value="<?php echo $content['title'];?>"/></p>
    <br/>
    <p><b>Доп. Название:</b></p>
    <p><input type="text" class="main_inputs" id='label' name='label' value="<?php echo $content['label'];?>"/></p>
    <br/>
    <p><b>Alias (slug):</b></p>
    <p><input type="text" class="main_inputs" id='slug' name='slug' value="<?php echo $content['slug'];?>"/></p>
    <br/>
    <p><b>Подарок:</b></p>
    <p><input type="text" class="main_inputs" id='gift' name='gift' value="<?php echo $content['gift'];?>"/></p>
    <br/>
        <?php if($content['image_list']) {?>
            <?php $count = (5 - count($content['image_list']));?>
            <?php foreach($content['image_list'] as $imageData):?>
                <p><b><?php if($imageData['is_main']) { echo 'Main'; } ?> Image:</b></p>
                <p><input type="text" name='image[<?php echo $imageData['id'];?>]' value="<?php echo $imageData['image'];?>"/></p>
                <br/>
            <?php endforeach;?>
            <?php if($count) {?>
                <?php for($i=0; $i < $count; $i++):?>
                    <p><b>Image:</b></p>
                    <p><input type="text" name='image[<?php echo '#'.$i;?>]' value=""/></p>
                    <br/>
                <?php endfor;?>
            <?php }?>
        <?php } else {?>
            <?php for($i=0; $i < 5; $i++):?>
                <p><b><?php if($i==0) { echo 'Main'; } ?> Image:</b></p>
                <p><input type="text" name='image[<?php echo '#'.$i;?>]' value=""/></p>
                <br/>
            <?php endfor;?>
        <?php }?>
    <p><b>Описание короткое:</b></p>
    <textarea style='width:100%' name='description' cols='80' rows='8'><?php echo $content['description'];?></textarea>
    <br/>
    <p><b>Описание основное:</b></p>
    <textarea style='width:100%' name='text' cols='80' rows='8'><?php echo $content['text'];?></textarea>
    <br/>
    <p><b>Доставка:</b></p>
    <textarea style='width:100%' name='delivery' cols='80' rows='5'><?php echo $content['delivery'];?></textarea>
    <br/>
    <p><b>Оплата:</b></p>
    <textarea style='width:100%' name='payment' cols='80' rows='5'><?php echo $content['payment'];?></textarea>
    <br/>
    <p><b>Цена:</b></p>
    <p><input type="text" id='price' name='price' value="<?php echo $content['price'];?>"/></p>
    <br/>

    <input id="id" name="id" type="hidden" value="<?php echo set_value('id', $content['id']);?>"/>
    <input id="sequence_num" name="sequence_num" type="hidden" value="<?php echo set_value('sequence_num', $content['sequence_num']);?>"/>
    <input id="status" name="status" type="hidden" value="<?php echo set_value('status', $content['status']);?>"/>
    <input id="created_at" name="created_at" type="hidden" value="<?php echo set_value('created_at', $content['created_at']);?>"/>

    <div style="width:600px; clear:both">&nbsp;</div>
    
    <input id='button' name='edit_sale_product' type='submit' value='Сохранить'/>
</form>
<script>
        SPRING.Core.registerModule("sale-products-mce", TinymceInitModule()); 
        SPRING.Core.registerModule("back_form_sale_products", EditSaleProductsFormModule());
</script>  