<?php
    if(session_status()!=PHP_SESSION_ACTIVE) session_start();
    include_once("../../database/connect.php");
    include_once("../../functions/functions.php");
?>
<link rel="stylesheet" href="../../css/style_catalog_page.css">
<link rel="stylesheet" href="../../css/style_common.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="../../functions/ajax.js"></script>
<?php

  
    //выбор товара по категории 
    if($_SESSION['catalog_title_category'] == " "){
        $current_category = "все товары";
        $query = "SELECT id_product, product_name, price, image FROM products";
    }
    else{
        $current_category = $_SESSION['catalog_title_category'];
        $query = "SELECT id_product, product_name, category, price, image FROM products inner join categories on products.category_id=categories.category_id WHERE categories.category = '".$_SESSION['catalog_title_category']."'"; 
    }

    
    $allproducts_info = getAllProducts($mysqli, $query); 

    $products_ids = get_ids_product($mysqli, "SELECT id_product FROM products order by id_product ASC");

    /* добавление в бд корзина */
    function add_to_bag($mysqli, $query){
        $result = mysqli_query($mysqli, $query);
    }


    $query_id="SELECT id FROM `bag` order by id DESC LIMIT 1";
    $result_id=mysqli_query($mysqli, $query_id) or die("Ошибка " . mysqli_error($mysqli));
    $row = mysqli_fetch_assoc($result_id);
    $current_id = $row['id']+1;

    foreach ($products_ids as $id) {
        if(isset($_POST["add_".$id["id_product"]])){
            if($_SESSION['user_id']!=''){
                $query_isinbag = get_ids_product($mysqli, "SELECT * FROM `bag` where user_id=".$_SESSION['user_id']." and order_id=0 and id_product=".$id["id_product"]);
                if(count($query_isinbag) > 0){
                    print '<script> alert("Товар уже есть в корзине");
                    function reload(){top.location = "catalog_page.php"}; setTimeout("reload()", 0);</script>';
                }
                else{
                    /* array_push( $_SESSION['products_in_bag'], $current_id); */
                    $products_count = get_ids_product($mysqli, "SELECT count FROM products where id_product=".$id["id_product"]);
                    if($products_count[0]['count'] > 0){

                        $count = $products_count[0]['count'] - 1;
                        mysqli_query($mysqli, "UPDATE products SET count='".$count."' WHERE id_product='".$id["id_product"]."'");

                        add_to_bag($mysqli, "INSERT INTO bag (`id`, `user_id`, `id_product`, `count`, `order_id`) VALUES ('".$current_id."','".$_SESSION['user_id']."','".$id["id_product"]."', 1, 0)");
                        print '<script> alert("Товар добавлен в корзину");
                        function reload(){top.location = "catalog_page.php"}; setTimeout("reload()", 0);</script>'; 
                    }
                    else{
                        print '<script> alert("Товар отсутствует на складе");
                        function reload(){top.location = "catalog_page.php"}; setTimeout("reload()", 0);</script>';
                    }
                }
            }
            else{
                print '<script> alert("Зарегистрируйтесь или войдите в аккаунт!");
                function reload(){top.location = "catalog_page.php"}; setTimeout("reload()", 0);</script>';
            }
        }
    }
?>

<div class="banner">
    <img src="../../images/bag_banner.png" alt="">
</div>

<div class="bag_panel">
    <p class="title_category"><?=$current_category?></p>

    <form class="search" method="post" id="form_search" action="" onsubmit="return false;">
        <input class="search_input" type="text" name="search" placeholder="Поиск">

        <div class="">
            <div class="column">
                <p>Сортрировка по цене</p>
                <select name="button_sort">
                    <option value="not">не выбрано</option>
                    <option value="дешёвые">сначала дешёвые</option>
                    <option value="дорогие">сначала дорогие</option>
                </select>
            </div>
            
            <div class="column">
                <p>Тип кожи</p>
                <select name="button_filter">
                    <option value="not">не выбрано</option>
                    <option value="нормальная">нормальная</option>
                    <option value="сухая">сухая</option>
                    <option value="жирная">жирная</option>
                    <option value="комбинированная">комбинированная</option>
                </select>
            </div>

            <input type="submit" name="button_search" class="button_search" value='' onclick="search1()">
        </div>
    </form> 
    
</div>

<div id="results" class="container"></div>

<div class="container" id="container_products"> 

    <form class="products" action="catalog.php" method="post">
        <?php
            if(empty($allproducts_info)){
                echo"<p style='width:100%; text-align:center;'>не найдено</p>";
            }
            else{
            foreach ($allproducts_info as $product) : 
        ?>
            <div class="product">
                <input type="submit" class="add add_ordinary" id="add_<?=$product["id_product"]?>" name="add_<?=$product["id_product"]?>" value="">
                <img class="product_img" src="../../<?=$product["image"]?>" alt="">
                <p class="product_name"><?=$product["product_name"]?></p>
                <p class="product_price">$<?=$product["price"]?></p>
            </div>
        <?php 
            endforeach;
        }
        ?>
    </form>
</div>
        