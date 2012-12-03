<script  type="text/javascript" src="<?php echo base_url();?>js/spring/modules/edit_sale_products.js"></script>
<h2><?php echo $title." '".$content['title']."'";?></h2>
<?php echo @$message; ?>
<?php echo validation_errors(); ?>
<form id="back_form_sale_products" class="add_new" action='<?php echo base_url()?>backend/check_valid_sale_products' method='post' name='edit_text' enctype='multipart/form-data'>
    <p><b>Название:</b></p>
    <p><input type="text" class="main_inputs" id='title' name='title' value="<?php echo $content['title'];?>"/></p>
    <br/>
    <p><b>Описание:</b></p>
    <textarea id="sale-products-mce" style='width:100%' name='description' cols='80' rows='8'><?php echo $content['description'];?></textarea>
    <br/>
    <p><b>Цена:</b></p>
    <p><input type="text" id='price' name='price' value="<?php echo $content['price'];?>"/></p>
    <br/>
    <p><b>Выбрать sale page:</b></p>
    <p><a class="show-landing-articles-list">показать/скрыть</a></p>
    <br/>
    <ul class="sale-page-list">
        <?php foreach($salePageArr as $salePage):?>
            <li>
                <input type="checkbox" class="edit_detail" name="sale_page_id" value="<?php echo $salePage['id']?>" <?php echo (in_array($salePage['id'], $content['sale_page'])) ? 'checked="checked"': '';?>>
                <span class="landing_title_list">&nbsp;<?php echo $salePage['title']?></span>
            </li>                    
        <?php endforeach;?>
    </ul> 
    <input id="id" name="id" type="hidden" value="<?php echo set_value('id', $content['id']);?>"/>
    <input id="sequence_num" name="sequence_num" type="hidden" value="<?php echo set_value('sequence_num', $content['sequence_num']);?>"/>
    <input id="status" name="status" type="hidden" value="<?php echo set_value('status', $content['status']);?>"/>
    <input id="created_at" name="created_at" type="hidden" value="<?php echo set_value('created_at', $content['created_at']);?>"/>
    <div style="width:600px; clear:both">&nbsp;</div>
    
    <input id='button' name='edit_sale_products' type='submit' value='Сохранить'/>
</form>
<script>
        SPRING.Core.registerModule("sale-products-mce", TinymceInitModule()); 
        SPRING.Core.registerModule("back_form_sale_products", EditSaleProductsFormModule());
</script>  