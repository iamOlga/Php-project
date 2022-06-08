<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
require("../../database/connect.php");
include("../../functions/functions.php");


    echo '<script> console.log("ыцвапернго"); </script>';

    $query_id="SELECT review_id FROM `reviews` order by review_id DESC LIMIT 1";
    $result_id=mysqli_query($mysqli, $query_id) or die("Ошибка " . mysqli_error($mysqli));
    $row = mysqli_fetch_assoc($result_id);
    $current_id = $row['review_id']+1;

    if(!empty($_POST["review_add"]) && strlen(trim($_POST["review_add"])) != 0 && $_POST["review_add"]!= "Введите отзыв"){
        mysqli_query($mysqli, "INSERT INTO `reviews`(`review_id`, `user_id`, `review`) VALUES ('".$current_id."','".$_SESSION['user_id']."','".$_POST["review_add"]."')"); 
    }

    $query_ = "SELECT * FROM reviews inner join users on users.user_id=reviews.user_id";
    $reviews_ = getAllProducts($mysqli, $query_);  

    foreach ($reviews_ as $review) :
        echo '<div class="review">
                <div class="img"><span>'.strtoupper(substr($review["user_name"], 0, 1)).'</span></div>
                <div class="review_info">
                    <p class="review_name">'.strtoupper(substr($review["user_name"], 0, 1)).substr($review["user_name"], 1).'</p>
                    <p class="review_text">«'.$review["review"].'»</p>
                </div>
            </div>'; 
    endforeach;


?>

