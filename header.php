<?php
    if (!session_id()) {
        session_start();
    }
    include("db.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>МБУК Радуга</title>
    <link rel="stylesheet" href="CSS/Style_guest.css" type="text/css">
</head>
<body>
    <div class="header">
        <a href="index.php"><img src="Content/logo.jpg" class="logo"></a>
        <div class="header_row">
			<div>
                <a class="button" href="index.php">МБУК "Радуга"</a>
            </div>
            <div>
                <a class="button" href="news_page.php">Новости</a>
            </div>
            <div>
                <a class="button" href='groups.php'>Ансамбли</a>
            </div>
            <div>
                <a class="button" href="contacts_page.php">Контакты</a>
            </div>
            <div>
                <?php 
                    if ($_SESSION['ID_group'] != null) {
                        echo "<a  class='button' href='";
                        if ($_SESSION['ID_group'] == '1' || $_SESSION['ID_group'] == '2') {
                            echo "user.php";
                        }
                        elseif ($_SESSION['ID_group'] == '0') {
                            echo "moderator.php";
                        }
                        elseif ($_SESSION['ID_group'] == '-1') {
                            echo "admin.php";
                        }
                        echo "'>Личный кабинет</a>";
                    }
                ?>
            </div>
			<div>
                <?php 
                    if(!empty($_SESSION['ID_group']) || $_SESSION['ID_group'] == '0') {
                        //echo "$_SESSION[ID_group]";//temp
                        echo "<a class=\"button\" href=\"logout.php\">Выход</a>";
                    }   
                    else {
				        echo "<a class=\"button\" href=\"login.php\">Вход</a>";
                    }
                ?>  
			</div>
        </div>
    </div>
    <div class="body_content">

