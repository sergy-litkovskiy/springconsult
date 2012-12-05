<!--<script  type="text/javascript" src="<?php echo base_url();?>js/spring/modules/article_list_container.js"></script>-->
<h2><?php echo @$title;?></h2>
    <div class="add_new">
         <p>
            <a title="add new" href="<?php echo base_url().'backend/sale_page_edit'?>">
                <img src="<?php echo base_url()?>img/img_main/add.png"/>&nbsp;Создать страницу
            </a>
        </p>
    </div>
    <table id="main_content">
        <thead>
            <tr class="table_title_row">
                <td>Название</td>
                <td>Текстовый блок1</td>
                <td>Текстовый блок2</td>
                <td style="width:180px">Список продуктов</td>
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
                    <p><?php echo Common::cutString($item['text1'], 10);?></p>
                </td>
                <td class="article_table">
                    <p><?php echo Common::cutString($item['text2'], 10);?></p>
                </td>
                <td class="article_table">
                    <ul>
                    <?php if(count($item['sale_products'])){
                        foreach ($item['sale_products'] as $sale_products):?>
                            <?php if($sale_products['title']){
                                $status = ($sale_products['status'] == 1) ? '<b style="color:green">вкл</b>': '<b style="color:red">октл</b>';?>
                                <li><?php  echo $sale_products['title'].' - '.$status;?></li>
                            <?php };?>
                        <?php endforeach;
                    }?>
                    </ul>
                </td>
                <td>
                    <a title="edit" href="<?php echo base_url().'backend/sale_page_edit/'.$item['id'];?>">
                        <img src="<?php echo base_url()?>img/img_main/edit.png"/>
                    </a>
                </td>
                <td>
                    <a title="delete" href="#" data-email="<?php echo base_url().'backend/sale_page_drop/'.$item['id'];?>">
                        <img src="<?php echo base_url()?>img/img_main/del.png"/>
                    </a>
                </td>
                   
                <td style="width:40px">
                    <form id="<?php echo @$item['id'];?>">
                    <input type="hidden" name="table" id="hidden<?php echo $item['id'];?>" value="sale_page">
                    <input type="radio" id="<?php echo $item['id'];?>" name="status" value="1" <?php echo ($item['status'] == '1') ? 'checked="checked"': null;?>/>
                    <img src="<?php echo base_url()?>img/img_main/on.png"/>
                </td>
                <td style="width:40px">
                    <input type="radio" id="<?php echo $item['id'];?>" name="status" value="0" <?php echo ($item['status'] == '0') ? 'checked="checked"': null;?>/>
                    <img src="<?php echo base_url()?>img/img_main/off.png"/>
                    </form>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>

<div id="mess_mailsent"></div>

<!--<script>
        SPRING.Core.registerModule("main_content", ArticleListContainerModule());
</script>  -->