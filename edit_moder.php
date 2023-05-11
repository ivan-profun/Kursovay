<?php
    include('header_adm.php');
    include('db.php');
    /*echo "<pre>";
    print_r($_POST);
    echo "</pre>";*/
    
    if (isset($_POST['submit'])) {
        if ($_POST['submit'] == 'add-moder') {
            //страничка добавления модератора
            echo "<script>document.location.href = 'add_moder.php';</script>";
        }
        if ($_POST['submit'] == 'rm-moder') {
            //алгоритм удаления модераторов
            unset($_POST['submit']);
            foreach($_POST as $idDelUser => $value) {
                $sql = "SELECT User_name FROM users WHERE ID_user = '$idDelUser'";
                $result = mysqli_query($db, $sql);
                $myrow = mysqli_fetch_array($result);   
                $nameDel .= $myrow['User_name'].'['.$idDelUser.'], ';
            }
            foreach($_POST as $idDelUser => $value) {
                $sql = "DELETE FROM users WHERE ID_user = '$idDelUser'";
                $result = mysqli_query($db, $sql);
            }
            if (!empty($nameDel)) {
                echo "<script>alert('Модераторы $nameDel удалены!');</script>";
            } else {
                echo "<script>alert('Ошибка удаления.');</script>";
            }
            header("Location: edit_moder.php");
        }
    }
?>


    <h3 class='mainTitle'>Редактирование состава модерации</h3>

    <div class='block'>
        <form action="#" method="post">
            <div class="column col-1">
                <h4>Действия</h4>
                <button type="submit" name="submit" value="add-moder" title='Нажмите на кнопку чтобы добавить модератора'>Добавить модератора</button><br>
                <!--<button type="submit" name="submit">tempПодуматьНадПредупреждениями</button><br>-->
                <button type="submit" name="submit" value="rm-moder" title='Сначала выберите кого нужно удальть, потом нажимите на кнопку'>Удалить модератора</button><br>
            </div>
            <div class="column col-2">
                <h4>Список модераторов</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Псевдоним</th>
                            <th>Фамилия</th>
                            <th>Имя</th>
                            <th>Отчество</th>
                            <th>Год рождения</th>
                            <th>Телефон</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT ID_user,User_name,Lastname,Firstname,Fathername,DATE_FORMAT( `Birth_date` , '%d' ) AS `Birth_d`, DATE_FORMAT( `Birth_date` , '%m' ) AS `Birth_m`, DATE_FORMAT( `Birth_date` , '%Y' ) AS `Birth_y`,Tel,Email FROM users WHERE ID_group = '0'";
                            $result = mysqli_query($db, $sql);
                            while ($myrow = mysqli_fetch_array($result)){
                                echo "
                                    <tr>
                                        <td><input type='checkbox' name='".$myrow['ID_user']."'></td>
                                        <td>".$myrow['User_name']."</td>
                                        <td>".$myrow['Lastname']."</td>
                                        <td>".$myrow['Firstname']."</td>
                                        <td>".$myrow['Fathername']."</td>
                                        <td>".$myrow['Birth_d'].".".$myrow['Birth_m'].".".$myrow['Birth_y']."</td>
                                        <td>".$myrow['Tel']."</td>
                                        <td>".$myrow['Email']."</td>
                                    </tr>
                                ";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</body>
</html>

<?php
    
?>