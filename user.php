<?php
    include("header.php");
    include("check_user.php");
    include("db.php");
?>
<div class='accountInfo'><h3>Личный кабинет</h3>

<?php
    $idUser = $_SESSION['ID_user'];
    $sql = "SELECT User_name,Lastname,Firstname,Fathername,Birth_date,Tel,Email FROM users WHERE ID_user=$idUser";
    $result = mysqli_query($db, $sql);
    $myrow = mysqli_fetch_array($result);

    if (empty($myrow)) {
        echo "<div>Ошибка загрузки данных</div>";
    }
    
    $userName = $myrow["User_name"];
    $lastName = $myrow["Lastname"];
    $firstName = $myrow["Firstname"];
    $fatherName = $myrow["Fathername"];
    $birthDate = $myrow["Birth_date"];
    $tel = $myrow["Tel"];
    $email = $myrow["Email"];

    echo "
        <div>
            <div class='field'><label>Псевдоним: <span> $userName </span></label></div>
            <div class='field'><label>Почта: <span> $email </span></label></div>
            <div class='field'><label>Пароль: <span>********</span></label></div>
            <div class='field'><label>Имя: <span> $lastName </span></label></div>
            <div class='field'><label>Фамилия: <span> $firstName </span></label></div>
            <div class='field'><label>Отчество: <span> $fatherName </span></label></div>
            <div class='field'><label>Год рождения: <span> $birthDate </span></label></div>
            <div class='field'><label>Телефон: <span> $tel </span></label></div>
        </div>
        <a href='edit_account_info.php'>Изменить</a>
    ";
?>

</div>









