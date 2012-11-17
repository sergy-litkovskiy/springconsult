<h2>Landing pages</h2>
    <div class="add_new">
         <p>
            <a title="add new" href="<?php echo base_url().'backend/landing_edit'?>">
                <img src="<?php echo base_url()?>img/img_main/add.png"/>&nbsp;Добавить Landing page
            </a>
        </p>
    </div>
    <table id="main_content" class="landing-page-last">
        <thead>
            <tr class="table_title_row">
                <td style="width:65px">Дата создания</td>
                <td>Уникальная ссылка</td>
                <td>Название</td>
                <td style="width:270px">Зарегистрированные</td>
                <td><p>edit<p></td>
                <td><p>del</p></td>
                <td style="width:40px"><p>&nbsp;&nbsp;&nbsp;on</p></td>
                <td style="width:40px"><p>&nbsp;&nbsp;off</p></td>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($content as $key => $item):?>
            <tr>
                <td class="article_table">
                    <p title="edit"><p><?php echo $item['created_at'];?></p>
                </td>
                <td class="article_table title">
                    <p><?php echo base_url().'landing/'.$item['unique'];?></p>
                </td>                
                <td class="article_table title">
                    <p><b><?php echo $item['title'];?></b></p>
                </td>
                <td class="article_table title">
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
                <td>
                    <a title="edit" href="<?php echo base_url().'backend/landing_edit/'.$item['id'];?>"><img src="<?php echo base_url()?>img/img_main/edit.png"/></a>
                </td>
                <td>
                    <a title="delete" href="#" data-email="<?php echo base_url().'backend/landing_drop/'.$item['id'];?>">
                        <img src="<?php echo base_url()?>img/img_main/del.png"/>
                    </a>
                </td>
                   
                <td>
                    <form id="<?php echo @$item['id'];?>">
                    <input type="hidden" name="table" id="hidden<?php echo $item['id'];?>" value="landing_page">
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
        </tbody>
    </table>

<div id="mess_mailsent"></div>