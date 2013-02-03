<script  type="text/javascript" src="<?php echo base_url();?>js/spring/modules/article_list_container.js"></script>
<script  type="text/javascript" src="<?php echo base_url();?>js/spring/modules/sale_product_letter_container.js"></script>
<h2><?php echo @$title;?></h2>
    <div class="add_new">
         <p>
            <a title="add new" href="<?php echo base_url().'backend/sale_products_edit'?>">
                <img src="<?php echo base_url()?>img/img_main/add.png"/>&nbsp;Создать продукт
            </a>
        </p>
    </div>
    <table id="main_content">
        <thead>
            <tr class="table_title_row">
                <td>Название</td>
                <td>Описание</td>
                <td>Цена</td>
                <td style="width:180px">Продающая страница</td>
                <td>Письмо</td>
                <td><p>edit<p></td>
                <td><p>del</p></td>
                <td style="width:40px"><p>&nbsp;&nbsp;&nbsp;on</p></td>
                <td style="width:40px"><p>&nbsp;&nbsp;off</p></td>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($content as $key => $item):?>
            <tr data-article-id="<?php echo $item['id'];?>" data-article-title="<?php echo $item['title'];?>">
                <td class="article_table title">
                    <p><b><?php echo $item['title'];?></b></p>
                </td>
                <td class="article_table">
                    <p><?php echo $item['description'];?></p>
                </td>
                <td class="article_table">
                    <p><b><?php echo $item['price'];?></b></p>
                </td>
                <td class="article_table">
                    <ul>
                        <?php if(count($item['sale_page'])){
                            foreach ($item['sale_page'] as $sale_page):?>
                                <?php if($sale_page['title']){
                                    $status = ($sale_page['status'] == 1) ? '<b style="color:green">вкл</b>': '<b style="color:red">октл</b>';?>
                                    <li><?php  echo $sale_page['title'].' - '.$status;?></li>
                                <?php };?>
                            <?php endforeach;
                        }?>
                    </ul>
                </td>
                <td>
                    <?php if($item['sale_products_letters']){?>
                        <span class="edit_sale_products_letters" data-sale-products-letters="<?php echo base64_encode(json_encode($item['sale_products_letters']));?>">
                            <img src="<?php echo base_url()?>img/img_main/mail_edit.png"/>
                        </span>
                        <?php } else {?>
                        <span class="new_sale_products_letters">
                            <img src="<?php echo base_url()?>img/img_main/mail_add.png"/>
                        </span>
                    <?php }?>
                </td>
                <td>
                    <a title="edit" href="<?php echo base_url().'backend/sale_products_edit/'.$item['id'];?>">
                        <img src="<?php echo base_url()?>img/img_main/edit.png"/>
                    </a>
                </td>
                <td>
                    <a class="drop" title="Удалить" href="#" data-email="<?php echo base_url().'backend/sale_products_drop/'.$item['id'];?>">
                        <img src="<?php echo base_url()?>img/img_main/del.png"/>
                    </a>
                </td>

                <td colspan="2" class="status-change">
                    <form id="<?php echo @$item['id'];?>" data-table="sale_products">
                        <input type="radio" name="status" value="1" <?php echo ($item['status'] == '1') ? 'checked="checked"': null;?>/>
                        <img src="<?php echo base_url()?>img/img_main/on.png"/>
                        &nbsp;&nbsp;
                        <input type="radio" name="status" value="0" <?php echo ($item['status'] == '0') ? 'checked="checked"': null;?>/>
                        <img src="<?php echo base_url()?>img/img_main/off.png"/>
                    </form>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>

<?php echo $saleProductLetterContainer;?>
<script>
    SPRING.Core.registerModule("main_content", ArticleListContainerModule());
</script>