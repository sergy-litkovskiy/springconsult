<h1><?php echo $text_i18n[SEARCH_RESULT]; ?>:</h1>
<?php foreach ($content as $key => $item):?>
    <div id="main_content">
        <p><b><a href='<?php echo base_url().$item["code"]."/".$item["slug"]."/".$item["id"]?>' class='actual'><?php echo @$item['title'];?></a></b></p>
        <div class="search_result">
            <p><?php echo word_limiter(@$item['text'], 25, '...');?></p>
        </div>
    </div>
<?php endforeach;?>