<p class="edit_message"><?php echo @$message; ?></p>
<h2>Бесплатные продукты</h2>
    <table id="main_content">
            <tr class="table_title_row">
                <td>Картинка</td>
                <td>Название</td>
                <td>Материал</td>
                <td>Описание</td>
                <td><p>edit<p></td>
                <td><p>del</p></td>
                <td style="width:40px"><p>&nbsp;&nbsp;&nbsp;on</p></td>
                <td style="width:40px"><p>&nbsp;&nbsp;off</p></td>
            </tr>
        <?php foreach ($content as $key => $item):?>
            <tr>
                <td class="article_table">
                    <p>
                        <img style="width:80px" src="<?php echo base_url()."subscribe/".$item['img_path']?>"/>
                    </p>
                </td>
                <td class="article_table title">
                    <p><b><?php echo $item['subscribe_name'];?></b></p>
                </td>
                <td class="article_table">
                    <?php $file_path_parts = $item['material_path'] ? explode('.', $item['material_path']) : null;?>
                    <a title="Show" href="<?php echo base_url()."subscribegift/".$item['material_path'];?>">
                        <img class="subscribe_edit material" src="<?php echo base_url()."img/img_main/".@$file_path_parts[1].".png"?>"/>
                    </a>
                </td>
                <td>
                    <p><b><?php echo $item['description'];?></b></p>
                </td>
                <td>
                    <a title="edit" href="<?php echo base_url().'backend/subscribe_edit/'.$item['id'];?>"><img src="<?php echo base_url()?>img/img_main/edit.png"/></a>
                </td>
                <td>
                    <input type="hidden" name="id" id="hiddenid<?php echo $item['id'];?>" value="<?php echo $item['id'];?>"/>
                    <input type="hidden" name="filename" id="hiddenfilename<?php echo $item['id'];?>" value="<?php echo $item['img_path'];?>"/>
                    <input type="hidden" name="table" id="hiddentable<?php echo $item['id'];?>" value="subscribe"/>
                    <a class="drop" title="Удалить" href="#">
                        <img src="<?php echo base_url()?>img/img_main/del.png"/>
                    </a>
                </td>

                <td>
                    <form id="<?php echo @$item['id'];?>">
                    <input type="hidden" name="table" id="hidden<?php echo $item['id'];?>" value="subscribe"/>
                    <input type="radio" id="<?php echo $item['id'];?>" name="status" value="1" <?php echo ($item['status'] == '1') ? 'checked="checked"': null;?>/>
                    <img src="<?php echo base_url()?>img/img_main/on.png"/>
                </td>
                <td>
                    <input type="radio" id="<?php echo $item['id'];?>" name="status" value="0" <?php echo ($item['status'] == '0') ? 'checked="checked"': null;?>/>
                    <img src="<?php echo base_url()?>img/img_main/off.png"/>
                    </form>
                </td>
            </tr>
        <?php endforeach;?>
    </table>
    <div class="add_new">
         <p>
            <a title="add new" href="<?php echo base_url().'backend/subscribe_edit'?>">
                <img src="<?php echo base_url()?>img/img_main/add.png"/>&nbsp;Добавить продукт
            </a>
        </p>
    </div>