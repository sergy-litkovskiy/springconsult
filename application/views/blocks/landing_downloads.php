<script  type="text/javascript" src="<?php echo base_url();?>js/spring/modules/landing_downloads.js"></script>
<div id="subscribe">
    <div class="subscribe">
        <p>Введите Ваш e-mail, чтобы получить пароль доступа к MP3</p>
    </div>
</div>

<form id="landing_downloads_form" action='#' method='post' enctype='multipart/form-data'>
    <p class="err_mess"><?php echo validation_errors(); ?></p>
    <table>
        <tr>
            <td>
                <p><b>E-mail:</b></p>
            </td>
            <td>
                <input type='text' id='email' name='email' value="<?php echo set_value('email');?>"/>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center; padding-left: 3em">
                <input type="hidden" name="page" id="page" value="<?php echo $content['landing_page_id'];?>"/>
                <input type="hidden" name="article" id="article" value="<?php echo $content['id'];?>"/>
                <input id='button' class="download" type='submit' value='Получить'/>
            </td>
        </tr>
    </table>
</form>
<div id="subscribe_mess"></div>
<div id="loader" class="loader" style="display:none;">
    <img id="img_loader" src="/img/img_main/ajax-loader.gif" alt="Loading"/>
</div>
<script>
        SPRING.Core.registerModule("landing_downloads_form", LandingDownloadsModule());
</script> 