<script  type="text/javascript" src="<?php echo base_url();?>js/spring/modules/sale_products_list.js"></script>
<script  type="text/javascript" src="<?php echo base_url();?>js/spring/modules/payment_registration_form.js"></script>
<div id="sale-page-content">
    <?php echo $content['text1'];?>
    <?php if(isset($content['sale_products']) && count($content['sale_products'])){?>
        <div id="sale-products-list">
        <?php foreach($content['sale_products'] as $product){?>
            <table class="sale-page-products">
                <tr>
                    <td class="description">
                        <h1><?php echo $product['title'];?></h1>
                        <?php echo $product['description'];?>
                    </td>
                    <td class="products-price">
                        <h2><?php echo $product['price'];?> грн.</h2>
                        <div class="payment-box">
                            <form name="payment" action="https://www.interkassa.com/lib/payment.php" method="post" enctype="application/x-www-form-urlencoded" accept-charset="cp1251">
                                <input type="hidden" name="ik_shop_id" value="<?php echo SALESHOPID;?>">
                                <input type="hidden" name="ik_payment_amount" value="<?php echo $product['price'];?>.0">
                                <input type="hidden" name="ik_payment_id" value="<?php echo $product['id'];?>">
                                <input type="hidden" name="ik_payment_desc" value="<?php echo $content['title'] .' - '. $product['title'];?>">
                                <input type="hidden" name="ik_baggage_fields" value="">
                                <input class="button-payment" type="submit" name="process" value="Заказать">
                            </form>
                        </div>                        
                    </td>
                </tr>
            </table>
      <?php }?>
        </div>
     <?php }?>
    <?php echo @$content['text2'];?>
        <p class="social_share">
            Понравился материал - поделись с друзьями, жми на кнопку!
        </p>
    	<ul class="social_likes">
		<li>
			<div style="width:215px" class="fb-like" data-href="http://www.springconsult.com.ua/sale/<?php echo @$content['slug'];?>" data-send="true" data-layout="button_count" data-width="215" data-show-faces="false"></div>
		</li>
		<li>
			<div class="twitter-like"><a href="https://twitter.com/share" class="twitter-share-button" data-via="Litkovska" data-lang="ru">Твитнуть</a></div>
		</li>
		<li>
			<div id="odnoklasniki-like"><a class="odkl-klass-stat" href="<?php echo "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];?> " onclick="ODKL.Share(this);return false;" ><span class="custom_count">0</span></a></div>
		</li>
		<li>
			<div id="vk_like"></div>
		</li>
		<script type="text/javascript">
		VK.Widgets.Like("vk_like", {type: "mini"});
		</script>
	</ul>
	<div class="clear_no_border"></div>
    <?php echo $payment_form;?>
</div>
<script>
        SPRING.Core.registerModule("sale-products-list", SaleProductsListModule()); 
        SPRING.Core.registerModule("payment_form_block", PaymentRegistrationFormModule()); 
</script>  