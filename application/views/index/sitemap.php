<h1><?php echo $text_i18n[SITEMAP]; ?>:</h1>

    <div id="main_content">
        <ul id="sitemap">
        <?php for($i=0; $i<=count($content)-1; $i++):?>
        <!-- start first level -->
            <?php if($content[$i]->childs) {echo "<li><b>".$content[$i]->title."</b>";} else{echo "<li><b><a href='".base_url().$content[$i]->lang."/".$content[$i]->slug."'>".$content[$i]->title."</b></a>";}?>
            <?php $child = $content[$i]->childs; ?>
            <!-- second level -->
                    <ul>
                <?php for($k=0; $k<=count($child)-1; $k++):?>

                    <?php if($child[$k]->childs) {echo "<li>".$child[$k]->title;} else{echo "<li><a href='".base_url().$child[$k]->lang."/".$child[$k]->slug."'>".$child[$k]->title."</a>";}?>
                    <?php $next_child = $child[$k]->childs; ?>
                    <!-- start third level -->
                                    <ul>
                        <?php for($j=0; $j<=count($next_child)-1; $j++):?>
                             <?php echo "<li><a href='".base_url().$next_child[$j]->lang."/".$next_child[$j]->slug."'>".$next_child[$j]->title."</a></li>"; ?>
                        <?php endfor;?>
                                    </ul>
                    <!-- end third level -->
                                </li>
                <?php endfor;?>
                   </ul>
            <!-- end second level -->
                   </li>
        <!-- end first level -->
        <?php endfor;?>
        </ul>
    </div>