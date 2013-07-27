<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru">

<head>
    <?php echo head_htm();?>
    <script  type="text/javascript" src="<?php echo base_url();?>js/spring/modules/search.js"></script>
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
                    <p><?php echo $aforizmus['text']."<br/>".$aforizmus['author'];?></p>
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
                <!--<div style="width:215px" class="fb-like" data-href="http://helen.springconsult.com.ua" data-send="true" data-layout="button_count" data-width="215" data-show-faces="false"></div>-->
                    <form id="search_form" action='<?php echo base_url();?>search' method='post' enctype='multipart/form-data'>
                      <table>
                        <tr>
                            <td style="padding-left:0.1em">
                                <input type="text" id='searchtext' name='search_text' value=""/>
                            </td>
                            <td>
                                <input type="submit" class="search_button" name="search_button" value=""/>
                            </td>
                        </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <div class="content_block">
            <div class="content_block_left">
                <div class="content_left_col">
                <div class="logo_col_left"></div>
                    <?php echo $menu;?>
                    <?php echo $cloud_tag;?>
                </div>
            </div>
            <div class="content_block_right">
                <div class="content_block_top"></div>
                <div class="right_col_content">
                    <div class="logo_col_right"></div>
                        <?php echo $content;?>
                    <div class="content_news_list">
                        <h1>Подарок</h1>
                        <div id="newslist"><?php echo $subscribe;?></div>
						<noindex>
                        <div class="fb-like-box" data-href="http://www.facebook.com/pages/Spring-Consulting/224221514260502" data-width="240" data-show-faces="true" data-border-color="#FFFFFF" data-stream="false" data-header="true"></div>
						</noindex>
                    </div>
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
    SPRING.Core.registerModule("search_form", SearchModule());
    SPRING.Core.startAll();
</script>
</html>




