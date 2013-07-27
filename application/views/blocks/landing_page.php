<div id="content" class="landing_content">
    <?php echo $content['page_text'];?>
    <p class="social_share">
        Понравился материал - поделись с друзьями, жми на кнопку!
    </p>
    <ul class="social_likes">
        <li>
            <div style="width:215px" class="fb-like" data-href="http://www.springconsult.com.ua/landing/<?php echo @$content['unique'];?>" data-send="true" data-layout="button_count" data-width="215" data-show-faces="false"></div>
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
</div>