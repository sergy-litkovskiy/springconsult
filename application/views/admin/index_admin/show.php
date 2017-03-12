<script  type="text/javascript" src="<?php echo base_url();?>js/spring/modules/article_list_container.js"></script>
<script  type="text/javascript" src="<?php echo base_url();?>js/spring/modules/spec_mailer_container.js"></script>

<h2><?php echo @$content[0]['slug_title'];?></h2>
    <div class="add_new">
         <p>
            <a title="add new" href="<?php echo base_url().'backend/article_edit'?>">
                <img src="<?php echo base_url()?>img/img_main/add.png"/>&nbsp;Добавить статью
            </a>
        </p>
    </div>
    <table id="main_content">
        <thead>
            <tr class="table_title_row">
                <th style="width:65px">Дата</th>
                <th>Название</th>
                <th style="width:150px">Опубликовано в:</th>
                <td>Meta Keywords</td>
                <td>Meta Descript</td>
                <td>Рассылка</td>
                <td>Спец. рассылка</td>
                <td><p>edit<p></td>
                <td><p>del</p></td>
                <td style="width:45px"><p>&nbsp;&nbsp;&nbsp;on</p></td>
                <td style="width:75px"><p>&nbsp;&nbsp;off</p></td>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($content as $key => $item):?>
            <tr data-article-id="<?php echo $item['id'];?>" data-article-title="<?php echo $item['title'];?>">
                <td class="article_table">
                    <p title="edit"><p><?php echo $item['date'];?></p>
                </td>
                <td class="article_table title">
                    <p><b><?php echo $item['title'];?></b></p>
                </td>
                <td class="article_table title">
                    <ul>
                    <?php foreach ($assigns[$item['id']] as $menuItem):?>
                        <?php if($menuItem){?>
                            <li><?php  echo $menuItem;?></li>
                        <?php };?>
                    <?php endforeach;?>
                    </ul>
                </td>
                <td class="article_table"><p><?php  echo Common::cutString($item['meta_keywords'], 10);?></p></td>
                <td class="article_table"><p><?php  echo Common::cutString($item['meta_description'], 10);?></p></td>
                <td class="article_table">
                    <?php if($item['is_sent_mail'] !== STATUS_ON){?>
                        <a class="send_subscribe" title="subscribe" href="#">
                            <img src="<?php echo base_url()?>img/img_main/email_go.png"/>
                        </a>
                    <?php } else {?>
                        <img src="<?php echo base_url()?>img/img_main/check.png"/>
                    <?php }?>
                </td>
                <td class="article_table mailer">
                    <a title="edit" class="go-mailer-lp" href="">
                        <img src="<?php echo base_url()?>img/img_main/email_go_lp.png"/>
                    </a>
                </td>                
                <td>
                    <a title="edit" href="<?php echo base_url().'backend/article_edit/'.$item['id'];?>">
                        <img src="<?php echo base_url()?>img/img_main/edit.png"/>
                    </a>
                </td>
                <td>
                    <a class="drop" title="Удалить" href="#" data-email="<?php echo base_url().'backend/article_drop/'.$item['id'];?>">
                        <img src="<?php echo base_url()?>img/img_main/del.png"/>
                    </a>
                </td>

                <td colspan="2" class="status-change">
                    <form id="<?php echo @$item['id'];?>" data-table="article">
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

<div id="mess_mailsent"></div>
<?php echo $specMailerContainer;?>
<script>
        SPRING.Core.registerModule("main_content", ArticleListContainerModule());
</script>