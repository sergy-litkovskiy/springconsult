<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru">

<head>
    <?php echo head_htm_backend();?>
</head>
<body>
    <div class="container">
        <div class="top">
            <a href="<?php echo base_url();?>backend/login" ALT="На главную">
                <div class="logo"></div>
            </a>
            <div class="aforizm_contact">
                <div class="aforizm"></div>
            </div>
        </div>
        <div class="content_block">
            <div class="content_block_left">
                <div class="content_left_col">
                <div class="logo_col_left"></div>
                    <?php echo $menu;?>
                </div>
            </div>
            <div class="content_block_right">
                <div class="content_block_top"></div>
                <div class="right_col_content">
                    <div class="logo_col_right"></div>
                        <?php echo $content;?>
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