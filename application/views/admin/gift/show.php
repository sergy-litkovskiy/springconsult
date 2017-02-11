<script  type="text/javascript" src="<?php echo base_url();?>js/spring/modules/article_list_container.js"></script>
<p class="edit_message"><?php echo @$message; ?></p>
<h2>Бесплатные продукты</h2>
    <table id="main_content">
            <tr class="table_title_row">
                <td>Картинка</td>
                <td>Название</td>
                <td>Доп. Название</td>
                <td>Статьи</td>
                <td>Материал</td>
                <td><p>edit<p></td>
                <td><p>del</p></td>
                <td style="width:40px"><p>&nbsp;&nbsp;&nbsp;on</p></td>
                <td style="width:40px"><p>&nbsp;&nbsp;off</p></td>
            </tr>
        <?php foreach ($content as $key => $item):?>
            <tr>
                <td class="article_table">
                    <p>
                        <img style="width:80px" src="<?php echo base_url()."img/subscribe/".$item['data']['image']?>"/>
                    </p>
                </td>
                <td class="article_table title">
                    <p><b><?php echo $item['data']['name'];?></b></p>
                </td>
                <td class="article_table title">
                    <p><?php echo htmlspecialchars($item['data']['label']);?></p>
                </td>
                <td class="article_table" style="padding: 1em">
                    <ul>
                        <?php if(isset($item['articleList']) && count($item['articleList'])){
                            foreach ($item['articleList'] as $articleData):?>
                                <?php if($articleData['article_title']){
                                    $status = ($articleData['article_status'] == 1) ? '<b style="color:green">вкл</b>': '<b style="color:red">октл</b>';?>
                                    <li><?php  echo $articleData['article_title'].' - '.$status;?></li>
                                <?php };?>
                            <?php endforeach;
                        }?>
                    </ul>
                </td>
                <td class="article_table">
                    <?php $file_path_parts = $item['data']['material'] ? explode('.', $item['data']['material']) : null;?>
                    <a title="Show" href="<?php echo base_url()."subscribegift/".$item['data']['material'];?>">
                        <img class="subscribe_edit material" src="<?php echo base_url()."img/img_main/".@$file_path_parts[1].".png"?>"/>
                    </a>
                </td>
                <td>
                    <a title="edit" href="<?php echo base_url().'backend/gift_edit/'.$item['data']['id'];?>">
                        <img src="<?php echo base_url()?>img/img_main/edit.png"/>
                    </a>
                </td>
                <td>
                    <a class="drop" title="Удалить" href="#" data-email="<?php echo base_url().'backend/gift_drop/'.$item['data']['id'];?>" data-file="<?php echo $item['data']['image'];?>">
                        <img src="<?php echo base_url()?>img/img_main/del.png"/>
                    </a>
                </td>

                <td colspan="2" class="status-change">
                    <form id="<?php echo @$item['data']['id'];?>" data-table="gift">
                        <input type="radio" name="status" value="1" <?php echo ($item['data']['status'] == '1') ? 'checked="checked"': null;?>/>
                        <img src="<?php echo base_url()?>img/img_main/on.png"/>
                        &nbsp;&nbsp;
                        <input type="radio" name="status" value="0" <?php echo ($item['data']['status'] == '0') ? 'checked="checked"': null;?>/>
                        <img src="<?php echo base_url()?>img/img_main/off.png"/>
                    </form>
                </td>
            </tr>
        <?php endforeach;?>
    </table>
    <div class="add_new">
         <p>
            <a title="add new" href="<?php echo base_url().'backend/gift_edit'?>">
                <img src="<?php echo base_url()?>img/img_main/add.png"/>&nbsp;Добавить продукт
            </a>
        </p>
    </div>
<script>
    SPRING.Core.registerModule("main_content", ArticleListContainerModule());
</script>