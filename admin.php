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
    <title>Панель администратора</title>
    <link rel="stylesheet" href="CSS/Style_admin.css" type="text/css">
</head>
<body>

    <div class='center'>
        <h3>Панель администратора</h3>

        <a href='index.php'>Прейти на сайт</a><br>
        <a href='edit_account_info.php'>Редактировать профиль</a></br>
        <a href='edit_moder.php'>Редактирвать состав модерации</a><br>
        <a href='statistics.php'>Статистика сайта</a><br>
    </div>

</body>
</html>