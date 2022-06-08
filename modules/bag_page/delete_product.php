<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
include_once("../../database/connect.php");
include_once("../../functions/functions.php");
$name = explode("\n", $_GET["message"]);
$query = "SELECT id_product FROM products WHERE product_name='".$name[0]."'";
$result = mysqli_query($mysqli, $query) or die('Error');
$row = mysqli_fetch_array($result);
echo $row[0];
$queryD = "DELETE FROM bag WHERE id_product='".$row[0]."' AND user_id='".$_SESSION["user_id"]."'";
$resultD = mysqli_query($mysqli, $queryD) or die('Error');

?>
