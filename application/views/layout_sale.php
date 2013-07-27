<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru">

<head>
    <?php echo head_htm();?>
</head>
<body  onload="ODKL.init();">
<div id="fb-root"></div>
    <div class="container">
        <div class="top">
            <a href="<?php echo base_url();?>" ALT="На главную">
                <div class="logo"></div>
            </a>
            <div class="aforizm_contact">
                <div class="aforizm">
                </div>
                <div class="top_contact">
                <div class="socials">
				<noindex>
                    <a title="facebook" href="http://www.facebook.com/pages/Spring-Consulting/224221514260502" target="_blank">
                        <img src="<?php echo base_url()?>img/img_main/facebook24.png"/>
                    </a>
                    <a title="odnoklassniki" href="http://www.odnoklassniki.ua/#/group/51777436582140" target="_blank">
                        <img src="<?php echo base_url()?>img/img_main/odnoklassniki24.png"/>
                    </a>
                    <a title="vkontakte" href="http://vkontakte.ru/id135923751" target="_blank">
                        <img src="<?php echo base_url()?>img/img_main/vkontakte24.png"/>
                    </a>
					<a title="twitter" href="http://twitter.com/#!/Litkovska" target="_blank">
                        <img src="<?php echo base_url()?>img/img_main/twitter.png"/>
                    </a>
                    <a title="rss" href="<?php echo base_url()?>rss">
                        <img src="<?php echo base_url()?>img/img_main/rss24.png"/>
                    </a>
				</noindex>                    
                </div>
                </div>
            </div>
        </div>
        <div class="content_block">
            <div class="content_block_left">
                <div class="content_left_col">
                <div class="logo_col_left"></div>
                <?php if(isset($menu)){echo $menu;}?>
                </div>
            </div>
            <div class="content_block_right">
                <div class="content_block_top"></div>
                <div class="right_col_content">
                    <div class="logo_col_right"></div>
                        <?php echo $content;?>
<!--                    <div class="content_news_list">
                    </div>                    -->
                </div>
                <div class="content_block_bottom">
                    <p id="copyright">&copy; Copyright Spring consulting</p>
                    <a id="author" href="#">Design &amp; programming by Sergy Litkovskiy</a>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
        SPRING.Core.startAll();
</script>     
</html>




