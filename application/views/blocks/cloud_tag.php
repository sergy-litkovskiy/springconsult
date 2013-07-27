<div id="cloud_tag">
    <p>Облако тегов:</p>
    <?php if($tags){
        foreach($tags as $val){?>
            <span class="tags">
                <a href='/cloudtag/<?php echo $val['id'];?>' style="font-size:<?php echo $val['font_size'].'%';?>">
                    <?php echo $val['description'];?>
                </a>
            </span>
    <?php }}?>
</div>