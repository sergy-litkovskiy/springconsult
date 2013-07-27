<h2><?php echo @$title;?> (success - <?php echo $successCount;?>)</h2>
    <table id="main_content">
        <thead>
            <tr class="table_title_row">
                <th>Дата создания&nbsp;&nbsp;&nbsp;</th>
                <th>Дата оплаты&nbsp;&nbsp;</th>
                <th>Название продукта</th>
                <th>Цена&nbsp;&nbsp;&nbsp;</th>
                <th>Имя, email</th>
                <td>ID оплаты</td>
                <th>Платежная система&nbsp;&nbsp;</th>
                <th>Статус&nbsp;&nbsp;</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($content as $key => $item):?>
            <tr <?php if($item['payment_state']){ echo "class='success'";}?>>
                <td class="article_table title">
                    <p><?php echo $item['created_at'];?></p>
                </td>
                <td class="article_table">
                    <p><?php echo $item['payment_date'];?></p>
                </td>
                <td class="article_table">
                    <p><?php echo $item['sale_products_title'];?></p>
                </td>
                <td class="article_table">
                    <p><?php echo $item['sale_products_price'];?></p>
                </td>
                <td class="article_table">
                    <p><?php echo $item['recipients_name'];?></p>
                    <p><?php echo $item['recipients_email'];?></p>
                </td>
                <td class="article_table">
                    <p><?php echo $item['payment_trans_id'];?></p>
                </td>
                <td class="article_table">
                    <p><?php echo $item['payment_system'];?></p>
                </td>
                <td class="article_table">
                    <p><?php echo $item['payment_state'];?></p>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
