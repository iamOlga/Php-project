<?php
session_start();
require ("../../database/connect.php");
$info = explode("\n", $_GET["name"]);
$count = $_GET["message"];
$query1 = "SELECT * FROM products WHERE product_name='".$info[0]."'";
$result1 = mysqli_query($mysqli, $query1) or die ("Ошибка" . mysqli_error($mysqli));
$num_rows = mysqli_num_rows($result1);
$row = mysqli_fetch_array($result1);


if($count <= $row[5]) {
    
    $query = "UPDATE bag SET count='".$count."' WHERE id_product='".$row[0]."'";
    $result = mysqli_query($mysqli, $query) or die("Ошибка" . mysqli_error($mysqli));

} 
echo $count;
return;
?>