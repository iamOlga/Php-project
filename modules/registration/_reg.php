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
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    if (isset($_POST['input'])) { 
        if ($_POST['input'] == $_SESSION['captcha_string']) {

        if(isset($_POST["go"])){
            $e1=null;
            $user_name=trim($_POST["user_name"]);
            $user_name=strip_tags($user_name);
            $user_name=stripslashes($user_name);
            if(strlen($user_name)==""){
                $e1.="Заполните поле Имя<br>";
            }

            /* $regex_login = '/[a-zA-ZА-ЯЁа-яё0-9_]{4,}$/';
            $regex2_login = '/([a-zA-ZА-ЯЁа-яё0-9_])\1{3,}/u'; */

            /* if ((!preg_match($regex_login, $login) || preg_match($regex2_login, $login)) && !strlen($login)==""){
                $e1.="Введеный логин не соответствует требованиям<br>";
                myError(strip_tags($e1));
            } */
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

            /* $regex_password = '/[a-zA-ZА-ЯЁа-яё]{8,}$/';
            $regex2_password = '/[#$%^&_=+-]/';
            if((!preg_match($regex_password, $password) || preg_match($regex2_password, $password)) && !strlen($password)=="") { 
                $e4.="Введеный пароль не соответствует требованиям<br>";
                myError(strip_tags($e2));
            } */

 

            $e3=null;
            $email=trim($_POST["email"]);
            $email=strip_tags($email);
            $email=htmlspecialchars($email,ENT_QUOTES);
            $regex_email = '(\@gm)';
            if(preg_match($regex_email, $email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) { 
                $e3.="Введеный e-mail не соответствует требованиям<br>";
                myError(strip_tags($e3));
            }
    
           
        $eEn=$e1.$e2.$e3;
        if($eEn==""):
            $password = md5($password);
            $query="INSERT INTO users (`user_id`, `user_name`, `email`, `password`, `city`, `street`, `house`, `image`)  VALUES ('2', '$user_name','$email','$password')";
            $result=mysqli_query($mysqli, $query) or die("Ошибка " . mysqli_error($mysqli));
            if ($result){ //пишем данные в БД и авторизовываем пользователя
                $query="SELECT * FROM users WHERE name='$name'";
                $rez = mysqli_query($mysqli, $query);
                if ($rez){
                    $row = mysqli_fetch_assoc($rez);
                    $_SESSION['name'] = $row['name'];
                    $_SESSION['email']=$row['email']; 
                    mysqli_close($mysqli);
                    // выводим уведомление об успехе операции и перезагружаем страничку
                    print "<script language='Javascript' type='text/javascript'>alert ('Ваши данные были снесены в БД!');</script>";
                }
                else {
                    print "<script language='Javascript' type='text/javascript'>alert ('Ваши данные не были снесены в БД!');</script>";
                }
            }
        endif;
        }

    } else { 
        $cap = NULL; 
        $cap .= "Ошибка при вводе каптчи<br>"; 
        create_image(); 
    } 
    } else { 
    $cap = NULL; 
    $cap .= "Заполните поле 'Каптча'<br>"; 
    create_image(); 
    }

    function  create_image() 
    { 
        global $image; 
        $image = imagecreatetruecolor(200, 50); 
     
        $background_color = imagecolorallocate($image, 255, 255, 255); 
        $text_color = imagecolorallocate($image, 0, 255, 255); 
        $pixel_color = imagecolorallocate($image, 0, 0, 255); 
     
        imagefilledrectangle($image, 0, 0, 200, 50, $background_color); 
     
        for ($i = 0; $i < 6; $i++) { 
            $line_color = imagecolorallocate($image, rand(10,255), rand(10,255), rand(10,255)); 
            imageline($image, 0, rand() % 50, 200, rand() % 50, $line_color); 
        } 
     
        for ($i = 0; $i < 1000; $i++) { 
            imagesetpixel($image, rand() % 200, rand() % 50, $pixel_color); 
        } 
     

        $sumbols = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
        $length = rand(5,8); 

        $str = substr(str_shuffle($sumbols), 0, $length);
        $fontfile= __DIR__.'/Tahoma.ttf'; 
        $word = ""; 
        $array = str_split($str); 
        $i = 0; 
        foreach ($array as $char){ 
        $i = $i+20; 
        $text_color = imagecolorallocate($image, rand(10,100), rand(10,100), rand(10,100)); 
        $angle = rand(-30,30); 
        if ($char == '-'){ 
            imagettftext($image, 30, 0, 10+$i, 30, $text_color, $fontfile, $char); 
            $word .= $char; 
        } else { 
            imagettftext($image, 20, $angle, 10+$i, 30, $text_color, $fontfile, $char); 
            $word .= $char; } 
        } 
     
        for ($i = 0; $i < 6; $i++) { 
            $line_color = imagecolorallocate($image, rand(10,255), rand(10,255), rand(10,255)); 
            imageline($image, 0, rand() % 50, 200, rand() % 50, $line_color); 
        } 
     
        $_SESSION['captcha_string'] = $str; 
         
        imagepng($image, 'image'.$_SESSION['count'].'.png'); 

    }
?>
<html>
    <body>
        <div class="auth_reg_container reg_container">
            <p class="title_h2">Регистрация</p>
            <form action="../account_page/account_page.php" method="post" class="inputs">
                <p>
                    <input type="text" name="user_name" class="input_account" value="<?=@$user_name;?>" size="25" placeholder="Имя" maxlength="25">
                    <span class="error"><?=@$e1;?></span>
                </p>
                <p>
                    <input name="email" class="input_account" value="<?=@$email;?>" type="text" size="25" placeholder="Электронная почта" maxlength="25">
                    <span class="error"><?=@$e3;?></span>
                </p>
                <p>
                    <input name="password" class="input_account" type="password" size="25" placeholder="Пароль" maxlength="25">
                    <span class="error"><?=@$e2;?></span>
                </p>
                <div class="container_captcha">
                    <img src="image<?php echo $_SESSION['count']?>.png"> 
                    <input type="submit" value="Обновить капчу">
                </div> 
                    <input type="text" name="input" class="input_account" /> 
                
                <form class="buttons" action="../account_page/account_page.php" method="post">
                    <input type="submit" name="to_reg" value="Зарегистрироваться" class="black_button_auth_reg black_button">
                    <p>У меня есть аккаунт</p>
                    <button name="to_signin" class="button_reg_signin">войти</button>
                </form>
            </form>
        </div>
    </body>
</html>