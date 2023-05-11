<?php
    session_start();
    include("db.php");

    $idUser = $_SESSION['ID_user'];
    if (!empty($_SESSION['ID_user']) && (!empty($_SESSION['ID_group'] || $_SESSION['ID_group'] == '0'))) {
        if (isset($_POST['submit'])) {
            $userName = $_POST["userName"];
            $lastName = $_POST["lastName"];
            $firstName = $_POST["firstName"];
            $fatherName = $_POST["fatherName"];
            $birthDate = $_POST["birthDate"];
            $tel = $_POST["tel"];
            $email = $_POST["email"];
            $passw = $_POST["passw"];

            $sql = "UPDATE users SET Password='$passw',User_name='$userName',Lastname='$lastName',Firstname='$firstName',Fathername='$fatherName',Birth_Date='$birthDate',Tel='$tel',Email='$email' WHERE ID_user=$idUser";
            if (mysqli_query($db, $sql)) {
                if ($_SESSION['ID_group'] == -1) {
                    echo "Данные успешно сохранены!";
                    echo "<script>document.location.href = 'admin.php'</script>";
                }
                elseif ($_SESSION['ID_group'] == 0) {
                    echo "Данные успешно сохранены!";
                    echo "<script>document.location.href = 'moderator.php'</script>";
                }
                else {
                    echo "Данные успешно сохранены!";
                    echo "<script>document.location.href = 'user.php'</script>";
                }
            } else {
                echo "Ошибка";
            }
        }
    }
    elseif (empty($_SESSION['ID_user'])) {
        session_destroy();
        echo "Вы являетесь незарегистрированным пользователем";
        echo "<script>document.location.href = 'login.php'</script>";
    }
    else {
        echo "<script>document.location.href = 'logout.php'</script>";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Данные об аккаунте</title>
    <link rel="stylesheet" href="CSS/Style_account.css" type="text/css">
</head>
<body>

<?php

$sql = "SELECT Password,User_name,Lastname,Firstname,Fathername,Birth_date,Tel,Email FROM users WHERE ID_user=$idUser";
$result = mysqli_query($db, $sql);
$myrow = mysqli_fetch_array($result);

$userName = $myrow["User_name"];
$lastName = $myrow["Lastname"];
$firstName = $myrow["Firstname"];
$fatherName = $myrow["Fathername"];
$birthDate = $myrow["Birth_date"];
$tel = $myrow["Tel"];
$email = $myrow["Email"];
$passw = $myrow["Password"];

echo "
<div class='center'>
    <form action='#' method='POST' class='form-group'>
        <h3>Данные о пользователе</h3>
        <div class='allInput'>
            <div class='accountData'>
                <label for='userName'>Псевдоним:</label><br>
                <input type='text' name='userName' id='userName' placeholder='Username' class='form-control' value='$userName'required><br>
                <label for='email'>Email:</label><br>
                <input type='email' name='email' id='email' placeholder='Email' class='form-control' value='$email'required><br>
                <label for='passw'>Пароль:</label><br>
                <input type='password' name='passw' id='passw' placeholder='Пароль' class='form-control' value='$passw'required><br>
                <label for='tel'>Номер телефона:</label><br>
                <input type='text' name='tel' id='tel' placeholder='Телефон' class='form-control' value='$tel'required><br>
            </div>
            <div class='personData'>
                <label for='lastName'>Фамилия:</label><br>
                <input type='text' name='lastName' id='lastName' placeholder='Фамилия' class='form-control' value='$lastName'required><br>
                <label for='firstName'>Имя:</label><br>
                <input type='text' name='firstName' id='firstName' placeholder='Имя' class='form-control' value='$firstName'required><br>
                <label for='fatherName'>Отчество:</label><br>
                <input type='text' name='fatherName' id='fatherName' placeholder='Отчество' class='form-control' value='$fatherName'><br>
                <label for='birthDate'>Дата рождения:</label><br>
                <input type='date' name='birthDate' id='birthDate' class='form-control' value='$birthDate'required><br>
            </div>
        </div>
        <br><button type='submit' name='submit' id='submit' class='btn'><span>Сохранить изменения</span></button>
    </form>
</div>";

?>



</body>

</html>