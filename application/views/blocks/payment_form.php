<div id="payment_form_block">
    <form id="payment_form" action='#' method='post' name='add_new' enctype='multipart/form-data'>
        <h1>Оформление заказа</h1>
        <p class="payment-title">Введите Ваше имя и E-mail для получения <br/>электронного продукта после успешной оплаты!</p>
        <table class="contact">
            <tr>
                <td class='td-label'>
                    <p><b>Имя:</b><lable class="red_point">*</lable></p>
                </td>
                <td class='td-input'>
                    <input class='name' name='recipient_name' value=""/>
                </td>
            </tr>
            <tr>
                <td class='td-label'>
                    <p><b>E-mail:</b><lable class="red_point">*</lable></p>
                </td>
                <td class='td-input'>
                    <input class='email' name='email' value=""/>
                </td>
            </tr>
        </table>
        <input id='button' class="add_payment_data" name='add' type='submit' value='Заказать'/>
    </form>
    <div id="loader" class="loader" style="display:none;">
        <img id="img_loader" src="<?php echo base_url();?>img/img_main/ajax-loader.gif" alt="Loading"/>
    </div>
</div>