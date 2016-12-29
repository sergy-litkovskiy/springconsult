<script  type="text/javascript" src="<?php echo base_url();?>js/spring/modules/review_list_container.js"></script>

<h2><?php echo @$title;?></h2>
    <div class="add_new">
         <p>
            <a title="add new" href="<?php echo base_url().'backend/review_edit'?>">
                <img src="<?php echo base_url()?>img/img_main/add.png"/>&nbsp;Создать отзыв
            </a>
        </p>
    </div>
    <table id="review_list_content">
        <thead>
            <tr class="table_title_row">
                <td>Автор</td>
                <td>Фото</td>
                <td>Текст</td>
                <td>Sale product list</td>
                <td>Разделы</td>
                <td><p>edit<p></td>
                <td><p>del</p></td>
                <td style="width:60px"><p>&nbsp;&nbsp;&nbsp;on</p></td>
                <td style="width:60px"><p>&nbsp;&nbsp;off</p></td>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($reviewsToAssignedItemsMap as $reviewId => $map):?>
            <tr data-review-id="<?php echo $map['data']['id'];?>" data-review-author="<?php echo $map['data']['author'];?>">
                <td class="article_table title" style="padding: 1em">
                    <p><b><?php echo $map['data']['author'];?></b></p>
                </td>
                <td class="article_table title" style="padding: 1em">
                    <p><b><?php echo $map['data']['image'];?></b></p>
                </td>
                <td class="article_table title" style="padding: 1em">
                    <p><b><?php echo $map['data']['text'];?></b></p>
                </td>
                <td class="article_table" style="padding: 1em">
                    <ul>
                        <?php if(isset($map['sale_product_list']) && count($map['sale_product_list'])){
                            foreach ($map['sale_product_list'] as $saleProductData):?>
                                <?php if($saleProductData['sale_products_status']){
                                    $status = ($saleProductData['sale_products_status'] == 1) ? '<b style="color:green">вкл</b>': '<b style="color:red">октл</b>';?>
                                    <li><?php  echo $saleProductData['sale_products_title'].' - '.$status;?></li>
                                <?php };?>
                            <?php endforeach;
                        }?>
                    </ul>
                </td>
                <td class="article_table" style="padding: 1em">
                    <ul>
                        <?php if(isset($map['menu_list']) && count($map['menu_list'])){
                            foreach ($map['menu_list'] as $menuData):?>
                                <?php if($menuData['menu_status']){
                                    $status = ($menuData['menu_status'] == 1) ? '<b style="color:green">вкл</b>': '<b style="color:red">октл</b>';?>
                                    <li><?php  echo $menuData['menu_title'].' - '.$status;?></li>
                                <?php };?>
                            <?php endforeach;
                        }?>
                    </ul>
                </td>
                <td style="text-align: center">
                    <a title="edit" href="<?php echo base_url().'backend/review_edit/'.$reviewId;?>">
                        <img src="<?php echo base_url()?>img/img_main/edit.png"/>
                    </a>
                </td>
                <td style="text-align: center">
                    <a class="drop" title="Удалить" href="#" data-email="<?php echo base_url().'backend/review_drop/'.$reviewId;?>">
                        <img src="<?php echo base_url()?>img/img_main/del.png"/>
                    </a>
                </td>

                <td colspan="2" class="status-change" style="text-align: center">
                    <form id="<?php echo $reviewId;?>" data-table="reviews">
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
    SPRING.Core.registerModule("review_list_content", ReviewListContainerModule());
</script>