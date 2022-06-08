<?php
    if(session_status()!=PHP_SESSION_ACTIVE) session_start();
    include_once("../../database/connect.php");
    include_once("../../functions/functions.php");
    


    $categories = getCatigories($mysqli);

    $query_id="SELECT category_id FROM categories order by category_id DESC LIMIT 1";
    $result_id=mysqli_query($mysqli, $query_id) or die("Ошибка " . mysqli_error($mysqli));
    $row1 = mysqli_fetch_assoc($result_id);
    $current_id = $row1['category_id'];

    foreach ($result_id as $id) {
        if(isset($_POST["button_delete_category_".$id["category_id"]])){
            mysqli_query($mysqli, "DELETE FROM categories WHERE category_id=".$id["category_id"]);
            $_SESSION['current_admin_page']='admin_categories';
            print "<script language='Javascript' type='text/javascript'> function reload(){top.location = 'admin_page.php'}; setTimeout('reload()', 0);</script>";
        }
        if(isset($_POST["button_update_category_".$id["category_id"]])){  
            mysqli_query($mysqli, "UPDATE categories SET category='".$_POST["category_".$id["category_id"]]."' WHERE category_id=".$id["category_id"]);
            $_SESSION['current_admin_page']='admin_categories';
            print "<script language='Javascript' type='text/javascript'> function reload(){top.location = 'admin_page.php'}; setTimeout('reload()', 0);</script>"; 
        }
    }

    if(isset($_POST["back_to_admin_page"])){
        $_SESSION['current_admin_page']='';
            print "<script language='Javascript' type='text/javascript'> function reload(){top.location = 'admin_page.php'}; setTimeout('reload()', 0);</script>";
    }

    if(isset($_POST["button_add_category"])){
        mysqli_query($mysqli, "INSERT INTO `categories`(`category_id`, `category`) VALUES ('".$_POST["category_id_add"]."','".$_POST["category_add"]."')");

        $_SESSION['current_admin_page']='admin_categories';
        print "<script language='Javascript' type='text/javascript'> function reload(){top.location = 'admin_page.php'}; setTimeout('reload()', 0);</script>";
    }

?>
<link rel="stylesheet" href="../../css/style_common.css">
<form class="products_table" action="admin_categories.php" method="post">
    <input type="submit" name="back_to_admin_page"  class="back back_cat" value="">

        <?php 
        foreach ($categories as $category) :              
        ?>

            <div class="product product_<?=$product["id_product"]?>">
                <input name="category_id_<?=$category["category_id"]?>" placeholder="<?=$category["category_id"]?>" readonly/> 
                <input name="category_<?=$category["category_id"]?>" value="<?=$category["category"]?>"/>
                
                <input type="submit" name="button_update_category_<?=$category["category_id"]?>" class="black_button" value="u"/>
                <input type="submit" name="button_delete_category_<?=$category["category_id"]?>" class="black_button" value="d"/>
            </div>
        <?php      
            endforeach;
        ?>

    <div class="product add_product">
        <input name="category_id_add" value="<?=$current_id+1?>" readonly/> 
        <input name="category_add" placeholder="category name" />
        <input type="submit" name="button_add_category" class="black_button" value="+"/>
    </div>
    </form>
