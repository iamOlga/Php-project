<link rel="stylesheet" href="../../css/style_bag_page.css">
<form class="bag_list orders_list" action="bag.php" method="post">

    <?php 
    $query = "SELECT products.product_name, products.price, products.image, bag.count, orders.order_id, orders.payment_method, orders.adress, orders.date, orders.time, orders.status 
    FROM products join bag on bag.id_product = products.id_product join orders on bag.order_id = orders.order_id
    WHERE bag.user_id = ".$_SESSION['user_id']." and bag.order_id=orders.order_id order by orders.order_id DESC";/* ." and bag.order_id <> 0" */
    $info_products = getAllProducts($mysqli, $query);

        
        if(empty($info_products)){
            echo"<p style='width:100%; text-align:center;'>у вас нет заказов</p>";
        }
        else{
        foreach ($info_products as $product) : 
    ?>

    <div class="item">
        <img src="../../<?=$product["image"]?>" alt="">
        <div class="info">
            <p class="product_name"><?=$product["product_name"]?></p>
            <p class="price">$<?=$product["price"]?></p>
            <p class="price">количество: <?=$product["count"]?></p>
        </div>
        <div class="info">
            <p class="price"><?=$product["adress"]?></p>
            <p class="price"><?=$product["date"]?></p>
            <p class="price"><?=$product["time"]?></p>
        </div>
        <div class="info">
            <p class="price">Общая стоимость</p>
            <p class="common_price">$<?=$product["price"]*$product["count"]?></p>
            <p class="price"><?=$product["payment_method"]?></p>
        </div>
        
        <p class="price"><?=$product["status"]?></p>
    </div>

    <?php 
        endforeach;
    }
    ?>

</form>