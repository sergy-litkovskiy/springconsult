<script  type="text/javascript" src="<?php echo base_url();?>js/spring/modules/article_list_container.js"></script>
<script  type="text/javascript" src="<?php echo base_url();?>js/spring/modules/spec_mailer_container.js"></script>
<h2><?php echo @$content[0]['slug_title'];?></h2>
    <div class="add_new">
         <p>
            <a title="add new" href="<?php echo base_url().'backend/landing_articles_edit'?>">
                <img src="<?php echo base_url()?>img/img_main/add.png"/>&nbsp;Добавить статью
            </a>
        </p>
    </div>
    <table id="main_content">
        <thead>
            <tr class="table_title_row">
                <th style="width:65px">Дата</th>
                <td>Ссылка на статью</td>
                <td>Название</td>
                <td>Landing page</td>
                <td>Link mp3</td>
                <td>Password mp3</td>
                <td>Спец. рассылка</td>
                <td><p>edit<p></td>
                <td><p>del</p></td>
                <td style="width:4px"><p>&nbsp;&nbsp;&nbsp;on</p></td>
                <td style="width:40px"><p>&nbsp;&nbsp;off</p></td>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($content as $key => $item):?>
            <tr data-article-id="<?php echo $item['id'];?>" data-article-title="<?php echo $item['title'];?>" data-is-landing="1">
                <td class="article_table">
                    <p title="edit"><?php echo $item['created_at'];?></p>
                </td>
                <td class="article_table title">
                    <p><?php echo base_url().'landing_articles/'.$item['id'];?></p>
                </td>
                <td class="article_table title">
                    <p><b><?php echo $item['title'];?></b></p>
                </td>
                <td class="article_table">
                    <p><b><?php echo $item['landing_page_name'];?></b></p>
                </td>
                <td class="article_table">
                    <p><b><?php echo $item['link_mp3'];?></b></p>
                </td>
                <td class="article_table">
                    <p><b><?php echo $item['password_mp3'];?></b></p>
                </td>
                <td class="article_table mailer">
                    <a title="edit" class="go-mailer-lp" href="">
                        <img src="<?php echo base_url()?>img/img_main/email_go_lp.png"/>
                    </a>
                </td>                
                <td>
                    <a title="edit" href="<?php echo base_url().'backend/landing_articles_edit/'.$item['id'];?>">
                        <img src="<?php echo base_url()?>img/img_main/edit.png"/>
                    </a>
                </td>
                <td>
                    <a title="delete" href="#" data-email="<?php echo base_url().'backend/landing_articles_drop/'.$item['id'];?>">
                        <img src="<?php echo base_url()?>img/img_main/del.png"/>
                    </a>
                </td>
                   
                <td style="width:65px">
                    <form id="<?php echo @$item['id'];?>">
                    <input type="hidden" name="table" id="hidden<?php echo $item['id'];?>" value="landing_articles">
                    <input type="radio" id="<?php echo $item['id'];?>" name="status" value="1" <?php echo ($item['status'] == '1') ? 'checked="checked"': null;?>/>
                    <img src="<?php echo base_url()?>img/img_main/on.png"/>
                </td>
                <td style="width:65px">
                    <input type="radio" id="<?php echo $item['id'];?>" name="status" value="0" <?php echo ($item['status'] == '0') ? 'checked="checked"': null;?>/>
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