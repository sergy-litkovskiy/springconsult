<script  type="text/javascript" src="<?php echo base_url();?>js/sort_menu_item.js"></script>
<script  type="text/javascript" src="<?php echo base_url();?>js/spring/modules/menu_list_container.js"></script>
<h2>Редактировать меню</h2>
<p class="edit_message"><?php echo @$message; ?></p>
    <table id="main_content" class="menu_content" cellspacing="0">
        <tr class="admin_panel">
                <td>
                    <a title="Add main item" id="add_main_item" href="<?php echo base_url()?>backend/menu_admin/item_edit">
                        <img src="<?php echo base_url()?>img/img_main/add.png"/>&nbsp;Добавить раздел
                    </a>
                </td>
                <td>
                    <a title="Add division" id="add_division" href="<?php echo base_url()?>backend/menu_admin/subitem_edit">
                        <img src="<?php echo base_url()?>img/img_main/add.png"/>&nbsp;Добавить подраздел
                    </a>
                </td>
                <td style="width:50px">Color|Icon</td>
                <td style="width:150px">Short description</td>
                <td style="width:150px">Meta keywords</td>
                <td style="width:150px">Meta description</td>
                <td class="menu_edit">
                    <p>edit</p>
                </td>
                <td class="menu_edit">
                    <p>del</p>
                </td>
                <td class="menu_status">&nbsp;&nbsp;on&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;off</td>
        </tr>
        <?php for($i=0; $i<=count($contentMenu)-1; $i++):?>
        <!-- start first level -->
            <tr class="main_item"   id="<?php echo $contentMenu[$i]->id;?>" parent="<?php echo $contentMenu[$i]->parent;?>" position="<?php echo $contentMenu[$i]->numSeq;?>">
                <td id="menu_<?php echo $contentMenu[$i]->id;?>">
                    <a href="" class="arrow_up" title="move up"><img src="<?php echo base_url()?>img/img_main/arrow_up.png"/></a>
                    <a href="" class="arrow_down" title="move down"><img src="<?php echo base_url()?>img/img_main/arrow_down.png"/></a>
                    <?php echo $contentMenu[$i]->title;?>
                </td>
                <td></td>
                <td><?php echo $contentMenu[$i]->color_class.'|'.$contentMenu[$i]->icon_class;?></td>
                <td><?php echo Common::cutString($contentMenu[$i]->description, 10);?></td>
                <td><?php echo Common::cutString($contentMenu[$i]->meta_keywords, 10);?></td>
                <td><?php echo Common::cutString($contentMenu[$i]->meta_description, 10);?></td>
                <td>
                    <a title="edit" class="edit" id="<?php echo $contentMenu[$i]->id;?>" href="<?php echo base_url()?>backend/menu_admin/item_edit/<?php echo $contentMenu[$i]->id;?>">
                        <img src="<?php echo base_url()?>img/img_main/edit.png"/>
                    </a>
                </td>
                <td>
                    <a title="delete" class="drop" id="<?php echo $contentMenu[$i]->id;?>" href="#" data-email="<?php echo base_url()?>backend/menu_admin/del/<?php echo $contentMenu[$i]->parent;?>/<?php echo $contentMenu[$i]->id;?>">
                        <img src="<?php echo base_url()?>img/img_main/del.png"/>
                    </a>
                </td>
                <td class="status-change">
                    <form id="<?php echo $contentMenu[$i]->id;?>" data-table="menu">
                        <input type="radio" id="<?php echo $contentMenu[$i]->id;?>" name="status" value="1" <?php echo ($contentMenu[$i]->status == '1') ? 'checked="checked"': null;?>/>
                        <img src="<?php echo base_url()?>img/img_main/on.png"/>
                        <input type="radio" id="<?php echo $contentMenu[$i]->id;?>" name="status" value="0" <?php echo ($contentMenu[$i]->status == '0') ? 'checked="checked"': null;?>/>
                        <img src="<?php echo base_url()?>img/img_main/off.png"/>
                    </form>
                </td>
            </tr>
            <?php $child = $contentMenu[$i]->childs; ?>
            <!-- second level -->
                <?php for($k=0; $k<=count($child)-1; $k++):?>
                <tr id="<?php echo $child[$k]->id;?>" parent="<?php echo $child[$k]->parent;?>" position="<?php echo $child[$k]->numSeq;?>">
                    <td>&nbsp;</td>
                    <td id="menu_<?php echo $child[$k]->id;?>">
                        <a href="" class="arrow_up" title="move up"><img src="<?php echo base_url()?>img/img_main/arrow_up.png"/></a>
                        <a href="" class="arrow_down" title="move down"><img src="<?php echo base_url()?>img/img_main/arrow_down.png"/></a>
                        <?php echo $child[$k]->title;?>
                    </td>
                    <td><?php echo $child[$k]->color_class.'|'.$child[$k]->icon_class;?></td>
                    <td><?php echo Common::cutString($child[$k]->description, 10);?></td>
                    <td><?php echo Common::cutString($child[$k]->meta_keywords, 10);?></td>
                    <td><?php echo Common::cutString($child[$k]->meta_description, 10);?></td>
                    <td>
                        <a title="edit" class="edit" id="<?php echo $child[$k]->id;?>" href="<?php echo base_url()?>backend/menu_admin/subitem_edit/<?php echo $child[$k]->id;?>">
                            <img src="<?php echo base_url()?>img/img_main/edit.png"/>
                        </a>
                    </td>
                    <td>
                        <a title="delete" class="drop" id="<?php echo $child[$k]->id;?>" href="#" data-email="<?php echo base_url()?>backend/menu_admin/del/<?php echo $child[$k]->parent;?>/<?php echo $child[$k]->id;?>">
                            <img src="<?php echo base_url()?>img/img_main/del.png"/>
                        </a>
                    </td>
                    <td class="status-change">
                        <form id="<?php echo $child[$k]->id;?>" data-table="menu">
                            <input type="radio" id="<?php echo $child[$k]->id;?>" name="status" value="1" <?php echo ($child[$k]->status == '1') ? 'checked="checked"': null;?>/>
                            <img src="<?php echo base_url()?>img/img_main/on.png"/>
                            <input type="radio" id="<?php echo $child[$k]->id;?>" name="status" value="0" <?php echo ($child[$k]->status == '0') ? 'checked="checked"': null;?>/>
                            <img src="<?php echo base_url()?>img/img_main/off.png"/>
                        </form>
                    </td>

                </tr>
                <?php endfor;?>
            <!-- end second level -->
        <!-- end first level -->
        <?php endfor;?>
    </table>
  
<div id="mess_mailsent"></div>
<script>
    SPRING.Core.registerModule("main_content", MenuListContainerModule());
</script>