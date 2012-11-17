<p class="edit_message"><?php echo @$message; ?></p>
<h2>Материалы</h2>
    <table id="main_content">
            <tr class="table_title_row">
                <td>Материал</td>
                <td>Название</td>
                <td>Опубликовано в:</td>
                <td><p>edit<p></td>
                <td><p>del</p></td>
                <td style="width:40px"><p>&nbsp;&nbsp;&nbsp;on</p></td>
                <td  style="width:40px"><p>&nbsp;&nbsp;off</p></td>
            </tr>
        <?php foreach ($content as $key => $item):?>
            <?php $file_path_parts = explode('.', $item['file_path']);?>
            <tr>
                <td class="article_table">
                    <p>
                        <a title="Show" href="<?php echo base_url()."materials/".$item['file_path'];?>">
                            <img class="material" src="<?php echo base_url()."img/img_main/".$file_path_parts[1].".png"?>"/>
                        </a>
                    </p>
                </td>
                <td class="article_table title" style="width:560px">
                    <p><b><?php echo $item['rus_name'];?></b></p>
                </td>
                <td class="article_table">
                    <ul>
                    <?php foreach ($assigns[$item['id']] as $menuItem):?>
                        <?php if($menuItem){?>
                            <li><?php  echo $menuItem;?></li>
                        <?php };?>
                    <?php endforeach;?>
                    </ul>
                </td>
                 <td>
                    <a title="edit" href="<?php echo base_url().'backend/material_edit/'.$item['id'];?>"><img src="<?php echo base_url()?>img/img_main/edit.png"/></a>
                </td>
                <td>
                    <input type="hidden" name="id" id="hiddenid<?php echo $item['id'];?>" value="<?php echo $item['id'];?>"/>
                    <input type="hidden" name="filename" id="hiddenfilename<?php echo $item['id'];?>" value="<?php echo $item['file_path'];?>"/>
                    <input type="hidden" name="table" id="hiddentable<?php echo $item['id'];?>" value="material"/>
                    <a class="drop" title="Удалить" href="#">
                        <img src="<?php echo base_url()?>img/img_main/del.png"/>
                    </a>
                </td>

                <td>
                    <form id="<?php echo @$item['id'];?>">
                    <input type="hidden" name="table" id="hidden<?php echo $item['id'];?>" value="materials"/>
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
            <a title="add new" href="<?php echo base_url().'backend/material_edit'?>">
                <img src="<?php echo base_url()?>img/img_main/add.png"/>&nbsp;Добавить материал
            </a>
        </p>
    </div>