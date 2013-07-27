<div id="overlay-box-container" style="display: none">
    <div id="wrap-spec-mailer">
        <form id="spec-mailer-form" action="#" method="POST" enctype="multipart/form-data">             
            <table class="spec_mailer">
                <tr>
                    <td style="width:160px">
                        <label for="thema">Тема письма:<span class="red_point">*</span></label>
                    </td>
                    <td>
                        <input type="text" value="" name="theme"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="text">Текст письма:<span class="red_point">*</span></label>
                    </td>
                    <td>
                        <textarea class="edit_detail" name="text" id="spec-mailer-lp"></textarea>
                    </td>
                </tr>
                <tr>
                    <td class="landing-list-lable">
                        <label for="landing">Список landing page:<span class="red_point">*</span></label>
                    </td>
                    <td>
                        <a class="show-landing-list">показать/скрыть</a><br/>
                        <div class="landing-list">
                            <?php foreach($landings as $landing):?>
                                <input type="radio" class="edit_detail" name="landing" value="<?php echo $landing['id']?>">
                                <span class="landing_title_list">&nbsp;<?php echo $landing['title']?></span>
                            <?php endforeach;?>
                        </div>
                    </td>
                </tr>                
                <tr>
                    <td>
                        <input id="button" class="button_submit" type="submit" value="Разослать"/>
                    </td>  
                    <td class="button_close">
                        <input id="button_red" class="button_reset" type="reset" value="Отменить"/>
                    </td>
                </tr>
            </table>
        </form>    
    </div> 
</div>
<div id="loader" class="loader" style="display:none;">
    <img id="img_loader" src="/img/img_main/ajax-loader.gif" alt="Loading"/>
</div>
<script>
        SPRING.Core.registerModule("overlay-box-container", SpecMailerContainerModule());
        SPRING.Core.registerModule("spec-mailer-mce", TinymceInitModule());        
</script> 