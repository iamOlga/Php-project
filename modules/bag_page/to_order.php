<?php
    if(session_status()!=PHP_SESSION_ACTIVE) session_start();
    include_once("../../database/connect.php");
    /* include_once("../../functions/functions.php"); */

    $d = strtotime("+1 day");
    $result_info = mysqli_query($mysqli, "SELECT * FROM users WHERE user_name='".$_SESSION['user_name']."'");
    $user_info = mysqli_fetch_all($result_info, 1);

    $adress = $user_info[0]["city"].', '.$user_info[0]["street"].', '.$user_info[0]["house"];
    $phone = $user_info[0]["phone"];


    $_SESSION['summary'] = 0;
    $query2 = "SELECT * FROM products INNER join bag on bag.id_product = products.id_product WHERE bag.user_id = ".$_SESSION['user_id']." and bag.order_id = 0";
    $info_products = getAllProducts($mysqli, $query2);
    foreach ($info_products as $product){  
        $_SESSION['summary']+= $product["price"]*$product["count"];
    }

?>

<div class="title_panel">
        <p class="title_h3">Оформление заказа</p>
</div>

<form action="bag_page.php" method="post" class="to_order_container">
    <input type="submit" name="back_to_bag" class="back" value=''>

    <div class="inputs">
            <p>Заказ на сумму: $<?=$_SESSION['summary']?></p>
            <p>Способ оплаты</p>
            <div class="payment_method">
                <div>
                    <input type="radio" id="payment_method1" name="payment_meth" value="карта" checked>
                    <label for="payment_method1">Карта</label>
                </div>
                <div>
                    <input type="radio" id="payment_method2" name="payment_meth" value="наличные">
                    <label for="payment_method2">Наличные</label>
                </div>
            </div>
            <p>Дата и время</p>
            <div class="date_time">
                <input type="text" class="input_account input_account_date" name="date" size="25" maxlength="25" value="<?=date("d.m.Y", $d)?>">
                <input type="text" class="input_account input_account_time" name="time" size="25" maxlength="25" value="12:00">
            </div>
            <p>Адрес доставки</p>
            <input type="text" class="input_account" name="adress" size="25" maxlength="25" value="<?=$adress?>">
            <p>Телефон для связи</p>
            <input type="text" class="input_account" name="phone" size="25" maxlength="25" value="<?=$phone?>">
                        
            <input type="submit" name="toorder" value="заказать" class="black_button_toorder black_button">
    </div>
</form>

