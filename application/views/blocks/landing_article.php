<div id="content" class="landing_content">
    <?php echo $content['text'];?>
    <div class="clear_no_border"></div>
    <?php if(isset($disqus) && $disqus){?>
        <script type="text/javascript">
            var disqus_identifier = 'landing_<?php echo @$content['id'];?>_identifier';
        </script>
        <noindex>
            <div id="disqus_thread"></div>
        </noindex>
    <?php echo $disqus;}?>
</div>