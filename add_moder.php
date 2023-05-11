<?php
    session_start();
    include("check_adm.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавление модератора</title>
    <link rel="stylesheet" href="CSS/Style_admin.css" type="text/css">
</head>
<body>
    <div class='formAddModer'>
        <form action="#" method="post">
            <div>
                <label for="email">Email<br>
                <input type="text" name='email' placeholder='Email' required></label><br>
                <label for="passw">Пароль<br>
                <input type="text" name='passw' placeholder='Пароль' required></label>
            </div>
            <div>
                <button type="submit" name="submit">Добавить</button>
            </div>
        </form>
    </div>
</body>
</html>

<?php
    if(isset($_POST['submit'])){
        $email=$_POST['email'];
        $passw=$_POST['passw'];
        include("db.php");
        $sql = "SELECT email FROM users WHERE email='$email'";
        $result = mysqli_query($db,$sql);
        if(mysqli_num_rows($result) > 0){
            echo "<script>alert('Пользователь с таким email уже зарегистрирован.');</script>";
        }
        else {
            $sql = "INSERT INTO users (Email,Password,ID_group,User_name) VALUES ('$email','$passw','0','Moderator')";
            $result = mysqli_query($db,$sql);
            if($result){
                echo "<script>alert('Модератор успешно зарегестрирован!');</script>";
                header("location:edit_moder.php");
            }
            else {
                echo "<script>alert('Ошибка регитрации.');</script>";
            }
        }
    }
?>