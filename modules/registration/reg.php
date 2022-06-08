<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
include("../../database/connect.php");

if (isset($_POST['user_name'])) { 
    $user_name = $_POST['user_name']; //заносим введенный пользователем логин впеременную $name, если он пустой, то уничтожаем переменную
    if ($user_name =='') { 
        unset($user_name);
    } 
}
if (isset($_POST['email'])) { 
    $email=$_POST['email'];
    if($email =='') { 
        unset($email);
    } 
}
if (isset($_POST['password'])) { 
    $password=$_POST['password'];
    if($password =='') { 
        unset($password);
    } 
}

if (isset($_POST["button_reg"]))
{
 if(isset($_POST["go"])):
    $e1=null;
    $user_name=trim($_POST["user_name"]);
    $user_name=strip_tags($user_name);
    $user_name=stripslashes($user_name);
    if(strlen($user_name)==""){
        $e1.="Заполните поле Имя<br>";
    }

    $regex_user_name = '/[a-zA-ZА-ЯЁа-яё0-9_]/';
    

    if (!preg_match($regex_user_name, $user_name) && !strlen($user_name)==""){
        $e1.="Введеный логин не соответствует требованиям<br>";

    }
        $query="SELECT user_name FROM users WHERE user_name='$user_name'";
        $result = mysqli_query($mysqli, $query) or die("Ошибка выполнения запроса".mysqli_error($mysqli));
        if ($result){
            $row = mysqli_fetch_row($result);
            if (!empty($row[0])) $e1="Данный логин занят"; // проверка на существование в БД такого же логина
        }

    $e2=null;
    $password=trim($_POST["password"]);
    $password=strip_tags($password);
    $password=htmlspecialchars($password,ENT_QUOTES);
    $password=stripslashes($password);
    if(strlen($password)==""):
        $e2.="Заполните поле 'Пароль'<br>";
    endif;

    $regex_password = '/[a-zA-ZА-ЯЁа-яё]/';
    $regex2_password = '/[#$%^&_=+-]/';
    if((!preg_match($regex_password, $password) || preg_match($regex2_password, $password)) && !strlen($password)=="") { 
        $e2.="Введеный пароль не соответствует требованиям<br>";
    }



    $e3=null;
    $email=trim($_POST["email"]);
    $email=strip_tags($email);
    $email=htmlspecialchars($email,ENT_QUOTES);
    if(strlen($email)==""):
        $e3.="Заполните поле 'Электронная почта'<br>";
    endif;

   
    if( !filter_var($email, FILTER_VALIDATE_EMAIL)) { 
        $e3.="Введеный e-mail не соответствует требованиям<br>";

    }

    endif;


$eEn=$e1.$e2.$e3;
if($eEn==""):

    $query_id="SELECT user_id FROM `users` order by user_id DESC LIMIT 1";
    $result_id=mysqli_query($mysqli, $query_id) or die("Ошибка " . mysqli_error($mysqli));
    $row = mysqli_fetch_assoc($result_id);
    $current_id = $row['user_id'];

    $password = md5($password);
    $query="INSERT INTO users (`user_id`, `user_name`, `email`, `password`, `phone`, `city`, `street`, `house`)  VALUES ($current_id+1, '$user_name','$email','$password', '' , '', '', '')";
    $result=mysqli_query($mysqli, $query) or die("Ошибка " . mysqli_error($mysqli));
    if ($result) //пишем данные в БД и авторизовываем пользователя
    {
        $query="SELECT * FROM users WHERE user_name='$user_name'";
        $rez = mysqli_query($mysqli, $query);
        if ($rez)
        {
            echo "заносим в сессию";
            $row = mysqli_fetch_assoc($rez);
            $_SESSION['user_id']=$row['user_id'];
            $_SESSION['user_name']=$row['user_name'];
            $_SESSION['email']=$row['email'];
            $_SESSION['password']=$row['password'];
            $_SESSION['phone']='';
            $_SESSION['city']='';
            $_SESSION['street']='';
            $_SESSION['house']='';
            //echo "Вы успешно зарегистрированы, 
            mysqli_close($mysqli);
            print "<script language='Javascript' type='text/javascript'>alert ('Вы успешно зарегистрировались ! Спасибо!');function reload(){top.location = '../account_page/account_page.php'};setTimeout('reload()', 0);</script>";
        }
        else
        {
            print "<script language='Javascript' type='text/javascript'>alert ('Ваши данные не были занесены в БД!');</script>";
        }
    }
endif;
}

?>

<div class="auth_reg_container reg_container">
    <p class="title_h2">Регистрация</p>
    <form class="inputs" action="../account_page/account_page.php" method="post">
        <p>
            <input type="text" class="input_account" name="user_name" size="25" maxlength="25" placeholder="Имя">
            <span class="error"><?=@$e1;?></span>
        </p>
        <p>
            <input name="email" class="input_account" type="text" size="25" maxlength="25" placeholder="Электронная почта">
            <span class="error"><?=@$e3;?></span>
        </p>
        <p>
            <input name="password" class="input_account" type="password" size="25" maxlength="25" placeholder="Пароль">
            <span class="error"><?=@$e2;?></span>
        </p>
        <p><input type="hidden" name="go" value="5"></p>
 <!-- … Здесь должны быть строки скрипта вашей каптчи … --> 
        <div class="buttons">
            <input type="submit" name="button_reg" value="Зарегистрироваться" class="black_button_auth_reg black_button">
            <p>У меня есть аккаунт</p>
            <button name="to_signin" class="button_reg_signin">войти</button>
        </div>
 </form>
</div>
