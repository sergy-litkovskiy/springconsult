<div class="login_block">
    <h2>Authorization:</h2>
    <form id="login_form" action='<?php echo base_url();?>backend/login' method='post' name='add_new' enctype='multipart/form-data'>
    <p class="error"><?php echo validation_errors(); ?></p>
    <table class="contact">
        <tr>
            <td style="width: 60px;">
                <p><b>Login:</b><lable class="red_point">*</lable></p>
            </td>
            <td>
                <input type="text" style='width:100%' id='log' name='log' value="<?php echo set_value('log');?>"/>
            </td>
        </tr>
        <tr>
            <td>
                <p><b>Password:</b><lable class="red_point">*</lable></p>
            </td>
            <td style='width:100%; padding-top: 0.5em'>
                <input type="password" style='width:100%' id='pass' name='pass' value="<?php echo set_value('pass');?>"/>
            </td>
        </tr>
        
    </table>
            <input style='text-align:center; border: none' id='login_button' class="add_mess" name='add' type='submit' value='Send'/>
    </form>
</div>