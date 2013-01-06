<p class="edit_message"><?php echo @$message; ?></p>
<h2>Анонсы</h2>
    <div class="add_new">
        <p>
            <a title="add new" href="<?php echo base_url().'backend/announce_edit'?>">
                <img src="<?php echo base_url()?>img/img_main/add.png"/>&nbsp;Добавить анонс
            </a>
        </p>
    </div>
    <table id="main_content" style="margin-left: 4em">
            <tr class="table_title_row">
                <td>Дата</td>
                <td>Содержание</td>
                <td><p>edit<p></td>
                <td><p>del</p></td>
                <td style="width:40px"><p>&nbsp;&nbsp;&nbsp;on</p></td>
                <td style="width:40px"><p>&nbsp;&nbsp;off</p></td>
            </tr>
        <?php foreach ($content as $key => $item):?>
            <tr>
                <td class="article_table">
                    <p>
                        <?php echo $item['created_at']?>
                    </p>
                </td>
                <td>
                    <p>
                        <?php echo $item['text'];?>
                    </p>
                </td>
                <td>
                    <a title="edit" href="<?php echo base_url().'backend/announce_edit/'.$item['id'];?>">
                        <img src="<?php echo base_url()?>img/img_main/edit.png"/>
                    </a>
                </td>
                <td>
                    <input type="hidden" name="id" id="hiddenid<?php echo $item['id'];?>" value="<?php echo $item['id'];?>"/>
                    <input type="hidden" name="table" id="hiddentable<?php echo $item['id'];?>" value="announcement"/>
                    <a class="drop" title="Удалить" href="#">
                        <img src="<?php echo base_url()?>img/img_main/del.png"/>
                    </a>
                </td>

                <td>
                    <form id="<?php echo @$item['id'];?>">
                    <input type="hidden" name="table" id="hidden<?php echo $item['id'];?>" value="announcement"/>
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