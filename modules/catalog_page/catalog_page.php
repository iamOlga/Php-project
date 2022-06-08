<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
include("../../database/connect.php");
include("../../functions/functions.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>True Botanicals. Catalog</title>
</head>
<body>

    <?php
    
    for($i=0; $i<count($_SESSION['categories_buttons']); $i++){
        if(array_key_exists($_SESSION['categories_buttons_name'][$i], $_POST)){
            $_SESSION['catalog_title_category'] = $_SESSION['categories_buttons_value'][$i];
            print "<script language='Javascript' type='text/javascript'>
            function reload(){top.location ='catalog_page.php'};setTimeout('reload()', 0);</script>";    

            $_SESSION['current_page']='../catalog_page/catalog_page.php';
        }
    }
    if(array_key_exists('button_account', $_POST)) {
        print "<script language='Javascript' type='text/javascript'>
                function reload(){top.location ='../account_page/account_page.php'};setTimeout('reload()', 0);</script>";
                $_SESSION['current_page']='../account_page/account_page.php';
    }
    if(array_key_exists('button_bag', $_POST)) {
        print "<script language='Javascript' type='text/javascript'>
                function reload(){top.location ='../bag_page/bag_page.php'};setTimeout('reload()', 0);</script>";
                $_SESSION['current_page']='../bag_page/bag_page.php';
    }


        include("../header/header.php");
        include("catalog.php"); 
        include("../footer/footer.php");
    ?>
</body>
</html>