<?php
    include('check_moder.php');
    include('db.php');

    if (isset($_POST['news'])) {
        if ($_POST['news'] == 'add') {
            //отправка на сервер
            $sql = "INSERT INTO news(";
            $sql_insert = ") VALUES ('";
            //INSERT INTO news(Title!, Announce_image_path, Format_annonce_image, Max_image_size, Announce!, Last_change_date!, Publish_date) VALUES ('','','','','','','')
            $isEdit = false;
            if (!empty($_POST['title'])) {
                if ($isEdit) {
                    $sql .= ",";
                    $sql_insert .= "','";
                }
                $isEdit = true;
                $sql .= "Title";
                $sql_insert .= $_POST['title'];    
            }
            if (!empty($_POST['content_text'])) {
                if ($isEdit) {
                    $sql .= ",";
                    $sql_insert .= "','";
                }
                $isEdit = true;
                $sql .= "Announce";
                $sql_insert .= $_POST['content_text'];
            }
            if (isset($_POST['size_img']) && !empty($_FILES['content_img']['tmp_name'])) {
                if ($isEdit) {
                    $sql .= ",";
                    $sql_insert .= "','";
                }
                $isEdit = true;
                $sql .= "Max_image_size";
                $sql_insert .= $_POST['size_img'];
            }
            if ($isEdit) {
                $sql .= ",Last_change_date,Publish_date".$sql_insert."','".date("Y-m-d")."','".$_POST['publish_date']."')";
                $result = mysqli_query($db, $sql);
                $sql_id = "SELECT MAX(ID_new) AS ID_new FROM news WHERE Title = '".$_POST['title']."'";
                $result = mysqli_query($db, $sql_id);
                $myrow = mysqli_fetch_array($result);
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                if (!empty($_FILES['content_img']['tmp_name'])) {
                    $tmp_name = $_FILES["content_img"]["tmp_name"];
                    $type_img = $_FILES["content_img"]["type"];
                    $parts = [];
                    $tok = strtok($type_img, "/");
                    while ($tok !== false) {
                        $parts[] = $tok;
                        $tok = strtok("/");
                    }
                    $type_file = $parts[1];
                    $path_file = "/opt/lampp/htdocs/website/web-site/Content/News_image/id_".$myrow['ID_new'].".0";
                    $name = $path_file.".".$type_file;
                    if (move_uploaded_file($tmp_name, $name)) {
                        //echo "<script>alert('Файл успешно загружен.');</script>";
                    }
                    else {
                        echo '<script>alert("Ошибка загрузки файла!\nВсе изменения отменены!");</script>';
                        echo "<script> document.location.href = 'edit_news.php'</script>";
                    }
                    $sql_upd_part1 = "UPDATE news SET Announce_image_path='Content/News_image/id_";
                    $sql_upd_part2 = ".0',Format_annonce_image='".$type_file."' WHERE ID_new='".$myrow['ID_new']."'";
                    $sql_upd = $sql_upd_part1.$myrow['ID_new'].$sql_upd_part2;
                    $result = mysqli_query($db, $sql_upd);
                }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            }
            else {
                unset($sql);
            }
            echo "<script> document.location.href = 'edit_news.php'</script>";
            //echo "<script>alert('Проверь!/$sql/$sql_id/$sql_upd/');</script>";
            //echo "<script>alert('$sql/*/$sql_id/*/$sql_upd');</script>";
        }
        elseif ($_POST['news'] == 'save') {
            echo '<script>alert("Кнопка временно не работает!\nПожалуйста, сохраните данные на устройстве!");</script>';
            $title = $_POST['title'];
            $content_text = $_POST['content_text'];
        }
        elseif ($_POST['news'] == 'cancel') {
            //отмена действий и переход на страницу модератора
            //подумать над предупреждением пользователя
            $_FILES = array();
            $_POST = array();
            header('location: edit_news.php');
        }
    }

//////////////////////////////////////
    if (empty($title)) { 
        $title = '';
    }
    if (empty($content_text)) { 
        $content_text = '';
    }

?>

<form action='#' method='post' enctype='multipart/form-data'>
    <div class='btn-edit-content'>
        <button type='submit' name='news' value='add'>Добавить новость</button>
        <button type='submit' name='news' value='save'>Сохранить изменения</button>
        <button type='submit' name='news' value='cancel'>Отмена</button><br><br>
        <input type='reset' value='Очистить поля'>
    </div>
    <div class='field-edit-content'>
        <?php
            echo "   
                <label for='title'>Заголовок новости</label><br>
                <input size='98' maxlength='255'  type='text' name='title' placeholder='Введите заголовок новости...' value='".$title."' required><br>
                <label for='content_text'>Содержание новости</label><br>
                <textarea rows='20' cols='100' maxlength='100000' name='content_text' placeholder='Введите содержание новости...' required>".$content_text."</textarea><br>
                <label for='content_img'>Афиша</label><br>
                <input type='file' name='content_img' accept='image/*,.jpg,.png'>
                <label for='size_img'>Размер афиши: </label>
                <label for='size_img'>Стандартный</label>
                <input type='radio' name='size_img' id='standard' value='standard' checked>
                <label for='size_img'>Полноэкранный</label>
                <input type='radio' name='size_img' id='fullsize' value='full_screen'><br>
                <label for='publish_date'>Дата публикации<br>(Дата, когда новость будет видна пользователям)</label><br>
                <input type='date' name='publish_date' id='publish_date' value='".date("Y-m-d")."'><br>
            ";
        ?>
    </div>
</form>