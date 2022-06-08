<?php
    if(session_status()!=PHP_SESSION_ACTIVE) session_start();
    include_once("../../database/connect.php");
    include_once("../../functions/functions.php");
    


    $categories = getCatigories($mysqli);

    function add_product($mysqli, $query){
        $result = mysqli_query($mysqli, $query);
    }

    $products_ids = get_ids_product($mysqli, "SELECT id_product FROM products order by id_product ASC");

    $query_id="SELECT id_product FROM products order by id_product DESC LIMIT 1";
    $result_id=mysqli_query($mysqli, $query_id) or die("Ошибка " . mysqli_error($mysqli));
    $row1 = mysqli_fetch_assoc($result_id);
    $current_id = $row1['id_product'];

    foreach ($products_ids as $id) {
        if(isset($_POST["button_delete_product_".$id["id_product"]])){
            $_SESSION['current_admin_page']='admin_products';
            mysqli_query($mysqli, "DELETE FROM products WHERE id_product=".$id["id_product"]);
            
            print "<script language='Javascript' type='text/javascript'> function reload(){top.location = 'admin_page.php'}; setTimeout('reload()', 0);</script>";
        }
        if(isset($_POST["button_update_product_".$id["id_product"]])){  
            $_SESSION['current_admin_page']='admin_products';
            $get_id_category = mysqli_query($mysqli, "SELECT * FROM categories WHERE category='".$_POST["category_".$id["id_product"]]."'");
            $row = mysqli_fetch_all($get_id_category, 1);
            mysqli_query($mysqli, "UPDATE products SET id_product='".$id["id_product"]."', product_name='".$_POST["product_name_".$id["id_product"]]."', product_type='".$_POST["product_type_".$id["id_product"]]."', category_id='".$row[0]["category_id"]."', price='".$_POST["price_".$id["id_product"]]."', count='".$_POST["count_".$id["id_product"]]."', image='images/21_img.jpg' WHERE id_product='".$id["id_product"]."'");
            
            print "<script language='Javascript' type='text/javascript'> function reload(){top.location = 'admin_page.php'}; setTimeout('reload()', 0);</script>"; 
        }
    }

    if(isset($_POST["back_to_admin_page"])){
        $_SESSION['current_admin_page']='';
            print "<script language='Javascript' type='text/javascript'> function reload(){top.location = 'admin_page.php'}; setTimeout('reload()', 0);</script>";
    }


    

    if(isset($_POST["button_add_product"])){
        $_SESSION['current_admin_page']='admin_products';
        if(!empty($_FILES)){
            $file = $_FILES['file'];
            $filename = $file['name'];
            $puthfile = '../../images/'.$filename;
            move_uploaded_file($file['tmp_name'], $puthfile);
            
        } 
    $get_id_category = mysqli_query($mysqli, "SELECT * FROM categories WHERE category='".$_POST["category_add"]."'");
        $row = mysqli_fetch_all($get_id_category, 1);
        mysqli_query($mysqli, "INSERT INTO `products`(`id_product`, `product_name`, `product_type`, `category_id`, `price`, `count`, `image`) VALUES ('".$_POST["id_product_add"]."','".$_POST["product_name_add"]."','".$_POST["product_type_add"]."','".$row[0]["category_id"]."','".$_POST["price_add"]."', '".$_POST["count_add"]."', 'images/".$filename."')");
   
        $_SESSION['current_admin_page']='admin_products';
        print "<script language='Javascript' type='text/javascript'> function reload(){top.location = 'admin_page.php'}; setTimeout('reload()', 0);</script>";
    }

?>
<link rel="stylesheet" href="../../css/style_common.css">
<form class="products_table" action="admin_products.php" method="post" enctype="multipart/form-data">
    <input type="submit" name="back_to_admin_page"  class="back" value="">
    <?php
        /* $query = "SELECT * FROM products order by id_product ASC"; */
        $query = "SELECT * FROM products inner join categories on categories.category_id=products.category_id order by id_product ASC";
        $info_products = getAllProducts($mysqli, $query);
        foreach ($info_products as $product) : 
    ?>
    <div class="product product_<?=$product["id_product"]?>">
        <input class="id_product" placeholder="<?=$product["id_product"]?>" readonly/> 
        <img class="image" src="../../<?=$product["image"]?>" alt="">

        <select name="category_<?=$product["id_product"]?>" class="select">
                <?php 
                    foreach ($categories as $category) :
                        if($product["category"] == $category["category"]){  
                ?>
                    <option value="<?=$category["category"]?>" selected><?=$category["category"]?></option>
                <?php 
                        }
                        else {
                ?>
                    <option value="<?=$category["category"]?>"><?=$category["category"]?></option>
                <?php
                        }
                     endforeach;
                ?>
        </select>
        
        
        <input type="text" name="product_name_<?=$product["id_product"]?>" class="product_name" value="<?=$product["product_name"]?>"/>

        <select name="product_type_<?=$product["id_product"]?>"  class="select">
                <?php 
                    if($product["product_type"] == 'сухая'){  
                ?>
                    <option value="сухая" selected>сухая</option>
                    <option value="жирная">жирная</option>
                    <option value="нормальная">нормальная</option>
                    <option value="комбинированная">комбинированная</option>
                <?php 
                    }
                    else if($product["product_type"] == 'жирная'){  
                ?>
                    <option value="сухая">сухая</option>
                    <option value="жирная" selected>жирная</option>
                    <option value="нормальная">нормальная</option>
                    <option value="комбинированная">комбинированная</option>
                <?php 
                    }
                    else if($product["product_type"] == 'нормальная'){  
                ?>
                    <option value="сухая">сухая</option>
                    <option value="жирная">жирная</option>
                    <option value="нормальная" selected>нормальная</option>
                    <option value="комбинированная">комбинированная</option>
                <?php 
                    }
                    else {  
                ?>
                    <option value="сухая">сухая</option>
                    <option value="жирная">жирная</option>
                    <option value="нормальная">нормальная</option>
                    <option value="комбинированная" selected>комбинированная</option>
                <?php 
                    }
                ?>

            </select>
        <input type="text" name="price_<?=$product["id_product"]?>" class="price" value="<?=$product["price"]?>"/>
        <input type="text" name="count_<?=$product["id_product"]?>" class="price" value="<?=$product["count"]?>"/>
        <input type="submit" name="button_update_product_<?=$product["id_product"]?>" class="black_button" value="u"/>
        <input type="submit" name="button_delete_product_<?=$product["id_product"]?>" class="black_button" value="d"/>
    </div>
    <?php 
        endforeach;
    ?>

    <div class="product add_product">
        <input class="id_product" name="id_product_add" value="<?=$current_id +1?>" readonly/>
        <input type="file" name="file" class="file">
        <select name="category_add" class="category">">
                <?php 
                    foreach ($categories as $category) :
                ?>
                    <option value="<?=$category["category"]?>" selected><?=$category["category"]?></option>
                <?php 
                     endforeach;
                ?>
        </select>
        <input type="text" name="product_name_add" class="product_name" placeholder="product_name"/>
        <select name="product_type_add"  class="select">
                <option value="сухая" selected>сухая</option>
                <option value="жирная">жирная</option>
                <option value="нормальная">нормальная</option>
                <option value="комбинированная">комбинированная</option>
        </select>
        <input type="text" name="price_add" class="price" placeholder="price"/>
        <input type="text" name="count_add" class="price" placeholder="count"/>
        <input type="submit" name="button_add_product" class="black_button" value="+"/>
    </div>
    </form>
