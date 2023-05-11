<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="CSS/Style_login.css" type="text/css">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css&family=Oswald:400.300" type="text/css">
</head>

<body>
    <form action="#" method="post">
        <input checked="" id="signin" name="action" type="radio" value="signin">
        <label for="signin">Вход</label>
        <input id="signup" name="action" type="radio" value="signup">
        <label for="signup">Регистрация</label>
        <div id="wrapper">
            <div id="arrow"></div>
            <input id="email" placeholder="Email" type="text" name="email">
            <input id="pass" placeholder="Пароль" type="password" name="pass">
            <input id="repass" placeholder="Повтор пароля" type="password" onkeyup="valid();">
        </div>
        <button type="submit" name="submit">
            <span>
                Вход
                <br>
                Регистрация
            </span>
        </button>
    </form>
    <script type="text/javascript">
        function valid() {
            if (document.getElementById('pass').value != document.getElementById('repass').value) {
                var colorRepass = document.getElementsById('repass');
                colorRepass.style.colorText = '#ff0000';
                return false;
            }
        }
    </script>
</body>

</html>

<?php
if (ISSET($_POST['submit'])) {
    $email=$_POST['email'];
    $passw=$_POST['pass'];
    //echo "(".$email.")<br>";
    if(empty($email) or empty($passw)) {
        exit("Вы ввели не всю информацию");
    }

    include("db.php");

    if($_POST['action']=="signup") {
        //if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $query="SELECT ID_user FROM users WHERE Email='$email'";
            $result=mysqli_query($db,$query); 
            $myrow=mysqli_fetch_array($result); 
            if(!empty($myrow['ID_user'])) {
                exit("Извините, пользователь с таким email уже существует");
            }
            $query="INSERT INTO users(ID_group,Email,Password,User_name) VALUES ('2','$email','$passw','Пользователь')";
            $result=mysqli_query($db, $query);
            if($result==true) {
                echo "Первый шаг регистрации выполнен!";
                $_SESSION['Email']=$email; 
                $query="SELECT ID_user FROM users WHERE Email='$email'";
                $result=mysqli_query($db,$query);
                $myrow=mysqli_fetch_array($result);
                $_SESSION['ID_user']=$myrow['ID_user'];
                if (isset($_GET['group'])) {
                    echo "<script> document.location.href = 'signupUser.php?group=".$_GET['group']."'</script>";
                }
                echo "<script> document.location.href = 'signupUser.php'</script>";
            }
            else {
                echo "Ошибка регистрации";
            }
        /*}
        else if(!empty($email)) {
            echo "Email введён неверно";
        }*/
    }   

    if($_POST['action']=="signin") {
        $query="SELECT * FROM users WHERE Email='$email'";
        $result=mysqli_query($db,$query);
        $myrow=mysqli_fetch_array($result);

        if(empty($myrow['Email'])) {
            exit("Извините, пользователь с таким email не зарегистрирован");
        }
        else {
            if (empty($myrow['ID_user'])) {
                exit("Пользователь с таким email не существует");
            } 
            else if ($myrow['Password'] == $passw) {
                if(!empty($myrow['User_name'])) {
                    $_SESSION['User_name'] = $myrow['User_name'];
                }
                $_SESSION['ID_group'] = $myrow['ID_group'];
                $_SESSION['ID_user'] = $myrow['ID_user'];
                if ($_SESSION['ID_group'] == "-1") {
                    echo "<script>document.location.href = 'admin.php';</script>";
                } 
                else if($_SESSION['ID_group'] == "0"){
                    echo "<script>document.location.href = 'moderator.php';</script>";
                }
                else {
                    echo "<script>document.location.href = 'user.php';</script>";
                }
            } 
            else {
                exit("Неверный логин или пароль");
            }
        }
    }
}
?>