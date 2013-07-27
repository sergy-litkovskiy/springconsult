<ul id="my-menu" class="main_menu">
    <?php for($i=0; $i<=count($menu)-1; $i++):?>
        <?php
            if($menu[$i]->childs) {
                echo "<li><span class='has_child'>".$menu[$i]->title."</span>";
            } else {
                echo "<li>";
                if($menu[$i]->slug == $current_url){
                    echo "<span id='has_child_current_url'>".$menu[$i]->title."</span>";
                } else {
                    echo "<a id='cat_name' class='not_drop' href='".base_url().'show/'.$menu[$i]->slug."'>".$menu[$i]->title."</a>";
                }
            }
        ?>
        <?php $child = $menu[$i]->childs; ?>
            <ul>
                <?php for($k=0; $k<=count($child)-1; $k++):
                        echo "<li class='drop_item'>"; 
                        if($child[$k]->slug == $current_url){
                            echo "<span id='current_url'>".$child[$k]->title."</span>";
                        } else {
                            echo "<a id='drop_item' href='".base_url().'show/'.$child[$k]->slug."'>".$child[$k]->title."</a>";
                        }
                        echo "<li>";
                endfor;?>
            </ul>
            </li>
    <?php endfor;?>
    <li>
        <a id='cat_name' class='not_drop' href='http://springmagazin.com.ua'>
            Spring - Магазин
        </a>
    </li>
</ul>