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
    
    <div class="header">
        <a href="admin.php" class="btn-back"> <-- Назад</a>
        <a href="logout.php" class="btn-exit">Выход</a>
    </div>