<link rel="stylesheet" href="../../css/style_account_page.css">

<?php
    if(session_status()!=PHP_SESSION_ACTIVE) session_start();
    /* $_SESSION['user_name']='olya'; */
    include("../../database/connect.php");
    $_SESSION['tosave'] = "false";

    if(isset($_POST["button_exit"])){
        $_SESSION['user_id']='';
        $_SESSION['user_name']='';
        $_SESSION['email']='';
        $_SESSION['password']='';
        print "<script language='Javascript' type='text/javascript'>
 function reload(){top.location = 'account_page.php'};
 setTimeout('reload()', 0);
 </script>";
    }

    $result_info = mysqli_query($mysqli, "SELECT * FROM users WHERE user_name='".$_SESSION['user_name']."'");
    $user_info = mysqli_fetch_all($result_info, 1);


    function _update($mysqli, $query){
        $result = mysqli_query($mysqli, $query);
    } 

        
        if(!empty($_FILES)){

            $file = $_FILES['file'];
            $filename = $file['name'];
            /* $puthfile = '../../images/'.$filename;
            move_uploaded_file($file['tmp_name'], $puthfile); */
        } 

        

    if(isset($_POST["button_save_info"])){   
        $_SESSION['tosave'] = "true";
        
        $_SESSION['user_name']=$_POST["user_name"];
        $_SESSION['email']=$_POST["email"]; 
        $_SESSION['phone']=$_POST["phone"]; 
        $_SESSION['city']=$_POST["city"]; 
        $_SESSION['street']=$_POST["street"]; 
        $_SESSION['house']=$_POST["house"]; 
        $query = "UPDATE users SET user_id='".$_SESSION['user_id']."', user_name='".$_SESSION['user_name']."',email='".$_SESSION['email']."',password='".$_SESSION['password']."',phone='".$_SESSION["phone"]."',city='".$_SESSION["city"]."',street='".$_SESSION["street"]."',house='".$_SESSION["house"]."' WHERE user_id='".$_SESSION['user_id']."'";
        _update($mysqli, $query);
        print "<script language='Javascript' type='text/javascript'> function reload(){top.location = 'account_page.php'}; setTimeout('reload()', 0);</script>"; 
        
    }


    foreach ($user_info as $user) : 

        $email = $user['email'];
        $phone = $user['phone'];
        $city = $user['phone'];
        $street = $user['street'];
        $house = $user['house'];
?>

<div class="in_container">
    <form action="account.php" method="post" class="form_info" enctype="multipart/form-data">
        <div class="account_info_container">
            
            <div class="account_info">
                <div class="column">
                    <input type="text" name="user_name" class="input_account" value="<?=$_SESSION['user_name']?>">
                    <input type="text" name="email" class="input_account" value="<?=$email?>">
                    <input type="text" name="phone" class="input_account" placeholder="Телефон" value="<?=$phone?>">
                </div>
                <div class="column">
                        <input type="text" name="city" class="input_account" placeholder="Город" value="<?=$city?>">
                        <div class="">
                            <input type="text" name="street" class="input_account input_account_street" placeholder="Улица" value="<?=$street?>">
                            <input type="text" name="house" class="input_account input_account_house" placeholder="Дом" value="<?=$house?>">
                        </div>   
                </div>
            </div>
        </div>

        <!-- <div class="button"> -->
            <input type="submit" name="button_save_info" value="сохранить" class="black_button">

        <!-- </div> -->
    </form>

    <form action="account_page.php" method="post" class="buttons_div">
        <input  type="submit" name="button_my_orders" class="button_my_orders" value='Мои заказы'/>
        <input  type="submit" name="button_exit" class="button_exit" value=''/>
    </form>
</div>

<?php 
        endforeach;
    
    ?>