<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
    include("../../database/connect.php");
    include("../../functions/functions.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>True Botanicals. Bag</title>
    <link rel="stylesheet" href="../../css/style_common.css">
    <link rel="stylesheet" href="../../css/style_bag_page.css">
</head>
<body>




    <?php
        include_once("../header/header.php");

        if(array_key_exists('button_account', $_POST)) {
            print "<script language='Javascript' type='text/javascript'>
                function reload(){top.location ='../account_page/account_page.php'};setTimeout('reload()', 0);</script>";
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
    ?>

    <div class="banner">
        <img src="../../images/bag_banner.png" alt="">
    </div>
    
        <?php
            if($_SESSION['user_name'] == ''){
        ?>
                <form action="../../index.php" method="post" class="not_in_acc">
                    <input type="submit" name="reviews_registration" class="button" style="background:none" value="зарегистрируйтесь, чтобы добавлять товары"/>
                </form>
        <?php
            }
            else if (isset($_POST["button_toorder"])){
                include_once("to_order.php");
            }
            else if (isset($_POST["back_to_bag"])){
                include_once("bag.php");
            }
            else if (isset($_POST["toorder"])){
                print "<script language='Javascript' type='text/javascript'>
                    function reload(){top.location ='../bag_page/bag_page.php'};setTimeout('reload()', 0);</script>";
            }
            else{
                include_once("bag.php");
            }



            if(isset($_POST["toorder"])){

                $query_id="SELECT order_id FROM `orders` order by order_id DESC LIMIT 1";
                $result_id=mysqli_query($mysqli, $query_id) or die("Ошибка " . mysqli_error($mysqli));
                $row = mysqli_fetch_assoc($result_id);
                $current_id = $row['order_id']+1;

                mysqli_query($mysqli, "INSERT INTO `orders`(`order_id`, `user_id`, `summary_price`, `payment_method`, `adress`, `phone`, `date`, `time`, `status`) VALUES ('".$current_id."','".$_SESSION['user_id']."','".$_SESSION['summary']."','".$_POST['payment_meth']."','".$_POST['adress']."','".$_POST['phone']."','".$_POST['date']."','".$_POST['time']."','Оформлен')");
                mysqli_query($mysqli, "UPDATE `bag` SET order_id = '".$current_id."' WHERE user_id = ".$_SESSION['user_id']." and order_id = 0");


            }

            /* if ($_SESSION['user_name']==''){
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
            else{
                include_once("account.php");
            } */

                ?>
      
    

    <?php
        
        include_once("../footer/footer.php");
    ?>

 
</body>
</html>