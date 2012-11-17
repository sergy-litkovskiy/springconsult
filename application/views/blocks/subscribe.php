<script  type="text/javascript" src="<?php echo base_url();?>js/spring/modules/subscribe_form.js"></script>
<div id="subscribe-box">
    <?php foreach ($subscribeArr as $key => $subscribe):?>
    <?php if($subscribe['img_path']){?>
    <div id="subscribe">
        <img class="img_subscribe" src="<?php echo base_url()."subscribe/".$subscribe['img_path'];?>"/>
        <div class="subscribe"><?php echo $subscribe['description'];?></div>
    </div>
    <?php }?>
    <form class="subscribe_form" action='#' method='post' name='add_new' enctype='multipart/form-data'>
        <p class="err_mess"><?php echo validation_errors(); ?></p>
        <table>
            <tr>
                <td>
                    <p><b>Имя:</b></p>
                </td>
                <td>
                    <input type='text' id='name' name='recip_name' value="<?php echo set_value('name');?>"/>
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
                    <input type="hidden" name="subscribe_id" id="subscribe_id" value="<?php echo $subscribe['id'];?>"/>
                    <input type="hidden" name="subscribe_name" id="subscribe_name" value="<?php echo $subscribe['subscribe_name'];?>"/>
                    <input id='button' class="add_subscribe" name='add' type='submit' value='Получить'/>
                </td>
            </tr>
        </table>
    </form>
    <div class="clear">&nbsp;</div>
    <?php endforeach;?>
    <div id="loader" style="display:none;">
        <img id="img_loader" src="/img/img_main/ajax-loader.gif" alt="Loading"/>
    </div>
</div>
<script>
        SPRING.Core.registerModule("subscribe-box", SubscribeBoxModule()); 
</script>