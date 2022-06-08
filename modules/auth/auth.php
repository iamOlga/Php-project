<?php
    if(session_status()!=PHP_SESSION_ACTIVE) session_start();

    if(isset($_POST["button_to_signin"])){

        if (isset($_POST['user_name'])) { 
            $user_name = $_POST['user_name']; 
            if ($user_name == '') { 
                unset($user_name);
            } 
        }
        if (isset($_POST['password'])) { 
            $password=$_POST['password']; 
            if ($password =='') { 
                unset($password);
            } 
        }

        $e1=null;
        $e2=null;
        $_SESSION['user_name']=$user_name;  
        if($user_name == '' || $password== ''){
            if ($user_name == '') {
                $e1.="Заполните поле 'Имя'<br>";
            }
            if ($password== '') {
                $e2.="Заполните поле 'Пароль'<br>";
            }
        }
        
         else{ 
            $user_name = stripslashes($user_name);
            $user_name = htmlspecialchars($user_name);
            $password = stripslashes($password);
            $password = htmlspecialchars($password);
            $user_name = trim($user_name);
            $password = trim($password);
    
            
        
            /*include("../../database/connect.php"); */
        
            $query ="SELECT * FROM users WHERE user_name='".$user_name."'";
            $result = mysqli_query($mysqli, $query) or die("Ошибка " . mysqli_error($mysqli));
            $row = mysqli_fetch_assoc($result);
            if (empty($row['user_id']))
            {
                mysqli_close($mysqli);
                /* print "<script language='Javascript' type='text/javascript'>
                alert ('Такого user_name не существует!');
                </script>"; */
                $e1="Такого имени не существует<br>";
            }
            else
            {
                if ($row['user_name']=="admin" && $row['password']==md5($password))
                {
                    $_SESSION['user_id']=$row['user_id'];
                    $_SESSION['user_name']=$row['user_name'];
                    $_SESSION['email']=$row['email'];
                    $_SESSION['password']=$row['password'];
                    print "<script language='Javascript' type='text/javascript'>
                    function reload(){top.location = '../admin_page/admin_page.php'};
                    setTimeout('reload()', 0)
                    </script>";
                }
                else
                if ($row['password']==md5($password))
                {
                    $_SESSION['user_id']=$row['user_id'];
                    $_SESSION['user_name']=$row['user_name'];
                    $_SESSION['email']=$row['email'];
                    $_SESSION['password']=$row['password'];
                    $_SESSION['phone']='';
                    $_SESSION['city']='';
                    $_SESSION['street']='';
                    $_SESSION['house']='';
                    print "<script language='Javascript' type='text/javascript'>
                    function reload(){top.location = '../account_page/account_page.php'};
                    setTimeout('reload()', 0)
                    </script>";
                }
                else
                {
                    /* print "<script language='Javascript' type='text/javascript'>
                    alert ('Вы ввели неправильный пароль!');
                    </script>"; */
                    $e2="Вы ввели неправильный пароль!<br>";
                }
                mysqli_close($mysqli);
            }
        } 
     
        
    }
?>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
    </head>
    <body>
        
        <div class="auth_reg_container">
        <p class="title_h2">Вход</p>
            <form class="inputs" action="../account_page/account_page.php" method="post">
            <p>
                <input name="user_name" class="input_account" type="text" value="<?=@$_SESSION['user_name'];?>" size="28" maxlength="28" placeholder="Имя">
                <span class="error"><?=@$e1;?></span>
            </p>
            <p>
            <input name="password" class="input_account" type="password" size="28" maxlength="28" placeholder="Пароль">
                <span class="error"><?=@$e2;?></span>
            </p>
                <div class="buttons">
                    <input type="submit" class="black_button_auth_reg black_button" name="button_to_signin" value="Войти">
                    <p>У меня нет аккаунта</p>
                    <button  name="to_reg" class="button_reg_signin">зарегистрироваться</button>
                </div>
            </form>
        </div>
    </body>
</html>