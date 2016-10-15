<script type="text/javascript" src="<?php echo base_url(); ?>js/spring/modules/sale_products_list.js"></script>
<div id="sale-page-content">
    <?php echo $content['text1']; ?>
    <?php if (isset($content['sale_products']) && count($content['sale_products'])) { ?>
        <div id="sale-products-list">
            <?php foreach ($content['sale_products'] as $product) { ?>
                <table class="sale-page-products">
                    <tr class="sale-block-description">
                        <td class="description" colspan="2">
                            <h1><?php echo $product['title']; ?></h1>
                            <?php echo $product['description']; ?>
                        </td>
                        <td class="products-price">
                            <h2><?php echo $product['price']; ?> грн.</h2>

                            <div class="payment-box">
                                <form
                                    name="payment"
                                    method="POST"
                                    data-product-id="<?php echo $product['id']; ?>"
                                    action="<?php echo PRIVAT_PAYMENT_HTTP_REQUEST_URI ?>"
                                >
                                    <input type="hidden" name="amt" value="<?php echo $product['price']; ?>" />
<!--                                    <input type="hidden" name="amt" value="10" />-->
                                    <input type="hidden" name="ccy" value="<?php echo PRIVAT_PAYMENT_CURRENCY; ?>" />
                                    <input type="hidden" name="merchant" value="<?php echo PRIVAT_MERCHANT_ID ?>" />
                                    <input type="hidden" name="order" value="" />
                                    <input type="hidden" name="details" value="<?php echo $product['title']; ?>" />
                                    <input type="hidden" name="ext_details" value="" />
                                    <input type="hidden" name="pay_way" value="privat24" />
                                    <input type="hidden" name="return_url" value="<?php echo base_url(); ?>sale/<?php echo $content['slug']; ?>" />
                                    <input type="hidden" name="server_url" value="<?php echo base_url(); ?>payment/response" />
                                </form>
                                <button class="button-payment">Заказать</button>
                            </div>
                        </td>
                    </tr>
                    <tr class="sale-block-payment">
                        <td></td>
                        <td class="payment-form">
                            <form
                                action='<?php echo base_url(); ?>payment/send'
                                method='post'
                                name='add_new'
                                enctype='multipart/form-data'
                            >
                                <h1>Оформление заказа</h1>

                                <p>
                                    <b><?php echo $product['title']; ?></b> -
                                    <?php echo $product['price']; ?> грн.
                                </p>

                                <p class="payment-title">Введите Ваше имя и E-mail для получения <br/>электронного
                                    продукта после успешной оплаты!</p>

                                <p class="payment-input">
                                    <input type="text" class='name' name='recipient_name' value="" placeholder="Имя"/>
                                </p>

                                <p class="payment-input">
                                    <input type="text" class='email' name='email' value="" placeholder="Email"/>
                                </p>
                                <input type="hidden" name='product-id' value=""/>
                                <input id='button' class="add_payment_data" name='add' type='submit' value='Оплатить'/>
                                <img class="privat-logo" src="<?php echo base_url(); ?>img/img_main/api_logo_privat.jpg" alt="Privat24"/>
                            </form>
                            <div id="loader" class="loader" style="display:none;">
                                <img id="img_loader" src="<?php echo base_url(); ?>img/img_main/ajax-loader.gif"
                                     alt="Loading"/>
                            </div>
                        </td>
                        <td></td>
                    </tr>
                </table>
            <?php } ?>
        </div>
    <?php } ?>
    <?php echo @$content['text2']; ?>
    <p class="social_share">
        Понравился материал - поделись с друзьями, жми на кнопку!
    </p>
    <ul class="social_likes">
        <li>
            <div style="width:215px" class="fb-like"
                 data-href="http://www.springconsult.com.ua/sale/<?php echo @$content['slug']; ?>" data-send="true"
                 data-layout="button_count" data-width="215" data-show-faces="false"></div>
        </li>
        <li>
            <div class="twitter-like">
                <a href="https://twitter.com/share" class="twitter-share-button"
                   data-via="Litkovska" data-lang="ru">Твитнуть</a></div>
        </li>
        <li>
            <div id="odnoklasniki-like">
                <a class="odkl-klass-stat"
                   href="<?php echo "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?> "
                   onclick="ODKL.Share(this);return false;"><span class="custom_count">0</span></a>
            </div>
        </li>
        <li>
            <div id="vk_like"></div>
        </li>
        <script type="text/javascript">
            VK.Widgets.Like("vk_like", {type: "mini"});
        </script>
    </ul>
    <div class="clear_no_border"></div>
</div>
<script>
    SPRING.Core.registerModule("sale-products-list", SaleProductsListModule());
</script>  