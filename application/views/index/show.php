<div id="content">
    <h1><b><?php echo @$content['title'];?></b></h1>
    <?php echo @$content['text'];?>
    <?php echo isset($contact_form) ? $contact_form : false;?>
    <?php if($articles):?>
        <div class="docs" style="float:left">
            <h3>Статьи к теме:</h3>
            <table>
                <?php foreach ($articles as $article):?>
                <tr>
                    <td><a href="<?php echo base_url().@$content['slug'];?>/<?php echo $article['id'];?>">"<?php echo $article['title'];?>"</a></td>
                </tr>
                <?php endforeach;?>
            </table>
        </div>
    <?php endif;?>
    <?php if($materials):?>
        <div class="docs">
            <h3>Материалы к теме:</h3>
            <table>
                <?php foreach ($materials as $material):?>
                    <?php $format = explode('.', $material['file_path']);?>
                    <tr>
                        <td style="padding-left:0"><img src="/img/img_main/<?php echo $format[1];?>.png"/></td>
                        <td><a style="color:#0000FF" href="<?php echo base_url();?>materials/<?php echo $material['file_path'];?>">Открыть Скачать</a></td>
                        <td><a href="<?php echo base_url();?>materials/<?php echo $material['file_path'];?>">"<?php echo $material['rus_name'];?>"</a></td>
                    </tr>
                <?php endforeach;?>
            </table>
        </div>
    <?php endif;?>
	<?php if($is_article){?>
	<noindex>
	<ul class="social_likes">
		<li>
			<div style="width:215px" class="fb-like" data-href="http://www.springconsult.com.ua/articles/<?php echo @$content['id'];?>" data-send="true" data-layout="button_count" data-width="215" data-show-faces="false"></div>
		</li>
		<li>
			<div class="twitter-like"><a href="https://twitter.com/share" class="twitter-share-button" data-via="Litkovska" data-lang="ru">Твитнуть</a></div>
		</li>
		<li>
			<div id="odnoklasniki-like"><a class="odkl-klass-stat" href="<?php echo "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];?> " onclick="ODKL.Share(this);return false;" ><span class="custom_count">0</span></a></div>
		</li>
		<li>
			<div id="vk_like"></div>
		</li>
		<script type="text/javascript">
		VK.Widgets.Like("vk_like", {type: "mini"});
		</script>
	</ul>
	</noindex>
	<div class="clear_no_border"></div>
	<?php }?>
    <?php if(isset($disqus) && $disqus){?>
        <script type="text/javascript">
            var disqus_identifier = 'article_<?php echo @$content['id'];?>_identifier';
        </script>
        <noindex>
        <div id="disqus_thread"></div>
        </noindex>
    <?php echo $disqus;}?>
</div>