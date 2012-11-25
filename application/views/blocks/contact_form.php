<script  type="text/javascript" src="<?php echo base_url();?>js/spring/modules/contact_form.js"></script>
<div id="contact-form-box">
    <div class="contact_block">
        <form id="contact_form" action='#' method='post' name='add_new' enctype='multipart/form-data'>
            <table class="contact" style='width:660px'>
                <tr>
                    <td style="width: 60px;">
                        <p><b>Имя:</b><lable class="red_point">*</lable></p>
                    </td>
                    <td>
                        <input type="text" style='width:40%' id='name' name='recip_name' value="<?php echo set_value('recip_name', $contact_form['name']);?>"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><b>E-mail:</b><lable class="red_point">*</lable></p>
                    </td>
                    <td>
                        <input type="text" style='width:40%' id='email' name='email' value="<?php echo set_value('email', $contact_form['email']);?>"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><b>Текст:</b><lable class="red_point">*</lable></p>
                    </td>
                    <td colspan="3">
                        <textarea style='width:100%' id='text' name='text' cols='50' rows='6'><?php echo set_value('text', $contact_form['text']);?></textarea>
                    </td>
                </tr>
            </table>
            <input style='text-align:center; border: none' id='button' class="add_mess" name='add' type='submit' value='Отправить'/>
        </form>
    </div>
    <div id="loader" class="loader" style="display:none;">
        <img id="img_loader" src="/img/img_main/ajax-loader.gif" alt="Loading"/>
    </div>
</div>
<script>
    SPRING.Core.registerModule("contact-form-box", ContactFormModule());
</script>