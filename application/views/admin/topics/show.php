<script  type="text/javascript" src="<?php echo base_url();?>js/spring/modules/topic_list_container.js"></script>

<h2><?php echo @$title;?></h2>
    <div class="add_new">
         <p>
            <a title="add new" href="<?php echo base_url().'backend/topic_edit'?>">
                <img src="<?php echo base_url()?>img/img_main/add.png"/>&nbsp;Создать topic
            </a>
        </p>
    </div>
    <table id="topic_content">
        <thead>
            <tr class="table_title_row">
                <td>Название</td>
                <td>Статьи</td>
                <td><p>edit<p></td>
                <td><p>del</p></td>
                <td style="width:60px"><p>&nbsp;&nbsp;&nbsp;on</p></td>
                <td style="width:60px"><p>&nbsp;&nbsp;off</p></td>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($topicArticlesMap as $topicId => $topic):?>
            <tr data-topic-id="<?php echo $topic['data']['id'];?>" data-topic-title="<?php echo $topic['data']['name'];?>">
                <td class="article_table title" style="padding: 1em">
                    <p><b><?php echo $topic['data']['name'];?></b> (<?php echo $topic['data']['slug'];?>)</p>
                </td>
                <td class="article_table" style="padding: 1em">
                    <ul>
                        <?php if(isset($topic['articleList']) && count($topic['articleList'])){
                            foreach ($topic['articleList'] as $articleData):?>
                                <?php if($articleData['article_title']){
                                    $status = ($articleData['article_status'] == 1) ? '<b style="color:green">вкл</b>': '<b style="color:red">октл</b>';?>
                                    <li><?php  echo $articleData['article_title'].' - '.$status;?></li>
                                <?php };?>
                            <?php endforeach;
                        }?>
                    </ul>
                </td>
                <td style="text-align: center">
                    <a title="edit" href="<?php echo base_url().'backend/topic_edit/'.$topicId;?>">
                        <img src="<?php echo base_url()?>img/img_main/edit.png"/>
                    </a>
                </td>
                <td style="text-align: center">
                    <a class="drop" title="Удалить" href="#" data-email="<?php echo base_url().'backend/topic_drop/'.$topicId;?>">
                        <img src="<?php echo base_url()?>img/img_main/del.png"/>
                    </a>
                </td>

                <td colspan="2" class="status-change" style="text-align: center">
                    <form id="<?php echo $topicId;?>" data-table="topics">
                        <input type="radio" name="status" value="1" <?php echo ($topic['data']['status'] == '1') ? 'checked="checked"': null;?>/>
                        <img src="<?php echo base_url()?>img/img_main/on.png"/>
                        &nbsp;&nbsp;
                        <input type="radio" name="status" value="0" <?php echo ($topic['data']['status'] == '0') ? 'checked="checked"': null;?>/>
                        <img src="<?php echo base_url()?>img/img_main/off.png"/>
                    </form>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>

<script>
    SPRING.Core.registerModule("topic_content", TopicListContainerModule());
</script>