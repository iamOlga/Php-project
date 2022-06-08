<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
require("../../database/connect.php");


if($_SESSION['catalog_title_category'] == " "){
    $current_category = "все товары";
    $query_ = "SELECT * FROM products";
    $for_search = " WHERE";
}
else{
    $current_category = $_SESSION['catalog_title_category'];
    $query_ = "SELECT * FROM products inner join categories on products.category_id=categories.category_id WHERE categories.category = '".$_SESSION['catalog_title_category']."'"; 
    $for_search = " and";
}

$_SESSION['catalog_orderby']='';
$_SESSION['catalog_filterskin']='';
$_SESSION['search']='';

if(isset($_POST["search"])){
  
    /* поисковая строка */
    if($_POST["search"]!='Поиск' && $_POST["search"]!=''){
        $str_search = $for_search." product_name LIKE '%".$_POST["search"]."%' ";
        $for_select_filter = " and";
    }
    else{
        $str_search = " ";
        $for_select_filter = $for_search;
    }
 
    /* фильтрация по типу кожи */
    if($_POST['button_filter'] == 'not'){
        $_SESSION['catalog_filterskin'] = "";
    }
    else if($_POST['button_filter'] == 'нормальная'){
        $_SESSION['catalog_filterskin'] = $for_select_filter." product_type = 'нормальная'";
    }
    else if($_POST['button_filter'] == 'сухая'){
        $_SESSION['catalog_filterskin'] = $for_select_filter." product_type = 'сухая'";
    }
    else if($_POST['button_filter'] == 'жирная'){
        $_SESSION['catalog_filterskin'] = $for_select_filter." product_type = 'жирная'";
    }
    else{
        $_SESSION['catalog_filterskin'] = $for_select_filter." product_type = 'комбинированная'";
    }

    /* сортировка по цене */
    if($_POST['button_sort'] == 'not'){
        $_SESSION['catalog_orderby'] = "";
    }
    else if($_POST['button_sort'] == 'дешёвые'){
        $_SESSION['catalog_orderby'] = " order by price ASC";
    }
    else {
        $_SESSION['catalog_orderby'] = " order by price DESC";
    }
        
    /* запрос в бд */
    $query = $query_.$str_search.$_SESSION['catalog_filterskin'].$_SESSION['catalog_orderby'];
    $result = mysqli_query($mysqli, $query) or die ("Ошибка" . mysqli_error($mysqli));
    $num_rows = mysqli_num_rows($result);


    if(empty($num_rows)){
        echo"<p style='width:100%; text-align:center;'>не найдено</p>";
    }
    else{
        echo '<form class="products" action="catalog.php" method="post">';
            for($i=0; $i < $num_rows; $i++) {
            $row = mysqli_fetch_array($result);
            
                echo '<div class="product">
                    <input type="submit" class="add add_ordinary" id="add_'.$row[0].'" name="add_'.$row[0].'" value="">
                    
                    <img class="product_img" src="../../'.$row[6].'" alt="">
                    <p class="product_name">'.$row[1].'</p>
                    <p class="product_price">$'.$row[4].'</p>
                </div>';
                }
            
        echo '</form>';
    }
}





?>