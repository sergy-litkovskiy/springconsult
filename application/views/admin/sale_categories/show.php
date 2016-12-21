<script  type="text/javascript" src="<?php echo base_url();?>js/spring/modules/sale_category_list_container.js"></script>

<h2><?php echo @$title;?></h2>
    <div class="add_new">
         <p>
            <a title="add new" href="<?php echo base_url().'backend/sale_category_edit'?>">
                <img src="<?php echo base_url()?>img/img_main/add.png"/>&nbsp;Создать sale category
            </a>
        </p>
    </div>
    <table id="category_list_content">
        <thead>
            <tr class="table_title_row">
                <td>Название</td>
                <td>Sale product list</td>
                <td><p>edit<p></td>
                <td><p>del</p></td>
                <td style="width:60px"><p>&nbsp;&nbsp;&nbsp;on</p></td>
                <td style="width:60px"><p>&nbsp;&nbsp;off</p></td>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($categoriesToProductsMap as $categoryId => $map):?>
            <tr data-topic-id="<?php echo $map['data']['id'];?>" data-topic-title="<?php echo $map['data']['name'];?>">
                <td class="article_table title" style="padding: 1em">
                    <p><b><?php echo $map['data']['name'];?></b></p>
                </td>
                <td class="article_table" style="padding: 1em">
                    <ul>
                        <?php if(isset($map['sale_product_list']) && count($map['sale_product_list'])){
                            foreach ($map['sale_product_list'] as $saleProductData):?>
                                <?php if($saleProductData['sale_products_title']){
                                    $status = ($saleProductData['sale_products_title'] == 1) ? '<b style="color:green">вкл</b>': '<b style="color:red">октл</b>';?>
                                    <li><?php  echo $saleProductData['sale_products_title'].' - '.$status;?></li>
                                <?php };?>
                            <?php endforeach;
                        }?>
                    </ul>
                </td>
                <td style="text-align: center">
                    <a title="edit" href="<?php echo base_url().'backend/sale_category_edit/'.$categoryId;?>">
                        <img src="<?php echo base_url()?>img/img_main/edit.png"/>
                    </a>
                </td>
                <td style="text-align: center">
                    <a class="drop" title="Удалить" href="#" data-email="<?php echo base_url().'backend/sale_category_drop/'.$categoryId;?>">
                        <img src="<?php echo base_url()?>img/img_main/del.png"/>
                    </a>
                </td>

                <td colspan="2" class="status-change" style="text-align: center">
                    <form id="<?php echo $categoryId;?>" data-table="topics">
                        <input type="radio" name="status" value="1" <?php echo ($map['data']['status'] == '1') ? 'checked="checked"': null;?>/>
                        <img src="<?php echo base_url()?>img/img_main/on.png"/>
                        &nbsp;&nbsp;
                        <input type="radio" name="status" value="0" <?php echo ($map['data']['status'] == '0') ? 'checked="checked"': null;?>/>
                        <img src="<?php echo base_url()?>img/img_main/off.png"/>
                    </form>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>

<script>
    SPRING.Core.registerModule("category_list_content", CategoryListContainerModule());
</script>