<div id="content">
    <?php if(isset($announcement)):?>
        <div class="announce">
            <?php echo $announcement['text'];?>
        </div>
    <?php endif;?>
    <h1><b><?php echo @$content[0]['slug_title'];?></b></h1>
    <div style="text-align: right" id="article_subscribe">
        <a class="detail_show" href="#">
            <img src="/img/img_main/email_go.png"/>&nbsp;Подписаться на получение последних статей
        </a>
        <div id="article_subscribe_form">
            <form class="article_subscribe_form" action='#' method='post' name='add_new' enctype='multipart/form-data'>
                <p id="subscribe_error"></p>
                <table>
                    <tr>
                        <td>
                            <p><b>Имя:</b></p>
                        </td>
                        <td>
                            <input type='text' id='name' name='name' value=""/>
                        </td>
                    </tr>
                    <tr style="height:10px"></tr>
                    <tr>
                        <td>
                            <p><b>E-mail:</b></p>
                        </td>
                        <td>
                            <input type='text' id='email' name='email' value=""/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="subscribe_button">
                            <input id='button' class="subscribe_action" name='add' type='submit' value='Подписаться' style="margin-right:1em"/>
                        </td>
                    </tr>
                </table>
            </form>
        </div>    
        <div id="loader" class="loader" style="display:none;">
            <img id="img_loader" src="/img/img_main/ajax-loader.gif" alt="Loading"/>
        </div>
    </div>
    <div id="content-text-short">
        <?php foreach ($content as $key => $item):?>
            <p class="title"><span class="date"><?php echo Common::getDate(@$item['date']);?></span><?php echo @$item['title'];?></p>
                <div class="short_text">
                    <?php echo @$item['text'];?>
                    <span class='article_id' id="article_<?php echo $key;?>"><?php echo @$item['id'];?></span>
                </div>
            <p><a class="comments_count" href="<?php echo base_url();?>articles/<?php echo @$item['id'];?>#disqus_thread" data-disqus-identifier="article_<?php echo @$item['id'];?>_identifier"></a></p>
        <?php endforeach;?>
    </div>
    <div class="clear">&nbsp;</div>
    <?php echo $pager ? $pager : null;?>
    
    <div id="loader" class="loader" style="display:none;">
        <img id="img_loader" src="/img/img_main/ajax-loader.gif" alt="Loading"/>
    </div>
</div>
<?php echo $disqus ? $disqus : null;?>
<script  type="text/javascript" src="<?php echo base_url();?>js/spring/modules/article_subscribe.js"></script>
<script  type="text/javascript" src="<?php echo base_url();?>js/spring/modules/short_text_list.js"></script>
<script>
        SPRING.Core.registerModule("article_subscribe", ArticleSubscribeModule());
        SPRING.Core.registerModule("content-text-short", ShortTextListModule());
</script>  