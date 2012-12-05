<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

    <head>
        <?php echo head_htm_backend();?>
    </head>
    <body>
    <div class="container">
        <div class="content_block">
            <div class="content_block_right" style="margin:6em 6em auto auto">
                <div class="content_block_top"></div>
                <div class="right_col_content">
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