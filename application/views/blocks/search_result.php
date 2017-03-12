<div id="content">
    <h1>Результаты поиска</h1>

    <p class="search">Вы искали: "<b><?php echo $searching_text;?></b>"</p>
    <?php if(isset($content['menuArr'])){
        foreach($content['menuArr'] as $menu){?>
        <div class="search_result">
            <h2 class="search"><a href="/show/<?php echo $menu['slug'];?>"><?php echo $menu['title'];?></a></h2>
            <p><a href="/show/<?php echo $menu['slug'];?>"><?php echo $menu['text'];?></a></p>
        </div>
    <?php }}?>
    <?php if(isset($content['articlesArr'])){
        foreach($content['articlesArr'] as $articles){?>
        <div class="search_result">
            <h2 class="search"><a href="/article/<?php echo $articles['id'];?>"><?php echo $articles['title'];?></a></h2>
            <p><a href="/article/<?php echo $articles['id'];?>"><?php echo $articles['text'];?></a></p>
        </div>
    <?php }}?>
    <?php if(isset($content['materialsArr'])){
        foreach($content['materialsArr'] as $materials){?>
        <div class="search_result">
            <h2 class="search"><a href="/docs/<?php echo $materials['file_path'];?>"><?php echo $materials['rus_name'];?></a></h2>
        </div>
    <?php }}?>
    <?php if($empty_result){?>
        <h3 style="text-align: center"><?php echo $empty_result;?></h3>
    <?php }?>
</div>