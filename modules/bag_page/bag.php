<?php
    if(session_status()!=PHP_SESSION_ACTIVE) session_start();
    include_once("../../database/connect.php");
    include_once("../../functions/functions.php");
    /* function delete_product_from_bag($mysqli, $id_product){
        $result = mysqli_query($mysqli, "DELETE FROM bag WHERE id_product=".$id_product." and user_id = ".$_SESSION['user_id']);
    } */

    $query = "SELECT * FROM products INNER join bag on bag.id_product = products.id_product WHERE bag.user_id = ".$_SESSION['user_id']." and bag.order_id = 0";
    $info_products = getAllProducts($mysqli, $query);

 
    foreach ($info_products as $product) :
        

        $products_count = get_ids_product($mysqli, "SELECT count FROM products where id_product=".$product["id_product"]);
        if(isset($_POST["count_plus_".$product["id_product"]])){
            if($products_count[0]['count'] > $product["count"]+1){

                $count_new = $products_count[0]['count'] - 1;
                mysqli_query($mysqli, "UPDATE products SET count='".$count_new."' WHERE id_product='".$product["id_product"]."'");

                $count = $product["count"]+1;
                mysqli_query($mysqli, "UPDATE `bag` SET `count`='".$count."' WHERE id_product='".$product["id_product"]."' and user_id=".$_SESSION['user_id']); 
                print "<script language='Javascript' type='text/javascript'> function reload(){top.location = 'bag_page.php'}; setTimeout('reload()', 0);</script>";
            }
            else{
                print '<script> alert("Данное количество товаров отсутствует на складе");
                function reload(){top.location = "bag_page.php"}; setTimeout("reload()", 0);</script>';
            }
            
        }
        if(isset($_POST["count_minus_".$product["id_product"]])){
            $count = $product["count"]-1;
            if($count==0){
                $count = 1;
            }
            else{
                $count_new = $products_count[0]['count'] + 1;
                mysqli_query($mysqli, "UPDATE products SET count='".$count_new."' WHERE id_product='".$product["id_product"]."'");
            }

            mysqli_query($mysqli, "UPDATE `bag` SET `count`='".$count."' WHERE id_product='".$product["id_product"]."' and user_id=".$_SESSION['user_id']); 
            print "<script language='Javascript' type='text/javascript'> function reload(){top.location = 'bag_page.php'}; setTimeout('reload()', 0);</script>";
        }
    endforeach;
?>  
<div class="title_panel">
        <p class="title_h3">Корзина</p>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
 
<div class="_container bag_container"> 
<div class="bag_list" id="bag_list1">

    <?php 
        /* $_SESSION['summary']=0; */
        if(empty($info_products)){
            echo"<p style='width:100%; text-align:center;'>в корзине нет товаров</p>";
        }
        else{
        foreach ($info_products as $product) : 
            /* $_SESSION['summary']+= $product["price"]*$product["count"]; */

            $query_max = "SELECT count FROM `products` WHERE id_product=".$product["id_product"];
            $info_max = getAllProducts($mysqli, $query_max);
           
    ?>

    <div class="item">
        <img src="../../<?=$product["image"]?>" alt="">
        <div class="info">
            <p class="product_name"><?=$product["product_name"]?></p>
            <p class="price">$<?=$product["price"]?></p>
        </div>
        <div class="div_count">
            <input type="submit" name="count_minus_<?=$product["id_product"]?>" class="icon count_minus" value="">
            <input class="count" type="number" step="1" max="<?=+$info_max[0]["count"]?>" value="<?=$product["count"]?>" readonly>
            <input type="submit" name="count_plus_<?=$product["id_product"]?>" class="icon count_plus" value="">
        </div>
        <p class="common_price">$<?=$product["price"]*$product["count"]?></p>
        
       <form id="form_del" name="del" method="post" action="" onsubmit="return false;">
        <input type="submit" name="delete_from_bag_<?=$product["id_product"]?>" class="icon delete_from_bag" value="">
        </form>
    </div>

    <?php 
        endforeach;
    
    ?>

</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

<script>

/* НЕ РАБОТАЮЩЕЕ УДАЛЕНИЕ----------------------------------------------------- */
$('.delete_from_bag').on('click', function delete_product_frombag(){
        let msg = $(this).closest('.item')[0].innerText;
        console.log(msg);
        $.ajax({
            type: 'POST',
            url: 'delete_product.php',
            data: msg,
            success: $.get('delete_product.php', {message: msg}, function(data){
                /* alert(data); */
            })
        });
        $(this).closest('.item').remove();
    })


    $('.count_minus').on('click', function count_minus() {
    var messages = $(this).parent().find('.count')[0].defaultValue;
    if($(this).parent().find('.count')[0].defaultValue > 1){
        $(this).parent().find('.count')[0].defaultValue = Number(messages) - 1; 
        $(this).parent().parent().find('.common_price')[0].innerText = '$' + Number($(this).parent().parent().find('.price')[0].innerText.slice(1)) * Number($(this).parent().find('.count')[0].defaultValue);
    } else {
        $(this).parent().find('.count')[0].defaultValue = 1;
        $(this).parent().parent().find('.common_price')[0].innerText = '$' + Number($(this).parent().parent().find('.price')[0].innerText.slice(1)) * Number($(this).parent().find('.count')[0].defaultValue);
    }
    messages = $(this).parent().find('.count')[0].defaultValue;
    var name = $(this).parent().parent()[0].innerText;
    $.ajax({
        type: 'POST',
        url: 'update_count.php',
        data: messages + name,
        success: $.get('update_count.php', {message: messages, name: name}, function(data) {
            
        })
    }); 
    });

    $('.count_plus').on('click', function count_plus() {
    var messages = $(this).parent().find('.count')[0].defaultValue;
    if($(this).parent().find('.count')[0].defaultValue < $(this).parent().find('.count')[0].max){
        $(this).parent().find('.count')[0].defaultValue = Number(messages) + 1; 
        $(this).parent().parent().find('.common_price')[0].innerText = '$' + Number($(this).parent().parent().find('.price')[0].innerText.slice(1)) * Number($(this).parent().find('.count')[0].defaultValue);
    } 

    messages = $(this).parent().find('.count')[0].defaultValue;
    var name = $(this).parent().parent()[0].innerText;
    let max_value = $(this).parent().find('.count')[0].max;
    
    $.ajax({
        type: 'POST',
        url: 'update_count.php',
        data: messages + name,
        success: $.get('update_count.php', {message: messages, name: name}, function(data) {
            if(data == max_value){
                alert("Вы забрали последний товар со склада!");
            }
        })
    }); 
    
    });
</script> 


<form action="bag_page.php" method="post" class="bag_toorder">

    <input type="submit" name="button_toorder" value="оформить заказ" class="black_button">
</form>
<?php 
        
    }
    ?>
</div>