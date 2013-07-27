<script  type="text/javascript" src="<?php echo base_url();?>js/spring/modules/landing_subscribe_form.js"></script>
<div id="landing-subscribe-box">
    <div id="subscribe">
        <p class="landing_title_description"><?php echo $content['title_description']?></p>
        <img class="img_subscribe" src="<?php echo base_url()."img/img_main/arrow-down.gif";?>"/>
    </div>

    <form id="landing_form" action='#' method='post' enctype='multipart/form-data'>
        <p class="err_mess"><?php echo validation_errors(); ?></p>
        <table>
            <tr>
                <td>
                    <p><b>Имя:</b></p>
                </td>
                <td>
                    <input type='text' id='recip_name' name='recip_name' value="<?php echo set_value('recip_name');?>"/>
                </td>
            </tr>
            <tr style="height:10px"></tr>
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
                    <input type="hidden" name="page_id" id="page_id" value="<?php echo $content['id']?>">
                    <input type="hidden" name="title" id="title" value="<?php echo $content['title']?>">
                    <input id='button' class="try_landing_subscribe" type='submit' value='Записаться'/>
                </td>
            </tr>
        </table>
    </form>
    <div id="subscribe_mess"></div>
    <div id="loader" style="display:none;">
        <img id="img_loader" src="/img/img_main/ajax-loader.gif" alt="Loading"/>
    </div>
</div>
<script>
    SPRING.Core.registerModule("landing-subscribe-box", LandingSubscribeBoxModule());
</script>