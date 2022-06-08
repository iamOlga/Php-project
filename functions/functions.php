<?php
    if(session_status()!=PHP_SESSION_ACTIVE) session_start();

    /* меню категории */
    function getCatigories($mysqli) {
        $categories_query ="SELECT * FROM categories";
        $result = mysqli_query($mysqli, $categories_query) or die('Error connect to DB');
        $categories = mysqli_fetch_all($result, 1);
        foreach ($categories as $category){
            array_push( $_SESSION['categories_buttons_value'], $category["category"]);///////////////
            array_push( $_SESSION['categories_buttons_name'], "category_".$category["category_id"]);
        }


        /* $id_product_query ="SELECT id_product FROM products";
        $result2 = mysqli_query($mysqli, $id_product_query) or die('Error connect to DB');
        $id_product = mysqli_fetch_all($result2, 1);
        foreach ($id_product as $id){
            array_push( $_SESSION['categories_buttons_name'], "category_".$id["id_product"]);
        } */
        
        return $categories; 
    }


    function getBestsellersInfo($mysqli){
        $product_info_query ="SELECT id_product, product_name, price, image FROM products ORDER BY id_product ASC LIMIT 4";
        $result = mysqli_query($mysqli, $product_info_query);
        $product_info = mysqli_fetch_all($result, 1);
        return $product_info; 
    }


    function getAllProducts($mysqli, $query){
        $result = mysqli_query($mysqli, $query);
        $product_info = mysqli_fetch_all($result, 1);
        
        return $product_info; 
    }


    /* для админа */
    function get_ids_product($mysqli, $query){
        $result = mysqli_query($mysqli, $query);
        $product_ids = mysqli_fetch_all($result, 1);
        return $product_ids; 
    }
    
    function update($mysqli, $query){
        $result = mysqli_query($mysqli, $query);
    }
    
    function delete_product($mysqli, $query){
        $result = mysqli_query($mysqli, $query);
    }

?>