<?php
    session_start();
    include("db.php");

    $idUser = $_SESSION['ID_user'];
    if (!empty($_SESSION['ID_user']) && empty($_SESSION['ID_group'])) {
        if (isset($_POST['submit'])) {
            $userName = $_POST["userName"];
            $lastName = $_POST["lastName"];
            $firstName = $_POST["firstName"];
            $fatherName = $_POST["fatherName"];
            $birthDate = $_POST["birthDate"];
            $tel = $_POST["tel"];
            $email = $_POST["email"];
            if ($_POST["role"] == 'parent') {
                $idGroup = 1;
            }
            else {
                $idGroup = 2;
            }

            $sql = "UPDATE users SET ID_group='$idGroup',User_name='$userName',Lastname='$lastName',Firstname='$firstName',Fathername='$fatherName',Birth_Date='$birthDate',Tel='$tel',Email='$email' WHERE ID_user=$idUser";
            if (mysqli_query($db, $sql)) {
                $_SESSION['ID_group'] = $idGroup;
                echo "Данные успешно сохранены! Регистрация завершена.";
                if (isset($_GET['group'])) {
                    echo "<script> document.location.href = 'requests.php?id=".$_GET['group']."'</script>";
                }
                echo "<script>document.location.href = 'user.php'</script>";
            } else {
                echo "Ошибка";
            }
        }
    }
    elseif (empty($_SESSION['ID_user'])) {
        echo "Вы являетесь незарегистрированным пользователем";
        echo "<script>document.location.href = 'login.php'</script>";
    }
    else {
        echo "<script>document.location.href = 'index.php'</script>";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="CSS/Style_signup.css" type="text/css">
</head>
<body>

<?php

$sql = "SELECT ID_group,Lastname,Firstname,Fathername,Birth_date,Tel,Email FROM users WHERE ID_user=$idUser";
$result = mysqli_query($db, $sql);
$myrow = mysqli_fetch_array($result);

$lastName = $myrow["Lastname"];
$firstName = $myrow["Firstname"];
$fatherName = $myrow["Fathername"];
$birthDate = $myrow["Birth_date"];
$tel = $myrow["Tel"];
$email = $myrow["Email"];

echo "
<div class='register'>
    <form action='' method='POST' class='form-group'>
        <h4>Регистрация</h4>
        <label class='red_digit'>*</label><input type='text' name='userName' placeholder='Username' class='userName' value='$userName'required><br>
        <label class='red_digit'>*</label><input type='text' name='lastName' placeholder='Фамилия' class='lastNmae' value='$lastName'required><br>
        <label class='red_digit'>*</label><input type='text' name='firstName' placeholder='Имя' class='firstName' value='$firstName'required><br>
        <input type='text' name='fatherName' placeholder='Отчество' class='fatherName' value='$fatherName'><br>
        <label class='red_digit'>*</label><input type='date' name='birthDate' class='birthDate' value='$birthDate'required><br>
        <label class='red_digit'>*</label><input type='text' name='tel' placeholder='Телефон' class='tel' value='$tel'required><br>
        <label class='red_digit'>*</label><input type='email' name='email' placeholder='Email' class='email' value='$email' required><br>
        <div class='role'>
            <label class='red_digit'>*</label><label class='textRole'>Выберите кто вы:</label>
            <select name='role' id='role'>
                <option value='parent'>Родитель</option>
                <option value='child'>Ребёнок</option>
            </select>
        </div>
        <button type='submit' name='submit' class='btn'>Сохранить изменения</button>
    </form>
</div>";

?>



</body>

</html>