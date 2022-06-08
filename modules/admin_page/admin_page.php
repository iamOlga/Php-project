<?php
    if(session_status()!=PHP_SESSION_ACTIVE) session_start();
    include_once("../../database/connect.php");
    include_once("../../functions/functions.php");

    
    
    if(isset($_POST["button_exit"])){
        $_SESSION['user_name']='';
        $_SESSION['user_id']='';
        $_SESSION['email']='';
        $_SESSION['password']='';
        print "<script language='Javascript' type='text/javascript'>
        function reload(){top.location = '../account_page/account_page.php'};
        setTimeout('reload()', 0);</script>";
    }
?>
<html>
<head>
    <title>True Botanicals. Admin page</title>
    <link rel="stylesheet" href="../../css/style_common.css">
    <link rel="stylesheet" href="../../css/style_admin_page.css">
</head>
<body>
    <div class="admin_container">
        <div class="header">
            <p class="title_h3">Вы зашли в личный кабинет в качества Администратора!</p>
            <img src="../../images/logo.png" alt="">
        </div>

        <div class="admin_panel">
            <?php
            if(isset($_POST["button_products"]) || $_SESSION['current_admin_page'] == 'admin_products'){
                include("admin_products.php");
            }
            else if(isset($_POST["button_orders"]) || $_SESSION['current_admin_page'] == 'admin_orders'){
                include("admin_orders.php");
            }
            else if(isset($_POST["button_categories"]) || $_SESSION['current_admin_page'] == 'admin_categories'){
                include("admin_categories.php");   
            }
            else {
                include("admin_main.php");
            }
                
            ?>
        </div>

        <div class="footer">
            <form action="admin_page.php" method="post">
                <input  type="submit" name="button_exit" class="black_button button_exit" value='выход'/>
            </form>
        </div>
    </div>
    
</body>
</html>