<h2>Афоризмы</h2>
    <div class="add_new" style="margin: 0.5em auto">
         <p>
            <a id="add_new_aforizmus" title="add new" href="#">
                <img src="<?php echo base_url()?>img/img_main/add.png"/>&nbsp;Добавить афоризм
            </a>
        </p>
    </div>
    <div id="add_new_content_container">
        <table id="add_new_content" style="width:100%">
            <tr class="table_title_row">
                <td>Автор</td>
                <td>Текст</td>
                <td colspan="2"><p>save<p></td>
            </tr>
            <tr>
                <td class="article_table author">
                    <input type="text" name="author" id="author" value=""/>
                </td>
                <td class="article_table text">
                    <textarea name="text" id="text"></textarea>
                </td>
                <td  colspan="2">
                    <a class="button_aforizmus" data-url="aforizmus_edit" href="#">
                        <img src="<?php echo base_url()?>img/img_main/floppy_disk.png"/>
                    </a>
                </td>
            </tr>
        </table>
    </div>
    <table id="main_content" style="margin: auto 0.5em auto 0.5em">
        <thead>
            <tr class="table_title_row">
                <th>Автор</th>
                <th>Текст</th>
                <td><p>edit<p></td>
                <td><p>del</p></td>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($content as $key => $item):?>
            <tr>
                <td class="article_table author">
                    <p><b><?php echo $item['author'];?></b></p>
                </td>
                <td class="article_table text">
                    <p><?php  echo $item['text'];?></p>
                </td>
                <td>
                    <a class="edit_aforizmus"  data-url="aforizmus_edit/<?php  echo $item['id'];?>" href="#"><img src="<?php echo base_url()?>img/img_main/edit.png"/></a>
                </td>
                <td>
                    <a title="delete" href="#" data-email="<?php echo base_url().'backend/aforizmus_drop/'.$item['id'];?>">
                        <img src="<?php echo base_url()?>img/img_main/del.png"/>
                    </a>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
<div id="mess_mailsent"></div>