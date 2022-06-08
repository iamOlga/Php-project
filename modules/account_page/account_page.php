<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
    include("../../database/connect.php");
    include("../../functions/functions.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>True Botanicals. Account</title>
    <link rel="stylesheet" href="../../css/style_common.css">
    <link rel="stylesheet" href="../../css/style_account_page.css">
</head>
<body>
    <?php
        include_once("../header/header.php");
    ?>

    <div class="banner">
        <img src="../../images/account_banner.png" alt="">
    </div>
    <div class="title_panel">
        <p class="title_h3">Личный кабинет</p>
    </div>

    <div class="_container">
        
        <?php
        
            if(array_key_exists('button_account', $_POST)) {
                print "<script language='Javascript' type='text/javascript'>
                    function reload(){top.location ='account_page.php'};setTimeout('reload()', 0);</script>";
                    $_SESSION['current_page']='../account_page/account_page.php';
            }
            for($i=0; $i<count($_SESSION['categories_buttons']); $i++){
                if(array_key_exists($_SESSION['categories_buttons_name'][$i], $_POST)){
                    $_SESSION['catalog_title_category'] = $_SESSION['categories_buttons_value'][$i];
                    print "<script language='Javascript' type='text/javascript'>
                        function reload(){top.location ='../catalog_page/catalog_page.php'};setTimeout('reload()', 0);</script>";    
                        $_SESSION['current_page']='../catalog_page/catalog_page.php';
                }
            }
            if(array_key_exists('button_bag', $_POST)) {
                print "<script language='Javascript' type='text/javascript'>
                        function reload(){top.location ='../bag_page/bag_page.php'};setTimeout('reload()', 0);</script>";
                        $_SESSION['current_page']='../bag_page/bag_page.php';
            }


           
            /* if(array_key_exists('button_my_orders', $_POST)) {
                include_once("my_orders.php");
            } */


            if ($_SESSION['user_name']==''){
                if(array_key_exists('to_reg', $_POST)){
                    include_once("../registration/reg.php");
                }
                else if(array_key_exists('to_signin', $_POST) || array_key_exists('button_to_signin', $_POST)){
                    include_once("../auth/auth.php");
                }
                else{
                    include_once("../registration/reg.php");
                }
            }
            else if($_SESSION['user_name']=='admin'){
                print "<script language='Javascript' type='text/javascript'>
                    function reload(){top.location ='../admin_page/admin_page.php'};setTimeout('reload()', 0);</script>";
            }
            else if(isset($_POST["button_exit"])){
                $_SESSION['user_id']='';
                $_SESSION['user_name']='';
                $_SESSION['email']='';
                $_SESSION['password']='';
                print "<script language='Javascript' type='text/javascript'>
                function reload(){top.location = 'account_page.php'};
                setTimeout('reload()', 0);
                </script>";
            }
            else if(array_key_exists('button_my_orders', $_POST)) {
                include_once("my_orders.php");
            }

            
            else{
                include_once("account.php");
            }

            ?>
      
    </div>
    <?php
        include_once("../footer/footer.php");
    ?>
</body>
</html>