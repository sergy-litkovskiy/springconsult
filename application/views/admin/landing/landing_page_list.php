<h2>Выбрать Landing page для отображения статистики спец. рассылки</h2>
<ul class="landing-page-list">
    <?php foreach ($content as $key => $item):?>
        <li>
            <a href="<?php echo base_url().'backend/spec_mailer_statistics/'.$item['id']?>">
                <b><?php echo $item['title'];?></b>
                <img src="<?php echo base_url()?>img/img_main/go.png"/>
            </a>
        </li>
    <?php endforeach;?>
</ul>