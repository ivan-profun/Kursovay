<?php
    session_start();
    if ($_SESSION['ID_group'] == '0') {
        include('header_moder.php');
        include('db.php');
    }
    elseif ($_SESSION['ID_group'] == null) {
        header('Location: login.php');
    }
    elseif ($_SESSION['ID_group'] == '1' || $_SESSION['ID_group'] == '2') {
        //include('header.php');
        include('db.php');
    }
    else {
        header('Location: index.php');
    }
    
    //логика страници
    if ($_SESSION['ID_group'] == '0') {
        //страница модератора
        echo '
            <div class="requestForm">
                <form action="#" method="post">
                    <div class="other">
                        <h4>Список необработанных заявок</h4>
                        <button name="submit" id="process">Обработать выбранные заявки</button>
                        <button name="reset" id="reset">Отменить выбор</button>
                    </div>
                    <div class="table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Решение</th>
                                    <th>№</th>
                                    <th>Дата подачи</th>
                                    <th>Группа</th>
                                    <th>Фамилия</th>
                                    <th>Имя</th>
                                    <th>Отчество</th>
                                    <th>Возраст</th>
                                    <th>Телефон</th>
                                    <th>Email</th>
                                    <th>Подробности</th>
                                    <th>Комментарий модератора</th>
                                </tr>
                            </thead>
                            <tbody>
                            ';
                                $sql = "SELECT requests_info.ID_request,date_submit,Name_group,Lastname,Firstname,Fathername,Age,Tel,Email,details 
                                        FROM requests_info 
                                            JOIN requests ON requests.ID_request=requests_info.ID_request 
                                            JOIN groups ON groups.ID_group=requests_info.ID_group 
                                        WHERE requests.status='1'";
                                $result = mysqli_query($db, $sql);
                                while ($myrow = mysqli_fetch_array($result)){
                                    $sql = "SELECT ";
                                    if (empty($myrow['Lastname'])) {
                                        $sql .= "Lastname,";
                                    }
                                    if (empty($myrow['Firstname'])) {
                                        $sql .= "Firstname,";
                                    }
                                    if (empty($myrow['Fathername'])) {
                                        $sql .= "Fathername,";
                                    }
                                    if (empty($myrow['Tel'])) {
                                        $sql .= "Tel,";
                                    }
                                    if (empty($myrow['Email'])) {
                                        $sql .= "Email,";
                                    }
                                    if ($sql != "SELECT ") {
                                        $sql .= "User_name FROM users WHERE ID_user=".$_SESSION['ID_user'];
                                        $result = mysqli_query($db, $sql);
                                        $myrow_user = mysqli_fetch_array($result);
                                        if (empty($myrow['Lastname'])) {
                                            $myrow['Lastname'] = $myrow_user['Lastname'];
                                        }
                                        if (empty($myrow['Firstname'])) {
                                            $myrow['Firstname'] = $myrow_user['Firstname'];
                                        }
                                        if (empty($myrow['Fathername'])) {
                                            $myrow['Fathername'] = $myrow_user['Fathername'];
                                        }
                                        if (empty($myrow['Tel'])) {
                                            $myrow['Tel'] = $myrow_user['Tel'];
                                        }
                                        if (empty($myrow['Email'])) {
                                            $myrow['Email'] = $myrow_user['Email'];
                                        }
                                    } 
                                    $date = explode("-",$myrow['date_submit']);
                                    echo "
                                        <tr>
                                            <td>
                                                <label for='".$myrow['ID_request']."' id='accept'>
                                                    <input type='radio' name='".$myrow['ID_request']."' id='accept' value='accept'>
                                                    Принять
                                                </label>
                                                <br>
                                                <label for='".$myrow['ID_request']."' id='refuse'>
                                                    <input type='radio' name='".$myrow['ID_request']."' id='refuse' value='refuse'>
                                                    Отклонить
                                                </label>
                                            </td>
                                            <td>".$myrow['ID_request']."</td>
                                            <td>".$date[2].".".$date[1].".".$date[0]."</td>
                                            <td>".$myrow['Name_group']."</td>
                                            <td>".$myrow['Lastname']."</td>
                                            <td>".$myrow['Firstname']."</td>
                                            <td>".$myrow['Fathername']."</td>
                                            <td>".$myrow['Age']."</td>
                                            <td>".$myrow['Tel']."</td>
                                            <td>".$myrow['Email']."</td>
                                            <td>".$myrow['details']."</td>
                                            <td><textarea id='comment' name='comment_".$myrow['ID_request']."' cols='50' rows='3' maxlength='500' placeholder='Подробности такого решения...'></textarea></td>
                                        </tr>
                                    ";
                                }
                            echo '
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        ';
        if (isset($_POST['submit'])) {
            //алгоритм обработки заявок
            unset($_POST['submit']);
            $current_date = date('Y-m-d');
            foreach($_POST as $id_request => $value) {
                if ($value == 'accept') {
                    if (empty($idaccept)) {
                        $idaccept = $id_request;
                    }
                    else {
                        $idaccept .= ", ".$id_request;
                    }
                    $sql = "UPDATE requests SET ID_user_who_accept='".$_SESSION['ID_user']."',status='2',comment='".$_POST['comment_'.$id_request.'']."',date_processing='$current_date' WHERE ID_request = $id_request";
                    $result = mysqli_query($db, $sql);
                    // смена группы
                    /*$sql_group = "SELECT users.ID_user,users.ID_group FROM requests JOIN users ON users.ID_user = requests.ID_user WHERE ID_request = $id_request";
                    $result_group = mysqli_query($db, $sql_group);
                    $myrow_iduser = mysqli_fetch_array($result);
                    if ($myrow_iduser['ID_group'] == '2') {
                        $sql = "UPDATE users SET ID_group = $id_group WHERE ID_user = '".$myrow_iduser['ID_user']."'";
                        $result = mysqli_query($db, $sql);
                    }*/
                }
                elseif ($value == 'refuse') {
                    if (empty($idrefuse)) {
                        $idrefuse = $id_request;
                    }
                    else {
                        $idrefuse .= ", ".$id_request;
                    }
                    $sql = "UPDATE requests SET ID_user_who_accept='".$_SESSION['ID_user']."',status='0',comment='".$_POST['comment_'.$id_request.'']."',date_processing='$current_date' WHERE ID_request = $id_request";
                    $result = mysqli_query($db, $sql);
                }
            }
            if (!empty($idaccept) || !empty($idrefuse)) {
                if (!empty($idaccept) && !empty($idrefuse)) {
                    echo '<script>alert("Заявки под номерами '.$idaccept.' приняты.\nЗаявки под номерами '.$idrefuse.' отклонены.");</script>';
                }
                else if (!empty($idaccept) && empty($idrefuse)) {
                    echo "<script>alert('Заявки под номерами $idaccept приняты.');</script>";
                }
                else if (empty($idaccept) && !empty($idrefuse)) {
                    echo "<script>alert('Заявки под номерами $idrefuse отклонены.');</script>";
                }
            } 
            else {
                echo "<script>alert('Ошибка обработки. Возможно действия не были выполнены...');</script>";
            }
            echo "<script> document.location.href = 'requests.php'</script>";
        }
    }
    elseif ($_SESSION['ID_group'] == '1' || $_SESSION['ID_group'] == '2') {
        //страница пользователя
        $id = $_GET['id'];
        if ($id > 2) {
            $sql = "SELECT Name_group FROM groups WHERE ID_group = $id";
            $result = mysqli_query($db, $sql);
            $myrow = mysqli_fetch_array($result);
            $name_group = $myrow['Name_group'];
            if (!empty($name_group)) {
                $idUser = $_SESSION['ID_user'];
                $sql = "SELECT Lastname,Firstname,Fathername,Birth_date,Tel,Email FROM users WHERE ID_user=$idUser";
                $result = mysqli_query($db, $sql);
                $myrow = mysqli_fetch_array($result);
                $firstname = $myrow['Firstname'];
                $lastname = $myrow['Lastname'];
                $fathername = $myrow['Fathername'];
                $birthdate = $myrow['Birth_date'];
                $tel = $myrow['Tel'];
                $email = $myrow['Email'];
                //расчёт текущего возраста
                $current_year = date('Y');
                $current_month = date('m');
                $current_day = date('d');
                if ($birthdate != null) {
                    $date = explode("-",$birthdate);
                    $year = $current_year-$date[0];
                    $month = $current_month-$date[1];
                    $day = $current_day-$date[2];
                    if ($day < 0) {
                        $month -= 1;
                    }
                    if ($month < 0) {
                        $year -= 1;
                    }
                    $age = $year;
                }
                else {
                    $age = '';
                }
                //небольшой костыль
                switch ($id) {
                    case 3:
                        $group = "Vyshe_radugi";
                    break;
                    case 4:
                        $group = "Raduga";
                    break;
                    case 5:
                        $group = "12_kadrov";
                    break;
                    case 6:
                        $group = "StarKids";
                    break;
                    case 7:
                        $group = "Zvonki_dozhd'";
                    break;
                    case 8:
                        $group = "Kapel'ki";
                    break;
                }
                //страница отображаемая у пользователя
                echo '
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Форма подачи заявки</title>
                    <link rel="stylesheet" href="CSS/Style_requests.css" type="text/css">
                </head>
                <body>
                ';

                echo "<div class='requestsAllFields'>
                    <div class='header'>
                        <a href=\"group_page.php?group=".$group."\">Отмена</a>
                    </div>";
                echo '<h3>Страница подачи заявки на вступление в ансамбль "'.$name_group.'"</h3>';
                //расположить элементы 2\1\1 по вертиали \количество элементов в строке\
                echo '
                    <form action="#" method="post">
                        <div>
                            <div class="person_data">
                                <label for="">Фамилия:</label><br>
                                <input type="text" id="lastname" name="lastname" value="'.$lastname.'" required><br>
                                <label for="">Имя:</label><br>
                                <input type="text" id="firstname" name="firstname" value="'.$firstname.'" required><br>
                                <label for="">Отчество:</label><br>
                                <input type="text" id="fathername" name="fathername" value="'.$fathername.'"><br>
                                <label for="age">Возраст:</label><br>
                                <input type="text" id="age" name="age" value="'.$age.'" required><br>
                            </div>
                            <div class="person_contact">
                                <p><b>Контакты:</b></p>
                                <label for="tel">Номер телефона:</label><br>
                                <input type="tel" id="tel" name="tel" value="'.$tel.'"><br>
                                <label for="email">Email:</label><br>
                                <input type="email" id="email" name="email" value="'.$email.'"><br>
                            </div>
                            <div class="details">
                                <label for="details">
                                ';
                                    if ($_SESSION['ID_group'] == '1') {
                                        echo 'Расскажите подробнее о вашем ребёнке, какими навыками он(она) обладает и какой у него(неё) опыт в вокале?';
                                    }
                                    elseif ($_SESSION['ID_group'] == '2') {
                                        echo 'Расскажите подробнее о себе, какими навыками вы обладаете и какой у вас опыт в вокале?';
                                    }
                                echo '
                                </label><br>
                                <textarea id="details" name="details" cols="50" rows="10" maxlength="500" placeholder="Напишите подробнее о себе...">'.$text_details.'</textarea>
                            </div>
                            <div>
                                <button type="submit" name="btn" value="submit">Отправить заявку</button>
                            </div>
                        </div>
                    </form>
                ';
                //отправка данных
                if (isset($_POST['btn'])) {
                    if ($_POST['btn'] == 'submit') {
                        //echo $lastname.", ".$firstname.", ".$fathername.", ".$age.", ".$tel.", ".$email.", ".$text_details."<br>";
                        $lastname = $_POST['lastname'];
                        $firstname = $_POST['firstname'];
                        $fathername = $_POST['fathername'];
                        $age = $_POST['age'];
                        $tel = $_POST['tel'];
                        $email = $_POST['email'];
                        $text_details = $_POST['details'];
                        //echo $lastname.", ".$firstname.", ".$fathername.", ".$age.", ".$tel.", ".$email.", ".$text_details."<br>";
                        $sql = "INSERT INTO requests(ID_user, status, date_submit) VALUES ('".$idUser."','1','".date('Y-m-d')."')";
                        $result = mysqli_query($db, $sql);
                        $sql = "SELECT MAX(ID_request) AS ID_request FROM requests WHERE ID_user = '".$idUser."'";
                        $result = mysqli_query($db, $sql);
                        $myrow = mysqli_fetch_array($result);
                        $sql = "INSERT INTO requests_info(ID_request, ID_group, Lastname, Firstname, Fathername, Age, Tel, Email, details) VALUES ('".$myrow['ID_request']."','".$id."','".$lastname."','".$firstname."','".$fathername."','".$age."','".$tel."','".$email."','".$text_details."')";
                        $result = mysqli_query($db, $sql);
                        //конец обработки заявки
                        header("Location: group_page.php?group=$group");
                    }
                }
            }
            else {
                echo "<div><h3>Страница не найдена</h3>
                <p>Страница устарела, была удалена или не существовала вовсе</p></div>";
            }
        }
        else {
            echo "<div><h3>Страница не найдена</h3>
            <p>Страница устарела, была удалена или не существовала вовсе</p></div>";
        }
    }

?> 