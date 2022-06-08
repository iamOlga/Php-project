<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
include_once("../../database/connect.php");
include_once("../../functions/functions.php");

    if(isset($_POST["back_to_admin_page"])){
        $_SESSION['current_admin_page']='';
            print "<script language='Javascript' type='text/javascript'> function reload(){top.location = 'admin_page.php'}; setTimeout('reload()', 0);</script>";
    }

    $query1 = "SELECT * FROM orders";
    $info_orders = getAllProducts($mysqli, $query1);

    $query2 = "SELECT * FROM products INNER join bag on bag.id_product = products.id_product WHERE bag.order_id != 0 ";
    $info_products = getAllProducts($mysqli, $query2);

    $orders_ids = get_ids_product($mysqli, "SELECT order_id FROM orders order by order_id ASC");

    /* print '<script language="Javascript" type="text/javascript"> alert("'.$orders_ids[0]["order_id"].'");
        </script>';  */

    for ($i=0; $i<= count($orders_ids); $i++){
        if(isset($_POST["button_update_product_".$orders_ids[$i]["order_id"]])){
            $_SESSION['current_admin_page']='admin_orders';
            mysqli_query($mysqli, "UPDATE orders SET status='".$_POST['status_'.$orders_ids[$i]["order_id"]]."' WHERE order_id = ".$orders_ids[$i]["order_id"]);
            print "<script language='Javascript' type='text/javascript'> function reload(){top.location = 'admin_page.php'}; setTimeout('reload()', 0);</script>"; 

        }
    }
?>

<form class="orders_table" action="admin_orders.php" method="post">
    <input type="submit" name="back_to_admin_page"  class="back" value="">
 
    
    <?php 
        foreach ($info_orders as $order) : 
    ?>
    <div class="item">
        <div class="products">
            <?php
            foreach ($info_products as $product) : 
                if($order["order_id"] == $product["order_id"]){    
            ?>
                    
                <div class="product">
                    <img src="../../<?=$product["image"]?>" alt="">
                    <div class="info">
                        <p class="price"><?=$product["product_name"]?></p>
                        <p class="price">$<?=$product["price"]?></p>
                        <p class="price">количество: <?=$product["count"]?></p>
                    </div>
                </div>
                    
            <?php 
                }
            endforeach;
            ?>
        </div>       
        
            <div class="order_info">
                <p class="common_price">Общая стоимость: $<?=$order["summary_price"]?></p>
                <p class="price">Способ оплаты: <?=$order["payment_method"]?></p>
                <p class="price">Адрес: <?=$order["adress"]?></p>
                <p class="price">Телефон: <?=$order["phone"]?></p>
                <p class="price">Дата: <?=$order["date"]?></p>
                <p class="price">Время: <?=$order["time"]?></p>
            </div>
            <select id="status" name="status_<?=$order["order_id"]?>">
                <?php 
                    if($order["status"] == 'Оформлен'){  
                ?>
                    <option value="Оформлен" selected>Оформлен</option>
                    <option value="В пути">В пути</option>
                    <option value="Доставлен">Доставлен</option>
                <?php 
                    }
                    else if($order["status"] == 'В пути'){  
                ?>
                    <option value="Оформлен">Оформлен</option>
                    <option value="В пути" selected>В пути</option>
                    <option value="Доставлен">Доставлен</option>
                <?php 
                    }
                    else {  
                ?>
                    <option value="Оформлен">Оформлен</option>
                    <option value="В пути">В пути</option>
                    <option value="Доставлен" selected>Доставлен</option>
                <?php 
                    }
                ?>

            </select>
            <input type="submit" name="button_update_product_<?=$order["order_id"]?>" class="black_button" value="u"/>
        
    </div>
    <?php 
            endforeach;
        ?>

    </form>