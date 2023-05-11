<?php
    session_start();
    include("check_moder.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель модератора</title>
    <link rel="stylesheet" href="CSS/Style_moder.css" type="text/css">
</head>
<body>

    <div class="center">
        <h3>Панель модератора</h3>
        <a href="index.php">Прейти на сайт</a><br>
        <a href='edit_account_info.php'>Редактировать профиль</a></br>
        <a href="edit_news.php">Новости</a><br>
        <a href="requests.php">Заявки</a>
    </div>

</body>
</html>