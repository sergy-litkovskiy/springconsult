<h2>Статистика спец. рассылки</h2>
    <table id="main_content" class="spec-mailer-statistics-list">
        <thead>
            <tr class="table_title_row">
                <td style="width:65px">Дата рассылки</td>
                <td>Тема письма</td>
                <td>Текст письма</td>
                <td>Название статьи</td>
                <td>Название LP</td>
                <td>Кол-во человек</td>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($content as $key => $item):?>
            <tr>
                <td class="article_table">
                    <p title="edit"><p><?php echo $item['created_at'];?></p>
                </td>
                <td class="article_table title">
                    <p><b><?php echo $item['theme'];?></b></p>
                </td>  
                <td class="article_table title">
                    <p><?php echo $item['text'];?></p>
                </td> 
                <td class="article_table title">
                    <p><b><?php echo $item['articles_title'];?></b></p>
                </td>                
                <td class="article_table title">
                    <p><b><?php echo $item['landing_page_title'];?></b></p>
                </td>
                <td class="article_table title" style="width:200px">
                    <p style="color:red; font-size:18px; text-align: center">
                        <b><?php echo count($item['registred_list']);?></b>
                        <a class="registred_detail" href="">
                            <img alt="Список зарегистрированных" src="<?php echo base_url()?>img/img_main/users_group.png"/>
                        </a>                        
                    </p>
                    <div class="landing_registred_list">
                        <?php if(count($item['registred_list'])){;?>
                            <?php foreach ($item['registred_list'] as $i => $recipient):?>
                                <p><?php echo ($i+1).' - <b>'.$recipient['name'].'</b> ('.$recipient['email'].')';?></p>
                            <?php endforeach;?>
                        <?php };?>
                    </div>
                </td>                

            </tr>
        <?php endforeach;?>
        </tbody>
    </table>