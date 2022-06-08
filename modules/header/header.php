<link rel="stylesheet" href="../../css/style_header.css">
<link rel="stylesheet" href="../../css/style_common.css">
<?php
    if(session_status()!=PHP_SESSION_ACTIVE) session_start();
    /* include("../../database/connect.php");
    include("../../functions/functions.php"); */
?>



<header> 
    <li><a href="#"><img id="img_header_menu" src="../../images/button_menu_open.png" alt="button_menu_open"></a>

        <form class="submenu" action="<?=$_SESSION['current_page']?>" method="post">

            <input type="submit" name="category_all" class="button" value="все товары"/>
            <?php
                $categories = getCatigories($mysqli);
                foreach ($categories as $category) :
            ?>
            
                <input type="submit" name="category_<?=$category["category_id"]?>" class="button" value="<?=$category["category"]?>"/>
            <?php     
                endforeach;
            ?>

        </form>

    </li>

    <a href="../../index.php">
        <img src="../../images/logo.png" alt="logo">
    </a>
  
    <form action="<?=$_SESSION['current_page']?>" method="post" class="container_account_bag">
        <input  type="submit" name="button_account" class="button_account" value=''/>
        <input  type="submit" name="button_bag" class="button_bag" value=''/>
        </form>
</header>
