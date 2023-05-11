<?php
    include('header_moder.php');
    include('db.php');
?>

<div class='allBlocks'><!--общий-->
    <div class='block-left'><!--левая часть-->
        <div class="block-stat-news"><!--статистика-->
            <p>Всего новостей:
            <?php
                $sql = "SELECT COUNT(ID_new) AS quantity_news FROM news";
                $result = mysqli_query($db,$sql);
                $myrow = mysqli_fetch_array($result);
                echo $myrow['quantity_news'];
            ?>
            </p>
        </div>
        <!--
            //кнопки взаимодействия (добавить удалить редактировать) 
            //по возможности сделать меню с двигающимися списками
            //выбрал поск - выкатился поиск
            //выбоал 
        -->
        <div class='block-search'><!--поиск-->
            <form action="#" method="get">
                <h3>Поиск новости</h3>
                <label for="title">По названию</label><br>
                <input type="text" id='title' name='title' placeholder='Введите ключевые слова...'><br>
                <label for="content">По содержанию</label><br>
                <input type="text" id='content' name='content' placeholder='Введите ключевые слова...'><br>
                <label for="date">По дате публикации</label><br>
                <input type="date" id='date' name='date'><br>
                <button type='submit' name='action' value='search'>Поиск</button>
                <a href='edit_news.php'>Очистить</a><br><br>
            </form>
            <form action="#" method="get">
                <label for="date"><b>Сортировка по id новости</b></label><br>
                <label for="sort">От первой к последней</label>
                <input type="radio" name="sort" value="1to9" <?php if($_GET['sort'] == '1to9'){echo "checked";} ?>><br>
                <label for="sort">От последней к первой</label>
                <input type="radio" name="sort" value="9to1" <?php if($_GET['sort'] == '9to1'){echo "checked";} ?>><br>
                <label for="date"><b>Сортировка по дате публикации</b></label><br>
                <label for="sort">Сначала новые</label>
                <input type="radio" name="sort" value="pub9to1" <?php if($_GET['sort'] == 'pub9to1'){echo "checked";} ?>><br>
                <label for="sort">Сначала старые</label>
                <input type="radio" name="sort" value="pub1to9" <?php if($_GET['sort'] == 'pub1to9'){echo "checked";} ?>><br>
                <label for="date"><b>Сортировка по дате последней редакции</b></label><br>
                <label for="sort">Сначала новые</label>
                <input type="radio" name="sort" value="edit9to1" <?php if($_GET['sort'] == 'edit9to1'){echo "checked";} ?>><br>
                <label for="sort">Сначала старые</label>
                <input type="radio" name="sort" value="edit1to9" <?php if($_GET['sort'] == 'edit1to9'){echo "checked";} ?>><br>
                <button type='submit' name='action' value='sort'>Отсортировать</button>
                <a href='edit_news.php'>Отменить</a><br><br>
            </form>
        </div>
        <div class='block-edit'><!--Редактирование-->
        <form action="#" method="post">
            <!--при нажатии на кнопку с удаленем новостей visible становятся checkbox возле новостей (с помощью ::after  ::before)-->
            <h3>Изменение новости</h3>
            <a href="add_news.php">Добавление</a><br>
            <button type="submit" name="delete">Удаление</button>
        </div>
    </div>
    <div class='block-right'><!--правая часть (вывод новостей)-->
        <?php
            $sql = "SELECT `ID_new`, `Title`, `Announce_image_path`, `Format_annonce_image`, 
                        DATE_FORMAT( `Publish_date` , '%d' ) AS `Pub_d`, 
                        DATE_FORMAT( `Publish_date` , '%m' ) AS `Pub_m`,
                        DATE_FORMAT( `Publish_date` , '%Y' ) AS `Pub_y` 
                    FROM `news`";
            $sql_search = $sql." WHERE ";
            if ($_GET['action'] == 'search') {
                $isSearch = false;
                if (!empty($_GET['title'])) {
                    if ($isSearch) {
                        $sql_search .= " OR ";
                    }
                    $isSearch = true;
                    $sql_search .= "Title LIKE '%".$_GET['title']."%'";
                }
                elseif (!empty($_GET['content'])) {
                    if ($isSearch) {
                        $sql_search .= " OR ";
                    }
                    $isSearch = true;
                    $sql_search .= "Announce LIKE '%".$_GET['content']."%'";
                }
                elseif (!empty($_GET['date'])) {
                    if ($isSearch) {
                        $sql_search .= " OR ";
                    }
                    $isSearch = true;
                    $sql_search .= "Publish_date LIKE '%".$_GET['date']."%'";
                }
                //$sql = "SELECT * FROM news WHERE Announce LIKE '%карта%' OR Title LIKE '%Глава%' OR Publish_date LIKE '%23-02-16%'";
            }
            elseif ($_GET['action'] == 'sort') {
                switch($_GET['sort']) {
                    case '1to9':
                        $sql_sort = "ORDER BY ID_new ASC";
                    break;
                    case '9to1':
                        $sql_sort = "ORDER BY ID_new DESC";
                    break;
                    case 'pub9to1':
                        $sql_sort = "ORDER BY Publish_date DESC";
                    break;
                    case 'pub1to9':
                        $sql_sort = "ORDER BY Publish_date ASC";
                    break;
                    case 'edit9to1':
                        $sql_sort = "ORDER BY Last_change_date DESC";
                    break;
                    case 'edit1to9':
                        $sql_sort = "ORDER BY Last_change_date ASC";
                    break;
                }
            }
            else {
                $sql_sort = "ORDER BY ID_new ASC";
            }
            if ($sql." WHERE " == $sql_search) {
                $sql .= $sql_sort;
                echo "<script>alert('$sql');</script>";
                $result = mysqli_query($db, $sql);
            }
            else {
                $sql_search .= $sql_sort;
                $result = mysqli_query($db, $sql_search);
            }        
            echo "<div class='header_new'><h1>Новости</h1></div>";
            while ($myrow = mysqli_fetch_array($result)){
                $id = $myrow['ID_new'];
                echo "<div><div class='checkbox'><input type='checkbox' name='$id'></div>";
                echo "<a class='news' href='edit_news_content.php?id=".$myrow['ID_new']."'><div class='new'><div class='title'><p><strong>" . $myrow['Title'] . "</strong></p>";
                echo "<div class='publish-date'>" . $myrow['Pub_d'] . "." . $myrow['Pub_m'] . "." . $myrow['Pub_y'] . "</div></div>";
                if ($myrow['Announce_image_path'] != null) {
                    echo "<img src='" . $myrow['Announce_image_path'].".".$myrow['Format_annonce_image'] . "'>";
                }
                echo "</div></a></div><br><br><br>";
            }
        ?>
        </form>
    </div>
</div>

<?php
    if (isset($_POST['delete'])) {
        unset($_POST['delete']);
        $count_del = 0;
        foreach($_POST as $idDelNews => $value) {
            $sql_del = "DELETE FROM news WHERE ID_new = '$idDelNews'";
            $result = mysqli_query($db, $sql_del);
            $count_del++;
        }
        if ($count_del !== 0) {
            $count_del_n = $count_del;
            while ($count_del >= 10) {
                $count_del_n = $count_del_n % 10;
            }
            if ($count_del_n == 1) {
                $message_text .= $count_del." новость удалена!";
            }
            elseif ($count_del_n >= 2 && $count_del_n <= 4) {
                $message_text .= $count_del." новости удалено!";
            }
            elseif (($count_del_n >= 5 && $count_del_n <= 9) || $count_del_n === 0) {
                $message_text .= $count_del." новостей удалено!";
            }
            echo "<script>alert('$message_text');</script>";
        } else {
            echo "<script>alert('Ошибка удаления.');</script>";
        }
        echo "<script> document.location.href = 'edit_news.php?sort=".$_GET['sort']."&action=".$_GET['action']."'</script>";
    }
?>


</body>
</html>