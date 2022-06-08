<?php
    if(session_status()!=PHP_SESSION_ACTIVE) session_start();
    $_SESSION['catalog_title_category']='';
    $_SESSION['catalog_orderby']='';
    $_SESSION['catalog_filterskin']='';
    $_SESSION['search']='';

    $_SESSION['categories_buttons_value']=[" "];
    $_SESSION['categories_buttons_name']=["category_all"];

   /*  $_SESSION['user_name']='';
    $_SESSION['email']='';
    $_SESSION['password']=''; */

    $_SESSION['current_page']='../../index.php';
    $_SESSION['current_admin_page']='';

?>

<?php
     include("database/connect.php");
    include("functions/functions.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>True Botanicals</title>
    <link rel="stylesheet" href="css/style_common.css">
</head>
<body>


    <?php
        
        
            include_once("modules/header/header.php");
            include_once("modules/main_page/main_banner.php");
            include_once("modules/main_page/bestsellers.php");
            include_once("modules/main_page/reviews.php");
            include_once("modules/footer/footer.php");



        /* $query_id="SELECT review_id FROM `reviews` order by review_id DESC LIMIT 1";
        $result_id=mysqli_query($mysqli, $query_id) or die("Ошибка " . mysqli_error($mysqli));
        $row = mysqli_fetch_assoc($result_id);
        $current_id = $row['review_id']+1; */

        /* if(isset($_POST["add_review_button"])){
            if(!empty($_POST["review_add"]) && strlen(trim($_POST["review_add"])) != 0)
                mysqli_query($mysqli, "INSERT INTO `reviews`(`review_id`, `user_id`, `review`) VALUES ('".$current_id."','".$_SESSION['user_id']."','".$_POST["review_add"]."')"); 
            print '<script> function reload(){top.location = "../../index.php"}; setTimeout("reload()", 0);</script>';
            } */

        for($i=0; $i<count($_SESSION['categories_buttons']); $i++){
            if(array_key_exists($_SESSION['categories_buttons_name'][$i], $_POST)){
                $_SESSION['catalog_title_category'] = $_SESSION['categories_buttons_value'][$i];
                print "<script language='Javascript' type='text/javascript'>
                        function reload(){top.location ='modules/catalog_page/catalog_page.php'};setTimeout('reload()', 0);</script>";    
                $_SESSION['current_page']='../catalog_page/catalog_page.php';
            }
        }

        if(array_key_exists('button_catalog', $_POST)) {
            $_SESSION['catalog_title_category'] = " ";
            print "<script language='Javascript' type='text/javascript'>
                    function reload(){top.location ='modules/catalog_page/catalog_page.php'};setTimeout('reload()', 0);</script>";
            $_SESSION['current_page']='../catalog_page/catalog_page.php';
        }

        if(array_key_exists('button_account', $_POST) || array_key_exists('reviews_registration', $_POST)) {
            print "<script language='Javascript' type='text/javascript'>
                    function reload(){top.location ='modules/account_page/account_page.php'};setTimeout('reload()', 0);</script>";
            $_SESSION['current_page']='../account_page/account_page.php';
        }

        if(array_key_exists('button_bag', $_POST)) {
            print "<script language='Javascript' type='text/javascript'>
                    function reload(){top.location ='modules/bag_page/bag_page.php'};setTimeout('reload()', 0);</script>";
            $_SESSION['current_page']='../bag_page/bag_page.php';
        }


    ?>
</body>
</html>